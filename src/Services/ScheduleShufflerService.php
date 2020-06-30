<?php


namespace App\Services;


use App\Entity\MoviePlanning;
use App\Entity\Planning;

class ScheduleShufflerService
{
    public function init(&$arr,Planning $planning)
        {
            $today=$planning->getStartingDate()->format("Y-m-d");
            for ($i=1 ;$i<=7;$i++)
            {
                $arr[$today]=array() ;
                $today = date('Y-m-d',strtotime($today . "+1 days"));

            }

        }

    public function shuffle(&$arr)
    {
        foreach($arr as $column)
        {
            usort($column, ["App\\Services\\ScheduleShufflerService","sort_by_date_element"]);
        }
        uksort($arr,["App\\Services\\ScheduleShufflerService","sort_by_date_week"]);

        foreach ($arr as $key=>$column )
        {$currentKey=date("l",strtotime($key)) ;
            $arr[$currentKey]=$arr[$key];
            unset ($arr[$key]) ;
        }

    }


    private static function sort_by_date_element( $a, $b) {
        $a = strtotime(date_format($a->getStartingTime(),"Y-m-d H:m"));
        $b = strtotime(date_format($b->getStartingTime(),"Y-m-d H:m"));
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    private static function sort_by_date_week($a,$b)
    {   $a = strtotime($a);
        $b = strtotime($b);
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

}