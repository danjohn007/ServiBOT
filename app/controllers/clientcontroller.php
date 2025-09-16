<?php

require_once 'basecontroller.php';

class ClientController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Check if user is client
        checkRole(['cliente']);
    }
    
    /**
     * Client dashboard
     */
    public function dashboard() {
        $this->data['pageTitle'] = 'Mi Panel - ServiBOT';
        
        $this->view('client/dashboard', $this->data);
    }
    
    /**
     * Client requests
     */
    public function requests() {
        $this->data['pageTitle'] = 'Mis Solicitudes - ServiBOT';
        
        $this->view('client/requests', $this->data);
    }
}