<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController;

/**
 * Auth Controller
 *
 * Handles admin authentication (login/logout)
 */
class AuthController extends BaseController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // Load Authentication component
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * Before filter - allow login/logout without authentication
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow login and logout without authentication
        $this->Authentication->allowUnauthenticated(['login', 'logout']);
    }

    /**
     * Login action
     *
     * @return \Cake\Http\Response|null|void
     */
    public function login()
    {
        // Use login layout
        $this->viewBuilder()->setLayout('admin_login');

        $result = $this->Authentication->getResult();

        // If the user is logged in, redirect
        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? ['controller' => 'Dashboard', 'action' => 'index'];
            return $this->redirect($target);
        }

        // Display error if authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário ou senha inválidos.'));
        }
    }

    /**
     * Logout action
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success(__('Você foi desconectado.'));
        
        return $this->redirect(['action' => 'login']);
    }
}
