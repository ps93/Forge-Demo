<?php namespace App\Classes;
use App\Classes\Country;

class User {

        // variabili membro
        public $id ;
        public $firstName ;
        public $lastName;
        public $joinDate;
        public $phoneNumber;
        public $username ;
        public $email ;
        public $profileImageURL;
        public $country ;
        public $password;

        public function __construct($firstName,$username,$email,$password)
                {

                    $this->firstName = $firstName;
                    $this->$username = $username;
                    $this->email = $email;
                    $this-> $password = $password;

                }


        public function personSort( $a, $b )
        {
            return $a->age == $b->age ? 0 : ( $a->age > $b->age ) ? 1 : -1;
        }


}
