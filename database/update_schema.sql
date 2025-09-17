-- SQL Update Script for ServiBOT System Improvements
-- Run this script to apply the necessary database changes

-- Add 'franquicitario' role to existing users table
ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'cliente', 'prestador', 'franquicitario') NOT NULL;

-- Create financial transactions table for the financial module
CREATE TABLE IF NOT EXISTS financial_transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    transaction_type ENUM('ingreso', 'egreso', 'comision', 'reembolso') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description TEXT,
    reference_id INT, -- Can reference service_requests, payments, etc.
    reference_type VARCHAR(50), -- 'service_request', 'payment', 'commission', etc.
    status ENUM('pendiente', 'completado', 'cancelado') DEFAULT 'pendiente',
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create financial reports table
CREATE TABLE IF NOT EXISTS financial_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    report_type ENUM('mensual', 'semanal', 'anual', 'personalizado') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_income DECIMAL(10, 2) DEFAULT 0,
    total_expenses DECIMAL(10, 2) DEFAULT 0,
    total_commissions DECIMAL(10, 2) DEFAULT 0,
    net_profit DECIMAL(10, 2) DEFAULT 0,
    status ENUM('generando', 'completado', 'error') DEFAULT 'generando',
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_financial_transactions_user ON financial_transactions(user_id);
CREATE INDEX idx_financial_transactions_type ON financial_transactions(transaction_type);
CREATE INDEX idx_financial_transactions_date ON financial_transactions(transaction_date);
CREATE INDEX idx_financial_reports_user ON financial_reports(user_id);
CREATE INDEX idx_financial_reports_date ON financial_reports(start_date, end_date);