<?php

namespace App\Controllers;

use App\Models\VagaSugeridaModel;

class VagasSugeridas extends BaseController
{
    public function index(): string
    {
        $candidatoId = session()->get('candidato_id');
        $candidatoId = $candidatoId !== null ? (int) $candidatoId : null;

        $model  = new VagaSugeridaModel();
        $vagas  = $model->listar($candidatoId);
        $perfil = $model->getPerfil($candidatoId);

        return view('pages/vagas_sugeridas/index', [
            'vagas'  => $vagas,
            'perfil' => $perfil,
            'total'  => count($vagas),
        ]);
    }
}
