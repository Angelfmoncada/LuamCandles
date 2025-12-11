<?php
class Cart extends Controller {
    private $productModel;

    public function __construct(){
        $this->productModel = $this->model('Product');
    }

    public function index(){
        $data = [
            'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : [],
            'total' => $this->calculateTotal()
        ];
        $this->view('cart/index', $data);
    }

    public function add($id){
        $product = $this->productModel->getProductById($id);

        if(!$product){
            redirect('pages');
        }

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        flash('cart_message', 'Producto agregado al carrito');
        redirect('pages/product/' . $id);
    }

    public function update($id, $qty = 1){
        if(isset($_SESSION['cart'][$id])){
            if($qty > 0){
                $_SESSION['cart'][$id]['quantity'] = $qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        redirect('cart');
    }

    public function remove($id){
        if(isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
        }
        redirect('cart');
    }

    public function clear(){
        unset($_SESSION['cart']);
        redirect('cart');
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
