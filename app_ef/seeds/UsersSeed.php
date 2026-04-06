<?php
declare(strict_types=1);

namespace App\Database\Seed;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Phinx\Seed\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $hasher = new \Authentication\PasswordHasher\DefaultPasswordHasher();
        $hashedPassword = $hasher->hash('admin123');
        
        $users = $this->table('users');
        $users->insert([
            'nombre' => 'Admin',
            'apellido' => 'Admin',
            'correo' => 'admin@example.com',
            'password' => $hashedPassword,
            'language' => 'es',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])->save();
    }
}
