<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    private function getUserFromCookie()
    {
        $userData = $this->request->getCookie('user_data');
        if ($userData) {
            return json_decode(base64_decode($userData), true);
        }
        return null;
    }

    public function index()
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser) {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        // Si es admin, ve todos los usuarios
        if ($loggedInUser['correo'] === 'admin@example.com') {
            $users = $this->Users->find()->all();
            $this->set(compact('users', 'loggedInUser'));
        } else {
            // Usuario normal solo ve su propio registro
            $user = $this->Users->get($loggedInUser['id']);
            $this->set(compact('user', 'loggedInUser'));
        }
    }

    public function view($id = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser) {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        // Solo el admin puede ver cualquier usuario
        if ($loggedInUser['correo'] === 'admin@example.com') {
            $user = $this->Users->get($id, contain: []);
            $this->set(compact('user', 'loggedInUser'));
        } else {
            // Usuario normal solo puede verse a sí mismo
            $user = $this->Users->get($loggedInUser['id']);
            $this->set(compact('user', 'loggedInUser'));
        }
    }

    public function add()
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser || $loggedInUser['correo'] !== 'admin@example.com') {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // No hacer hash aquí - el entity ya lo hace con _setPassword
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, intente de nuevo.'));
        }
        $this->set(compact('user', 'loggedInUser'));
    }

    public function edit($id = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser) {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        // Admin puede editar cualquier usuario, usuario normal solo su propio perfil
        if ($loggedInUser['correo'] !== 'admin@example.com' && $loggedInUser['id'] != $id) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Si no hay password nueva, no la enviamos al entity
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no pudo ser actualizado. Por favor, intente de nuevo.'));
        }

        $this->set(compact('user', 'loggedInUser'));
    }

    public function delete($id = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser || $loggedInUser['correo'] !== 'admin@example.com') {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El usuario no pudo ser eliminado. Por favor, intente de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}