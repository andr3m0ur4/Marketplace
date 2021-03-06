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
            if ($name == 'id_store' || $name == 'id' || $name == 'availability' || $name == 'id_category') {
                $this->$name = intval($value);
            } else if ($name == 'price') {
                $this->$name = doubleval($value);
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

            $sql = "SELECT
                    p.*,
                    s.fantasy_name, s.phone, s.cell_phone,
                    c.name AS category
                FROM products AS p
                INNER JOIN stores AS s ON p.id_store = s.id
                INNER JOIN categories AS c ON p.id_category = c.id
                WHERE p.id = :id";
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
            $this->deletePhoto();

            $sql = "DELETE FROM products WHERE id = :id";
            return $this->query($sql, [
                ':id' => $this->id
            ]);
        }

        public function total()
        {
            $sql = "SELECT COUNT(*) AS counter FROM products";
            $results = $this->select($sql, $this);
            return $results[0]->counter;
        }

        public function latestProducts()
        {
            $sql = "SELECT p.*, c.name AS category FROM products AS p
                    INNER JOIN categories AS c ON p.id_category = c.id
                    ORDER BY id DESC";
                    
            return $this->select($sql, $this);
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

        public function deletePhoto()
        {
            if ($this->picture != '' && file_exists("./images/products/{$this->picture}")) {
                unlink("./images/products/{$this->picture}");

                $sql = "UPDATE products SET picture = '' WHERE id = :id";

                return !$this->query($sql, [
                    ':id' => $this->id
                ]);
            }

            return 'Arquivo n??o existe!';
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
