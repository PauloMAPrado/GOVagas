<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Início<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
	.cards-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 28px 32px;
	}

	.cards-wrapper {
		max-width: 920px;
		margin: 0 auto;
		padding: 8px 12px;
	}

	.home-center {
		display: flex;
		align-items: center;
		justify-content: center;
		min-height: calc(100vh - 160px);
		padding: 8px 0;
		flex-direction: column;
	}

	@media (max-width: 760px) {
		.cards-grid { grid-template-columns: 1fr; }
		.vaga-meta-grid { grid-template-columns: repeat(2, 1fr); }
	}

	@media (max-width: 480px) {
		.vaga-meta-grid { grid-template-columns: 1fr; }
	}

	.vaga-card {
		background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(245,245,245,0.95));
		border-radius: 12px;
		padding: 18px;
		box-shadow: 0 6px 18px rgba(0,0,0,0.12);
		position: relative;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		min-height: 220px;
	}

	.vaga-header {
		display:flex;
		align-items:center;
		gap:12px;
		margin-bottom:8px;
	}

	.empresa-avatar {
		width:64px;height:64px;border-radius:50%;background:#ddd;flex:0 0 64px;border:4px solid rgba(255,255,255,0.6);
	}

	.empresa-nome { font-size:20px;font-weight:600;margin:0 }
	.empresa-cat { font-size:13px;color:#666;margin:0 }

	.vaga-meta-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 8px 16px;
		align-items: center;
		margin: 12px 0 14px;
		border-top: 1px solid rgba(0,0,0,0.06);
		padding-top: 12px;
	}

	.meta-col { display:flex; align-items:center; gap:10px; color:#444; font-size:14px; min-height:28px }
	.meta-col .fa-icon { width:22px; text-align:center; color:#2b4f9a; font-size:14px }

	.vaga-desc { flex:1;margin-bottom:14px;color:#333 }

	.btn-visualizar {
		align-self:center;
		background: linear-gradient(180deg,#9fbaf6,#cfe0ff);
		color:#1b3a7a;padding:12px 32px;border-radius:28px;border:none;cursor:pointer;box-shadow:0 6px 10px rgba(100,140,220,0.18);
	}

	.actions-row { display:flex;gap:18px;justify-content:center;margin-top:28px }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('status')): ?>
    <div class="alert success" style="max-width:920px;margin:0 auto 16px;"><?= session()->getFlashdata('status') ?></div>
<?php endif; ?>

<div class="home-center">
	<div class="cards-wrapper">
		<!--Filtros -->
		<div class="modelo-filtro-overlay" id="modelofiltrooverlay">
			<div class="modelo-filtro">
				<div class="modelo-filtro-header">
					<h2>Filtros</h2>
					<button class="fechar-botao-filtro" id="fecharbotaofiltro">
						<i class="fas fa-times"></i>
					</button>
				</div>

				<form id="filterForm" action="/" method="get">
					<!-- Busca por Título -->
					<div class="filter-group">
						<label for="filterTitle">Título da Vaga</label>
						<input 
							type="text" 
							id="filterTitle"
							name="titulo"
							placeholder="Ex: Desenvolvedor, Designer..."
							value="<?= esc($filtros['titulo'] ?? '') ?>"
						>
					</div>

					<!-- Categoria -->
					<div class="filter-group">
						<label for="filterCategory">Categoria</label>
						<select id="filterCategory" name="categoria">
							<option value="">Todas as Categorias</option>
							<option value="tecnologia" <?= ($filtros['categoria'] ?? '') === 'tecnologia' ? 'selected' : '' ?>>Tecnologia</option>
							<option value="design" <?= ($filtros['categoria'] ?? '') === 'design' ? 'selected' : '' ?>>Design</option>
							<option value="marketing" <?= ($filtros['categoria'] ?? '') === 'marketing' ? 'selected' : '' ?>>Marketing</option>
							<option value="vendas" <?= ($filtros['categoria'] ?? '') === 'vendas' ? 'selected' : '' ?>>Vendas</option>
							<option value="recursos humanos" <?= ($filtros['categoria'] ?? '') === 'recursos humanos' ? 'selected' : '' ?>>Recursos Humanos</option>
							<option value="administrativo" <?= ($filtros['categoria'] ?? '') === 'administrativo' ? 'selected' : '' ?>>Administrativo</option>
							<option value="financeiro" <?= ($filtros['categoria'] ?? '') === 'financeiro' ? 'selected' : '' ?>>Financeiro</option>
							<option value="outros" <?= ($filtros['categoria'] ?? '') === 'outros' ? 'selected' : '' ?>>Outros</option>
						</select>
					</div>

					<!-- Localização -->
					<div class="filter-group">
						<label for="filterLocation">Localização</label>
						<input 
							type="text" 
							id="filterLocation"
							name="localizacao"
							placeholder="Ex: São Paulo, Rio de Janeiro..."
							value="<?= esc($filtros['localizacao'] ?? '') ?>"
						>
					</div>

					<!-- Tipo de Contrato -->
					<div class="filter-group">
						<label>Tipo de Contrato</label>
						<div class="checkbox-group">
							<?php foreach (['CLT', 'PJ', 'Freelancer', 'Temporário', 'Estágio'] as $tipo): ?>
							<div class="checkbox-item">
								<input type="radio" name="tipo_contrato" value="<?= $tipo ?>" <?= ($filtros['tipo_contrato'] ?? '') === $tipo ? 'checked' : '' ?>>
								<label><?= $tipo ?></label>
							</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Modalidade -->
					<div class="filter-group">
						<label>Modalidade</label>
						<div class="checkbox-group">
							<?php foreach (['Presencial', 'Remoto', 'Híbrido'] as $mod): ?>
							<div class="checkbox-item">
								<input type="radio" name="modalidade" value="<?= $mod ?>" <?= ($filtros['modalidade'] ?? '') === $mod ? 'checked' : '' ?>>
								<label><?= $mod ?></label>
							</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Botões de Ação -->
					<div class="filter-actions">
						<a href="/" class="letra-botao botao-limpar">Limpar</a>
						<button type="submit" class="letra-botao botao-aplicar">Aplicar Filtros</button>
					</div>
				</form>
			</div>
		</div>

		<div class="cards-grid">
	<?php if (empty($vagas)): ?>
		<p style="grid-column:1/-1; text-align:center; color:#555;">Nenhuma vaga encontrada para os filtros selecionados.</p>
	<?php else: ?>
	<?php foreach ($vagas as $vaga): ?>
		<article class="vaga-card">
			<div class="vaga-header">
				<div class="empresa-avatar" aria-hidden="true"></div>
				<div>
					<h3 class="empresa-nome"><?= esc($vaga['empresa_nome'] ?? $vaga['nome'] ?? 'Empresa') ?></h3>
					<p class="empresa-cat"><?= esc($vaga['categoria'] ?? '') ?></p>
				</div>
			</div>

			<div class="vaga-meta-grid" role="list">
				<div class="meta-col" role="listitem"><span class="fa-icon"><i class="fas fa-briefcase"></i></span><span class="meta-text"><?= esc($vaga['titulo']) ?></span></div>
				<div class="meta-col" role="listitem"><span class="fa-icon"><i class="fas fa-map-marker-alt"></i></span><span class="meta-text"><?= esc($vaga['localizacao'] ?? '') ?></span></div>
				<div class="meta-col" role="listitem"><span class="fa-icon"><i class="fas fa-dollar-sign"></i></span><span class="meta-text"><?= esc($vaga['faixa_salarial'] ?? 'A combinar') ?></span></div>
				<div class="meta-col" role="listitem"><span class="fa-icon"><i class="fas fa-users"></i></span><span class="meta-text"><?= (int) ($vaga['quantidade'] ?? 1) ?> vagas</span></div>
			</div>

			<p class="vaga-desc"><?= esc(strlen($vaga['descricao'] ?? '') > 240 ? substr($vaga['descricao'],0,240).'...' : ($vaga['descricao'] ?? '')) ?></p>

			<a class="btn-visualizar" href="/vagas/<?= esc($vaga['id'] ?? 0) ?>">Visualizar Vaga</a>
		</article>
	<?php endforeach; ?>
	<?php endif; ?>
		</div>
	</div>
</div>

<div class="actions-row">
	<?php if (session()->get('logado')): ?>
		<a href="/empresa/vagas/nova" class="btn-visualizar" style="padding:10px 44px;border-radius:24px;display:inline-block">Registre sua Vaga</a>
		<a href="/empresa/vagas" class="btn-visualizar" style="padding:10px 44px;border-radius:24px;display:inline-block">Suas Vagas</a>
	<?php else: ?>
		<a href="/login" class="btn-visualizar" style="padding:10px 44px;border-radius:24px;display:inline-block">Anuncie sua Vaga</a>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>

