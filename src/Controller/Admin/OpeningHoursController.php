<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Entity\OpeningHour;

/**
 * OpeningHours Controller
 *
 * @property \App\Model\Table\OpeningHoursTable $OpeningHours
 */
class OpeningHoursController extends AppController
{
    /**
     * Index method - Lista horários por restaurante
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $restaurantId = $this->request->getQuery('restaurant_id');
        
        $restaurants = $this->fetchTable('Restaurants')->find('list')->all();
        
        $openingHours = [];
        $selectedRestaurant = null;
        
        if ($restaurantId) {
            $selectedRestaurant = $this->fetchTable('Restaurants')->get($restaurantId);
            
            // Inicializa os horários se necessário
            $this->OpeningHours->initializeForRestaurant((int)$restaurantId);
            
            $openingHours = $this->OpeningHours->findByRestaurant((int)$restaurantId)->all();
        }
        
        $daysOfWeek = OpeningHour::DAYS_OF_WEEK;
        
        $this->set(compact('openingHours', 'restaurants', 'restaurantId', 'selectedRestaurant', 'daysOfWeek'));
    }

    /**
     * Edit method - Edita horários de um restaurante
     *
     * @param string|null $restaurantId Restaurant id.
     * @return \Cake\Http\Response|null|void
     */
    public function edit(?string $restaurantId = null)
    {
        $restaurant = $this->fetchTable('Restaurants')->get($restaurantId);
        
        // Inicializa os horários se necessário
        $this->OpeningHours->initializeForRestaurant((int)$restaurantId);
        
        $openingHours = $this->OpeningHours->findByRestaurant((int)$restaurantId)->all()->toArray();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData('opening_hours');
            
            $success = true;
            foreach ($data as $dayData) {
                $hour = $this->OpeningHours->get($dayData['id']);
                
                // Se estiver fechado, limpa os horários
                if (!empty($dayData['is_closed'])) {
                    $dayData['open_time'] = null;
                    $dayData['close_time'] = null;
                }
                
                $hour = $this->OpeningHours->patchEntity($hour, $dayData);
                
                if (!$this->OpeningHours->save($hour)) {
                    $success = false;
                }
            }
            
            if ($success) {
                $this->Flash->success(__('Horários de funcionamento salvos com sucesso.'));
                return $this->redirect(['action' => 'index', '?' => ['restaurant_id' => $restaurantId]]);
            }
            
            $this->Flash->error(__('Não foi possível salvar os horários. Por favor, tente novamente.'));
        }
        
        $daysOfWeek = OpeningHour::DAYS_OF_WEEK;
        
        $this->set(compact('restaurant', 'openingHours', 'daysOfWeek'));
    }

    /**
     * Quick update - Atualização rápida via AJAX
     *
     * @return \Cake\Http\Response|null
     */
    public function quickUpdate()
    {
        $this->request->allowMethod(['post']);
        
        $id = $this->request->getData('id');
        $field = $this->request->getData('field');
        $value = $this->request->getData('value');
        
        $hour = $this->OpeningHours->get($id);
        $hour->set($field, $value);
        
        $response = ['success' => false];
        
        if ($this->OpeningHours->save($hour)) {
            $response['success'] = true;
        }
        
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }
}
