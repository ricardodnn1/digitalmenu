<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * AccessLogs Controller
 *
 * @property \App\Model\Table\AccessLogsTable $AccessLogs
 */
class AccessLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->AccessLogs->find()
            ->contain(['Restaurants'])
            ->orderBy(['AccessLogs.created_at' => 'DESC']);
        $accessLogs = $this->paginate($query);

        $this->set(compact('accessLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Access Log id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $accessLog = $this->AccessLogs->get($id, contain: ['Restaurants']);
        $this->set(compact('accessLog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Access Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accessLog = $this->AccessLogs->get($id);
        if ($this->AccessLogs->delete($accessLog)) {
            $this->Flash->success(__('Log de acesso excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o log de acesso. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Clear all logs method
     *
     * @return \Cake\Http\Response|null
     */
    public function clearAll()
    {
        $this->request->allowMethod(['post']);
        $this->AccessLogs->deleteAll([]);
        $this->Flash->success(__('Todos os logs foram excluídos com sucesso.'));

        return $this->redirect(['action' => 'index']);
    }
}
