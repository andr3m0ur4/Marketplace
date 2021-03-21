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
                    $store = new Store();
                    $store->email = $data['email'];
                    $store->password = $data['password'];

                    if ($store->checkCredentials()) {
                        // Gerar JWT
                        $response['jwt'] = $store->createJWT();
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

        public function register()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();

            if ($method == 'POST') {
                $store = new Store();
                $store->setData($data['store']);
                $store->address = $data['address'];
                $data = array_merge((array) $data['store'], (array) $data['address']);

                if ($this->validateFields($data, $this->getRequired())) {
                    if (filter_var($store->email, FILTER_VALIDATE_EMAIL)) {
                        if ($store->create()) {
                            $response['jwt'] = $store->createJWT();
                        } else {
                            $response['error'] = 'E-mail já existente.';
                        }
                    } else {
                        $response['error'] = 'E-mail inválido.';
                    }
                } else {
                    $response['error'] = 'Dados não preenchidos.';
                }
            } else {
                $response['error'] = 'Método de requisição incompatível.';
            }

            return $this->returnJson($response);
        }

        public function manage($id)
        {
            $response = [
                'error' => '',
                'logged' => false
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();
            $token = $_SERVER['HTTP_JWT'];

            $store = new Store();

            if (!empty($token) && $store->validateJWT($token)) {
                $response['logged'] = true;
                $response['thats_me'] = false;

                if ($id == $store->getId()) {
                    $response['thats_me'] = true;
                }

                switch ($method) {
                    case 'GET':
                        break;

                    case 'PUT':
                        break;

                    case 'DELETE':
                        break;

                    default:
                        $response['error'] = "Método $method não disponível.";
                }
            } else {
                $response['error'] = 'Acesso negado.';
            }

            return $this->returnJson($response);
        }

        private function getRequired()
        {
            return [
                'fantasy_name', 'cnpj', 'company_name', 'public_place', 'number', 'neighborhood',
                'city', 'uf', 'zip_code', 'cell_phone', 'responsible_contact', 'email', 'password'
            ];
        }
    }
