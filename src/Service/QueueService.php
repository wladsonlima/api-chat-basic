<?php

namespace App\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueService
{
    private $url;
    private $port;
    private $conn;


    /**
     * QueueService constructor.
     */
    public function __construct()
    {
        $this->url = "amqp://gvrjzfas:A1sNPhp3l0GCevAXw9xKN80JyuKnjsuj@barnacle.rmq.cloudamqp.com/gvrjzfas";
        $this->port = 5672;

        /**
         * Inicia a conexão
         */
        $url = parse_url($this->url);
        $vhost = substr($url['path'], 1);

        $this->conn = new AMQPStreamConnection($url['host'], $this->port, $url['user'], $url['pass'], $vhost);
    }


    /**
     * @throws \Exception
     */
    public function sendMsg()
    {


        $ch = $this->conn->channel();

        $exchange = 'amq.direct';
        $queue = 'chat';

        $ch->queue_declare($queue, false, true, false, false);
        $ch->exchange_declare($exchange, 'direct', true, true, false);
        $ch->queue_bind($queue, $exchange);


        $msg_body = 'the body';
        $msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery_mode' => 2));
        echo "Sending message...\n";
        $ch->basic_publish($msg, $exchange);

        $retrived_msg = $ch->basic_get($queue);
        echo sprintf("Message recieved: %s\n", $retrived_msg->body);
        $ch->basic_ack($retrived_msg->delivery_info['delivery_tag']);
        $ch->close();
        $this->conn->close();

    }

    public function getMsg(){


        $channel = $this->conn->channel();

        $channel->queue_declare('basic_get_queue', false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.'));
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('basic_get_queue', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $this->conn->close();


    }

}