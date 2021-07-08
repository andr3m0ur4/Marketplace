<?php

    namespace Controllers;

    use Core\Controller;
    use \Models\Product;
    use Models\Store;

    class ProductsController extends Controller
    {
        public function getProduct($id)
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();

            if ($method == 'GET') {
                $product = new Product();
                $product->id = $id;
                $product->setData($product->getProduct());

                $response['data'] = (array) $product;
    
                if (count($response['data']) === 0) {
                    $response['error'] = 'Produto não existe.';
                }
            } else {
                $response['error'] = 'Método de requisição incompatível.';
            }

            return $this->returnJson($response);
        }

        public function myProducts()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();
            $token = $_SERVER['HTTP_JWT'] ?? null;

            $store = new Store();

            if (!empty($token) && $store->validateJWT($token)) {
                $response['logged'] = true;

                if ($method == 'GET') {
                    $product = new Product();
                    $product->id_store = $store->getId();
                    $response['data'] = $product->getMyProducts();
                } else {
                    $response['error'] = 'Método de requisição incompatível.';
                }
            } else {
                $response['error'] = 'Acesso negado.';
            }

            return $this->returnJson($response);
        }

        public function insert()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();
            $data = $this->getRequestData();
            $token = $_SERVER['HTTP_JWT'] ?? null;

            $store = new Store();

            if (!empty($token) && $store->validateJWT($token)) {
                $response['logged'] = true;

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
                'error' => false,
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
                $product->setData($product->getProduct());

                if ($product->id_store == $store->getId()) {
                    $response['thats_me'] = true;

                    switch ($method) {
                        case 'PUT':
                            if (count($data) > 0) {
                                $product->setData($data);
                                $response['error'] = !$product->editProduct();
                            } else {
                                $response['error'] = 'Preencha os dados corretamente!';
                            }
                            break;
    
                        case 'DELETE':
                            $response['error'] = !$product->delete();
                            break;
    
                        default:
                            $response['error'] = "Método $method não disponível.";
                    }
                } else {
                    $response['error'] = 'Acesso negado.';
                }
            } else {
                $response['error'] = 'Acesso negado.';
            }

            return $this->returnJson($response);
        }

        public function getTotal()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();

            if ($method == 'GET') {
                $product = new Product();
                $response['total'] = $product->total();
            } else {
                $response['error'] = 'Método de requisição incompatível.';
            }

            return $this->returnJson($response);
        }

        public function latestProducts()
        {
            $response = [
                'error' => false
            ];

            $method = $this->getMethod();

            if ($method == 'GET') {
                $product = new Product();
                $response['data'] = $product->latestProducts();
            } else {
                $response['error'] = 'Método de requisição incompatível.';
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

        public function updateImage()
        {
            $response = [
                'error' => true
            ];

            if (isset($_FILES['picture']) && !$_FILES['picture']['error']) {
                // upload image in the folder images
                $temp = explode('.', $_FILES['picture']['name']);
                $new_filename = substr(md5(time() . $temp[0]), 0, 10) . '.' . end($temp);
                move_uploaded_file($_FILES['picture']['tmp_name'], './images/products/' . $new_filename);

                $response['error'] = false;
                $response['new_filename'] = $new_filename;
            }

            // give callback to your angular code with the image src name
            return $this->returnJson($response);
        }
    }
