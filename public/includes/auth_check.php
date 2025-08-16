<?php
/**
 * =====================================================
 * CLUBEMIX - VERIFICAÇÃO DE AUTENTICAÇÃO
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Verifica se o usuário está autenticado
 * =====================================================
 */

// Iniciar buffer de saída para evitar problemas de headers
ob_start();

// Verificar se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica se o usuário está logado
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
}

/**
 * Verifica se o usuário tem o tipo específico
 * @param string $userType
 * @return bool
 */
function hasUserType($userType) {
    return isLoggedIn() && $_SESSION['user_type'] === $userType;
}

/**
 * Verifica se o usuário tem um dos tipos especificados
 * @param array $userTypes
 * @return bool
 */
function hasAnyUserType($userTypes) {
    return isLoggedIn() && in_array($_SESSION['user_type'], $userTypes);
}

/**
 * Redireciona para login se não estiver autenticado
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}

/**
 * Redireciona para login se não tiver o tipo específico
 * @param string $userType
 */
function requireUserType($userType) {
    requireLogin();
    if (!hasUserType($userType)) {
        header('Location: ../login.php?error=unauthorized');
        exit;
    }
}

/**
 * Redireciona para login se não tiver um dos tipos especificados
 * @param array $userTypes
 */
function requireAnyUserType($userTypes) {
    requireLogin();
    if (!hasAnyUserType($userTypes)) {
        header('Location: ../login.php?error=unauthorized');
        exit;
    }
}

/**
 * Obtém dados do usuário logado
 * @return array|null
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'uuid' => $_SESSION['user_uuid'],
        'email' => $_SESSION['user_email'],
        'type' => $_SESSION['user_type'],
        'status' => $_SESSION['user_status'],
        'login_time' => $_SESSION['login_time']
    ];
}

/**
 * Verifica se a sessão expirou (24 horas)
 * @return bool
 */
function isSessionExpired() {
    if (!isset($_SESSION['login_time'])) {
        return true;
    }
    
    $sessionLifetime = 24 * 60 * 60; // 24 horas em segundos
    return (time() - $_SESSION['login_time']) > $sessionLifetime;
}

/**
 * Renova o tempo da sessão
 */
function renewSession() {
    if (isLoggedIn()) {
        $_SESSION['login_time'] = time();
    }
}

// Verificar se a sessão expirou (comentado para evitar erros)
/*
if (isLoggedIn() && isSessionExpired()) {
    session_destroy();
    header('Location: ../login.php?error=session_expired');
    exit;
}

// Renovar sessão se estiver ativa
if (isLoggedIn()) {
    renewSession();
}
*/
?>
