<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OpeningHour> $openingHours
 * @var \Cake\Collection\CollectionInterface|string[] $restaurants
 * @var string|null $restaurantId
 * @var \App\Model\Entity\Restaurant|null $selectedRestaurant
 * @var array $daysOfWeek
 */
$this->assign('title', 'Horários de Funcionamento');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Horários de Funcionamento</h2>
    </div>
    <div class="card-body">
        <!-- Seletor de Restaurante -->
        <div class="restaurant-selector">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'selector-form']) ?>
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <?= $this->Form->control('restaurant_id', [
                        'label' => 'Selecione o Restaurante',
                        'options' => $restaurants,
                        'empty' => '-- Selecione um restaurante --',
                        'value' => $restaurantId,
                        'class' => 'form-control',
                        'id' => 'restaurant-selector'
                    ]) ?>
                </div>
                <div class="form-group" style="align-self: flex-end;">
                    <?= $this->Form->button(__('Visualizar'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <?php if ($restaurantId && !empty($openingHours)): ?>
        <hr style="margin: 2rem 0; border-color: #e2e8f0;">
        
        <div class="hours-header">
            <h3><?= h($selectedRestaurant->name) ?> - Horários</h3>
            <?= $this->Html->link(__('Editar Horários'), ['action' => 'edit', $restaurantId], ['class' => 'btn btn-accent']) ?>
        </div>

        <div class="hours-grid">
            <?php foreach ($openingHours as $hour): ?>
            <div class="hour-card <?= $hour->is_closed ? 'closed' : 'open' ?>">
                <div class="day-name"><?= $daysOfWeek[$hour->day_of_week] ?></div>
                <div class="day-status">
                    <?php if ($hour->is_closed): ?>
                        <span class="status-badge closed">Fechado</span>
                    <?php else: ?>
                        <span class="status-badge open">Aberto</span>
                        <div class="time-range">
                            <span class="time"><?= $hour->open_time ? $hour->open_time->format('H:i') : '--:--' ?></span>
                            <span class="separator">às</span>
                            <span class="time"><?= $hour->close_time ? $hour->close_time->format('H:i') : '--:--' ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($restaurantId): ?>
        <div class="empty-state">
            <p>Nenhum horário cadastrado para este restaurante.</p>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>Selecione um restaurante para visualizar ou editar os horários de funcionamento.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.selector-form .form-row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.hours-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.hours-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark);
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.hour-card {
    background: var(--bg-content);
    border-radius: 12px;
    padding: 1.25rem;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.hour-card.open {
    border-color: rgba(16, 185, 129, 0.3);
}

.hour-card.closed {
    border-color: rgba(239, 68, 68, 0.3);
    opacity: 0.7;
}

.day-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
}

.day-status {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    width: fit-content;
}

.status-badge.open {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-badge.closed {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.time-range {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary);
}

.time-range .separator {
    font-size: 0.875rem;
    color: var(--text-muted);
    font-weight: 400;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.empty-state svg {
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    font-size: 1rem;
}

hr {
    border: none;
    border-top: 1px solid #e2e8f0;
}
</style>

<script>
document.getElementById('restaurant-selector').addEventListener('change', function() {
    if (this.value) {
        this.form.submit();
    }
});
</script>
