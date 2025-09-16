<?php

require_once 'basecontroller.php';

class ProviderController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Check if user is provider
        checkRole(['prestador']);
    }
    
    /**
     * Provider dashboard
     */
    public function dashboard() {
        $this->data['pageTitle'] = 'Mi Panel - ServiBOT';
        
        $this->view('provider/dashboard', $this->data);
    }
    
    /**
     * Provider requests
     */
    public function requests() {
        $this->data['pageTitle'] = 'Mis Servicios - ServiBOT';
        
        $this->view('provider/requests', $this->data);
    }
}