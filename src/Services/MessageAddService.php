<?php

namespace App\Services;

use App\Entity\TblComment;
use Doctrine\ORM\EntityManagerInterface;
use PDO;

class MessageAddService
{
    private $em ;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em ;

    }

    public function addmessage($cinema)
    {
        //add_comment.php

        $connect = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');

        $error = '';
        $comment_name = '';
        $comment_content = '';
        $time= new \DateTime() ;

        if (empty($_POST["comment_name"])) {
            $error .= '<p class="text-danger"> Name is required</p>';
        } else {
            $comment_name = $_POST["comment_name"];
        }

        if (empty($_POST["comment_content"])) {
            $error .= '<p class="text-danger"> Comment is required</p>';
        } else {
            $comment_content = $_POST["comment_content"];
        }

        if ($error == '') {

            $query = "
                 INSERT INTO tbl_comment 
                 (cinema_id, comment, comment_sender_name,reply_time) 
                 VALUES (:cinema_id, :comment, :comment_sender_name,:reply_time)";


            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    ':cinema_id' => $cinema->getId(),
                    ':comment' => $comment_content,
                    ':comment_sender_name' => $comment_name,
                    ':reply_time'=>$time->format("Y-m-d H:i:s")
                )
            );
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
            //fetch_comment.php

        $connect = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');

        $query = "SELECT * FROM tbl_comment 
                WHERE cinema_id = :cinema_id
                ORDER BY reply_time ASC ";

        $statement = $connect->prepare($query);

        $statement->execute(array(':cinema_id'=>$cinema->getId()));

        $result = $statement->fetchAll();
        $output = '';
        foreach ($result as $row) {
            $output .= '
                     <div class="panel panel-default">
                      <div class="panel-heading">By <b>' . $row["comment_sender_name"] . '</b> on <i>' . $row["reply_time"] . '</i></div>
                      <div class="panel-body">' . $row["comment"] . '</div>
                                <div class="panel-footer" align="right"><button type="button" class="btn btn-info reply" id="' . $row["id"] . '">Reply</button></div>
                     </div> 
                     ';


        //    $output .= get_reply_comment($connect, $row["comment_id"]);
        }
/*
        echo $output;*/

        return $output ;

    }

}
