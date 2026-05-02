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

<?php
	if (empty($vagas)) {
		$vagas = [
			[
				'id' => 0,
				'empresa_nome' => 'Empresa Exemplo',
				'categoria' => 'TI / Desenvolvimento',
				'titulo' => 'Desenvolvedor Fullstack',
				'localizacao' => 'São Paulo - SP',
				'faixa_salarial' => 'R$ 3.000 - R$ 5.000',
				'quantidade' => 2,
				'descricao' => 'Vaga demonstrativa criada automaticamente. Customize esta vaga via seed/migrations no banco de dados.'
			]
		];
	}
?>

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

				<form id="filterForm">
					<!-- Busca por Título -->
					<div class="filter-group">
						<label for="filterTitle">Título da Vaga</label>
						<input 
							type="text" 
							id="filterTitle" 
							placeholder="Ex: Desenvolvedor, Designer..."
							value=""
						>
					</div>

					<!-- Categoria -->
					<div class="filter-group">
						<label for="filterCategory">Categoria</label>
						<select id="filterCategory">
							<option value="">Todas as Categorias</option>
							<option value="TI / Desenvolvimento">TI / Desenvolvimento</option>
							<option value="Design">Design</option>
							<option value="Marketing">Marketing</option>
							<option value="Vendas">Vendas</option>
							<option value="Recursos Humanos">Recursos Humanos</option>
							<option value="Administrativo">Administrativo</option>
							<option value="Financeiro">Financeiro</option>
							<option value="Operações">Operações</option>
						</select>
					</div>

					<!-- Localização -->
					<div class="filter-group">
						<label for="filterLocation">Localização</label>
						<input 
							type="text" 
							id="filterLocation" 
							placeholder="Ex: São Paulo, Rio de Janeiro..."
							value=""
						>
					</div>

					<!-- Faixa Salarial -->
					<div class="filter-group">
						<label for="filterSalary">Faixa Salarial Mínima (R$)</label>
						<input 
							type="range" 
							id="filterSalary" 
							min="0" 
							max="20000" 
							step="500"
							value="0"
						>
						<div class="range-values">
							<span>R$ 0</span>
							<span id="salaryDisplay">R$ 0</span>
						</div>
					</div>

					<!-- Tipo de Contrato -->
					<div class="filter-group">
						<label>Tipo de Contrato</label>
						<div class="checkbox-group">
							<div class="checkbox-item">
								<input type="checkbox" id="contractCLT" value="CLT">
								<label for="contractCLT">CLT</label>
							</div>
							<div class="checkbox-item">
								<input type="checkbox" id="contractPJ" value="PJ">
								<label for="contractPJ">PJ</label>
							</div>
							<div class="checkbox-item">
								<input type="checkbox" id="contractFreelancer" value="Freelancer">
								<label for="contractFreelancer">Freelancer</label>
							</div>
							<div class="checkbox-item">
								<input type="checkbox" id="contractTemporario" value="Temporário">
								<label for="contractTemporario">Temporário</label>
							</div>
						</div>
					</div>

					<!-- Modalidade de Trabalho -->
					<div class="filter-group">
						<label>Modalidade</label>
						<div class="checkbox-group">
							<div class="checkbox-item">
								<input type="checkbox" id="modalPresencial" value="Presencial">
								<label for="modalPresencial">Presencial</label>
							</div>
							<div class="checkbox-item">
								<input type="checkbox" id="modalRemoto" value="Remoto">
								<label for="modalRemoto">Remoto</label>
							</div>
							<div class="checkbox-item">
								<input type="checkbox" id="modalHibrido" value="Híbrido">
								<label for="modalHibrido">Híbrido</label>
							</div>
						</div>
					</div>

					<!-- Botões de Ação -->
					<div class="filter-actions">
						<button type="button" class="letra-botao botao-limpar" id="botaolimpar">
							Limpar
						</button>
						<button type="button" class="letra-botao botao-aplicar" id="botaoaplicar">
							Aplicar Filtros
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="cards-grid">
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
		</div>
	</div>
</div>

<div class="actions-row">
	<a href="/vagas/novo" class="btn-visualizar" style="padding:10px 44px;border-radius:24px;display:inline-block">Registre sua Vaga</a>
	<a href="/minhas-vagas" class="btn-visualizar" style="padding:10px 44px;border-radius:24px;display:inline-block">Suas Vagas</a>
</div>
<?= $this->endSection() ?>

