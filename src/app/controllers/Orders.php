<?php
class Orders extends Controller {
    private $orderModel;

    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        $this->orderModel = $this->model('Order');
    }

    public function checkout(){
        if(empty($_SESSION['cart'])){
            redirect('pages');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'total_amount' => $this->calculateTotal(),
                'shipping_address' => trim($_POST['address']),
                'payment_method' => trim($_POST['payment_method']),
                'transaction_id' => isset($_POST['transaction_id']) ? trim($_POST['transaction_id']) : null,
                'paypal_response' => isset($_POST['paypal_response']) ? $_POST['paypal_response'] : null
            ];

            if(empty($data['shipping_address'])){
                flash('order_error', 'Por favor ingresa una dirección de envío', 'alert alert-danger');
                $data['cart'] = $_SESSION['cart'];
                $data['total'] = $this->calculateTotal();
                $this->view('cart/checkout', $data);
                return;
            }

            $orderId = $this->orderModel->createOrder($data);

            if($orderId){

                if($data['payment_method'] == 'PayPal' && !empty($data['transaction_id'])){

                    $this->orderModel->updatePayPalLogOrderId($data['transaction_id'], $orderId);

                    $this->orderModel->logPayPalTransaction(
                        $orderId,
                        $data['transaction_id'],
                        'order_created',
                        $data['paypal_response'] ?? json_encode(['transaction_id' => $data['transaction_id'], 'order_id' => $orderId])
                    );
                }

                foreach($_SESSION['cart'] as $item){
                    $this->orderModel->addOrderDetails($orderId, $item['id'], $item['quantity'], $item['price']);
                }

                unset($_SESSION['cart']);

                redirect('orders/confirmation');
            } else {
                die('Algo salió mal');
            }

        } else {
            $data = [
                'cart' => $_SESSION['cart'],
                'total' => $this->calculateTotal()
            ];
            $this->view('cart/checkout', $data);
        }
    }

    public function history(){
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';
        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user_id'], $sort);
        $data = [
            'orders' => $orders
        ];
        $this->view('orders/history', $data);
    }

    public function details($id){
        $details = $this->orderModel->getOrderDetails($id);
        $data = [
            'details' => $details,
            'order_id' => $id
        ];
        $this->view('orders/details', $data);
    }

    public function confirmation(){
        if(!isset($_SESSION['user_id'])){
            redirect('users/login');
        }
        $data = [];
        $this->view('orders/confirmation', $data);
    }

    public function logPaypalError(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $jsonData = file_get_contents('php:
            $data = json_decode($jsonData, true);

            if($data){
                $this->orderModel->logPayPalTransaction(
                    null,
                    null,
                    'error',
                    $jsonData
                );
            }
        }
    }

    private function calculateTotal(){
        $total = 0;
        if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $item){
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
}
