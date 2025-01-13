<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_AR');
        $roleAdmin = Role::firstOrCreate(['name' => 'user_admin']);
        $roleStandard = Role::firstOrCreate(['name' => 'user_standard']);

        foreach (range(1, 10) as $index) {

            $nombre = $faker->firstName;
            $nombreNormalizado = $this->normalizarTexto($nombre);


            $user = User::create([
                'dni' => $faker->unique()->numberBetween(10000000, 99999999),
                'email' => "{$nombreNormalizado}@mail.com",
                'password' => Hash::make('tomastomas'),
                'rol' => $index === 1 ? 0 : 1,
            ]);


            $role = $index === 1 ? $roleAdmin : $roleStandard;
            $user->assignRole($role);
        }
    }

    /**
     * Normaliza un texto eliminando tildes y caracteres especiales.
     */
    private function normalizarTexto($texto)
    {
        $texto = strtolower($texto);
        $texto = preg_replace('/\s+/', '_', $texto);
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n'],
            $texto
        );
        $texto = preg_replace('/[^a-z0-9_]/', '', $texto);
        return $texto;
    }
}
