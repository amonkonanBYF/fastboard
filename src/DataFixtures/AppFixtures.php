<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWWYZ';
        $LOT60 = "1 Entrée ou dessert";
        $LOT20 = "1 Burger ";
        $LOT10 = "1 Menu du jour ";
        $LOT6 = "1 Menu au choix ";
        $LOT4 = "70% de réduction ";
        $per_60 =  900000;
        $per_20 = 300000;
        $per_10 = 150000;
        $per_6 =  90000;
        $per_4 = 60000;

        $faker = Factory::create();

        for($u=0; $u < 30; $u++) {
            $user = new User();

            $passHash = $this->encoder->encodePassword($user, 'password');
            $user->setEmail($faker->email)
                ->setPassword($passHash)
                ->setUsername($faker->userName)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setDateCreated(new \DateTime('now'))
                ->setRoles(['ROLE_USER'])
                ->setNewsLetter(true)

            ;
            $manager->persist($user);
        }
        for($u=0; $u < 10; $u++) {
            $user = new User();

            $passHash = $this->encoder->encodePassword($user, 'password');
            $user->setEmail($faker->email)
                ->setPassword($passHash)
                ->setUsername($faker->userName)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setDateCreated(new \DateTime('now'))
                ->setRoles(['ROLE_ADMIN', 'ROLE_SERVEUR'])

            ;
            $manager->persist($user);
        }
        for ($i=0; $i < $per_4; $i++) {
            $random = substr(str_shuffle($permitted_chars), 0, 10);
            $tickets = new Ticket();
            $tickets->setLots($LOT4)
                    ->setValeurs($random)
                    ->setCreatedAt(new \DateTime('now'))
                    ->isBusy(false)

            ;
            $manager->persist($tickets);

        }
        for ($i=0; $i < $per_6; $i++) {
            $random = substr(str_shuffle($permitted_chars), 0, 10);
            $tickets = new Ticket();
            $tickets->setLots($LOT6)
                ->setValeurs($random)
                ->setCreatedAt(new \DateTime('now'))
                ->isBusy(false)

            ;
            $manager->persist($tickets);

        }
        for ($i=0; $i < $per_10; $i++) {
            $random = substr(str_shuffle($permitted_chars), 0, 10);
            $tickets = new Ticket();
            $tickets->setLots($LOT10)
                ->setValeurs($random)
                ->setCreatedAt(new \DateTime('now'))
                ->isBusy(false)


            ;
            $manager->persist($tickets);

        }
        for ($i=0; $i < $per_20; $i++) {
            $random = substr(str_shuffle($permitted_chars), 0, 10);
            $tickets = new Ticket();
            $tickets->setLots($LOT20)
                ->setValeurs($random)
                ->setCreatedAt(new \DateTime('now'))
                ->isBusy(false)


            ;
            $manager->persist($tickets);

        }
        for ($i=0; $i < $per_60; $i++) {
            $random = substr(str_shuffle($permitted_chars), 0, 10);
            $tickets = new Ticket();
            $tickets->setLots($LOT60)
                ->setValeurs($random)
                ->setCreatedAt(new \DateTime('now'))
                ->isBusy(false)


            ;
            $manager->persist($tickets);

        }
        $manager->flush();
    }
}
