<?php namespace App\Classes;
use App\Classes\User;

class Snap {

        public $imageURL;
        public $rating;
        public $category;
        public $subCategory;
        public $likes;


        public function __construct($likes,$imageURL,$rating,$category,$subCategory)
                {

                    $this->likes = $likes;
                    $this->imageURL = $imageURL;
                    $this->rating = $rating;
                    $this->category = $category;
                    $this->subCategory = $subCategory;
                }


      }
