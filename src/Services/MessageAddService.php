<?php

namespace App\Services;

use App\Entity\Cinema;
use App\Entity\TblComment;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MessageAddService
{
    private $em ;
    private $ratingHelper ;
    private $container  ;

    public function __construct(EntityManagerInterface $em,CinemaRatingService $cinemaRatingService,ContainerInterface $container)
    {
        $this->em=$em ;
        $this->ratingHelper= $cinemaRatingService ;
        $this->container = $container ;
    }

    public function addmessage($cinema,UserInterface $user)
    {
        $error = '';

        $comment_content = '';
        $time= new \DateTime() ;

        if (!isset($user))
        {
            $error .= '<p class="text-danger"> User isnt logged in</p>';
        }
        if (empty($_POST["comment_content"])) {
            $error .= '<p class="text-danger"> Comment is required</p>';
        } else {
            $comment_content = $_POST["comment_content"];
        }

        if ($error == '') {

            $comment = new TblComment() ;
            $comment->setCinema($cinema) ;
            $comment->setUser($user) ;
            $comment->setReplyTime($time) ;
            $comment->setComment($comment_content) ;

            $this->em->persist($comment);
            $this->em->flush();
            $error = '<label class="text-success">Comment Added</label>';
        }

        $data = array(
            'error' => $error
        );

        echo json_encode($data);
        return json_encode($data) ;
    }

    public function fetchmessage($cinema)
    {
       $comments= $this->em->getRepository(TblComment::class)->findBy(['cinema'=>$cinema]) ;
       $ratings = [] ;
      // $repo = $this->em->getRepository(CinemaRating::class) ;
       $i=0  ;
       foreach ($comments as $comment)
       {$ratings[$i]=$this->ratingHelper->getRating($cinema,$comment->getUser()) ;
       $i++ ;
       }
        $twig = $this->container->get('twig');
        $output = '';

        foreach ($comments as $key=>$comment) {
            $ratingOutput=$twig->render("cinemas/renderRating.html.twig",["rating"=>$ratings[$key]->getRating()]) ;
            $output .= '
                     <div class="panel panel-default">
                      <div class="panel-heading">By <b>' . $comment->getUser()->getUsername() . '</b> on <i>' . $comment->getReplyTime()->format("d-m-Y \A\\t H:i:s") . '</i>
                        '.$ratingOutput.'
                      </div>
                      <div class="panel-body">' . $comment->getComment() . '</div>
                       <br/>
                     </div> 
                     ';
        //    $output .= get_reply_comment($connect, $row["comment_id"]);
        }
/*
        echo $output;*/
        return $output ;
    }

}
