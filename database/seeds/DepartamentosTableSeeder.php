<?php

use Illuminate\Database\Seeder;
use App\Departamento;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create(['nombre'=>'Guatemala']);
        Departamento::create(['nombre'=>'El Progreso']);
        Departamento::create(['nombre'=>'Sacatepéquez']);
        Departamento::create(['nombre'=>'Chimaltenango']);
        Departamento::create(['nombre'=>'Escuintla']);
        Departamento::create(['nombre'=>'Santa Rosa']);
        Departamento::create(['nombre'=>'Sololá']);
        Departamento::create(['nombre'=>'Totonicapán']);
        Departamento::create(['nombre'=>'Quetzaltenango']);
        Departamento::create(['nombre'=>'Suchitepéquez']);
        Departamento::create(['nombre'=>'Retalhuleu']);
        Departamento::create(['nombre'=>'San Marcos']);
        Departamento::create(['nombre'=>'Huehuetenango']);
        Departamento::create(['nombre'=>'Quiché']);
        Departamento::create(['nombre'=>'Baja Verapaz']);
        Departamento::create(['nombre'=>'Alta Verapaz']);
        Departamento::create(['nombre'=>'Petén']);
        Departamento::create(['nombre'=>'Izabal']);
        Departamento::create(['nombre'=>'Zacapa']);
        Departamento::create(['nombre'=>'Chiquimula']);
        Departamento::create(['nombre'=>'Jalapa']);
        Departamento::create(['nombre'=>'Jutiapa']);
    }
}
