<?php namespace App\Classes;
class Location {

        // variabili membro
        public $id = "";
        public $name = "";

        public function __construct($id,$name)
                {

                    $this->id = $id;
                    $this->name = $name;
                }

}
