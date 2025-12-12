<?php
class Payments extends Controller {
    private $orderModel;

    public function __construct() {

        $this->orderModel = $this->model('Order');
    }

    public function create() {

        $input = json_decode(file_get_contents('php://input'), true);

        header('Content-Type: application/json');

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Cart is empty']);
            return;
        }

        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        echo json_encode([
            'status' => 'success',
            'orderID' => 'MOCK-' . strtoupper(uniqid()),
            'total' => $total
        ]);
    }

    public function capture() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['orderID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing Order ID']);
            return;
        }

        $order_id = isset($input['order_id']) ? $input['order_id'] : null;
        $transaction_id = $input['orderID'];
        $event_type = 'payment_capture';
        $response_json = json_encode($input);

        $this->orderModel->logPayPalTransaction($order_id, $transaction_id, $event_type, $response_json);

        $cliente_nombre = '-';
        $cliente_email = '-';
        $monto = 0;
        $estado = 'COMPLETED';

        if(isset($input['details'])) {
            $details = $input['details'];

            if(isset($details['payer']['name']['given_name']) && isset($details['payer']['name']['surname'])) {
                $cliente_nombre = $details['payer']['name']['given_name'] . ' ' . $details['payer']['name']['surname'];
            }

            if(isset($details['payer']['email_address'])) {
                $cliente_email = $details['payer']['email_address'];
            }

            if(isset($details['purchase_units'][0]['amount']['value'])) {
                $monto = $details['purchase_units'][0]['amount']['value'];
            }

            if(isset($details['status'])) {
                $estado = $details['status'];
            }
        }

        $this->orderModel->guardarTransaccion([
            'transaction_id' => $transaction_id,
            'cliente_nombre' => $cliente_nombre,
            'cliente_email' => $cliente_email,
            'monto' => $monto,
            'estado' => $estado,
            'paypal_data' => $response_json
        ]);

        echo json_encode([
            'status' => 'COMPLETED',
            'id' => $input['orderID'],
            'logged' => true
        ]);
    }

    public function webhook() {

        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if ($data) {
            $order_id = isset($data['order_id']) ? $data['order_id'] : null;
            $transaction_id = isset($data['id']) ? $data['id'] : 'WEBHOOK-' . time();
            $event_type = isset($data['event_type']) ? $data['event_type'] : 'webhook_received';

            $this->orderModel->logPayPalTransaction($order_id, $transaction_id, $event_type, $body);
        }

        http_response_code(200);
        echo json_encode(['status' => 'webhook_received', 'logged' => true]);
    }

    public function status($id) {
        header('Content-Type: application/json');

        echo json_encode([
            'id' => $id,
            'status' => 'COMPLETED',
            'simulated' => true
        ]);
    }
}
