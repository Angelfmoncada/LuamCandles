<?php
class Order {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function createOrder($data){

        $this->db->query('INSERT INTO orders (user_id, total_amount, shipping_address, payment_method, transaction_id) VALUES(:user_id, :total_amount, :shipping_address, :payment_method, :transaction_id)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':shipping_address', $data['shipping_address']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':transaction_id', $data['transaction_id']);

        if($this->db->execute()){
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function logPayPalTransaction($order_id, $transaction_id, $event_type = 'payment_capture', $response_json = ''){
        $this->db->query('INSERT INTO paypal_logs (order_id, transaction_id, event_type, response_json) VALUES(:order_id, :transaction_id, :event_type, :response_json)');
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':transaction_id', $transaction_id);
        $this->db->bind(':event_type', $event_type);
        $this->db->bind(':response_json', $response_json);
        return $this->db->execute();
    }

    public function getPayPalLogsByOrderId($order_id){
        $this->db->query('SELECT * FROM paypal_logs WHERE order_id = :order_id ORDER BY created_at DESC');
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }

    public function getAllPayPalLogs($limit = 100){
        $this->db->query('SELECT paypal_logs.*, orders.id as order_number FROM paypal_logs
                         LEFT JOIN orders ON paypal_logs.order_id = orders.id
                         ORDER BY paypal_logs.created_at DESC
                         LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function updatePayPalLogOrderId($transaction_id, $order_id){
        $this->db->query('UPDATE paypal_logs SET order_id = :order_id WHERE transaction_id = :transaction_id');
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':transaction_id', $transaction_id);
        return $this->db->execute();
    }

    public function addOrderDetails($order_id, $product_id, $quantity, $price){
        $this->db->query('INSERT INTO order_details (order_id, product_id, quantity, price) VALUES(:order_id, :product_id, :quantity, :price)');
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':product_id', $product_id);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':price', $price);
        return $this->db->execute();
    }

    public function getOrdersByUserId($id, $sort = 'date_desc'){
        $sql = 'SELECT * FROM orders WHERE user_id = :user_id';

        if($sort == 'date_asc'){
            $sql .= ' ORDER BY created_at ASC';
        } else {
            $sql .= ' ORDER BY created_at DESC';
        }

        $this->db->query($sql);
        $this->db->bind(':user_id', $id);
        return $this->db->resultSet();
    }

    public function getAllOrders($sort = 'date_desc'){
        $sql = 'SELECT orders.*, users.name as user_name, users.email as user_email FROM orders JOIN users ON orders.user_id = users.id';

        if($sort == 'date_asc'){
            $sql .= ' ORDER BY orders.created_at ASC';
        } else {
            $sql .= ' ORDER BY orders.created_at DESC';
        }

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getOrderById($id){
        $this->db->query('SELECT orders.*, users.name as user_name, users.email as user_email FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getOrderDetails($order_id){
        $this->db->query('SELECT order_details.*, products.name as product_name, products.image FROM order_details JOIN products ON order_details.product_id = products.id WHERE order_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }

    public function updateStatus($id, $status){
        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }

    public function guardarTransaccion($data){
        $this->db->query('INSERT INTO transacciones (transaction_id, cliente_nombre, cliente_email, monto, estado, paypal_data)
                         VALUES(:transaction_id, :cliente_nombre, :cliente_email, :monto, :estado, :paypal_data)');
        $this->db->bind(':transaction_id', $data['transaction_id']);
        $this->db->bind(':cliente_nombre', $data['cliente_nombre']);
        $this->db->bind(':cliente_email', $data['cliente_email']);
        $this->db->bind(':monto', $data['monto']);
        $this->db->bind(':estado', $data['estado']);
        $this->db->bind(':paypal_data', $data['paypal_data']);
        return $this->db->execute();
    }

    public function getAllTransacciones($limit = 100){
        $this->db->query('SELECT * FROM transacciones ORDER BY fecha_transaccion DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
