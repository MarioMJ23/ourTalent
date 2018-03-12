<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(PaisesTableSeeder::class);
    $this->call(EstadosTableSeeder::class);
    $this->call(CiudadesTableSeeder::class);
    $this->call(Ciudades2TableSeeder::class);
    $this->call(Ciudades3TableSeeder::class);
    $this->call(TiposDeUsuarioTableSeeder::class);
    $this->call(TiposDeSangreTableSeeder::class);
    $this->call(TiposDeInstitucionTableSeeder::class);
    $this->call(TiposDeActividadTableSeeder::class);
    $this->call(TiposDeArchivoTableSeeder::class);
    $this->call(ActividadesTableSeeder::class);
    $this->call(InstitucionesTableSeeder::class);
    $this->call(UsuariosTableSeeder::class);
    $this->call(UsuarioActividadesTableSeeder::class);
    $this->call(ArchivosTableSeeder::class);
    $this->call(PesosTableSeeder::class);
    $this->call(TallasTableSeeder::class);
  }
}
