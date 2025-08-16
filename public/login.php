<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClubeMix</title>
    <meta name="description" content="Faça login na sua conta ClubeMix e acesse seus benefícios e bonificações.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        :root {
            --primary-green: #28a745;
            --secondary-green: #20c997;
            --dark-color: #212529;
            --white-color: #ffffff;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 50%, #ced4da 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            position: relative;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: var(--white-color);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .login-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }

        .login-form-container {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--white-color);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-green);
        }

        .form-check {
            margin-bottom: 25px;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .form-check-label {
            color: var(--text-muted);
            font-size: 14px;
        }

        .forgot-password {
            color: var(--primary-green);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--secondary-green);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            color: var(--white-color);
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
            color: var(--white-color);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .divider {
            margin: 30px 0;
            text-align: center;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            background: var(--white-color);
            padding: 0 20px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn-social {
            flex: 1;
            padding: 12px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: var(--white-color);
            color: var(--text-muted);
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
        }

        .btn-social:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-social.facebook:hover {
            border-color: #1877f2;
            color: #1877f2;
        }

        .btn-social.google:hover {
            border-color: #ea4335;
            color: #ea4335;
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
        }

        .login-footer p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .login-footer a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--secondary-green);
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .notification-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            max-width: 400px;
            width: 100%;
        }

        .notification {
            background: var(--white-color);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
            transform: translateY(-100px);
            opacity: 0;
            transition: all 0.4s ease;
            border-left: 4px solid var(--primary-green);
        }

        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .notification.success {
            border-left-color: var(--primary-green);
        }

        .notification.error {
            border-left-color: #dc3545;
        }

        .notification.warning {
            border-left-color: #ffc107;
        }

        .notification.info {
            border-left-color: #17a2b8;
        }

        .notification-content {
            display: flex;
            align-items: center;
            padding: 15px 20px;
        }

        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
        }

        .notification.success .notification-icon {
            color: var(--primary-green);
        }

        .notification.error .notification-icon {
            color: #dc3545;
        }

        .notification.warning .notification-icon {
            color: #ffc107;
        }

        .notification.info .notification-icon {
            color: #17a2b8;
        }

        .notification-body {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 2px;
        }

        .notification-text {
            color: var(--text-muted);
            font-size: 14px;
        }

        .notification-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        .notification-close:hover {
            color: var(--dark-color);
        }

        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .notification-overlay.show {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 15px;
            }
            
            .login-card {
                margin: 10px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }
            
            .login-form-container {
                padding: 30px 20px;
            }
            
            .social-login {
                flex-direction: column;
            }
            
            .btn-social {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .login-header h1 {
                font-size: 1.8rem;
            }
            
            .login-form-container {
                padding: 25px 15px;
            }
            
            .form-control {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <h1>
                    <i class="fas fa-coins me-3"></i>
                    ClubeMix
                </h1>
                <p>Faça login na sua conta e acesse seus benefícios</p>
            </div>
            
            <!-- Formulário -->
            <div class="login-form-container">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>
                            E-mail
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="senha" class="form-label">
                            <i class="fas fa-lock me-2"></i>
                            Senha
                        </label>
                        <div class="password-field">
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lembrar" name="lembrar">
                            <label class="form-check-label" for="lembrar">
                                Lembrar de mim
                            </label>
                        </div>
                        <a href="#" class="forgot-password">Esqueceu a senha?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Entrar
                        </span>
                        <span class="btn-loading" style="display: none;">
                            <span class="loading"></span>
                            Entrando...
                        </span>
                    </button>
                </form>
                
                <div class="divider">
                    <span>ou</span>
                </div>
                
                <div class="social-login">
                    <a href="#" class="btn-social facebook">
                        <i class="fab fa-facebook-f"></i>
                        Facebook
                    </a>
                    <a href="#" class="btn-social google">
                        <i class="fab fa-google"></i>
                        Google
                    </a>
                </div>
                
                <div class="login-footer">
                    <p>
                        Ainda não tem uma conta? 
                        <a href="index.php#cadastro">Cadastre-se gratuitamente</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Sistema de Debug
            const DEBUG_ENABLED = window.location.search.includes('debug=true') || 
                                 localStorage.getItem('clubemix_debug') === 'true';

            function debugLog(functionName, message, data = null) {
                if (!DEBUG_ENABLED) return;
                
                const timestamp = new Date().toISOString();
                const logStyle = 'background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;';
                
                console.group(`%cClubeMix Login Debug - ${functionName}`, logStyle);
                console.log(`⏰ Timestamp: ${timestamp}`);
                console.log(`📝 Message: ${message}`);
                
                if (data) {
                    console.log('📊 Data:', data);
                }
                
                console.trace('📍 Stack Trace:');
                console.groupEnd();
            }

            // Toggle de senha
            $('#togglePassword').on('click', function() {
                const passwordField = $('#senha');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Submissão do formulário
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                debugLog('loginForm', 'Formulário de login submetido');
                
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const btnText = submitBtn.find('.btn-text');
                const btnLoading = submitBtn.find('.btn-loading');
                
                // Desabilitar botão e mostrar loading
                submitBtn.prop('disabled', true);
                btnText.hide();
                btnLoading.show();
                
                // Preparar dados do formulário
                const formData = new FormData(this);
                const data = {
                    email: formData.get('email'),
                    senha: formData.get('senha'),
                    lembrar: formData.get('lembrar') === 'on'
                };
                
                debugLog('loginForm', 'Enviando dados para API de login', { url: '../api/auth/login.php', data: { ...data, senha: '[PROTEGIDO]' } });
                
                // Fazer requisição para API
                $.ajax({
                    url: '../api/auth/login.php',
                    method: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    dataType: 'json',
                    timeout: 30000
                }).done(function(response) {
                    debugLog('loginForm', 'Resposta de sucesso recebida da API', response);
                    
                    // Sucesso
                    showNotification(
                        'Login realizado com sucesso!',
                        'Redirecionando para o painel...',
                        'success',
                        2000,
                        true
                    );
                    
                    // Redirecionar para o dashboard correto
                    setTimeout(() => {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            window.location.href = 'dashboard.php';
                        }
                    }, 2000);
                    
                }).fail(function(xhr, textStatus, errorThrown) {
                    debugLog('loginForm', 'Erro na requisição de login', { 
                        url: '../api/auth/login.php', 
                        status: xhr.status, 
                        statusText: xhr.statusText,
                        textStatus, 
                        errorThrown, 
                        responseText: xhr.responseText,
                        responseJSON: xhr.responseJSON 
                    });
                    
                    // Erro
                    let message = 'Erro interno do servidor. Tente novamente em alguns minutos.';
                    let title = 'Erro no Login!';
                    
                    if (xhr.responseJSON) {
                        const response = xhr.responseJSON;
                        title = response.message || title;
                        
                        if (response.errors) {
                            const firstError = Object.values(response.errors)[0];
                            message = firstError || message;
                        } else {
                            message = response.message || message;
                        }
                    } else if (textStatus === 'timeout') {
                        title = 'Tempo Esgotado!';
                        message = 'A requisição demorou muito para responder. Verifique sua conexão e tente novamente.';
                    } else if (textStatus === 'error') {
                        title = 'Erro de Conexão!';
                        message = 'Não foi possível conectar ao servidor. Verifique sua conexão com a internet.';
                    }
                    
                    showNotification(title, message, 'error', 7000, true);
                    
                }).always(function() {
                    // Restaurar botão
                    submitBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();
                });
            });

            // Sistema de notificações
            function showNotification(title, message = '', type = 'info', duration = 5000, showOverlay = false) {
                if (!message && title) {
                    message = title;
                    title = getNotificationTitle(type);
                }
                
                $('.notification').remove();
                $('.notification-overlay').remove();
                
                if (showOverlay) {
                    const overlay = $('<div class="notification-overlay"></div>');
                    $('body').append(overlay);
                    setTimeout(() => overlay.addClass('show'), 10);
                }
                
                if (!$('.notification-container').length) {
                    $('body').append('<div class="notification-container"></div>');
                }
                
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    warning: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };
                
                const notification = $(`
                    <div class="notification ${type}">
                        <div class="notification-content">
                            <div class="notification-icon">
                                <i class="${icons[type] || icons.info}"></i>
                            </div>
                            <div class="notification-body">
                                <div class="notification-title">${title}</div>
                                <div class="notification-text">${message}</div>
                            </div>
                        </div>
                        <button class="notification-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
                
                $('.notification-container').append(notification);
                
                setTimeout(() => {
                    notification.addClass('show');
                }, 100);
                
                if (duration > 0) {
                    setTimeout(() => {
                        hideNotification();
                    }, duration);
                }
                
                notification.find('.notification-close').on('click', hideNotification);
                
                if (showOverlay) {
                    $('.notification-overlay').on('click', hideNotification);
                }
                
                function hideNotification() {
                    notification.removeClass('show');
                    $('.notification-overlay').removeClass('show');
                    
                    setTimeout(() => {
                        notification.remove();
                        $('.notification-overlay').remove();
                    }, 400);
                }
            }
            
            function getNotificationTitle(type) {
                const titles = {
                    success: 'Sucesso!',
                    error: 'Erro!',
                    warning: 'Atenção!',
                    info: 'Informação'
                };
                return titles[type] || titles.info;
            }

            // Log inicial se debug estiver ativo
            if (DEBUG_ENABLED) {
                console.log('%cClubeMix Login Debug Mode ATIVO! 🐛🔍', 'background: #17a2b8; color: white; padding: 10px; font-size: 16px; font-weight: bold;');
                debugLog('System', 'Página de login inicializada com debug ativo');
            }
        });
    </script>
</body>
</html>
