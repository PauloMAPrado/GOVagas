<?php
/**
 * Filtros com Liquid Glass
 */
?>
<style>
	.modelo-filtro-overlay {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0, 0, 0, 0.4);
		backdrop-filter: blur(4px);
		display: none;
		align-items: center;
		justify-content: center;
		z-index: 999;
		animation: fadeIn 0.3s ease-out;
	}

	.modelo-filtro-overlay.active {
		display: flex;
	}

	@keyframes fadeIn {
		from { opacity: 0; }
		to { opacity: 1; }
	}

	@keyframes slideUp {
		from { 
			opacity: 0;
			transform: translateY(30px);
		}
		to { 
			opacity: 1;
			transform: translateY(0);
		}
	}

	.modelo-filtro-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 24px;
		border-bottom: 2px solid rgba(43, 79, 154, 0.15);
		padding-bottom: 16px;
	}

	.modelo-filtro-header h2 {
		margin: 0;
		font-size: 24px;
		color: #1b3a7a;
		font-weight: 700;
	}

	.fechar-botao-filtro {
		background: none;
		border: none;
		font-size: 28px;
		color: #33363B;
		cursor: pointer;
		padding: 0;
		width: 32px;
		height: 32px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.2s;
	}

	.fechar-botao-filtro:hover {
		color: #1b3a7a;
		transform: rotate(90deg);
	}

	.filter-group {
		margin-bottom: 24px;
	}

	.filter-group label {
		display: block;
		font-weight: 600;
		color: #1b3a7a;
		margin-bottom: 10px;
		font-size: 14px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.filter-group select,
	.filter-group input[type="text"],
	.filter-group input[type="range"] {
		width: 100%;
		padding: 12px 14px;
		border: 2px solid rgba(43, 79, 154, 0.2);
		border-radius: 10px;
		background: rgba(255, 255, 255, 0.5);
		font-size: 14px;
		color: #333;
		transition: all 0.3s;
	}

	.filter-group input[type="range"] {
		padding: 0;
		height: 6px;
		cursor: pointer;
	}

	.range-values {
		display: flex;
		justify-content: space-between;
		margin-top: 8px;
		font-size: 13px;
		color: #666;
	}

	.checkbox-group {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.checkbox-item {
		display: flex;
		align-items: center;
		gap: 10px;
		cursor: pointer;
	}

	.checkbox-item input[type="checkbox"] {
		width: 18px;
		height: 18px;
		cursor: pointer;
		accent-color: #9fbaf6;
	}

	.checkbox-item label {
		margin: 0;
		cursor: pointer;
		font-weight: 400;
		text-transform: none;
		letter-spacing: normal;
	}

	.filter-actions {
		display: flex;
		gap: 12px;
		margin-top: 28px;
		padding-top: 24px;
		border-top: 2px solid rgba(43, 79, 154, 0.15);
	}

	.letra-botao {
		flex: 1;
		padding: 12px 20px;
		border: none;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.botao-aplicar {
		background: linear-gradient(180deg, #9fbaf6, #cfe0ff);
		color: #1b3a7a;
		box-shadow: 0 6px 10px rgba(100, 140, 220, 0.18);
	}

	.botao-aplicar:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 15px rgba(100, 140, 220, 0.28);
	}

	.botao-limpar {
		background: rgba(43, 79, 154, 0.1);
		color: #1b3a7a;
		border: 2px solid rgba(43, 79, 154, 0.2);
	}

	.botao-limpar:hover {
		transform: translateY(-2px);
		background: rgba(43, 79, 154, 0.15);
		border-color: rgba(43, 79, 154, 0.3);
	}

	/* Scrollbar*/
	.modelo-filtro::-webkit-scrollbar {
		width: 10px;
	}

	.modelo-filtro::-webkit-scrollbar-track {
		background: rgba(43, 79, 154, 0.1);
		border-radius: 10px;
	}

	.modelo-filtro::-webkit-scrollbar-thumb {
		background: #33363b76;
		border-radius: 10px;
	}

	.modelo-filtro::-webkit-scrollbar-thumb:hover {
		background: #33363baf;
	}

	@media (max-width: 480px) {
		.modelo-filtro {
			max-width: 100%;
			padding: 24px;
			border-radius: 16px;
		}

		.modelo-filtro-header h2 {
			font-size: 20px;
		}

		.filter-actions {
			flex-direction: column;
		}

		.letra-botao {
			width: 100%;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Elementos do DOM
		const filterToggleBtn = document.getElementById('filterToggleBtn');
		const fecharbotaofiltro = document.getElementById('fecharbotaofiltro');
		const modelofiltrooverlay = document.getElementById('modelofiltrooverlay');
		const filterForm = document.getElementById('filterForm');
		const botaoaplicar = document.getElementById('botaoaplicar');
		const botaolimpar = document.getElementById('botaolimpar');
		const filterSalaryInput = document.getElementById('filterSalary');
		const salaryDisplay = document.getElementById('salaryDisplay');

		if (!filterToggleBtn) return; // Sai se não encontrar os elementos

		// Abrir Modelo
		filterToggleBtn.addEventListener('click', () => {
			modelofiltrooverlay.classList.add('active');
			document.body.style.overflow = 'hidden';
		});

		// Fechar Modelo
		function closeFilterModal() {
			modelofiltrooverlay.classList.remove('active');
			document.body.style.overflow = 'auto';
		}

		fecharbotaofiltro.addEventListener('click', closeFilterModal);

		// Fechar Modelo ao clicar no overlay
		modelofiltrooverlay.addEventListener('click', (e) => {
			if (e.target === modelofiltrooverlay) {
				closeFilterModal();
			}
		});

		// Fechar Modelo com ESC
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && modelofiltrooverlay.classList.contains('active')) {
				closeFilterModal();
			}
		});

		// Atualizar exibição do salário
		filterSalaryInput.addEventListener('input', (e) => {
			const value = parseInt(e.target.value);
			salaryDisplay.textContent = 'R$ ' + value.toLocaleString('pt-BR');
		});

		// Aplicar Filtros
		botaoaplicar.addEventListener('click', () => {
			const filters = {
				title: document.getElementById('filterTitle').value,
				category: document.getElementById('filterCategory').value,
				location: document.getElementById('filterLocation').value,
				salary: document.getElementById('filterSalary').value,
				contracts: Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
					.filter(el => el.id.startsWith('contract'))
					.map(el => el.value),
				modalities: Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
					.filter(el => el.id.startsWith('modal'))
					.map(el => el.value)
			};

			console.log('Filtros aplicados:', filters);
			
			// Aqui você pode chamar uma função para filtrar as vagas
			filterVagas(filters);
			closeFilterModal();
		});

		// Limpar Filtros
		botaolimpar.addEventListener('click', () => {
			filterForm.reset();
			salaryDisplay.textContent = 'R$ 0';
		});

		// Função para filtrar vagas (você pode expandir isso)
		function filterVagas(filters) {
			const cards = document.querySelectorAll('.vaga-card');
			
			cards.forEach(card => {
				let match = true;

				// Filtro por título
				if (filters.title) {
					const title = card.querySelector('.meta-text').textContent.toLowerCase();
					if (!title.includes(filters.title.toLowerCase())) {
						match = false;
					}
				}

				// Filtro por categoria
				if (filters.category) {
					const category = card.querySelector('.empresa-cat').textContent.toLowerCase();
					if (!category.includes(filters.category.toLowerCase())) {
						match = false;
					}
				}

				// Filtro por localização
				if (filters.location) {
					const location = card.querySelectorAll('.meta-text')[1]?.textContent.toLowerCase() || '';
					if (!location.includes(filters.location.toLowerCase())) {
						match = false;
					}
				}

				// Exibir ou ocultar card
				card.style.display = match ? 'flex' : 'none';
			});

			// Mensagem se nenhuma vaga encontrada
			const visibleCards = document.querySelectorAll('.vaga-card[style="display: flex"]').length;
			if (visibleCards === 0) {
				console.log('Nenhuma vaga encontrada com os filtros selecionados');
			}
		}
	});
</script>
