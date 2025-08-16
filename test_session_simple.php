<?php
echo "Teste de Sessao\n";
echo "================\n\n";

// Testar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    echo "Sessao iniciada\n";
} else {
    echo "Sessao ja estava ativa\n";
}

echo "Session ID: " . session_id() . "\n";

// Definir dados
$_SESSION['test'] = 'valor_teste';
echo "Dado definido na sessao\n";

// Verificar
echo "Valor na sessao: " . ($_SESSION['test'] ?? 'NAO DEFINIDO') . "\n";

echo "Teste concluido\n";
?>
