<?php

require_once 'basecontroller.php';

class HomeController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->data['pageTitle'] = 'Inicio - ServiBOT';
        $this->data['services'] = $this->getServices();
        $this->view('home/index', $this->data);
    }
    
    public function about() {
        $this->data['pageTitle'] = 'Acerca de - ServiBOT';
        $this->view('home/about', $this->data);
    }
    
    public function contact() {
        $this->data['pageTitle'] = 'Contacto - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleContactForm();
        }
        
        $this->view('home/contact', $this->data);
    }
    
    private function getServices() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT id, name, description, icon, base_price 
                FROM service_categories 
                WHERE is_active = 1 
                ORDER BY name
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    private function handleContactForm() {
        $this->validateCsrf();
        
        $name = $this->sanitize($this->getPost('name'));
        $email = $this->sanitize($this->getPost('email'));
        $message = $this->sanitize($this->getPost('message'));
        
        // Here you would typically send an email or save to database
        // For now, just show a success message
        $this->data['success'] = 'Gracias por tu mensaje. Te contactaremos pronto.';
    }
}