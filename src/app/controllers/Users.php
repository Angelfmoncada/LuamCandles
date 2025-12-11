<?php
class Users extends Controller {
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Por favor ingresa un email';
            } else {

                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'El email ya está registrado';
                }
            }

            if(empty($data['name'])){
                $data['name_err'] = 'Por favor ingresa tu nombre';
            }

            if(empty($data['password'])){
                $data['password_err'] = 'Por favor ingresa una contraseña';
            } elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
            }

            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Por favor confirma tu contraseña';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }

            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if($this->userModel->register($data)){
                    flash('register_success', 'Estás registrado y puedes iniciar sesión');
                    redirect('users/login');
                } else {
                    die('Algo salió mal');
                }

            } else {

                $this->view('auth/register', $data);
            }

        } else {

            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('auth/register', $data);
        }
    }

    public function login(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Por favor ingresa un email';
            }

            if(empty($data['password'])){
                $data['password_err'] = 'Por favor ingresa tu contraseña';
            }

            if($this->userModel->findUserByEmail($data['email'])){

            } else {
                $data['email_err'] = 'Usuario no encontrado';
            }

            if(empty($data['email_err']) && empty($data['password_err'])){

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){

                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Contraseña incorrecta';
                    $this->view('auth/login', $data);
                }
            } else {

                $this->view('auth/login', $data);
            }

        } else {

            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->role;

        if($user->role == 'admin'){
            redirect('admin');
        } else {
            redirect('pages/index');
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }
}
