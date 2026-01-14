<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Utility\Security;

/**
 * AdminUsers Controller
 *
 * @property \App\Model\Table\AdminUsersTable $AdminUsers
 */
class AdminUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->AdminUsers->find()
            ->contain(['Restaurants']);
        $adminUsers = $this->paginate($query);

        $this->set(compact('adminUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin User id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $adminUser = $this->AdminUsers->get($id, contain: ['Restaurants']);
        $this->set(compact('adminUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $adminUser = $this->AdminUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Hash da senha antes de salvar
            if (!empty($data['password'])) {
                $data['password'] = Security::hash($data['password'], 'sha256', true);
            }
            $adminUser = $this->AdminUsers->patchEntity($adminUser, $data);
            if ($this->AdminUsers->save($adminUser)) {
                $this->Flash->success(__('Usuário admin salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o usuário admin. Por favor, tente novamente.'));
        }
        $restaurants = $this->AdminUsers->Restaurants->find('list', limit: 200)->all();
        $this->set(compact('adminUser', 'restaurants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin User id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $adminUser = $this->AdminUsers->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Hash da senha apenas se foi alterada
            if (!empty($data['password'])) {
                $data['password'] = Security::hash($data['password'], 'sha256', true);
            } else {
                unset($data['password']);
            }
            $adminUser = $this->AdminUsers->patchEntity($adminUser, $data);
            if ($this->AdminUsers->save($adminUser)) {
                $this->Flash->success(__('Usuário admin salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o usuário admin. Por favor, tente novamente.'));
        }
        $restaurants = $this->AdminUsers->Restaurants->find('list', limit: 200)->all();
        $this->set(compact('adminUser', 'restaurants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $adminUser = $this->AdminUsers->get($id);
        if ($this->AdminUsers->delete($adminUser)) {
            $this->Flash->success(__('Usuário admin excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o usuário admin. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
