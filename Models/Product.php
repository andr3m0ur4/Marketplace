<?php

    namespace Models;

    use Core\Model;

    class Product extends Model
    {
        public function __get($name)
        {
            return $this->$name ?? null;
        }

        public function __set($name, $value)
        {
            if ($name == 'id_store' || $name == 'id') {
                $this->$name = intval($value);
            } else {
                $this->$name = $value;
            }
        }

        public function setData($data = [])
        {
            foreach ($data as $key => $value) {
                $this->__set($key, $value);
            }
        }

        public function getMyProducts()
        {
            $data = [];

            $sql = "SELECT * FROM products WHERE id_store = :id_store";
            $results = $this->select($sql, $this, [
                ':id_store' => $this->id_store
            ]);

            if (count($results) > 0) {
                $data = $results;
            }

            return $data;
        }

        public function getProduct()
        {
            $data = [];

            $sql = "SELECT * FROM products WHERE id = :id";
            $result = $this->select($sql, $this, [
                ':id' => $this->id
            ]);

            if (count($result) > 0) {
                $data = $result[0];
            }

            return $data;
        }

        public function create()
        {
            $sql = "INSERT INTO products (
                    name, description, availability, price, id_category, id_store
                ) VALUES (
                    :name, :description, :availability, :price, :id_category, :id_store
                )
            ";

            return $this->query($sql, [
                ':name' => $this->name,
                ':description' => $this->description,
                ':availability' => $this->availability,
                ':price' => $this->price,
                ':id_category' => $this->id_category,
                ':id_store' => $this->id_store
            ]);
        }

        public function editProduct()
        {
            $product = $this->getProduct();
            $this->validateAttributes($product);

            $sql = "UPDATE products SET
                    name = :name, description = :description, picture = :picture, availability = :availability,
                    price = :price, id_category = :id_category
                WHERE id = :id";
                
            return $this->query($sql, [
                ':name' => $product->name,
                ':description' => $product->description,
                ':picture' => $product->picture,
                ':availability' => $product->availability,
                ':price' => $product->price,
                ':id_category' => $product->id_category,
                ':id' => $product->id
            ]);
        }

        public function delete()
        {
            $sql = "DELETE FROM products WHERE id = :id";
            $this->query($sql, [
                ':id' => $this->id
            ]);
        }

        public function search($query)
        {
            $data = [];

            $sql = "SELECT * FROM products WHERE name LIKE :name";
            $result = $this->select($sql, $this, [
                ':name' => "%{$query}%"
            ]);

            if (count($result) > 0) {
                $data = $result;
            }

            return $data;
        }

        private function validateAttributes($product)
        {
            if (!empty($this->name)) {
                $product->name = $this->name;
            }
            if (!empty($this->description)) {
                $product->description = $this->description;
            }
            if (!empty($this->picture)) {
                $product->picture = $this->picture;
            }
            if (!empty($this->availability)) {
                $product->availability = $this->availability;
            }
            if (!empty($this->price)) {
                $product->price = $this->price;
            }
            if (!empty($this->id_category)) {
                $product->id_category = $this->id_category;
            }
        }
    }
