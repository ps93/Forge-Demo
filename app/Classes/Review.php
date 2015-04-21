<?php namespace App\Classes;
use App\Classes\User;

class Review {

        public $title;
        public $imageURL;
        public $rating;
        public $created;
        public $user;


        public function __construct($title,$imageURL,$rating,$created,$user)
                {
                    //inizializzazione della proprietà $name
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
    $this->user = new User("user",1,"lastName","joinDate","country","phoneNumber","username","email","profileImageURL");
                }


      }
