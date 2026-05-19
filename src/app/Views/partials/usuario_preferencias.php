<?php
/** @var array<string, mixed> $usuario Dados ou old() via $val */
$val = $val ?? static fn (string $key, $default = '') => old($key, $usuario[$key] ?? $default);
?>
<div class="letras-formulario">
    <label>Preferências de vaga:</label>
    <div class="posicionamento-inputs">
        <select class="input-duplo-formulario" name="estado" required>
            <option value="">Estado *</option>
            <?php foreach (vaga_estados() as $uf => $nome): ?>
                <option value="<?= $uf ?>" <?= $val('estado') === $uf ? 'selected' : '' ?>><?= esc($uf) ?> — <?= esc($nome) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="input-duplo-formulario" name="categoria" required>
            <option value="">Categoria *</option>
            <?php foreach (vaga_categorias() as $slug => $label): ?>
                <option value="<?= esc($slug) ?>" <?= $val('categoria') === $slug ? 'selected' : '' ?>><?= esc($label) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="posicionamento-inputs">
        <select class="input-duplo-formulario" name="tipo_contrato" required>
            <option value="">Tipo de contrato *</option>
            <?php foreach (vaga_tipos_contrato() as $tipo): ?>
                <option value="<?= esc($tipo) ?>" <?= $val('tipo_contrato') === $tipo ? 'selected' : '' ?>><?= esc($tipo) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="input-duplo-formulario" name="modalidade" required>
            <option value="">Modalidade *</option>
            <?php foreach (vaga_modalidades() as $mod): ?>
                <option value="<?= esc($mod) ?>" <?= $val('modalidade') === $mod ? 'selected' : '' ?>><?= esc($mod) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
