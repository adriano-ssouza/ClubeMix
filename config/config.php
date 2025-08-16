<?php
/**
 * =====================================================
 * CLUBEMIX - CONFIGURAÇÕES PRINCIPAIS DO SISTEMA
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Configurações principais da aplicação
 * =====================================================
 */

// Impede acesso direto
if (!defined('CLUBEMIX_SYSTEM')) {
    die('Acesso negado');
}

// =====================================================
// CONFIGURAÇÕES GERAIS
// =====================================================

// Informações do sistema
define('SYSTEM_NAME', 'ClubeMix');
define('SYSTEM_VERSION', '1.0.0');
define('SYSTEM_AUTHOR', 'ClubeMix Team');
define('SYSTEM_EMAIL', 'contato@clubemix.com');

// Configurações de ambiente
define('ENVIRONMENT', 'development'); // development, production
define('DEBUG', ENVIRONMENT === 'development');
define('TIMEZONE', 'America/Sao_Paulo');

// URLs base
define('BASE_URL', 'http://localhost/ClubeMix/public/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('UPLOADS_URL', BASE_URL . 'uploads/');

// Caminhos do sistema
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');
define('LOGS_PATH', ROOT_PATH . '/logs');

// =====================================================
// CONFIGURAÇÕES DE SESSÃO
// =====================================================

define('SESSION_NAME', 'clubemix_session');
define('SESSION_LIFETIME', 7200); // 2 horas
define('SESSION_SECURE', false); // true em HTTPS
define('SESSION_HTTPONLY', true);
define('SESSION_SAMESITE', 'Lax');

// =====================================================
// CONFIGURAÇÕES DE SEGURANÇA
// =====================================================

// Chaves de criptografia (ALTERAR EM PRODUÇÃO)
define('ENCRYPTION_KEY', 'ClubeMix2025!@#$%^&*()_+Security');
define('JWT_SECRET', 'ClubeMix_JWT_Secret_Key_2025_!@#$%');

// Configurações de senha
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_REQUIRE_UPPERCASE', true);
define('PASSWORD_REQUIRE_LOWERCASE', true);
define('PASSWORD_REQUIRE_NUMBERS', true);
define('PASSWORD_REQUIRE_SYMBOLS', false);

// Configurações de segurança
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_BLOCK_TIME', 30); // minutos
define('TOKEN_EXPIRY_TIME', 60); // minutos

// CSRF
define('CSRF_TOKEN_NAME', '_token');
define('CSRF_TOKEN_LENGTH', 32);

// =====================================================
// CONFIGURAÇÕES DE UPLOAD
// =====================================================

define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'txt']);

// =====================================================
// CONFIGURAÇÕES DE EMAIL
// =====================================================

define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'noreply@clubemix.com');
define('MAIL_PASSWORD', ''); // Configurar em produção
define('MAIL_ENCRYPTION', 'tls');
define('MAIL_FROM_NAME', 'ClubeMix');
define('MAIL_FROM_EMAIL', 'noreply@clubemix.com');

// =====================================================
// CONFIGURAÇÕES DE APIs EXTERNAS
// =====================================================

// API ViaCEP
define('VIACEP_URL', 'https://viacep.com.br/ws/');
define('VIACEP_TIMEOUT', 5);

// API WhatsApp (exemplo)
define('WHATSAPP_API_URL', '');
define('WHATSAPP_API_TOKEN', '');

// =====================================================
// CONFIGURAÇÕES DE CACHE
// =====================================================

define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // 1 hora
define('CACHE_PATH', ROOT_PATH . '/cache');

// =====================================================
// CONFIGURAÇÕES DE LOG
// =====================================================

define('LOG_ENABLED', true);
define('LOG_LEVEL', DEBUG ? 'DEBUG' : 'ERROR');
define('LOG_MAX_FILES', 30);
define('LOG_MAX_SIZE', 10 * 1024 * 1024); // 10MB

// =====================================================
// CONFIGURAÇÕES DO SISTEMA DE AFILIAÇÃO
// =====================================================

define('MAX_AFFILIATION_LEVELS', 10);
define('DEFAULT_BONUS_PERCENTAGE', 5.00);
define('MIN_WITHDRAWAL_AMOUNT', 10.00);
define('WITHDRAWAL_FEE', 0.00);
define('MAX_DAILY_WITHDRAWALS', 3);

// =====================================================
// CONFIGURAÇÕES DE PAGINAÇÃO
// =====================================================

define('DEFAULT_PAGE_SIZE', 20);
define('MAX_PAGE_SIZE', 100);

// =====================================================
// CONFIGURAÇÕES DE NOTIFICAÇÕES
// =====================================================

define('NOTIFICATIONS_ENABLED', true);
define('EMAIL_NOTIFICATIONS', true);
define('WHATSAPP_NOTIFICATIONS', false);

// =====================================================
// CONFIGURAÇÕES DE MANUTENÇÃO
// =====================================================

define('MAINTENANCE_MODE', false);
define('MAINTENANCE_MESSAGE', 'Sistema temporariamente indisponível para manutenção. Volte em breve!');
define('MAINTENANCE_ALLOWED_IPS', ['127.0.0.1', '::1']);

// =====================================================
// CONFIGURAÇÕES ESPECÍFICAS POR AMBIENTE
// =====================================================

if (ENVIRONMENT === 'production') {
    // Configurações de produção
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(0);
    
    // URLs de produção
    // define('BASE_URL', 'https://www.clubemix.com/');
    
} else {
    // Configurações de desenvolvimento
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// =====================================================
// FUNÇÕES AUXILIARES
// =====================================================

/**
 * Retorna configuração do sistema
 */
function getConfig($key, $default = null)
{
    return defined($key) ? constant($key) : $default;
}

/**
 * Verifica se está em modo de desenvolvimento
 */
function isDevelopment()
{
    return ENVIRONMENT === 'development';
}

/**
 * Verifica se está em modo de produção
 */
function isProduction()
{
    return ENVIRONMENT === 'production';
}

/**
 * Verifica se está em modo de manutenção
 */
function isMaintenanceMode()
{
    if (!MAINTENANCE_MODE) {
        return false;
    }
    
    $clientIP = $_SERVER['REMOTE_ADDR'] ?? '';
    return !in_array($clientIP, MAINTENANCE_ALLOWED_IPS);
}

/**
 * Gera URL absoluta
 */
function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

/**
 * Gera URL de assets
 */
function asset($path)
{
    return ASSETS_URL . ltrim($path, '/');
}

/**
 * Sanitiza entrada de dados
 */
function sanitize($data)
{
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    
    // Preservar tipos não-string (números, booleans, null, etc.)
    if (!is_string($data)) {
        return $data;
    }
    
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Valida email
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valida CPF
 */
function isValidCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }
    
    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += intval($cpf[$i]) * (10 - $i);
    }
    $remainder = $sum % 11;
    $digit1 = $remainder < 2 ? 0 : 11 - $remainder;
    
    if (intval($cpf[9]) != $digit1) {
        return false;
    }
    
    $sum = 0;
    for ($i = 0; $i < 10; $i++) {
        $sum += intval($cpf[$i]) * (11 - $i);
    }
    $remainder = $sum % 11;
    $digit2 = $remainder < 2 ? 0 : 11 - $remainder;
    
    return intval($cpf[10]) == $digit2;
}

/**
 * Valida CNPJ
 */
function isValidCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
    if (strlen($cnpj) != 14) {
        return false;
    }
    
    // Verifica se todos os dígitos são iguais
    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false;
    }
    
    // Calcula o primeiro dígito verificador
    $sum = 0;
    $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
    for ($i = 0; $i < 12; $i++) {
        $sum += intval($cnpj[$i]) * $weights[$i];
    }
    
    $remainder = $sum % 11;
    $digit1 = $remainder < 2 ? 0 : 11 - $remainder;
    
    if (intval($cnpj[12]) != $digit1) {
        return false;
    }
    
    // Calcula o segundo dígito verificador
    $sum = 0;
    $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
    for ($i = 0; $i < 13; $i++) {
        $sum += intval($cnpj[$i]) * $weights[$i];
    }
    
    $remainder = $sum % 11;
    $digit2 = $remainder < 2 ? 0 : 11 - $remainder;
    
    return intval($cnpj[13]) == $digit2;
}

/**
 * Formata CPF
 */
function formatCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

/**
 * Formata CNPJ
 */
function formatCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
}

/**
 * Formata telefone
 */
function formatPhone($phone)
{
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) == 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
    } elseif (strlen($phone) == 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
    }
    
    return $phone;
}

/**
 * Formata CEP
 */
function formatCEP($cep)
{
    $cep = preg_replace('/[^0-9]/', '', $cep);
    return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);
}

/**
 * Formata valor monetário
 */
function formatMoney($value, $symbol = 'R$')
{
    return $symbol . ' ' . number_format($value, 2, ',', '.');
}

/**
 * Gera token CSRF
 */
function generateCSRFToken()
{
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verifica token CSRF
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION[CSRF_TOKEN_NAME]) && 
           hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Registra log do sistema
 */
function logSystem($message, $level = 'INFO', $context = [])
{
    if (!LOG_ENABLED) return;
    
    $logFile = LOGS_PATH . '/system_' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
    
    $logEntry = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
    
    // Criar diretório se não existir
    if (!is_dir(LOGS_PATH)) {
        mkdir(LOGS_PATH, 0755, true);
    }
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// =====================================================
// INICIALIZAÇÃO
// =====================================================

// Definir timezone
date_default_timezone_set(TIMEZONE);

// Configurar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path' => '/',
        'domain' => '',
        'secure' => SESSION_SECURE,
        'httponly' => SESSION_HTTPONLY,
        'samesite' => SESSION_SAMESITE
    ]);
    
    session_name(SESSION_NAME);
    session_start();
}

// Verificar modo de manutenção
if (isMaintenanceMode() && !defined('MAINTENANCE_BYPASS')) {
    http_response_code(503);
    die(MAINTENANCE_MESSAGE);
}

// Incluir arquivo de banco de dados
require_once CONFIG_PATH . '/database.php';

// Log de inicialização
logSystem('Sistema inicializado', 'INFO', [
    'environment' => ENVIRONMENT,
    'version' => SYSTEM_VERSION,
    'user_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
]);
?>
