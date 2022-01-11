<?php

namespace App\Infile;

class Adendas {

   private $adenda = array();


   public function getAdenda() {
       return $this->adenda;
   }


   public function setAdenda($llave, $valor) {
       $this->adenda[$llave] = $valor;
   }
}
