<?php
/**
 * =====================================================
 * CLUBEMIX - CONTROLE DE DEBUG
 * =====================================================
 * Script para ativar/desativar debug e visualizar logs
 * =====================================================
 */

require_once 'api/base/Logger.php';

// Ação solicitada
$action = $_GET['action'] ?? '';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClubeMix - Controle de Debug</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f8f9fa; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #28a745; 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .status { 
            text-align: center; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            font-weight: bold; 
        }
        .status.active { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .status.inactive { 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
        .buttons { 
            text-align: center; 
            margin: 20px 0; 
        }
        .btn { 
            padding: 10px 20px; 
            margin: 0 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-weight: bold; 
        }
        .btn-success { 
            background: #28a745; 
            color: white; 
        }
        .btn-danger { 
            background: #dc3545; 
            color: white; 
        }
        .btn-info { 
            background: #17a2b8; 
            color: white; 
        }
        .btn:hover { 
            opacity: 0.8; 
        }
        .log-container { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 5px; 
            padding: 15px; 
            margin-top: 20px; 
            max-height: 600px; 
            overflow-y: auto; 
        }
        .log-content { 
            font-family: 'Courier New', monospace; 
            font-size: 12px; 
            white-space: pre-wrap; 
            line-height: 1.4; 
        }
        .info { 
            background: #d1ecf1; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
            border-left: 4px solid #17a2b8; 
        }
        .alert { 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
        }
        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .alert-danger { 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐛 ClubeMix - Controle de Debug</h1>
        
        <?php
        // Processar ações
        if ($action === 'enable') {
            Logger::enableDebug();
            echo '<div class="alert alert-success">✅ Debug ATIVADO com sucesso!</div>';
        } elseif ($action === 'disable') {
            Logger::disableDebug();
            echo '<div class="alert alert-success">❌ Debug DESATIVADO com sucesso!</div>';
        } elseif ($action === 'clean') {
            Logger::cleanOldLogs();
            echo '<div class="alert alert-success">🧹 Logs antigos limpos com sucesso!</div>';
        }
        
        // Verificar status do debug
        $logger = Logger::getInstance();
        $isActive = $logger->isDebugActive();
        ?>
        
        <div class="status <?php echo $isActive ? 'active' : 'inactive'; ?>">
            <?php if ($isActive): ?>
                🟢 DEBUG ATIVO - Logs sendo gerados
            <?php else: ?>
                🔴 DEBUG INATIVO - Logs não estão sendo gerados
            <?php endif; ?>
        </div>
        
        <div class="buttons">
            <?php if (!$isActive): ?>
                <a href="?action=enable" class="btn btn-success">🟢 Ativar Debug</a>
            <?php else: ?>
                <a href="?action=disable" class="btn btn-danger">🔴 Desativar Debug</a>
            <?php endif; ?>
            
            <a href="?action=clean" class="btn btn-info">🧹 Limpar Logs Antigos</a>
            <a href="?" class="btn btn-info">🔄 Atualizar Status</a>
        </div>
        
        <div class="info">
            <h3>📋 Como Usar:</h3>
            <ul>
                <li><strong>Ativar Debug:</strong> Clique em "Ativar Debug" e teste os formulários</li>
                <li><strong>Via URL:</strong> Acesse qualquer página com <code>?debug=true</code></li>
                <li><strong>Via Console JS:</strong> Digite <code>clubemixDebug(true)</code></li>
                <li><strong>Arquivo de Log:</strong> <code><?php echo $logger->getLogFile(); ?></code></li>
            </ul>
        </div>
        
        <?php if ($isActive && file_exists($logger->getLogFile())): ?>
            <h3>📄 Último Log (últimas 100 linhas):</h3>
            <div class="log-container">
                <div class="log-content"><?php
                    $logContent = file_get_contents($logger->getLogFile());
                    $lines = explode("\n", $logContent);
                    $lastLines = array_slice($lines, -100);
                    echo htmlspecialchars(implode("\n", $lastLines));
                ?></div>
            </div>
        <?php elseif ($isActive): ?>
            <div class="info">
                📝 Debug ativo, mas ainda não há logs. Teste os formulários para gerar logs.
            </div>
        <?php else: ?>
            <div class="info">
                💡 Ative o debug para visualizar os logs aqui.
            </div>
        <?php endif; ?>
        
        <div class="info">
            <h3>🔍 Informações do Sistema:</h3>
            <ul>
                <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                <li><strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
                <li><strong>IP:</strong> <?php echo $_SERVER['REMOTE_ADDR'] ?? 'unknown'; ?></li>
                <li><strong>User Agent:</strong> <?php echo htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'); ?></li>
            </ul>
        </div>
    </div>
    
    <script>
        // Auto-refresh a cada 30 segundos se debug estiver ativo
        <?php if ($isActive): ?>
        setTimeout(() => {
            location.reload();
        }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>
