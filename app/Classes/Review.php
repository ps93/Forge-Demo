<?php namespace App\Classes;
use App\Classes\User;

class Review {

        public $title;
        public $imageURL;
        public $rating;
        public $created;
        public $id;


        public function __construct($id,$title,$imageURL,$rating,$created)
                {
                    //inizializzazione della proprietà $name
                    $this->id = $id;
                    $this->title = $title;
                    $this->imageURL = $imageURL;
                    $this->rating = $rating;
                    $this->created = $created;
                  /*  $this->user = new User
                    ($user->firstName,
                    $user->id,
                    $user->lastName,
                    $user->joinDate,
                    $user->country,
                    $user->phoneNumber,
                    $user->username,
                    $user->email,
                    $user->profileImageURL);
*/
                }


      }
