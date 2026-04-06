<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use PDO;

class LoginController extends AppController
{
    public function login()
    {
        $userData = $this->request->getCookie('user_data');
        if ($userData) {
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
        
        $this->viewBuilder()->setLayout('dark');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $this->Flash->error('Credenciales inválidas');
            } else {
                $pdo = new PDO('mysql:host=192.168.56.250;port=3306;dbname=db_ef', 'rivaldo', 'rivaldo123');
                $stmt = $pdo->prepare('SELECT * FROM users WHERE correo = :correo AND correo IS NOT NULL LIMIT 1');
                $stmt->execute(['correo' => $username]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result && isset($result['password']) && !empty($result['password'])) {
                    if (password_verify($password, $result['password'])) {
                        $userData = base64_encode(json_encode([
                            'id' => $result['id'],
                            'nombre' => $result['nombre'],
                            'apellido' => $result['apellido'],
                            'correo' => $result['correo'],
                            'language' => $result['language']
                        ]));
                        
                        setcookie('user_data', $userData, time() + 3600, '/');
                        
                        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
                    }
                }
                
                $this->Flash->error('Credenciales inválidas');
            }
        }
    }

    public function logout()
    {
        setcookie('user_data', '', time() - 3600, '/');
        return $this->redirect(['action' => 'login']);
    }
}
