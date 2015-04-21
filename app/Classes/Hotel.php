<?php namespace App\Classes;
class Hotel {

        public $id = "";
        public $name = "";
        public $category ="";
        public $reviewCount = "";
        public $rating = "";
        public $ranking = 0;
        public $imageURL ="";

        

        public function __construct($id,$name,$category,$reviewCount,$rating,$ranking,$imageURL)
                {
                    //inizializzazione della proprietà $name
                    $this->id = $id;
                    $this->name = $name;
                    $this->category = $category;
                    $this->reviewCount = $reviewCount;
                    $this->rating = $rating;
                    $this->ranking = $ranking;
                    $this->imageURL = $imageURL;

                }


      }
