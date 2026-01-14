<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
 * @var array<\App\Model\Entity\OpeningHour> $openingHours
 * @var array $daysOfWeek
 */
$this->assign('title', 'Editar Horários - ' . $restaurant->name);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <span>Horários de Funcionamento</span>
            <small style="font-weight: 400; color: var(--text-muted); font-size: 0.875rem; margin-left: 0.5rem;">
                <?= h($restaurant->name) ?>
            </small>
        </h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index', '?' => ['restaurant_id' => $restaurant->id]], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create(null, ['id' => 'hours-form']) ?>
        
        <div class="hours-edit-grid">
            <?php foreach ($openingHours as $index => $hour): ?>
            <div class="hour-edit-card" data-day="<?= $hour->day_of_week ?>">
                <?= $this->Form->hidden("opening_hours.{$index}.id", ['value' => $hour->id]) ?>
                <?= $this->Form->hidden("opening_hours.{$index}.day_of_week", ['value' => $hour->day_of_week]) ?>
                
                <div class="day-header">
                    <span class="day-name"><?= $daysOfWeek[$hour->day_of_week] ?></span>
                    <div class="closed-toggle">
                        <label class="toggle-label">
                            <?= $this->Form->checkbox("opening_hours.{$index}.is_closed", [
                                'checked' => $hour->is_closed,
                                'class' => 'toggle-checkbox',
                                'id' => "closed-{$index}",
                                'hiddenField' => true
                            ]) ?>
                            <span class="toggle-switch"></span>
                            <span class="toggle-text">Fechado</span>
                        </label>
                    </div>
                </div>
                
                <div class="time-inputs" id="times-<?= $index ?>" <?= $hour->is_closed ? 'style="display: none;"' : '' ?>>
                    <div class="time-group">
                        <label>Abre às</label>
                        <?= $this->Form->control("opening_hours.{$index}.open_time", [
                            'type' => 'time',
                            'label' => false,
                            'class' => 'form-control time-input',
                            'value' => $hour->open_time ? $hour->open_time->format('H:i') : '08:00'
                        ]) ?>
                    </div>
                    <div class="time-separator">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                    <div class="time-group">
                        <label>Fecha às</label>
                        <?= $this->Form->control("opening_hours.{$index}.close_time", [
                            'type' => 'time',
                            'label' => false,
                            'class' => 'form-control time-input',
                            'value' => $hour->close_time ? $hour->close_time->format('H:i') : '22:00'
                        ]) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="quick-actions">
            <h4>Ações Rápidas</h4>
            <div class="quick-buttons">
                <button type="button" class="btn btn-secondary" onclick="setAllHours('08:00', '22:00')">
                    Comercial (08:00 - 22:00)
                </button>
                <button type="button" class="btn btn-secondary" onclick="setAllHours('11:00', '23:00')">
                    Restaurante (11:00 - 23:00)
                </button>
                <button type="button" class="btn btn-secondary" onclick="setAllHours('18:00', '02:00')">
                    Noturno (18:00 - 02:00)
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeWeekends()">
                    Fechar Finais de Semana
                </button>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button(__('Salvar Horários'), ['class' => 'btn btn-accent btn-lg']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index', '?' => ['restaurant_id' => $restaurant->id]], ['class' => 'btn btn-primary']) ?>
        </div>
        
        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.hours-edit-grid {
    display: grid;
    gap: 1rem;
    margin-bottom: 2rem;
}

.hour-edit-card {
    background: var(--bg-content);
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid #e2e8f0;
}

.day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.day-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
}

.closed-toggle {
    display: flex;
    align-items: center;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    user-select: none;
}

.toggle-checkbox {
    display: none;
}

.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
    background: #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.toggle-switch::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.toggle-checkbox:checked + .toggle-switch {
    background: var(--danger);
}

.toggle-checkbox:checked + .toggle-switch::after {
    transform: translateX(20px);
}

.toggle-text {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.time-inputs {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    padding-top: 0.5rem;
    border-top: 1px dashed #e2e8f0;
}

.time-group {
    flex: 1;
}

.time-group label {
    display: block;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.375rem;
}

.time-input {
    font-size: 1.125rem;
    font-weight: 500;
    text-align: center;
    padding: 0.75rem;
}

.time-separator {
    padding-bottom: 0.75rem;
    color: var(--text-muted);
}

.quick-actions {
    background: var(--bg-content);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 2rem;
}

.quick-actions h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
}

.quick-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.btn-secondary {
    background: white;
    color: var(--text-dark);
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.btn-lg {
    padding: 0.875rem 2rem;
    font-size: 1rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

@media (min-width: 768px) {
    .hours-edit-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .hours-edit-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .hour-edit-card:first-child {
        grid-column: span 3;
        max-width: 33.333%;
    }
}
</style>

<script>
// Toggle visibilidade dos campos de horário quando marcar como fechado
document.querySelectorAll('.toggle-checkbox').forEach((checkbox, index) => {
    checkbox.addEventListener('change', function() {
        const timesDiv = document.getElementById('times-' + index);
        if (this.checked) {
            timesDiv.style.display = 'none';
        } else {
            timesDiv.style.display = 'flex';
        }
    });
});

// Ações rápidas
function setAllHours(openTime, closeTime) {
    document.querySelectorAll('.toggle-checkbox').forEach((checkbox, index) => {
        checkbox.checked = false;
        document.getElementById('times-' + index).style.display = 'flex';
    });
    
    document.querySelectorAll('input[type="time"]').forEach(input => {
        if (input.name.includes('open_time')) {
            input.value = openTime;
        } else if (input.name.includes('close_time')) {
            input.value = closeTime;
        }
    });
}

function closeWeekends() {
    document.querySelectorAll('.hour-edit-card').forEach((card, index) => {
        const day = parseInt(card.dataset.day);
        const checkbox = card.querySelector('.toggle-checkbox');
        const timesDiv = document.getElementById('times-' + index);
        
        if (day === 0 || day === 6) { // Domingo ou Sábado
            checkbox.checked = true;
            timesDiv.style.display = 'none';
        }
    });
}
</script>
