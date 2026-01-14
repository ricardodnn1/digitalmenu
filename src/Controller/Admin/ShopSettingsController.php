<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Http\Response;

/**
 * ShopSettings Controller
 *
 * @property \App\Model\Table\ShopSettingsTable $ShopSettings
 */
class ShopSettingsController extends AppController
{
    /**
     * Index method - Shop settings dashboard
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            
            foreach ($data as $key => $value) {
                // Handle checkbox for boolean
                if ($key === 'online_payment_enabled') {
                    $value = isset($value) && $value === '1';
                }
                
                $this->ShopSettings->setValue($key, $value);
            }
            
            $this->Flash->success(__('Configurações salvas com sucesso!'));
            return $this->redirect(['action' => 'index']);
        }

        $settings = $this->ShopSettings->getAllSettings();
        $isOnlinePaymentEnabled = $this->ShopSettings->isOnlinePaymentEnabled();
        $whatsappSettings = $this->ShopSettings->getWhatsAppSettings();

        $this->set(compact('settings', 'isOnlinePaymentEnabled', 'whatsappSettings'));
    }

    /**
     * Toggle online payment
     *
     * @return \Cake\Http\Response|null
     */
    public function togglePayment(): ?Response
    {
        $this->request->allowMethod(['post']);
        
        $currentValue = $this->ShopSettings->isOnlinePaymentEnabled();
        $this->ShopSettings->setValue('online_payment_enabled', !$currentValue);
        
        $status = !$currentValue ? 'habilitado' : 'desabilitado';
        $this->Flash->success(__('Pagamento online {0}!', $status));

        return $this->redirect(['action' => 'index']);
    }
}
