<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * CustomerAuth Controller
 *
 * Handles customer authentication for the shop
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomerAuthController extends AppController
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // Load customers table
        $this->Customers = $this->fetchTable('Customers');
    }

    /**
     * Login page
     *
     * @return \Cake\Http\Response|null|void
     */
    public function login()
    {
        $this->viewBuilder()->setLayout('shop');
        
        // Check if online payment is enabled
        $shopSettingsTable = $this->fetchTable('ShopSettings');
        if (!$shopSettingsTable->isOnlinePaymentEnabled()) {
            $this->Flash->error('O login não está disponível no modo WhatsApp.');
            return $this->redirect(['controller' => 'Pages', 'action' => 'shop']);
        }

        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $password = $this->request->getData('password');
            
            $customer = $this->Customers->findByEmail($email);
            
            if ($customer && (new DefaultPasswordHasher())->check($password, $customer->password)) {
                // Update last login
                $customer->last_login = new \Cake\I18n\DateTime();
                $this->Customers->save($customer);
                
                // Store in session
                $this->request->getSession()->write('Customer', [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]);
                
                $this->Flash->success('Bem-vindo(a), ' . $customer->getFirstName() . '!');
                
                // Redirect to intended page or shop
                $redirect = $this->request->getSession()->read('Customer.redirect');
                if ($redirect) {
                    $this->request->getSession()->delete('Customer.redirect');
                    return $this->redirect($redirect);
                }
                
                return $this->redirect(['controller' => 'Pages', 'action' => 'shop']);
            }
            
            $this->Flash->error('E-mail ou senha incorretos.');
        }
        
        $this->set('title', 'Entrar na sua conta');
    }

    /**
     * Register page
     *
     * @return \Cake\Http\Response|null|void
     */
    public function register()
    {
        $this->viewBuilder()->setLayout('shop');
        
        // Check if online payment is enabled
        $shopSettingsTable = $this->fetchTable('ShopSettings');
        if (!$shopSettingsTable->isOnlinePaymentEnabled()) {
            $this->Flash->error('O cadastro não está disponível no modo WhatsApp.');
            return $this->redirect(['controller' => 'Pages', 'action' => 'shop']);
        }

        $customer = $this->Customers->newEmptyEntity();

        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity(
                $customer,
                $this->request->getData(),
                ['validate' => 'register']
            );

            if ($this->Customers->save($customer)) {
                // Auto login after registration
                $this->request->getSession()->write('Customer', [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]);
                
                $this->Flash->success('Cadastro realizado com sucesso! Bem-vindo(a)!');
                return $this->redirect(['controller' => 'Pages', 'action' => 'shop']);
            }
            
            $this->Flash->error('Não foi possível completar o cadastro. Verifique os dados informados.');
        }

        $this->set(compact('customer'));
        $this->set('title', 'Criar sua conta');
    }

    /**
     * Logout
     *
     * @return \Cake\Http\Response|null
     */
    public function logout(): ?Response
    {
        $this->request->getSession()->delete('Customer');
        $this->Flash->success('Você saiu da sua conta.');
        return $this->redirect(['controller' => 'Pages', 'action' => 'shop']);
    }

    /**
     * Profile page
     *
     * @return \Cake\Http\Response|null|void
     */
    public function profile()
    {
        $this->viewBuilder()->setLayout('shop');
        
        $customerId = $this->request->getSession()->read('Customer.id');
        if (!$customerId) {
            $this->Flash->error('Você precisa fazer login para acessar seu perfil.');
            return $this->redirect('/entrar');
        }

        $customer = $this->Customers->get($customerId, contain: ['CustomerAddresses']);

        if ($this->request->is(['post', 'put'])) {
            // Don't update password if empty
            $data = $this->request->getData();
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $customer = $this->Customers->patchEntity($customer, $data);
            
            if ($this->Customers->save($customer)) {
                // Update session
                $this->request->getSession()->write('Customer', [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]);
                
                $this->Flash->success('Seus dados foram atualizados!');
                return $this->redirect(['action' => 'profile']);
            }
            
            $this->Flash->error('Não foi possível atualizar seus dados.');
        }

        $this->set(compact('customer'));
        $this->set('title', 'Meu Perfil');
    }
}
