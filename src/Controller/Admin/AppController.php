<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController;

/**
 * Admin AppController
 *
 * Controlador base para toda a área administrativa.
 * Todos os controllers do admin devem herdar desta classe.
 */
class AppController extends BaseController
{
    /**
     * Usuário logado
     *
     * @var \App\Model\Entity\AdminUser|null
     */
    protected $currentUser = null;

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Usar layout específico do admin
        $this->viewBuilder()->setLayout('admin');

        // Carregar componente de autenticação
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\EventInterface $event The beforeFilter event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Obter usuário logado
        $identity = $this->Authentication->getIdentity();
        if ($identity) {
            $this->currentUser = $identity->getOriginalData();
            $this->set('currentUser', $this->currentUser);
        }
    }

    /**
     * Retorna o usuário logado atual
     *
     * @return \App\Model\Entity\AdminUser|null
     */
    protected function getCurrentUser()
    {
        return $this->currentUser;
    }
}
