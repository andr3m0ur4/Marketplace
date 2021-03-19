<?php

    namespace Controllers;

    use Core\Controller;
    use Models\Store;

    class HomeController extends Controller
    {
        public function index()
        {
            $data = [];

            $store = new Store();

            $data = [
                'stores' => $store->getAll()
            ];
            
            echo json_encode($data);
        }
    }
