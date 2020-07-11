<?php


namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailChanger
{

    private $manager ;
    private $repo ;

    public function __construct(EntityManagerInterface $em)
        {
            $this->manager = $em ;
           $this->repo = $em->getRepository("App:User") ;
        }

    public function changeEmail(UserInterface $user , $email)
        {
            $mail = trim($email) ;
            if (($user2=$this->repo->findOneBy(["email"=>$mail])) !=null) {
                if ($user2->getUsername() ==$user->getUsername() )
                    return ("error-This is already Your email");
                else
                    return ("error-This Email Already Exists") ;

            }

                else {
                $user->setEmail($mail);
                $this->manager->persist($user);
                $this->manager->flush();
                return ("success-Email Changed Successfully") ;
            }
            }


}