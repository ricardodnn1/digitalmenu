<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Banners Controller
 *
 * @property \App\Model\Table\BannersTable $Banners
 */
class BannersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->Banners->find()
            ->contain(['Restaurants'])
            ->orderBy(['Banners.restaurant_id' => 'ASC', 'Banners.position' => 'ASC']);
        $banners = $this->paginate($query);

        $this->set(compact('banners'));
    }

    /**
     * View method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $banner = $this->Banners->get($id, contain: ['Restaurants']);
        $this->set(compact('banner'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $banner = $this->Banners->newEmptyEntity();
        if ($this->request->is('post')) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('Banner salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o banner. Por favor, tente novamente.'));
        }
        $restaurants = $this->Banners->Restaurants->find('list', limit: 200)->all();
        $this->set(compact('banner', 'restaurants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $banner = $this->Banners->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('Banner salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o banner. Por favor, tente novamente.'));
        }
        $restaurants = $this->Banners->Restaurants->find('list', limit: 200)->all();
        $this->set(compact('banner', 'restaurants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $banner = $this->Banners->get($id);
        if ($this->Banners->delete($banner)) {
            $this->Flash->success(__('Banner excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o banner. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle active status
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null
     */
    public function toggleActive(?string $id = null)
    {
        $this->request->allowMethod(['post']);
        $banner = $this->Banners->get($id);
        $banner->is_active = !$banner->is_active;

        if ($this->Banners->save($banner)) {
            $status = $banner->is_active ? 'ativado' : 'desativado';
            $this->Flash->success(__("Banner {$status} com sucesso."));
        } else {
            $this->Flash->error(__('Não foi possível alterar o status do banner.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reorder banners
     *
     * @return \Cake\Http\Response|null
     */
    public function reorder()
    {
        $this->request->allowMethod(['post']);
        $positions = $this->request->getData('positions');

        if (!empty($positions)) {
            foreach ($positions as $id => $position) {
                $banner = $this->Banners->get($id);
                $banner->position = (int)$position;
                $this->Banners->save($banner);
            }
            $this->Flash->success(__('Ordem dos banners atualizada com sucesso.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
