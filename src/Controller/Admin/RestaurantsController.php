<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Restaurants Controller
 *
 * @property \App\Model\Table\RestaurantsTable $Restaurants
 */
class RestaurantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->Restaurants->find();
        $restaurants = $this->paginate($query);

        $this->set(compact('restaurants'));
    }

    /**
     * View method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $restaurant = $this->Restaurants->get($id, contain: ['Categories', 'AdminUsers']);
        $this->set(compact('restaurant'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $restaurant = $this->Restaurants->newEmptyEntity();
        if ($this->request->is('post')) {
            $restaurant = $this->Restaurants->patchEntity($restaurant, $this->request->getData());
            if ($this->Restaurants->save($restaurant)) {
                $this->Flash->success(__('Restaurante salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o restaurante. Por favor, tente novamente.'));
        }
        $this->set(compact('restaurant'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $restaurant = $this->Restaurants->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $restaurant = $this->Restaurants->patchEntity($restaurant, $this->request->getData());
            if ($this->Restaurants->save($restaurant)) {
                $this->Flash->success(__('Restaurante salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o restaurante. Por favor, tente novamente.'));
        }
        $this->set(compact('restaurant'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $restaurant = $this->Restaurants->get($id);
        if ($this->Restaurants->delete($restaurant)) {
            $this->Flash->success(__('Restaurante excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o restaurante. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
