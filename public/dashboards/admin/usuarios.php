<?php
/**
 * =====================================================
 * CLUBEMIX - GESTÃO DE USUÁRIOS (ADMIN)
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Página para gerenciar usuários do sistema
 * =====================================================
 */

// Definir título da página
$pageTitle = 'Gestão de Usuários';

// Definir conteúdo específico da página
$dashboardContent = '
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-users"></i> Gestão de Usuários</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i> Novo Usuário
            </button>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> Lista de Usuários</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Último Login</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Administrador</td>
                                <td>admin@clubemix.com</td>
                                <td><span class="badge bg-primary">Admin</span></td>
                                <td><span class="badge bg-success">Ativo</span></td>
                                <td>2025-08-15 21:45</td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Suspender">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Adriano Souza</td>
                                <td>adriano.ssouza@gmail.com</td>
                                <td><span class="badge bg-info">Cliente</span></td>
                                <td><span class="badge bg-warning">Pendente</span></td>
                                <td>2025-08-15 21:12</td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Ativar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h3>2</h3>
                        <p>Total de Usuários</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h3>1</h3>
                        <p>Usuários Ativos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body">
                        <h3>1</h3>
                        <p>Usuários Pendentes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h3>1</h3>
                        <p>Clientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para adicionar usuário -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Usuário</label>
                        <select class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="admin">Administrador</option>
                            <option value="cliente">Cliente</option>
                            <option value="empresa">Empresa</option>
                            <option value="representante">Representante</option>
                            <option value="suporte">Suporte</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Salvar Usuário</button>
            </div>
        </div>
    </div>
</div>
';

// Incluir o layout compartilhado
require_once '../layout.php';
?>
