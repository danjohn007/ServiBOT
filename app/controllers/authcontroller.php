<?php

require_once 'basecontroller.php';

class AuthController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('user');
    }
    
    /**
     * Show login form
     */
    public function login() {
        // Redirect if already logged in
        if (isLoggedIn()) {
            $this->redirectToDashboard();
            return;
        }
        
        $this->data['pageTitle'] = 'Iniciar Sesión - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleLogin();
        } else {
            $this->view('auth/login', $this->data);
        }
    }
    
    /**
     * Show registration form
     */
    public function register() {
        // Redirect if already logged in
        if (isLoggedIn()) {
            $this->redirectToDashboard();
            return;
        }
        
        $this->data['pageTitle'] = 'Registrarse - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleRegister();
        } else {
            $this->view('auth/register', $this->data);
        }
    }
    
    /**
     * Handle login
     */
    private function handleLogin() {
        $this->validateCsrf();
        
        $email = $this->sanitize($this->getPost('email'));
        $password = $this->getPost('password');
        $remember = $this->getPost('remember');
        
        // Validation
        if (empty($email) || empty($password)) {
            $this->data['error'] = 'Por favor, completa todos los campos.';
            $this->view('auth/login', $this->data);
            return;
        }
        
        // Find user
        $user = $this->userModel->findByEmail($email);
        
        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->data['error'] = 'Credenciales inválidas.';
            $this->view('auth/login', $this->data);
            return;
        }
        
        // Check if user is active
        if (!$user['is_active']) {
            $this->data['error'] = 'Tu cuenta está desactivada. Contacta al administrador.';
            $this->view('auth/login', $this->data);
            return;
        }
        
        // Set session
        $this->setUserSession($user);
        
        // Update last login
        $this->userModel->updateLastLogin($user['id']);
        
        // Set remember me cookie if requested
        if ($remember) {
            $this->setRememberMeCookie($user['id']);
        }
        
        // Redirect to appropriate dashboard
        $this->redirectToDashboard();
    }
    
    /**
     * Handle registration
     */
    private function handleRegister() {
        $this->validateCsrf();
        
        $data = [
            'name' => $this->sanitize($this->getPost('name')),
            'email' => $this->sanitize($this->getPost('email')),
            'phone' => $this->sanitize($this->getPost('phone')),
            'password' => $this->getPost('password'),
            'confirm_password' => $this->getPost('confirm_password'),
            'role' => $this->sanitize($this->getPost('role')),
            'address' => $this->sanitize($this->getPost('address')),
            'terms' => $this->getPost('terms')
        ];
        
        // Validation
        $errors = $this->validateRegistration($data);
        
        if (!empty($errors)) {
            $this->data['errors'] = $errors;
            $this->data['formData'] = $data;
            $this->view('auth/register', $this->data);
            return;
        }
        
        // Check if email already exists
        if ($this->userModel->emailExists($data['email'])) {
            $this->data['error'] = 'El email ya está registrado.';
            $this->data['formData'] = $data;
            $this->view('auth/register', $this->data);
            return;
        }
        
        // Create user
        if ($this->userModel->create($data)) {
            $this->data['success'] = 'Cuenta creada exitosamente. Puedes iniciar sesión.';
            $this->view('auth/login', $this->data);
        } else {
            $this->data['error'] = 'Error al crear la cuenta. Intenta de nuevo.';
            $this->data['formData'] = $data;
            $this->view('auth/register', $this->data);
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Clear session
        session_destroy();
        
        // Clear remember me cookie
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/');
        }
        
        $this->redirect('auth/login?logged_out=1');
    }
    
    /**
     * Validate registration data
     */
    private function validateRegistration($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors['name'] = 'El nombre es requerido.';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'El email es requerido.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es válido.';
        }
        
        if (empty($data['password'])) {
            $errors['password'] = 'La contraseña es requerida.';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'La contraseña debe tener al menos 6 caracteres.';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Las contraseñas no coinciden.';
        }
        
        // Map display values to database values
        $roleMap = [
            'Cliente - Solicitar servicios' => 'cliente',
            'Prestador - Ofrecer servicios' => 'prestador'
        ];
        
        if (empty($data['role']) || !isset($roleMap[$data['role']])) {
            $errors['role'] = 'Selecciona un tipo de cuenta válido.';
        } else {
            $data['role'] = $roleMap[$data['role']];
        }
        
        if (!$data['terms']) {
            $errors['terms'] = 'Debes aceptar los términos y condiciones.';
        }
        
        return $errors;
    }
    
    /**
     * Set user session
     */
    private function setUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['login_time'] = time();
    }
    
    /**
     * Set remember me cookie
     */
    private function setRememberMeCookie($userId) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
        
        setcookie('remember_me', $userId . ':' . $token, $expiry, '/', '', false, true);
        
        // You might want to store the token in database for security
    }
    
    /**
     * Redirect to appropriate dashboard
     */
    private function redirectToDashboard() {
        $role = $_SESSION['user_role'] ?? '';
        
        switch ($role) {
            case 'superadmin':
                $this->redirect('admin');
                break;
            case 'cliente':
                $this->redirect('client/dashboard');
                break;
            case 'prestador':
                $this->redirect('provider/dashboard');
                break;
            default:
                $this->redirect('home');
        }
    }
    
    /**
     * Password recovery (basic implementation)
     */
    public function forgot() {
        $this->data['pageTitle'] = 'Recuperar Contraseña - ServiBOT';
        
        if ($this->isPost()) {
            $email = $this->sanitize($this->getPost('email'));
            
            if (empty($email)) {
                $this->data['error'] = 'Por favor, ingresa tu email.';
            } else {
                $user = $this->userModel->findByEmail($email);
                
                if ($user) {
                    // In a real application, you would send an email here
                    $this->data['success'] = 'Se han enviado las instrucciones a tu email.';
                } else {
                    $this->data['error'] = 'No se encontró una cuenta con ese email.';
                }
            }
        }
        
        $this->view('auth/forgot', $this->data);
    }
}