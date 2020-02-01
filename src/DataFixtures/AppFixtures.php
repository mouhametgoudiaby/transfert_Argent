<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $profils = new Profil();
        $profils->setLibelle('supadmin');
        $manager->persist($profils);
        $manager->flush();

        $profile = new Profil();
        $profile->setLibelle('admin');
        $manager->persist($profile);
        $manager->flush();

        $profil = new Profil();
        $profil->setLibelle('caissier');
        $manager->persist($profil);
        $manager->flush();
 
        $users = new User();
        $users->setUsername('jamal');
        $users->setProfil($profils);
        $password = $this->encoder->encodePassword($users, 'admin11');
        $users->setPassword($password);
        $users->setRoles(array('ROLE_ADMIN_SYSTEM'));
        $users->setIsActive(true);
        
        $manager->persist($users);
        $manager->flush();

    }
}
