<?php

namespace App\DataFixtures;

use App\Entity\ChatMessage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        $usersTemp = [
            'Jose da Silva', 'Jhon', 'Maria'
        ];

        foreach ($usersTemp as $item) {
            $user = new User();
            $user->setNome($item);
            $user->setEmail($item . "@email.com.br");
            $user->setNivel("cli");
            $manager->persist($user);
        }
        $manager->flush();
        /**
         * Cria usuario de pa
         */
        $user = new User();
        $user->setNome('Bruna PA 1');
        $user->setEmail("brunaPa1@email.com.br");
        $user->setNivel("pa");
        $manager->persist($user);

        $manager->flush();

        for ($i = 1; $i <= 10; $i++) {
            $message = new ChatMessage();

            $users = $manager->getRepository(User::class)->findBy(['nivel' => 'cli']);
            $usersPa = $manager->getRepository(User::class)->findOneBy(['email' => 'brunaPa1@email.com.br']);
            $user = array_rand($users);

            $message->setEmail($users[$user]->getEmail());
            $message->setMsgTo($usersPa->getEmail());
            $message->setIdUserto($usersPa->getId());
            $message->setMessageText("Eu quero uma ajuda");
            $message->setMessageDate((new  \DateTime())->modify("- $i days"));

            $message->setUser($users[$user]);

            $manager->persist($message);
        }

        $manager->flush();
    }
}
