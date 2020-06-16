<?php

namespace App\Services;
use App\Entity\Cinema;

class ImageSaverService
{

    private $cinemaPath ;

    public function __construct($cinemaPath)
    {
        $this->cinemaPath=$cinemaPath;
    }

    public function saveImage(Cinema $cinema , $file)
    {
        $newImageName = md5(uniqid()).".".$file->guessExtension();
        $file->move($this->cinemaPath,$newImageName);
        $cinema->setImagePath($newImageName) ;
    }

}