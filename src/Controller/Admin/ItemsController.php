<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->Items->find()
            ->contain(['Categories' => ['Restaurants']])
            ->orderBy(['Items.name' => 'ASC']);
        $items = $this->paginate($query);

        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $item = $this->Items->get($id, contain: ['Categories' => ['Restaurants']]);
        $this->set(compact('item'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('Produto salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o produto. Por favor, tente novamente.'));
        }
        $categories = $this->Items->Categories->find('list', limit: 200)->all();
        $this->set(compact('item', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $item = $this->Items->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('Produto salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o produto. Por favor, tente novamente.'));
        }
        $categories = $this->Items->Categories->find('list', limit: 200)->all();
        $this->set(compact('item', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('Produto excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o produto. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle availability method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null
     */
    public function toggleAvailable(?string $id = null)
    {
        $this->request->allowMethod(['post']);
        $item = $this->Items->get($id);
        $item->available = !$item->available;

        if ($this->Items->save($item)) {
            $status = $item->available ? 'disponível' : 'indisponível';
            $this->Flash->success(__("Produto marcado como {$status}."));
        } else {
            $this->Flash->error(__('Não foi possível alterar o status do produto.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
