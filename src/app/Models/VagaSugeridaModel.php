<?php

namespace App\Models;

class VagaSugeridaModel
{
    public function getPerfil(?int $usuarioId): array
    {
        if (empty($usuarioId)) {
            return [];
        }

        $usuario = (new UsuarioModel())->find($usuarioId);
        if (! $usuario) {
            return [];
        }

        $ufs = vaga_estados();

        return [
            'estado' => $usuario['estado'],
            'estado_nome' => $ufs[$usuario['estado']] ?? $usuario['estado'],
            'categoria'  => $usuario['categoria'],
            'tipo_contrato' => $usuario['tipo_contrato'],
            'modalidade' => $usuario['modalidade'],
        ];
    }

    public function listar(?int $usuarioId): array
    {
        $perfil = $this->getPerfil($usuarioId);
        $rows   = $this->carregarVagas($perfil);

        $vagas = [];
        foreach ($rows as $row) {
            if ($perfil !== []) {
                $row['compatibilidade'] = $this->pontuacao($row, $perfil);
                $row['motivos'] = $this->porQueCombina($row, $perfil);
            }
            $vagas[] = $this->formatarVaga($row);
        }

        usort($vagas, static function ($a, $b) {
            return ($b['compatibilidade'] ?? 0) <=> ($a['compatibilidade'] ?? 0);
        });

        return $vagas;
    }

    public function formatarVaga(array $row): array
    {
        $motivos = $row['motivos'] ?? [];
        if (is_string($motivos)) {
            $motivos = json_decode($motivos, true) ?: [];
        }

        return [
            'id' => (int) ($row['id'] ?? 0),
            'titulo' => $row['titulo'] ?? '',
            'empresa_nome' => $row['empresa_nome'] ?? '',
            'categoria' => $row['categoria'] ?? '',
            'localizacao' => $row['localizacao'] ?? '',
            'faixa_salarial'  => $row['faixa_salarial'] ?? '',
            'quantidade' => (int) ($row['quantidade'] ?? 0),
            'tipo_contrato' => $row['tipo_contrato'] ?? '',
            'modalidade' => $row['modalidade'] ?? '',
            'descricao' => $row['descricao'] ?? '',
            'compatibilidade' => isset($row['compatibilidade']) ? (int) $row['compatibilidade'] : null,
            'motivos' => $motivos,
            'created_at'  => $row['created_at'] ?? null,
            'salario_ordem' => $this->maiorValorSalario($row['faixa_salarial'] ?? ''),
        ];
    }

    private function carregarVagas(array $perfil): array
    {
        $q = (new VagaModel())
            ->select('vagas.*, empresas.nome AS empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->where('vagas.status', 'ativo');

        if ($perfil !== []) {
            $uf = $perfil['estado'];
            $q->where('vagas.categoria', $perfil['categoria'])
                ->where('vagas.tipo_contrato', $perfil['tipo_contrato'])
                ->where('vagas.modalidade', $perfil['modalidade'])
                ->like('vagas.localizacao', ' - ' . $uf, 'before');
        }

        return $q->orderBy('vagas.created_at', 'DESC')->findAll();
    }

    private function pontuacao(array $vaga, array $perfil): int
    {
        $pts = 0;

        if (($vaga['categoria'] ?? '') === $perfil['categoria']) {
            $pts += 30;
        }
        if (($vaga['tipo_contrato'] ?? '') === $perfil['tipo_contrato']) {
            $pts += 25;
        }
        if (($vaga['modalidade'] ?? '') === $perfil['modalidade']) {
            $pts += 25;
        }
        if ($this->mesmoEstado($vaga['localizacao'] ?? '', $perfil['estado'])) {
            $pts += 20;
        }

        return min(100, $pts);
    }

    private function porQueCombina(array $vaga, array $perfil): array
    {
        $lista = [];

        if (($vaga['categoria'] ?? '') === $perfil['categoria']) {
            $lista[] = 'Mesma área de interesse';
        }
        if (($vaga['tipo_contrato'] ?? '') === $perfil['tipo_contrato']) {
            $lista[] = 'Tipo de contrato bate';
        }
        if (($vaga['modalidade'] ?? '') === $perfil['modalidade']) {
            $lista[] = 'Modalidade que você busca';
        }
        if ($this->mesmoEstado($vaga['localizacao'] ?? '', $perfil['estado'])) {
            $lista[] = 'Vaga no seu estado';
        }

        return $lista;
    }

    private function mesmoEstado(string $localizacao, string $uf): bool
    {
        if ($localizacao === '' || $uf === '') {
            return false;
        }

        return preg_match('/-\s*' . preg_quote($uf, '/') . '\s*$/i', $localizacao) === 1;
    }

    private function maiorValorSalario(string $faixa): int
    {
        if ($faixa === '' || stripos($faixa, 'combinar') !== false) {
            return 0;
        }

        if (! preg_match_all('/\d{1,3}(?:\.\d{3})+|\d+/', $faixa, $nums)) {
            return 0;
        }

        $valores = array_map(static fn ($n) => (int) str_replace('.', '', $n), $nums[0]);

        return max($valores);
    }
}
