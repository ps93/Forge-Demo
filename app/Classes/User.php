<?php namespace App\Classes;
class User {

        // variabili membro
        public $a = 10;
        public $id = "";
        public $firstName = "";
        public $lastName ="";
        public $joinDate = "";
        public $country = "";
        public $phoneNumber = "";
        public $username ="";
        public $email = "";
        public $profileImageURL ="";

        public function __construct($firstName,$id,$lastName,$joinDate,$country,$phoneNumber,$username,$email,$profileImageURL)
                {
                    //inizializzazione della proprietà $name
                    $this->id = $id;
                    $this->firstName = $firstName;
                    $this->lastName = $lastName;
                    $this->joinDate = $joinDate;
                    $this->country = $country;
                    $this->phoneNumber = $phoneNumber;
                    $this->username = $username;
                    $this->email = $email;
                    $this->profileImageURL = $profileImageURL;

                }

       
        public function personSort( $a, $b )
        {
            return $a->age == $b->age ? 0 : ( $a->age > $b->age ) ? 1 : -1;
        }


}
