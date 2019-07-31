<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;


class QueueController extends AbstractController
{
    /**
     * Envio da mensagem
     * Email - mensagem - from - to
     * @Route("/queue/")
     * @param Connection $connection
     */
    public function sendMessage(Connection $connection)
    {

       $query =  $connection->query('select * from messageschat');

        while ($row = $query->fetch()) {
            echo $row['msg_to'];
        }



    }
}
