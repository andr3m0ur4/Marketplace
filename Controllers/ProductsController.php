<?php

    namespace Controllers;

    use Core\Controller;
    use \Models\Product;
    use Models\Store;

    class ProductsController extends Controller
    {
        public function insert()
        {
            $response = [
                'error' => '',
                'logged' => false
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();
            $token = $_SERVER['HTTP_JWT'] ?? null;

            $store = new Store();

            if (!empty($token) && $store->validateJWT($token)) {
                $response['logged'] = true;
                $response['thats_me'] = false;

                if ($method == 'POST') {
                    $product = new Product();
                    $product->setData($data);
                    $product->id_store = $store->getId();
                    if ($product->create()) {
                        $response['error'] = false;
                    } else {
                        $response['error'] = 'Ocorreu um erro!';
                    }
                } else {
                    $response['error'] = 'Método de requisição incompatível.';
                }
            } else {
                $response['error'] = 'Acesso negado.';
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
            $token = $_SERVER['HTTP_JWT'] ?? null;

            $store = new Store();

            if (!empty($token) && $store->validateJWT($token)) {
                $response['logged'] = true;
                $response['thats_me'] = false;
                $product = new Product();
                $product->id = $id;

                if ($id == $store->getId()) {
                    $response['thats_me'] = true;
                }

                switch ($method) {
                    case 'GET':
                        $response['data'] = $store->getStore();

                        if (count((array) $response['data']) === 0) {
                            $response['error'] = 'Loja não existe.';
                        }
                        break;

                    case 'PUT':
                        if (count($data) > 0) {
                            $product->setData($data);
                            $response['error'] = $product->editProduct();
                        } else {
                            $response['error'] = 'Preencha os dados corretamente!';
                        }
                        break;

                    case 'DELETE':
                        $response['error'] = $product->delete();
                        break;

                    default:
                        $response['error'] = "Método $method não disponível.";
                }
            } else {
                $response['error'] = 'Acesso negado.';
            }

            return $this->returnJson($response);
        }

        public function search()
        {
            $response = [
                'error' => '',
                'products' => []
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();

            if ($method == 'GET') {
                $product = new Product();
                $query = $data['q'] ?? null;

                if ($query) {
                    $response['products'] = $product->search($query);
                }
            } else {
                $response['error'] = 'Método de requisição incompatível.';
            }

            return $this->returnJson($response);
        }
    }
