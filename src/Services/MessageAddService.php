<?php

namespace App\Services;

use App\Entity\TblComment;
use PDO;

class MessageAddService
{
    public function addmessage()
    {
        //add_comment.php

        $connect = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');

        $error = '';
        $comment_name = '';
        $comment_content = '';

        if (empty($_POST["comment_name"])) {
            $error .= '<p class="text-danger">test Name is required</p>';
        } else {
            $comment_name = $_POST["comment_name"];
        }

        if (empty($_POST["comment_content"])) {
            $error .= '<p class="text-danger">test Comment is required</p>';
        } else {
            $comment_content = $_POST["comment_content"];
        }

        if ($error == '') {
            $query = "
 INSERT INTO tbl_comment 
 (parent_comment_id, comment, comment_sender_name) 
 VALUES (:parent_comment_id, :comment, :comment_sender_name)
 ";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    ':parent_comment_id' => $_POST["comment_id"],
                    ':comment' => $comment_content,
                    ':comment_sender_name' => $comment_name
                )
            );
            $error = '<label class="text-success">Comment Added</label>';
        }

        $data = array(
            'error' => $error
        );

        echo json_encode($data);
    }

    public function fetchmessage()
    {
            //fetch_comment.php

        $connect = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');

        $query = "
SELECT * FROM tbl_comment 
WHERE parent_comment_id = '0' 
ORDER BY comment_id DESC
";

        $statement = $connect->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();
        $output = '';
        foreach ($result as $row) {
            $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>' . $row["comment_sender_name"] . '</b> on <i>' . $row["date"] . '</i></div>
  <div class="panel-body">' . $row["comment"] . '</div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="' . $row["comment_id"] . '">Reply</button></div>
 </div> 
 ';
            $output .= get_reply_comment($connect, $row["comment_id"]);
        }

        echo $output;

        function get_reply_comment($parent_id = 0, $marginleft = 0)
        {  $connect = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');
            $query = "
 SELECT * FROM tbl_comment WHERE parent_comment_id = '" . $parent_id . "'
 ";
            $output = '';
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $count = $statement->rowCount();
            if ($parent_id == 0) {
                $marginleft = 0;
            } else {
                $marginleft = $marginleft + 48;
            }
            if ($count > 0) {
                foreach ($result as $row) {
                    $output .= '
   <div class="panel panel-default" style="margin-left:' . $marginleft . 'px">
    <div class="panel-heading">By <b>' . $row["comment_sender_name"] . '</b> on <i>' . $row["date"] . '</i></div>
    <div class="panel-body">' . $row["comment"] . '</div>
    <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="' . $row["comment_id"] . '">Reply</button></div>
   </div>
   ';
                    $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
                }
            }
            return $output;
        }

    }
}
