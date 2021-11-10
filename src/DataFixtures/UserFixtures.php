<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//Klasa UserFixtures
//  tworzy obiekt i utrwala je w bazie danych.
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Yuliia');
        $user->setSurname('Durman');
        $user->setNumber('111111111');
        $user->setEmail('yuliia@wp.pl');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));
        $user->setTypeUser('firma');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
    }
}
