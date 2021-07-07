<?php

    namespace Models;

    use Core\Model;

    class Category extends Model
    {
        public function __get($name)
        {
            return $this->$name ?? null;
        }

        public function __set($name, $value)
        {
            if ($name == 'id') {
                $this->$name = intval($value);
            } else {
                $this->$name = $value;
            }
        }

        public function getAll()
        {
            $sql = "SELECT * FROM categories";
            $categories = $this->select($sql, $this);
            return $categories;
        }
    }
    