<?php

namespace App\Infile;

class ComplementoCambiaria  {

    private $id_complemento;

    private $nombre_complemento;

    private $uri_complemento;

    private $abono = [];

    public function setAbono($abono)
    {
        array_push($this->abono,$abono);
    }

    public function getAbono()
    {
        return $this->abono;
    }
  

    public function getIdComplemento() {
        return $this->id_complemento;
    }

    public function setIdComplemento($idComplemento) {
        $this->id_complemento = $idComplemento;
    }

    public function getNombreComplemento() {
        return $this->nombre_complemento;
    }

    public function setNombreComplemento($nombreComplemento) {
        $this->nombre_complemento = $nombreComplemento;
    }

    public function getUriComplemento() {
        return $this->uri_complemento;
    }

    public function setUriComplemento($uriComplemento) {
        $this->uri_complemento = $uriComplemento;
    }

  
}
