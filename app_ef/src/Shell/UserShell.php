<?php
declare(strict_types=1);

namespace App\Shell;

use Cake\Console\Shell;

class UserShell extends Shell
{
    public function main(): void
    {
        $hasher = new \Authentication\PasswordHasher\DefaultPasswordHasher();
        $hashedPassword = $hasher->hash('admin123');
        
        $usersTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->newEntity([
            'nombre' => 'Admin',
            'apellido' => 'Admin',
            'correo' => 'admin@example.com',
            'password' => $hashedPassword,
            'language' => 'es',
        ]);
        
        if ($usersTable->save($user)) {
            $this->out('Admin user created successfully!');
            $this->out('Email: admin@example.com');
            $this->out('Password: admin123');
        } else {
            $this->out('Error creating admin user');
        }
    }
}
