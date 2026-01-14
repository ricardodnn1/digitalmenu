<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PaymentTransaction> $transactions
 * @var array $paymentMethods
 * @var array $statuses
 */

use App\Model\Entity\PaymentTransaction;

$this->assign('title', 'Transações de Pagamento');
?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
    }
    
    .filters-bar {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-group label {
        font-size: 0.875rem;
        color: #64748b;
        white-space: nowrap;
    }
    
    .filter-group select {
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 0.875rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-outline {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-outline:hover {
        background: #f8fafc;
    }
    
    .transactions-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .transactions-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .transactions-table th,
    .transactions-table td {
        padding: 1rem 1.25rem;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .transactions-table th {
        background: #f8fafc;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }
    
    .transactions-table td {
        font-size: 0.875rem;
    }
    
    .transactions-table tr:hover {
        background: #fafafa;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-badge.pending { background: #fef3c7; color: #92400e; }
    .status-badge.processing { background: #dbeafe; color: #1e40af; }
    .status-badge.approved { background: #dcfce7; color: #166534; }
    .status-badge.declined { background: #fee2e2; color: #991b1b; }
    .status-badge.refunded { background: #e5e7eb; color: #374151; }
    .status-badge.cancelled { background: #f3f4f6; color: #6b7280; }
    
    .amount {
        font-weight: 600;
        font-family: 'Fira Code', monospace;
    }
    
    .customer-info {
        line-height: 1.4;
    }
    
    .customer-info strong {
        display: block;
    }
    
    .customer-info small {
        color: #64748b;
    }
    
    .payment-type {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        padding: 1.5rem;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.875rem;
        text-decoration: none;
        color: #475569;
    }
    
    .pagination a:hover {
        background: #f1f5f9;
    }
    
    .pagination .active {
        background: #1a1a2e;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state p {
        color: #64748b;
    }
</style>

<div class="page-header">
    <h1>📊 Transações de Pagamento</h1>
    <?= $this->Html->link('← Voltar', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
</div>

<!-- Filters -->
<form method="get" class="filters-bar">
    <div class="filter-group">
        <label>Status:</label>
        <select name="status">
            <option value="">Todos</option>
            <?php foreach ($statuses as $key => $label): ?>
                <option value="<?= $key ?>" <?= $this->request->getQuery('status') === $key ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="filter-group">
        <label>Gateway:</label>
        <select name="payment_method_id">
            <option value="">Todos</option>
            <?php foreach ($paymentMethods as $id => $name): ?>
                <option value="<?= $id ?>" <?= $this->request->getQuery('payment_method_id') == $id ? 'selected' : '' ?>>
                    <?= h($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-outline">🔍 Filtrar</button>
</form>

<!-- Transactions Table -->
<div class="transactions-table">
    <?php if (!empty($transactions->toArray())): ?>
    <table>
        <thead>
            <tr>
                <th>Referência</th>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Gateway</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td>
                    <code style="font-size: 0.75rem;"><?= h($transaction->reference_code ?? $transaction->id) ?></code>
                </td>
                <td>
                    <div class="customer-info">
                        <strong><?= h($transaction->customer_name ?? 'N/A') ?></strong>
                        <small><?= h($transaction->customer_email ?? '') ?></small>
                    </div>
                </td>
                <td>
                    <span class="amount">R$ <?= number_format($transaction->amount, 2, ',', '.') ?></span>
                    <?php if ($transaction->installments > 1): ?>
                        <small style="color: #64748b;"> (<?= $transaction->installments ?>x)</small>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="payment-type">
                        <?php
                        $icons = [
                            'credit_card' => '💳',
                            'debit_card' => '💳',
                            'pix' => '📱',
                            'boleto' => '📄',
                            'cash' => '💵',
                        ];
                        echo $icons[$transaction->payment_type] ?? '•';
                        ?>
                        <?= h(\App\Model\Entity\PaymentMethod::PAYMENT_TYPES[$transaction->payment_type] ?? $transaction->payment_type ?? 'N/A') ?>
                    </span>
                </td>
                <td>
                    <span class="status-badge <?= h($transaction->status) ?>">
                        <?= h(PaymentTransaction::STATUS_LABELS[$transaction->status] ?? $transaction->status) ?>
                    </span>
                </td>
                <td>
                    <?= h($transaction->payment_method->name ?? 'N/A') ?>
                </td>
                <td>
                    <?= $transaction->created->format('d/m/Y H:i') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="pagination">
        <?= $this->Paginator->prev('« Anterior') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('Próximo »') ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <p style="font-size: 3rem;">📭</p>
        <h3>Nenhuma transação encontrada</h3>
        <p>As transações de pagamento aparecerão aqui.</p>
    </div>
    <?php endif; ?>
</div>
