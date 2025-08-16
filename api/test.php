<?php
// Teste simples para verificar se a API está funcionando
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => 'API está funcionando!',
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'path' => $_SERVER['REQUEST_URI']
]);
?>
