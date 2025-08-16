<?php
/**
 * =====================================================
 * CLUBEMIX - DASHBOARD ADMINISTRADOR
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Dashboard para usuários administradores
 * =====================================================
 */

// Definir título da página
$pageTitle = 'Dashboard Principal';

// Definir conteúdo específico do dashboard
$dashboardContent = '
<div class="row">
    <div class="col-md-12">
        <h2>✅ Login Realizado com Sucesso!</h2>
        <p>Você está acessando o dashboard de <strong>Administrador</strong>.</p>
        
        <div class="alert alert-info" style="margin: 30px 0;">
            <h4><i class="fas fa-info-circle"></i> Funcionalidades do Administrador:</h4>
            <ul>
                <li><i class="fas fa-users"></i> Gerenciar todos os usuários do sistema</li>
                <li><i class="fas fa-cogs"></i> Configurações globais da plataforma</li>
                <li><i class="fas fa-chart-bar"></i> Relatórios e analytics</li>
                <li><i class="fas fa-building"></i> Gestão de empresas e clientes</li>
                <li><i class="fas fa-percentage"></i> Controle de comissões e bonificações</li>
                <li><i class="fas fa-headset"></i> Suporte e tickets</li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-text">Gerenciar usuários do sistema</p>
                        <a href="usuarios.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-cogs fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Configurações</h5>
                        <p class="card-text">Configurar sistema</p>
                        <a href="configuracoes.php" class="btn btn-success">Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Relatórios</h5>
                        <p class="card-text">Visualizar relatórios</p>
                        <a href="relatorios.php" class="btn btn-info">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-warning mt-4">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Atenção:</strong> Este é um painel de demonstração. As funcionalidades completas serão implementadas em breve.
        </div>
    </div>
</div>
';

// Incluir o layout compartilhado
require_once '../layout.php';
?>
