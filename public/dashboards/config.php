<?php
/**
 * =====================================================
 * CLUBEMIX - CONFIGURAÇÃO COMPARTILHADA DOS DASHBOARDS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Configurações e funções compartilhadas entre dashboards
 * =====================================================
 */

// Definir constantes do sistema
define('CLUBEMIX_VERSION', '1.0.0');
define('CLUBEMIX_BUILD', '2025-08-15');

// Configurações de sessão (comentado para evitar erros)
/*
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // 1 para HTTPS
ini_set('session.use_strict_mode', 1);
*/

// Funções utilitárias compartilhadas
function getDashboardConfig($userType) {
    $configs = [
        'admin' => [
            'title' => 'Dashboard Administrador',
            'theme' => 'admin',
            'menu_items' => [
                'dashboard' => ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'url' => 'index.php'],
                'usuarios' => ['icon' => 'fas fa-users', 'label' => 'Usuários', 'url' => 'usuarios.php'],
                'configuracoes' => ['icon' => 'fas fa-cogs', 'label' => 'Configurações', 'url' => 'configuracoes.php'],
                'relatorios' => ['icon' => 'fas fa-chart-bar', 'label' => 'Relatórios', 'url' => 'relatorios.php'],
                'sistema' => ['icon' => 'fas fa-server', 'label' => 'Sistema', 'url' => 'sistema.php']
            ]
        ],
        'cliente' => [
            'title' => 'Dashboard Cliente',
            'theme' => 'cliente',
            'menu_items' => [
                'dashboard' => ['icon' => 'fas fa-home', 'label' => 'Início', 'url' => 'index.php'],
                'perfil' => ['icon' => 'fas fa-user', 'label' => 'Meu Perfil', 'url' => 'perfil.php'],
                'compras' => ['icon' => 'fas fa-shopping-cart', 'label' => 'Minhas Compras', 'url' => 'compras.php'],
                'afiliacao' => ['icon' => 'fas fa-network-wired', 'label' => 'Afiliação', 'url' => 'afiliacao.php'],
                'bonificacoes' => ['icon' => 'fas fa-coins', 'label' => 'Bonificações', 'url' => 'bonificacoes.php']
            ]
        ],
        'empresa' => [
            'title' => 'Dashboard Empresa',
            'theme' => 'empresa',
            'menu_items' => [
                'dashboard' => ['icon' => 'fas fa-building', 'label' => 'Dashboard', 'url' => 'index.php'],
                'produtos' => ['icon' => 'fas fa-box', 'label' => 'Produtos', 'url' => 'produtos.php'],
                'vendas' => ['icon' => 'fas fa-chart-line', 'label' => 'Vendas', 'url' => 'vendas.php'],
                'comissoes' => ['icon' => 'fas fa-percentage', 'label' => 'Comissões', 'url' => 'comissoes.php'],
                'clientes' => ['icon' => 'fas fa-users', 'label' => 'Clientes', 'url' => 'clientes.php']
            ]
        ],
        'representante' => [
            'title' => 'Dashboard Representante',
            'theme' => 'representante',
            'menu_items' => [
                'dashboard' => ['icon' => 'fas fa-handshake', 'label' => 'Dashboard', 'url' => 'index.php'],
                'rede' => ['icon' => 'fas fa-sitemap', 'label' => 'Minha Rede', 'url' => 'rede.php'],
                'comissoes' => ['icon' => 'fas fa-money-bill-wave', 'label' => 'Comissões', 'url' => 'comissoes.php'],
                'marketing' => ['icon' => 'fas fa-bullhorn', 'label' => 'Marketing', 'url' => 'marketing.php'],
                'relatorios' => ['icon' => 'fas fa-chart-pie', 'label' => 'Relatórios', 'url' => 'relatorios.php']
            ]
        ],
        'suporte' => [
            'title' => 'Dashboard Suporte',
            'theme' => 'suporte',
            'menu_items' => [
                'dashboard' => ['icon' => 'fas fa-headset', 'label' => 'Dashboard', 'url' => 'index.php'],
                'tickets' => ['icon' => 'fas fa-ticket-alt', 'label' => 'Tickets', 'url' => 'tickets.php'],
                'base' => ['icon' => 'fas fa-book', 'label' => 'Base de Conhecimento', 'url' => 'base-conhecimento.php'],
                'chat' => ['icon' => 'fas fa-comments', 'label' => 'Chat', 'url' => 'chat.php'],
                'relatorios' => ['icon' => 'fas fa-chart-area', 'label' => 'Relatórios', 'url' => 'relatorios.php']
            ]
        ]
    ];
    
    return $configs[$userType] ?? $configs['cliente'];
}

// Função para gerar menu de navegação
function generateNavigationMenu($userType) {
    $config = getDashboardConfig($userType);
    $menu = '<nav class="dashboard-nav">';
    $menu .= '<ul class="nav-list">';
    
    foreach ($config['menu_items'] as $key => $item) {
        $active = ($_SERVER['PHP_SELF'] === $item['url']) ? 'active' : '';
        $menu .= '<li class="nav-item ' . $active . '">';
        $menu .= '<a href="' . $item['url'] . '" class="nav-link">';
        $menu .= '<i class="' . $item['icon'] . '"></i>';
        $menu .= '<span>' . $item['label'] . '</span>';
        $menu .= '</a></li>';
    }
    
    $menu .= '</ul></nav>';
    return $menu;
}

// Função para gerar breadcrumb
function generateBreadcrumb($userType, $currentPage = '') {
    $config = getDashboardConfig($userType);
    $breadcrumb = '<nav class="breadcrumb-nav">';
    $breadcrumb .= '<ol class="breadcrumb">';
    $breadcrumb .= '<li class="breadcrumb-item"><a href="index.php">' . $config['title'] . '</a></li>';
    
    if ($currentPage) {
        $breadcrumb .= '<li class="breadcrumb-item active">' . $currentPage . '</li>';
    }
    
    $breadcrumb .= '</ol></nav>';
    return $breadcrumb;
}

// Função para verificar permissões
function checkPermission($userType, $requiredType) {
    if (is_array($requiredType)) {
        return in_array($userType, $requiredType);
    }
    return $userType === $requiredType;
}

// Função para log de atividades
function logDashboardActivity($userId, $userType, $action, $details = '') {
    $logData = [
        'user_id' => $userId,
        'user_type' => $userType,
        'action' => $action,
        'details' => $details,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    // Aqui você pode implementar o log para banco de dados ou arquivo
    error_log('Dashboard Activity: ' . json_encode($logData));
}

// Configurações de tema
function getThemeColors($userType) {
    $themes = [
        'admin' => ['primary' => '#667eea', 'secondary' => '#764ba2'],
        'cliente' => ['primary' => '#11998e', 'secondary' => '#38ef7d'],
        'empresa' => ['primary' => '#f093fb', 'secondary' => '#f5576c'],
        'representante' => ['primary' => '#4facfe', 'secondary' => '#00f2fe'],
        'suporte' => ['primary' => '#fa709a', 'secondary' => '#fee140']
    ];
    
    return $themes[$userType] ?? $themes['cliente'];
}
?>
