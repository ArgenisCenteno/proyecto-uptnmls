<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'analista']);
        Role::create(['name' => 'personal']);

        // Crear usuarios y asignar roles
        $superAdmin = User::create([
            'name' => 'Argenis Centeno',
            'email' => 'argneniscentenno@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $superAdmin->assignRole('superAdmin');

        $empleado = User::create([
            'name' => 'Jose Cabrices',
            'email' => 'josecabrices@example.com',
            'password' => Hash::make('1234'),
        ]);
        $empleado->assignRole('analista');

        $cliente = User::create([
            'name' => 'Empleado',
            'email' => 'empleado@example.com',
            'password' => Hash::make('1234'),
        ]);
        $cliente->assignRole('personal');
    }
}
