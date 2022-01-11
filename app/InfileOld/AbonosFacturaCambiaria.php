<?php

namespace App\Infile;

class AbonosFacturaCambiaria {

    private $numero_abono;

    private $fecha_vencimiento;

    private $monto_abono;

    public function getNumeroAbono() {
        return $this->numero_abono;
    }

    public function setNumeroAbono($numeroAbono) {
        $this->numero_abono = $numeroAbono;
    }

    public function getFechaVencimiento() {
        return $this->fecha_vencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento) {
        $this->fecha_vencimiento = $fechaVencimiento;
    }

    public function getMontoAbono() {
        return $this->monto_abono;
    }

    public function setMontoAbono($montoAbono) {
        $this->monto_abono = $montoAbono;
    }

}

