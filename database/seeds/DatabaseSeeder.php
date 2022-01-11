<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersSeeder::class);
        $this->call(NegocioSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(EstadoPagoSeeder::class);
        $this->call(TipoPersonaSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(TipoPagoSeeder::class);
        $this->call(TipoFacturaSeeder::class);
        $this->call(TipoAbonoSeeder::class);
        $this->call(TipoTransporteSeeder::class);
        $this->call(TipoDocumentoImportacionSeeder::class);
        $this->call(TipoProveedorSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(PerfilesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserPerfilSeeder::class);
        
        //$this->call(TiposLocalidadesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
    }
}
