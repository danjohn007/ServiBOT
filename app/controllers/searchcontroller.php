<?php

require_once 'basecontroller.php';

class SearchController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->data['pageTitle'] = 'Buscar Servicios - ServiBOT';
        $query = $this->getGet('q', '');
        
        $this->data['query'] = $query;
        $this->data['results'] = [];
        $this->data['categories'] = [];
        $this->data['providers'] = [];
        
        if (!empty(trim($query))) {
            $this->data['results'] = $this->searchServices($query);
            $this->data['categories'] = $this->searchCategories($query);
            $this->data['providers'] = $this->searchProviders($query);
        }
        
        $this->view('search/results', $this->data);
    }
    
    private function searchServices($query) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $searchTerm = "%{$query}%";
            
            $stmt = $connection->prepare("
                SELECT DISTINCT sc.id, sc.name, sc.description, sc.icon, sc.base_price, sc.estimated_duration
                FROM service_categories sc
                LEFT JOIN service_providers sp ON JSON_CONTAINS(sp.service_categories, CAST(sc.id AS JSON))
                WHERE sc.is_active = 1 
                AND (
                    sc.name LIKE ? 
                    OR sc.description LIKE ?
                    OR sp.keywords LIKE ?
                )
                ORDER BY sc.name
            ");
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    private function searchCategories($query) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $searchTerm = "%{$query}%";
            
            $stmt = $connection->prepare("
                SELECT id, name, description, icon, base_price
                FROM service_categories
                WHERE is_active = 1 
                AND (name LIKE ? OR description LIKE ?)
                ORDER BY name
                LIMIT 10
            ");
            $stmt->execute([$searchTerm, $searchTerm]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    private function searchProviders($query) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $searchTerm = "%{$query}%";
            
            $stmt = $connection->prepare("
                SELECT DISTINCT u.id, u.name, u.phone, u.address, 
                       sp.rating, sp.total_services, sp.keywords, sp.experience_years
                FROM users u
                INNER JOIN service_providers sp ON u.id = sp.user_id
                WHERE u.role = 'prestador' 
                AND u.is_active = 1 
                AND sp.is_available = 1
                AND (
                    u.name LIKE ?
                    OR sp.keywords LIKE ?
                )
                ORDER BY sp.rating DESC, sp.total_services DESC
                LIMIT 20
            ");
            $stmt->execute([$searchTerm, $searchTerm]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}