<?php

require_once 'basecontroller.php';

class FinancialController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Financial module is accessible to all authenticated users
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
    }
    
    /**
     * Financial dashboard
     */
    public function index() {
        $this->data['pageTitle'] = 'Módulo Financiero - ServiBOT';
        
        // Get financial summary for current user
        $this->data['financialSummary'] = $this->getFinancialSummary();
        $this->data['recentTransactions'] = $this->getRecentTransactions();
        
        $this->view('financial/dashboard', $this->data);
    }
    
    /**
     * View all transactions
     */
    public function transactions() {
        $this->data['pageTitle'] = 'Transacciones - ServiBOT';
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $this->data['transactions'] = $this->getAllTransactions($limit, $offset);
        $this->data['totalTransactions'] = $this->getTotalTransactionsCount();
        $this->data['currentPage'] = $page;
        $this->data['totalPages'] = ceil($this->data['totalTransactions'] / $limit);
        
        $this->view('financial/transactions', $this->data);
    }
    
    /**
     * Generate financial reports
     */
    public function reports() {
        $this->data['pageTitle'] = 'Reportes Financieros - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleReportGeneration();
        }
        
        $this->data['reports'] = $this->getUserReports();
        
        $this->view('financial/reports', $this->data);
    }
    
    /**
     * Add new transaction (for admins and franchisees)
     */
    public function add_transaction() {
        // Only allow certain roles to add transactions manually
        checkRole(['superadmin', 'franquicitario']);
        
        $this->data['pageTitle'] = 'Nueva Transacción - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleNewTransaction();
        }
        
        $this->view('financial/add_transaction', $this->data);
    }
    
    /**
     * Get financial summary for current user
     */
    private function getFinancialSummary() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            // Get current month summary
            $stmt = $connection->prepare("
                SELECT 
                    transaction_type,
                    SUM(amount) as total
                FROM financial_transactions 
                WHERE user_id = ? 
                AND MONTH(transaction_date) = MONTH(CURRENT_DATE())
                AND YEAR(transaction_date) = YEAR(CURRENT_DATE())
                AND status = 'completado'
                GROUP BY transaction_type
            ");
            $stmt->execute([$userId]);
            $monthlyData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            // Get all-time summary
            $stmt = $connection->prepare("
                SELECT 
                    transaction_type,
                    SUM(amount) as total
                FROM financial_transactions 
                WHERE user_id = ? 
                AND status = 'completado'
                GROUP BY transaction_type
            ");
            $stmt->execute([$userId]);
            $allTimeData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            return [
                'monthly' => [
                    'income' => $monthlyData['ingreso'] ?? 0,
                    'expenses' => $monthlyData['egreso'] ?? 0,
                    'commissions' => $monthlyData['comision'] ?? 0,
                    'refunds' => $monthlyData['reembolso'] ?? 0
                ],
                'allTime' => [
                    'income' => $allTimeData['ingreso'] ?? 0,
                    'expenses' => $allTimeData['egreso'] ?? 0,
                    'commissions' => $allTimeData['comision'] ?? 0,
                    'refunds' => $allTimeData['reembolso'] ?? 0
                ]
            ];
        } catch (PDOException $e) {
            return [
                'monthly' => ['income' => 0, 'expenses' => 0, 'commissions' => 0, 'refunds' => 0],
                'allTime' => ['income' => 0, 'expenses' => 0, 'commissions' => 0, 'refunds' => 0]
            ];
        }
    }
    
    /**
     * Get recent transactions
     */
    private function getRecentTransactions($limit = 10) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT *
                FROM financial_transactions 
                WHERE user_id = ? 
                ORDER BY transaction_date DESC 
                LIMIT ?
            ");
            $stmt->execute([$userId, $limit]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get all transactions with pagination
     */
    private function getAllTransactions($limit, $offset) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT *
                FROM financial_transactions 
                WHERE user_id = ? 
                ORDER BY transaction_date DESC 
                LIMIT ? OFFSET ?
            ");
            $stmt->execute([$userId, $limit, $offset]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get total transactions count
     */
    private function getTotalTransactionsCount() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT COUNT(*) 
                FROM financial_transactions 
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    /**
     * Get user reports
     */
    private function getUserReports() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT *
                FROM financial_reports 
                WHERE user_id = ? 
                ORDER BY generated_at DESC
            ");
            $stmt->execute([$userId]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Handle report generation
     */
    private function handleReportGeneration() {
        $this->validateCsrf();
        
        try {
            $reportType = $this->sanitize($this->getPost('report_type'));
            $startDate = $this->sanitize($this->getPost('start_date'));
            $endDate = $this->sanitize($this->getPost('end_date'));
            
            if (empty($reportType) || empty($startDate) || empty($endDate)) {
                $this->data['error'] = 'Todos los campos son requeridos.';
                return;
            }
            
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $userId = $_SESSION['user_id'];
            
            // Calculate report data
            $stmt = $connection->prepare("
                SELECT 
                    transaction_type,
                    SUM(amount) as total
                FROM financial_transactions 
                WHERE user_id = ? 
                AND DATE(transaction_date) BETWEEN ? AND ?
                AND status = 'completado'
                GROUP BY transaction_type
            ");
            $stmt->execute([$userId, $startDate, $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            $totalIncome = $reportData['ingreso'] ?? 0;
            $totalExpenses = $reportData['egreso'] ?? 0;
            $totalCommissions = $reportData['comision'] ?? 0;
            $netProfit = $totalIncome - $totalExpenses;
            
            // Insert report
            $stmt = $connection->prepare("
                INSERT INTO financial_reports 
                (user_id, report_type, start_date, end_date, total_income, total_expenses, total_commissions, net_profit, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'completado')
            ");
            
            if ($stmt->execute([$userId, $reportType, $startDate, $endDate, $totalIncome, $totalExpenses, $totalCommissions, $netProfit])) {
                $this->data['success'] = 'Reporte generado exitosamente.';
            } else {
                $this->data['error'] = 'Error al generar el reporte.';
            }
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al generar el reporte.';
        }
    }
    
    /**
     * Handle new transaction creation
     */
    private function handleNewTransaction() {
        $this->validateCsrf();
        
        try {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'transaction_type' => $this->sanitize($this->getPost('transaction_type')),
                'amount' => (float) $this->getPost('amount'),
                'description' => $this->sanitize($this->getPost('description')),
                'status' => 'completado'
            ];
            
            if (empty($data['transaction_type']) || empty($data['amount'])) {
                $this->data['error'] = 'Tipo de transacción y monto son requeridos.';
                return;
            }
            
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                INSERT INTO financial_transactions 
                (user_id, transaction_type, amount, description, status)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute(array_values($data))) {
                $this->data['success'] = 'Transacción registrada exitosamente.';
            } else {
                $this->data['error'] = 'Error al registrar la transacción.';
            }
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al registrar la transacción.';
        }
    }
}