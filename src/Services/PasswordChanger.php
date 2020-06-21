<?php


namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordChanger
{
    private $manager ;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        $this->manager=$manager ;
        $this->passwordEncoder=$passwordEncoder;
    }

    public function changePassword(UserInterface $user, $newPass)
    {
        $encodedpass = $this->passwordEncoder->encodePassword($user,$newPass) ;
        $user->setPassword($encodedpass) ;
        $this->manager->persist($user);
        $this->manager->flush() ;

    }
}