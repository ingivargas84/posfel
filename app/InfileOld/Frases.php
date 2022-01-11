<?php

namespace App\Infile;

class Frases {

    private $tipo_frase;

    private $codigo_escenario;

    private $numero_resolucion;

    private $fecha_resolucion;

    public function getTipoFrase() {
        return $this->tipo_frase;
    }

    public function setTipoFrase($tipoFrase) {
        $this->tipo_frase = $tipoFrase;
    }

    public function getCodigoEscenario() {
        return $this->codigo_escenario;
    }

    public function setCodigoEscenario($codigoExcenario) {
        $this->codigo_escenario = $codigoExcenario;
    }

    public function getNumeroResolucion() {
        return $this->numero_resolucion;
    }

    public function setNumeroResolucion($numeroResolucion) {
        $this->numero_resolucion = $numeroResolucion;
    }


    public function getFechaResolucion() {
    return $this->fecha_resolucion;
    }


    public function setFechaResolucion($fechaResolucion) {
    $this->fecha_resolucion = $fechaResolucion;

    }


}
