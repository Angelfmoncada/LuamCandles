<?php
class Pages extends Controller {
    private $productModel;

    public function __construct(){
        $this->productModel = $this->model('Product');
    }

    public function index(){
        $products = $this->productModel->getProducts();

        if(empty($products)){
            $products = [
                (object)[
                    'id' => 1,
                    'name' => 'Vela Lavanda Relax',
                    'description' => 'Vela aromática con esencia de lavanda para momentos de relajación profunda. Hecha con cera de soja 100% natural.',
                    'price' => 15.00,
                    'image' => 'Screenshot 2025-07-26 042148.png',
                    'category' => 'Aromática'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Vela Vainilla Dulce',
                    'description' => 'Dulce aroma a vainilla que aporta calidez a tu hogar. Mecha de algodón orgánico.',
                    'price' => 18.50,
                    'image' => 'Screenshot 2025-07-26 042218.png',
                    'category' => 'Decorativa'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Vela Cítrica Energía',
                    'description' => 'Energizante mezcla de limón, naranja y bergamota. Ideal para empezar el día.',
                    'price' => 16.00,
                    'image' => 'Screenshot 2025-07-26 042236.png',
                    'category' => 'Aromática'
                ],
                (object)[
                    'id' => 4,
                    'name' => 'Bosque Místico',
                    'description' => 'Notas amaderadas de pino, cedro y sándalo. Te transportará a la naturaleza.',
                    'price' => 20.00,
                    'image' => 'Screenshot 2025-07-26 042251.png',
                    'category' => 'Premium'
                ],
                (object)[
                    'id' => 5,
                    'name' => 'Set de Regalo',
                    'description' => 'Pack de 3 velas pequeñas surtidas en caja decorativa. El regalo perfecto.',
                    'price' => 45.00,
                    'image' => 'Screenshot 2025-07-26 042344.png',
                    'category' => 'Regalos'
                ],
                (object)[
                    'id' => 6,
                    'name' => 'Rosa Romántica',
                    'description' => 'Suave y elegante aroma a rosas frescas recién cortadas.',
                    'price' => 19.00,
                    'image' => 'Screenshot 2025-07-26 042356.png',
                    'category' => 'Floral'
                ]
            ];
        }

        $data = [
            'title' => 'Luam Candles',
            'products' => $products
        ];
        $this->view('products/index', $data);
    }

    public function product($id){
        $product = $this->productModel->getProductById($id);
        $data = [
            'product' => $product
        ];
        $this->view('products/show', $data);
    }

    public function search(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $term = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $products = $this->productModel->searchProducts($term);
            $data = [
                'title' => 'Resultados de búsqueda: ' . $term,
                'products' => $products
            ];
            $this->view('products/index', $data);
        } else {
            redirect('pages');
        }
    }

    public function about(){
        $data = [
            'title' => 'Sobre Nosotros'
        ];
        $this->view('pages/about', $data);
    }
}
