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
}
