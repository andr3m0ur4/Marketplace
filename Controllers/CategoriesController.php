<?php

    namespace Controllers;

    use Core\Controller;
    use Models\Category;

    class CategoriesController extends Controller
    {
        public function index()
        {
            $response = [];

            $category = new Category();
            $response['categories'] = $category->getAll();

            return $this->returnJson($response);
        }
    }
    