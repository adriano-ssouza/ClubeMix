<?php
/**
 * =====================================================
 * CLUBEMIX - SETUP DO BANCO DE DADOS
 * =====================================================
 * Script para verificar e configurar o banco de dados
 * =====================================================
 */

echo "🔧 CLUBEMIX - SETUP DO BANCO DE DADOS\n";
echo "=====================================\n\n";

// Configurações do banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'clubemix';

try {
    // Conectar sem especificar o banco
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conectado ao MySQL com sucesso!\n";
    
    // Verificar se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $databaseExists = $stmt->rowCount() > 0;
    
    if (!$databaseExists) {
        echo "📦 Criando banco de dados '$dbname'...\n";
        $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✅ Banco de dados criado com sucesso!\n";
    } else {
        echo "✅ Banco de dados '$dbname' já existe!\n";
    }
    
    // Conectar ao banco específico
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verificar se as tabelas existem
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\n📋 Tabelas encontradas: " . count($tables) . "\n";
    
    if (count($tables) === 0) {
        echo "📦 Criando tabelas...\n";
        
        // Ler e executar o schema SQL
        $schemaFile = 'database/clubemix_schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            
            // Dividir em comandos individuais
            $commands = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($commands as $command) {
                if (!empty($command)) {
                    try {
                        $pdo->exec($command);
                        echo "✅ Comando executado: " . substr($command, 0, 50) . "...\n";
                    } catch (PDOException $e) {
                        echo "⚠️ Erro no comando: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            // Inserir dados iniciais
            $dadosFile = 'database/clubemix_dados_iniciais.sql';
            if (file_exists($dadosFile)) {
                echo "\n📦 Inserindo dados iniciais...\n";
                $sql = file_get_contents($dadosFile);
                $commands = array_filter(array_map('trim', explode(';', $sql)));
                
                foreach ($commands as $command) {
                    if (!empty($command)) {
                        try {
                            $pdo->exec($command);
                            echo "✅ Dados inseridos: " . substr($command, 0, 50) . "...\n";
                        } catch (PDOException $e) {
                            echo "⚠️ Erro nos dados: " . $e->getMessage() . "\n";
                        }
                    }
                }
            }
        } else {
            echo "❌ Arquivo de schema não encontrado: $schemaFile\n";
        }
    } else {
        echo "✅ Tabelas já existem!\n";
        foreach ($tables as $table) {
            echo "   - $table\n";
        }
    }
    
    // Verificar se há usuários na tabela
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $total = $stmt->fetch()['total'];
    
    echo "\n👥 Usuários cadastrados: $total\n";
    
    if ($total == 0) {
        echo "📝 Criando usuário de teste...\n";
        
        // Criar usuário de teste
        $senhaHash = password_hash('Teste@123', PASSWORD_DEFAULT);
        $uuid = uniqid('user_', true);
        
        $sql = "INSERT INTO usuarios (uuid, email, senha, tipo_usuario, status, criado_em) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$uuid, 'teste@exemplo.com', $senhaHash, 'cliente', 'ativo']);
        
        echo "✅ Usuário de teste criado!\n";
        echo "   Email: teste@exemplo.com\n";
        echo "   Senha: Teste@123\n";
    }
    
    echo "\n🎉 Setup do banco de dados concluído!\n";
    
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    echo "Verifique se o MySQL está rodando e as credenciais estão corretas.\n";
}
?>
