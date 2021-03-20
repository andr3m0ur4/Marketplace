<?php

    namespace Controllers;

    use Core\Controller;
    use Models\Store;

    class StoresController extends Controller
    {
        public function index()
        {
            
        }

        public function login()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();

            if ($method == 'POST') {
                if (!empty($data['email']) && !empty($data['password'])) {
                    $user = new Store();

                    if ($user->checkCredentials($data['email'], $data['password'])) {
                        // Gerar JWT
                        $response['jwt'] = '...';
                    } else {
                        $response['error'] = 'Acesso negado.';
                    }
                } else {
                    $response['error'] = 'E-mail e/ou senha não preenchidos.';
                }
            } else {
                $response['error'] = 'Método de requisição incompatível.';
            }

            return $this->returnJson($response);
        }
    }
