<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * FooterInfo Controller
 *
 * @property \App\Model\Table\FooterInfoTable $FooterInfo
 */
class FooterInfoController extends AppController
{
    /**
     * Index method - Lista e edita footer por restaurante
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $restaurantId = $this->request->getQuery('restaurant_id');
        
        $restaurants = $this->fetchTable('Restaurants')->find('list')->all();
        
        $footerInfo = null;
        $selectedRestaurant = null;
        
        if ($restaurantId) {
            $selectedRestaurant = $this->fetchTable('Restaurants')->get($restaurantId);
            $footerInfo = $this->FooterInfo->getOrCreateForRestaurant((int)$restaurantId);
        }
        
        $this->set(compact('footerInfo', 'restaurants', 'restaurantId', 'selectedRestaurant'));
    }

    /**
     * Edit method - Edita informações do footer
     *
     * @param string|null $restaurantId Restaurant id.
     * @return \Cake\Http\Response|null|void
     */
    public function edit(?string $restaurantId = null)
    {
        $restaurant = $this->fetchTable('Restaurants')->get($restaurantId);
        $footerInfo = $this->FooterInfo->getOrCreateForRestaurant((int)$restaurantId);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $footerInfo = $this->FooterInfo->patchEntity($footerInfo, $this->request->getData());
            
            if ($this->FooterInfo->save($footerInfo)) {
                $this->Flash->success(__('Informações do rodapé salvas com sucesso.'));
                return $this->redirect(['action' => 'index', '?' => ['restaurant_id' => $restaurantId]]);
            }
            
            $this->Flash->error(__('Não foi possível salvar as informações. Por favor, tente novamente.'));
        }
        
        $this->set(compact('restaurant', 'footerInfo'));
    }

    /**
     * View method
     *
     * @param string|null $id FooterInfo id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $footerInfo = $this->FooterInfo->get($id, contain: ['Restaurants']);
        $this->set(compact('footerInfo'));
    }

    /**
     * Delete method - Limpa todas as informações do footer
     *
     * @param string|null $id FooterInfo id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $footerInfo = $this->FooterInfo->get($id);
        $restaurantId = $footerInfo->restaurant_id;
        
        if ($this->FooterInfo->delete($footerInfo)) {
            $this->Flash->success(__('Informações do rodapé removidas com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível remover as informações. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['restaurant_id' => $restaurantId]]);
    }
}
