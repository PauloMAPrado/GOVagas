<?php

namespace App\Models;

/**
 * Formata vagas sugeridas com base no perfil do usuário.
 */
class VagaSugeridaModel
{
    /**
     * @return array<string, mixed>
     */
    public function getPerfil(?int $usuarioId = null): array
    {
        if ($usuarioId === null || $usuarioId <= 0) {
            return [];
        }

        $usuario = (new UsuarioModel())->find($usuarioId);

        if (! $usuario) {
            return [];
        }

        $estados = vaga_estados();

        return [
            'estado'        => $usuario['estado'],
            'estado_nome'   => $estados[$usuario['estado']] ?? $usuario['estado'],
            'categoria'     => $usuario['categoria'],
            'tipo_contrato' => $usuario['tipo_contrato'],
            'modalidade'    => $usuario['modalidade'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function listar(?int $usuarioId = null): array
    {
        $rows = $this->buscarDoBanco($usuarioId);

        $vagas = array_map(fn (array $row) => $this->formatarVaga($row), $rows);

        usort($vagas, static fn ($a, $b) => ($b['compatibilidade'] ?? 0) <=> ($a['compatibilidade'] ?? 0));

        return $vagas;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buscarDoBanco(?int $usuarioId): array
    {
        $builder = (new VagaModel())
            ->select('vagas.*, empresas.nome as empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->where('vagas.status', 'ativo');

        if ($usuarioId !== null && $usuarioId > 0) {
            $perfil = $this->getPerfil($usuarioId);
            if ($perfil !== []) {
                $uf = $perfil['estado'];
                $builder->where('vagas.categoria', $perfil['categoria'])
                    ->where('vagas.tipo_contrato', $perfil['tipo_contrato'])
                    ->where('vagas.modalidade', $perfil['modalidade'])
                    ->like('vagas.localizacao', ' - ' . $uf, 'before');
            }
        }

        $rows = $builder->orderBy('vagas.created_at', 'DESC')->findAll();

        if ($usuarioId !== null && $usuarioId > 0 && $rows !== []) {
            $perfil = $this->getPerfil($usuarioId);
            foreach ($rows as &$row) {
                $row['compatibilidade'] = $this->calcularCompatibilidade($row, $perfil);
                $row['motivos']         = $this->montarMotivos($row, $perfil);
            }
        }

        return $rows;
    }

    /**
     * @param array<string, mixed> $vaga
     * @param array<string, mixed> $perfil
     */
    private function calcularCompatibilidade(array $vaga, array $perfil): int
    {
        $pontos = 0;
        if (($vaga['categoria'] ?? '') === ($perfil['categoria'] ?? '')) {
            $pontos += 30;
        }
        if (($vaga['tipo_contrato'] ?? '') === ($perfil['tipo_contrato'] ?? '')) {
            $pontos += 25;
        }
        if (($vaga['modalidade'] ?? '') === ($perfil['modalidade'] ?? '')) {
            $pontos += 25;
        }
        if ($this->localizacaoNoEstado((string) ($vaga['localizacao'] ?? ''), (string) ($perfil['estado'] ?? ''))) {
            $pontos += 20;
        }

        return min(100, $pontos);
    }

    /**
     * @param array<string, mixed> $vaga
     * @param array<string, mixed> $perfil
     *
     * @return list<string>
     */
    private function montarMotivos(array $vaga, array $perfil): array
    {
        $motivos = [];
        if (($vaga['categoria'] ?? '') === ($perfil['categoria'] ?? '')) {
            $motivos[] = 'Categoria compatível';
        }
        if (($vaga['tipo_contrato'] ?? '') === ($perfil['tipo_contrato'] ?? '')) {
            $motivos[] = 'Mesmo tipo de contrato';
        }
        if (($vaga['modalidade'] ?? '') === ($perfil['modalidade'] ?? '')) {
            $motivos[] = 'Modalidade de interesse';
        }
        if ($this->localizacaoNoEstado((string) ($vaga['localizacao'] ?? ''), (string) ($perfil['estado'] ?? ''))) {
            $motivos[] = 'Localização no estado desejado';
        }

        return $motivos;
    }

    private function localizacaoNoEstado(string $localizacao, string $uf): bool
    {
        if ($localizacao === '' || $uf === '') {
            return false;
        }

        return (bool) preg_match('/-\s*' . preg_quote($uf, '/') . '\s*$/i', $localizacao);
    }

    /**
     * @param array<string, mixed> $row
     *
     * @return array<string, mixed>
     */
    public function formatarVaga(array $row): array
    {
        $motivos = $row['motivos'] ?? [];
        if (is_string($motivos)) {
            $decoded = json_decode($motivos, true);
            $motivos = is_array($decoded) ? $decoded : [];
        }

        return [
            'id'              => (int) ($row['id'] ?? 0),
            'titulo'          => (string) ($row['titulo'] ?? ''),
            'empresa_nome'    => (string) ($row['empresa_nome'] ?? ''),
            'categoria'       => (string) ($row['categoria'] ?? ''),
            'localizacao'     => (string) ($row['localizacao'] ?? ''),
            'faixa_salarial'  => (string) ($row['faixa_salarial'] ?? ''),
            'quantidade'      => (int) ($row['quantidade'] ?? 0),
            'tipo_contrato'   => (string) ($row['tipo_contrato'] ?? ''),
            'modalidade'      => (string) ($row['modalidade'] ?? ''),
            'descricao'       => (string) ($row['descricao'] ?? ''),
            'compatibilidade' => isset($row['compatibilidade']) ? (int) $row['compatibilidade'] : null,
            'motivos'         => is_array($motivos) ? $motivos : [],
            'created_at'      => $row['created_at'] ?? null,
            'salario_ordem'   => $this->extrairSalarioMax((string) ($row['faixa_salarial'] ?? '')),
        ];
    }

    private function extrairSalarioMax(string $faixa): int
    {
        if ($faixa === '' || $faixa === 'A combinar') {
            return 0;
        }

        if (preg_match_all('/\d{1,3}(?:\.\d{3})+|\d+/', $faixa, $matches)) {
            $valores = array_map(
                static fn (string $n) => (int) str_replace('.', '', $n),
                $matches[0]
            );

            return max($valores);
        }

        return 0;
    }
}
