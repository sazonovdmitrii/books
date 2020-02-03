<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach(['sazon@nxt.ru', 'kudinov_kirill@mail.ru'] as $email) {
            $user = new Users();
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'everest1024'
            )
            );
            $user->setRoles(
                ['ROLE_ADMIN']
            );
            $manager->persist($user);
            $manager->flush();
        }
    }
}
