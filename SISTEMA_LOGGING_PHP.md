# 🐛 Sistema de Logging PHP - ClubeMix

## 📋 Visão Geral

Sistema completo de logging para debug em PHP, similar ao sistema JavaScript, que gera logs detalhados em arquivos de texto para rastreamento de métodos e dados.

## 🚀 Como Ativar o Debug

### **Método 1: Interface Web**
Acesse: `http://localhost/ClubeMix/debug_control.php`
- Interface amigável para ativar/desativar
- Visualização dos logs em tempo real
- Limpeza de logs antigos

### **Método 2: Via URL Parameter**
```
http://localhost/ClubeMix/public/index.php?debug=true
http://localhost/ClubeMix/api/cliente/cadastro.php?debug=true
```

### **Método 3: Via Header HTTP**
```bash
curl -H "X-Debug: true" http://localhost/ClubeMix/api/cliente/cadastro.php
```

### **Método 4: Via Arquivo Flag**
```php
// Criar arquivo para ativar
Logger::enableDebug();

// Remover arquivo para desativar
Logger::disableDebug();
```

## 📊 Tipos de Log Disponíveis

### **🔵 INFO** - Informações gerais
```php
logInfo('MinhaClasse', 'meuMetodo', 'Operação iniciada', $dados);
```

### **🟢 SUCCESS** - Operações bem-sucedidas
```php
logSuccess('MinhaClasse', 'meuMetodo', 'Cliente cadastrado', $cliente);
```

### **🟡 WARNING** - Avisos importantes
```php
Logger::getInstance()->warning('MinhaClasse', 'meuMetodo', 'Campo opcional vazio');
```

### **🔴 ERROR** - Erros críticos
```php
logError('MinhaClasse', 'meuMetodo', 'Falha na validação', $erros);
```

### **🐛 DEBUG** - Informações de debug
```php
logDebug('MinhaClasse', 'meuMetodo', 'Variável processada', $variavel);
```

### **📡 API** - Requisições e respostas
```php
logApi('ApiClasse', 'processRequest', 'Enviando resposta', $response);
```

### **🗄️ DATABASE** - Operações de banco
```php
Logger::getInstance()->database('MinhaClasse', 'salvar', 'Executando query', $sql);
```

### **✅ VALIDATION** - Validações
```php
logValidation('MinhaClasse', 'validar', 'CPF válido', ['cpf' => $cpf]);
```

### **🔒 SECURITY** - Segurança
```php
logSecurity('MinhaClasse', 'checkAuth', 'Tentativa de acesso', ['ip' => $ip]);
```

## 📁 Estrutura dos Logs

### **Localização dos Arquivos**
```
logs/
├── clubemix_debug_2025-01-15.log    # Log do dia atual
├── clubemix_debug_2025-01-14.log    # Log de ontem
├── debug_enabled.flag               # Flag de debug ativo
└── system_2025-01-15.log           # Logs do sistema antigo
```

### **Formato do Log**
```
================================================================================
🚀 CLUBEMIX DEBUG SESSION INICIADA - 2025-01-15 14:30:25
================================================================================
📍 IP: 127.0.0.1
🌐 User Agent: Mozilla/5.0...
📄 Request URI: /ClubeMix/api/cliente/cadastro.php
🔧 Request Method: POST
================================================================================

[2025-01-15 14:30:25.123] 🐛 [DEBUG] ClienteCadastroApi::__construct()
    📝 Message: Iniciando construção da API
    🌐 Request: POST /ClubeMix/api/cliente/cadastro.php

[2025-01-15 14:30:25.125] 📡 [API] ClienteCadastroApi::processRequest()
    📝 Message: Processando requisição
    📊 Data: {
        "method": "POST"
    }
    🌐 Request: POST /ClubeMix/api/cliente/cadastro.php

[2025-01-15 14:30:25.130] ✅ [VALIDATION] ClienteCadastroApi::validateRequired()
    📝 Message: Validando campos obrigatórios
    📊 Data: {
        "fields": ["nome_completo", "cpf", "email"],
        "data_keys": ["nome_completo", "cpf", "email", "whatsapp"]
    }
    🌐 Request: POST /ClubeMix/api/cliente/cadastro.php
    📍 Stack Trace:
        #1 cadastro.php:60 - ClienteCadastroApi::cadastrarCliente()
        #2 cadastro.php:27 - ClienteCadastroApi::processRequest()
```

## 🛠️ Como Usar no Código

### **1. Importar o Logger**
```php
require_once 'api/base/Logger.php';
```

### **2. Usar Funções Helper (Recomendado)**
```php
class MinhaApi extends ApiBase 
{
    public function meuMetodo($dados) 
    {
        logInfo('MinhaApi', 'meuMetodo', 'Método iniciado', $dados);
        
        try {
            // Validação
            logValidation('MinhaApi', 'meuMetodo', 'Validando dados');
            $erros = $this->validar($dados);
            
            if (!empty($erros)) {
                logError('MinhaApi', 'meuMetodo', 'Validação falhou', $erros);
                return false;
            }
            
            // Sucesso
            logSuccess('MinhaApi', 'meuMetodo', 'Dados válidos');
            return true;
            
        } catch (Exception $e) {
            logError('MinhaApi', 'meuMetodo', $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
```

### **3. Usar Instância Direta**
```php
$logger = Logger::getInstance();

$logger->api('MinhaClasse', 'processRequest', 'Processando', $dados);
$logger->database('MinhaClasse', 'salvar', 'Salvando no banco', $sql);
$logger->security('MinhaClasse', 'checkAuth', 'Verificando auth', $token);
```

## 🔍 Logs Implementados no Sistema

### **ApiBase (Classe Base)**
- ✅ Construção da API
- ✅ Configuração CORS
- ✅ Conexão com banco
- ✅ Processamento de dados
- ✅ Validações (campos obrigatórios, email, CPF)
- ✅ Respostas de sucesso/erro
- ✅ Verificação de duplicatas

### **ClienteCadastroApi**
- ✅ Processamento de requisições
- ✅ Início do cadastro
- ✅ Verificação de força bruta
- ✅ Sanitização de dados
- ✅ Validação de dados
- ✅ Criação de usuário/cliente
- ✅ Criação de rede de afiliação

### **Logs Automáticos em:**
- Todas as validações
- Consultas ao banco de dados
- Operações de segurança
- Respostas da API
- Tratamento de erros
- Stack traces para debug

## 🎛️ Interface de Controle

### **Painel Web: `debug_control.php`**
- 🟢/🔴 Status visual do debug
- 🎮 Botões para ativar/desativar
- 📄 Visualização dos logs em tempo real
- 🧹 Limpeza de logs antigos
- 🔄 Auto-refresh a cada 30 segundos
- 📊 Informações do sistema

### **Funcionalidades:**
- Ativar/desativar debug com um clique
- Ver últimas 100 linhas do log
- Informações do PHP e sistema
- Auto-refresh quando debug ativo

## 🔧 Configurações Avançadas

### **Limpeza Automática**
```php
// Limpar logs com mais de 7 dias
Logger::cleanOldLogs();
```

### **Verificar Status**
```php
$logger = Logger::getInstance();
if ($logger->isDebugActive()) {
    echo "Debug está ativo!";
}
```

### **Obter Arquivo de Log**
```php
$logFile = Logger::getInstance()->getLogFile();
echo "Log em: $logFile";
```

## 📈 Benefícios do Sistema

### **🔍 Rastreamento Completo**
- Todos os métodos são rastreados
- Dados de entrada e saída registrados
- Stack traces para erros
- Timestamps precisos (com microsegundos)

### **🎯 Debug Focado**
- Logs organizados por classe/método
- Diferentes tipos de log (API, validação, segurança)
- Contexto completo da requisição
- Dados estruturados em JSON

### **⚡ Performance**
- Logs só são gerados quando debug está ativo
- Sistema singleton para eficiência
- Limpeza automática de logs antigos
- Arquivo por dia para organização

### **🛡️ Segurança**
- Logs de tentativas de acesso
- Rastreamento de IPs
- Logs de validação de dados
- Auditoria de operações críticas

## 🎯 Como Testar

### **1. Ativar Debug**
```
http://localhost/ClubeMix/debug_control.php
```
Clique em "Ativar Debug"

### **2. Testar API**
```
http://localhost/ClubeMix/public/index.php?debug=true
```
Preencha e envie o formulário de cliente

### **3. Verificar Logs**
Volte ao painel de controle e veja os logs gerados em tempo real

### **4. Analisar Problemas**
Os logs mostrarão exatamente onde ocorrem erros e quais dados estão sendo processados

## 🎉 Resultado Final

**Sistema completo de logging implementado com:**

- ✅ **9 tipos diferentes** de log com ícones coloridos
- ✅ **Interface web** para controle fácil
- ✅ **Logs estruturados** com JSON e stack traces
- ✅ **Ativação flexível** via URL, header, ou arquivo
- ✅ **Limpeza automática** de logs antigos
- ✅ **Integração completa** com todas as APIs
- ✅ **Performance otimizada** só gera logs quando necessário

**Agora você tem visibilidade completa de tudo que acontece no backend PHP! 🚀**
