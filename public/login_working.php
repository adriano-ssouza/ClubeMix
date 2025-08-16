<?php
// FORÇAR INÍCIO DA SESSÃO ANTES DE QUALQUER COISA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se já está logado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    // Usuário já logado, redirecionar para dashboard
    $userType = $_SESSION['user_type'];
    $dashboardUrl = "dashboards/{$userType}/";
    
    if (is_dir($dashboardUrl) && file_exists($dashboardUrl . 'index.php')) {
        header("Location: {$dashboardUrl}");
        exit;
    } else {
        header("Location: dashboard.php");
        exit;
    }
}

// Processar login se não estiver logado
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (!empty($email) && !empty($senha)) {
        try {
            // Simular verificação de login (substituir por chamada real da API)
            if ($email === 'admin@clubemix.com' && $senha === '123456') {
                // Login bem-sucedido
                $_SESSION['user_id'] = 1;
                $_SESSION['user_type'] = 'admin';
                $_SESSION['user_email'] = $email;
                $_SESSION['login_time'] = time();
                
                $success = 'Login realizado com sucesso!';
                
                // Redirecionar após 2 segundos
                header("refresh:2;url=dashboards/admin/");
            } else {
                $error = 'Email ou senha incorretos';
            }
        } catch (Exception $e) {
            $error = 'Erro interno: ' . $e->getMessage();
        }
    } else {
        $error = 'Preencha todos os campos';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClubeMix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 400px; width: 100%; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4>🎯 ClubeMix - Login</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Entrar</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <strong>Teste:</strong> admin@clubemix.com / 123456
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
