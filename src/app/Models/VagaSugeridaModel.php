<?php

namespace App\Models;

/**
 * Formata vagas sugeridas para a interface.
 * Sem dados demonstrativos — apenas o que vier do banco.
 */
class VagaSugeridaModel
{
    /**
     * Perfil do candidato usado no matching.
     *
     * @return array<string, mixed>
     */
    public function getPerfil(?int $candidatoId = null): array
    {
        // TODO: buscar em perfis_busca quando a tabela existir
        return [];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function listar(?int $candidatoId = null): array
    {
        $rows = $this->buscarDoBanco($candidatoId);

        $vagas = array_map(fn (array $row) => $this->formatarVaga($row), $rows);

        usort($vagas, static fn ($a, $b) => ($b['compatibilidade'] ?? 0) <=> ($a['compatibilidade'] ?? 0));

        return $vagas;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buscarDoBanco(?int $candidatoId): array
    {
        // TODO: retornar registros da query de vagas sugeridas (ex.: join vagas + matching)
        return [];
    }

    /**
     * Padroniza um registro do banco para o template da view.
     *
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
