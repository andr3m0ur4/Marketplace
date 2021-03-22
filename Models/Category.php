<?php

    namespace Models;

    use Core\Model;

    class Category extends Model
    {
        public function getAll()
        {
            $sql = "SELECT * FROM categories";
            $categories = $this->select($sql, $this);
            return $categories;
        }
    }
    