<?php
class Admin extends Controller {
    private $orderModel;

    public function __construct(){
        if(!isLoggedIn() || !isAdmin()){
            redirect('pages');
        }
        $this->orderModel = $this->model('Order');
    }

    public function index(){

        $logs = $this->orderModel->getAllPayPalLogs(200);
        $data = [
            'logs' => $logs
        ];
        $this->view('admin/transacciones', $data);
    }

    public function update_status($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $status = $_POST['status'];
            if($this->orderModel->updateStatus($id, $status)){
                flash('admin_message', 'Estado del pedido actualizado');
            } else {
                flash('admin_message', 'Error al actualizar', 'alert alert-danger');
            }
            redirect('admin');
        }
    }

    public function details($id){
        $order = $this->orderModel->getOrderById($id);
        $details = $this->orderModel->getOrderDetails($id);
        $paypal_logs = $this->orderModel->getPayPalLogsByOrderId($id);

        $data = [
            'order' => $order,
            'details' => $details,
            'paypal_logs' => $paypal_logs
        ];
        $this->view('admin/details', $data);
    }

    public function paypal_logs(){
        $logs = $this->orderModel->getAllPayPalLogs(200);
        $data = [
            'logs' => $logs
        ];
        $this->view('admin/paypal_logs', $data);
    }

    public function refund($order_id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if($this->orderModel->updateStatus($order_id, 'cancelled')){
                flash('admin_message', 'Pedido cancelado y marcado para reembolso', 'alert alert-success');
            } else {
                flash('admin_message', 'Error al procesar reembolso', 'alert alert-danger');
            }
            redirect('admin');
        }
    }
}
