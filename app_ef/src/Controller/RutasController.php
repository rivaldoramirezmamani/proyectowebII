<?php
declare(strict_types=1);

namespace App\Controller;

class RutasController extends AppController
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

        $search = $this->request->getQuery('search');
        $searchType = $this->request->getQuery('searchType');

        if ($loggedInUser['correo'] === 'admin@example.com') {
            $query = $this->Rutas->find()->contain(['Users']);
            
            if ($search && $searchType === 'idruta') {
                $query->where(['idruta' => (int)$search]);
            } elseif ($search && $searchType === 'usuario') {
                $query->matching('Users', function ($q) use ($search) {
                    return $q->where(['Users.nombre LIKE' => '%' . $search . '%']);
                });
            }
            
            $rutas = $query->all();
            $this->set(compact('rutas', 'loggedInUser', 'search', 'searchType'));
        } else {
            $misRutas = $this->Rutas->find()
                ->where(['user_id' => $loggedInUser['id']])
                ->orderBy(['fecha_uso' => 'DESC'])
                ->all();
            
            $rutasDisponibles = $this->Rutas->find()
                ->where(['user_id IS NULL'])
                ->all();
            
            $this->set(compact('misRutas', 'rutasDisponibles', 'loggedInUser'));
        }
    }

    public function add()
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser || $loggedInUser['correo'] !== 'admin@example.com') {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $ruta = $this->Rutas->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $ruta = $this->Rutas->patchEntity($ruta, $data);
            
            if ($this->Rutas->save($ruta)) {
                $this->Flash->success('Ruta creada correctamente');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('No se pudo crear la ruta');
        }

        $this->set(compact('ruta', 'loggedInUser'));
    }

    public function edit($idruta = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser || $loggedInUser['correo'] !== 'admin@example.com') {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $ruta = $this->Rutas->get($idruta);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $ruta = $this->Rutas->patchEntity($ruta, $data);
            
            if ($this->Rutas->save($ruta)) {
                $this->Flash->success('Ruta actualizada correctamente');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('No se pudo actualizar la ruta');
        }

        $this->set(compact('ruta', 'loggedInUser'));
    }

    public function delete($idruta = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser || $loggedInUser['correo'] !== 'admin@example.com') {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $this->request->allowMethod(['post', 'delete']);
        
        $ruta = $this->Rutas->get($idruta);
        
        if ($this->Rutas->delete($ruta)) {
            $this->Flash->success('Ruta eliminada correctamente');
        } else {
            $this->Flash->error('No se pudo eliminar la ruta');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function usar($idruta = null)
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser) {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $ruta = $this->Rutas->get($idruta);
        
        if ($ruta->user_id !== null) {
            $this->Flash->error('Esta ruta ya fue usada');
            return $this->redirect(['action' => 'index']);
        }

        $ruta->user_id = $loggedInUser['id'];
        $ruta->fecha_uso = date('Y-m-d H:i:s');
        
        if ($this->Rutas->save($ruta)) {
            $this->Flash->success('Ruta guardada en tu historial');
        } else {
            $this->Flash->error('No se pudo guardar la ruta');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function theme()
    {
        $theme = $this->request->getData('theme');
        setcookie('theme', $theme, time() + (86400 * 30), '/');
        return $this->redirect('/rutas');
    }

    public function map()
    {
        $loggedInUser = $this->getUserFromCookie();
        
        if (!$loggedInUser) {
            return $this->redirect(['controller' => 'Login', 'action' => 'login']);
        }

        $rutasDisponibles = $this->Rutas->find()
            ->where(['user_id IS NULL'])
            ->all();
        
        $misRutas = $this->Rutas->find()
            ->where(['user_id' => $loggedInUser['id']])
            ->orderBy(['fecha_uso' => 'DESC'])
            ->all();
        
        $this->set(compact('loggedInUser', 'rutasDisponibles', 'misRutas'));
    }
}
