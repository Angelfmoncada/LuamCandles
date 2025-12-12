<?php
class Product {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getProducts(){
        $this->db->query('SELECT * FROM products ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getProductById($id){
        $this->db->query('SELECT * FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getProductsByCategory($category){
        $this->db->query('SELECT * FROM products WHERE category = :category ORDER BY created_at DESC');
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    public function searchProducts($term){
        $this->db->query('SELECT * FROM products WHERE name LIKE :term OR description LIKE :term');
        $this->db->bind(':term', '%' . $term . '%');
        return $this->db->resultSet();
    }

    /**
     * Valida los datos del producto (Simulación de esquema estricto tipo Zod)
     * @param array $data
     * @return array Array de errores, vacío si es válido
     */
    public function validate($data) {
        $errors = [];

        // Reglas de validación
        $rules = [
            'name' => ['required' => true, 'min' => 3, 'max' => 255, 'type' => 'string', 'label' => 'Nombre'],
            'description' => ['required' => true, 'min' => 10, 'type' => 'string', 'label' => 'Descripción'],
            'price' => ['required' => true, 'min' => 0.01, 'type' => 'numeric', 'label' => 'Precio'],
            'category' => ['required' => true, 'type' => 'string', 'label' => 'Categoría'],
            'image' => ['required' => true, 'type' => 'string', 'label' => 'Imagen']
        ];

        foreach ($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : null;
            $label = $rule['label'];

            // Required check
            if ($rule['required'] && (is_null($value) || trim($value) === '')) {
                $errors[$field] = "El campo $label es obligatorio.";
                continue;
            }

            if ($value) {
                // Type check
                if ($rule['type'] === 'numeric' && !is_numeric($value)) {
                    $errors[$field] = "El campo $label debe ser numérico.";
                }
                if ($rule['type'] === 'string' && !is_string($value)) {
                    $errors[$field] = "El campo $label debe ser texto.";
                }

                // Min/Max check
                if (isset($rule['min'])) {
                    if ($rule['type'] === 'numeric' && $value < $rule['min']) {
                        $errors[$field] = "El campo $label debe ser mayor o igual a {$rule['min']}.";
                    } elseif ($rule['type'] === 'string' && strlen($value) < $rule['min']) {
                        $errors[$field] = "El campo $label debe tener al menos {$rule['min']} caracteres.";
                    }
                }
                if (isset($rule['max'])) {
                    if ($rule['type'] === 'string' && strlen($value) > $rule['max']) {
                        $errors[$field] = "El campo $label no debe exceder {$rule['max']} caracteres.";
                    }
                }
            }
        }
        
        return $errors;
    }

    public function addProduct($data){
        $this->db->query('INSERT INTO products (name, description, price, category, image) VALUES (:name, :description, :price, :category, :image)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':image', $data['image']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    public function updateProduct($id, $data){
        $this->db->query('UPDATE products SET name = :name, description = :description, price = :price, category = :category, image = :image WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':image', $data['image']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
