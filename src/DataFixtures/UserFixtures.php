<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $i = 1;

        while ($i <= 3) {
            $user = new User();
            $user->setUsername('Username'.$i);
            $user->setPassword($this->encoder->encodePassword($user, 'mdp' . $i));
            $user->setEmail('user' . $i . '@gmail.com');
            $manager->persist($user);
            $i++;
        }

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setEmail('admin@gmail.com');
        $admin->setIsAdmin(true);
        $manager->persist($admin);

        $manager->flush();
    }
}