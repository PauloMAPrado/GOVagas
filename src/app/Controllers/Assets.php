<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Assets extends BaseController
{
    /**
     * Serve imagens armazenadas em app/Views/img via rota /img/{filename}
     * Proteções básicas: nega traversal e verifica existência.
     */
    public function image(string $name)
    {
        // Sanitize filename: permite apenas letras, números, -, _, e extensão
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $name)) {
            return $this->response->setStatusCode(400)->setBody('Invalid file name');
        }

        $path = APPPATH . 'Views/img/' . $name;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404)->setBody('Not found');
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $data = file_get_contents($path);

        return $this->response->setHeader('Content-Type', $mime)
                               ->setHeader('Cache-Control', 'public, max-age=86400')
                               ->setBody($data);
    }
}
