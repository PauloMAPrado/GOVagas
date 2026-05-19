<?php

namespace App\Controllers;

use App\Models\VagaSugeridaModel;

class VagasSugeridas extends BaseController
{
    public function index(): string
    {
        $usuarioId = session()->get('usuario_id');
        $usuarioId = $usuarioId !== null ? (int) $usuarioId : null;

        $model  = new VagaSugeridaModel();
        $vagas  = $model->listar($usuarioId);
        $perfil = $model->getPerfil($usuarioId);

        return view('pages/vagas_sugeridas/index', [
            'vagas'  => $vagas,
            'perfil' => $perfil,
            'total'  => count($vagas),
        ]);
    }
}
