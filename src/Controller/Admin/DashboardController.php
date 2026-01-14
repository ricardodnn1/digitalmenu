<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Dashboard Controller
 *
 * Controlador principal da área administrativa.
 */
class DashboardController extends AppController
{
    /**
     * Index method - Página inicial do admin
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $this->set('title', 'Dashboard Administrativo');
    }
}
