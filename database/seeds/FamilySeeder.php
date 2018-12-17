<?php

use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [        
            ['name' => 'Aglomerado', 'description' => ''],
            ['name' => 'Angulares', 'description' => ''],
            ['name' => 'Armado', 'description' => ''],
            ['name' => 'Barniz', 'description' => ''],
            ['name' => 'Brochas', 'description' => ''],
            ['name' => 'Catalizador', 'description' => ''],
            ['name' => 'Clavillos', 'description' => ''],
            ['name' => 'Colas y Pegamentos', 'description' => ''],
            ['name' => 'Combustible', 'description' => ''],
            ['name' => 'Diluyente', 'description' => ''],
            ['name' => 'Enchape', 'description' => ''],
            ['name' => 'Endurecedor', 'description' => ''],
            ['name' => 'Esmalte', 'description' => ''],
            ['name' => 'Estructura', 'description' => ''],
            ['name' => 'Fondos', 'description' => ''],
            ['name' => 'Grampaz', 'description' => ''],
            ['name' => 'HDF', 'description' => ''],
            ['name' => 'Herramientas', 'description' => ''],
            ['name' => 'Instalacion', 'description' => ''],
            ['name' => 'Laca', 'description' => ''],
            ['name' => 'Lijas', 'description' => ''],
            ['name' => 'Limpieza', 'description' => ''],
            ['name' => 'Mantenimiento', 'description' => ''],
            ['name' => 'Marco', 'description' => ''],
            ['name' => 'Masquin Pulidor Franelas', 'description' => ''],
            ['name' => 'Material de Empaque', 'description' => ''],
            ['name' => 'Material de Trabajo', 'description' => ''],
            ['name' => 'MDF', 'description' => ''],
            ['name' => 'Melamina', 'description' => ''],
            ['name' => 'Multilaminado', 'description' => ''],
            ['name' => 'Otros', 'description' => ''],
            ['name' => 'Otros Tintes', 'description' => ''],
            ['name' => 'Pincel', 'description' => ''],
            ['name' => 'Pinturas', 'description' => ''],
            ['name' => 'Plancha', 'description' => ''],
            ['name' => 'Puerta Contraplacada', 'description' => ''],
            ['name' => 'Remaches', 'description' => ''],
            ['name' => 'Repuestos', 'description' => ''],
            ['name' => 'Rieles y Bisagras', 'description' => ''],
            ['name' => 'Tablero', 'description' => ''],
            ['name' => 'Tapaporos', 'description' => ''],
            ['name' => 'Tinte Base Agua', 'description' => ''],
            ['name' => 'Tinte Concentrado', 'description' => ''],
            ['name' => 'Tinte Martin', 'description' => ''],
            ['name' => 'Tinte Solvente', 'description' => ''],
            ['name' => 'Tornillos', 'description' => ''],
            ['name' => 'Venesta', 'description' => ''],
            ['name' => 'Venesta-Colada', 'description' => '']
        ];

        foreach($types as $type) {
            App\Family::create($type);
        }
    }
}
