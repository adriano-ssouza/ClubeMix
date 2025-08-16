# ClubeMix - Documentação das APIs

## 📋 Visão Geral

Este diretório contém todas as APIs REST do sistema ClubeMix, desenvolvidas em PHP com arquitetura orientada a objetos e padrões de segurança.

## 📁 Estrutura das APIs

```
api/
├── base/
│   └── ApiBase.php              # Classe base para todas as APIs
├── cliente/
│   └── cadastro.php             # API de cadastro de cliente
├── empresa/
│   └── cadastro.php             # API de cadastro de empresa
├── contato/
│   └── enviar.php               # API de formulário de contato
├── .htaccess                    # Configurações Apache
└── README.md                    # Esta documentação
```

## 🚀 APIs Disponíveis

### 1. API de Cadastro de Cliente

**Endpoint:** `POST /api/cliente/cadastro.php`

**Descrição:** Cadastra um novo cliente no sistema com validações completas e criação automática da rede de afiliação.

#### Parâmetros de Entrada
```json
{
    "nome_completo": "string (obrigatório, min: 3 chars)",
    "cpf": "string (obrigatório, formato: 000.000.000-00)",
    "email": "string (obrigatório, formato válido)",
    "whatsapp": "string (obrigatório, 10-11 dígitos)",
    "data_nascimento": "string (obrigatório, formato: YYYY-MM-DD)",
    "cep": "string (obrigatório, 8 dígitos)",
    "rua": "string (obrigatório)",
    "numero": "string (obrigatório)",
    "complemento": "string (opcional)",
    "bairro": "string (obrigatório)",
    "cidade": "string (obrigatório)",
    "estado": "string (obrigatório, 2 chars)",
    "codigo_indicacao": "string (opcional)",
    "senha": "string (obrigatório, min: 8 chars)"
}
```

#### Resposta de Sucesso (201)
```json
{
    "success": true,
    "message": "Cliente cadastrado com sucesso! Bem-vindo ao ClubeMix!",
    "timestamp": "2025-01-XX XX:XX:XX",
    "data": {
        "id": 123,
        "nome_completo": "João Silva",
        "cpf": "123.456.789-00",
        "whatsapp": "(11) 99999-9999",
        "codigo_indicacao": "CM123456",
        "nivel_afiliacao": 1,
        "email": "joao@email.com",
        "status": "pendente",
        "uuid": "550e8400-e29b-41d4-a716-446655440000"
    }
}
```

#### Resposta de Erro (400)
```json
{
    "success": false,
    "message": "Dados inválidos",
    "timestamp": "2025-01-XX XX:XX:XX",
    "errors": {
        "cpf": "CPF inválido",
        "email": "Email já cadastrado no sistema"
    }
}
```

### 2. API de Cadastro de Empresa

**Endpoint:** `POST /api/empresa/cadastro.php`

**Descrição:** Cadastra uma nova empresa parceira no sistema.

#### Parâmetros de Entrada
```json
{
    "razao_social": "string (obrigatório, min: 3 chars)",
    "nome_fantasia": "string (opcional)",
    "cnpj": "string (obrigatório, formato: 00.000.000/0000-00)",
    "inscricao_estadual": "string (opcional)",
    "email": "string (obrigatório, formato válido)",
    "telefone": "string (obrigatório, 10-11 dígitos)",
    "cep": "string (obrigatório, 8 dígitos)",
    "rua": "string (obrigatório)",
    "numero": "string (obrigatório)",
    "complemento": "string (opcional)",
    "bairro": "string (obrigatório)",
    "cidade": "string (obrigatório)",
    "estado": "string (obrigatório, 2 chars)",
    "segmento": "string (obrigatório)",
    "senha": "string (obrigatório, min: 8 chars)"
}
```

#### Segmentos Válidos
- `restaurante`
- `farmacia`
- `supermercado`
- `loja_roupas`
- `posto_combustivel`
- `loja_eletronicos`
- `pet_shop`
- `salao_beleza`
- `academia`
- `loja_calcados`
- `padaria`
- `lanchonete`
- `loja_casa_construcao`
- `clinica_medica`
- `oficina_mecanica`
- `loja_moveis`
- `floricultura`
- `papelaria`
- `loja_esportes`
- `outros`

#### Resposta de Sucesso (201)
```json
{
    "success": true,
    "message": "Empresa cadastrada com sucesso! Aguarde aprovação da parceria.",
    "timestamp": "2025-01-XX XX:XX:XX",
    "data": {
        "id": 456,
        "razao_social": "Empresa LTDA",
        "nome_fantasia": "Loja Exemplo",
        "cnpj": "12.345.678/0001-90",
        "telefone": "(11) 3333-4444",
        "segmento": "loja_roupas",
        "percentual_bonificacao": "5,00",
        "status_parceria": "pendente",
        "email": "empresa@email.com",
        "status": "pendente",
        "uuid": "550e8400-e29b-41d4-a716-446655440001"
    }
}
```

### 3. API de Formulário de Contato

**Endpoint:** `POST /api/contato/enviar.php`

**Descrição:** Processa mensagens do formulário de contato e cria tickets de suporte.

#### Parâmetros de Entrada
```json
{
    "contactName": "string (obrigatório, min: 2 chars)",
    "contactType": "string (obrigatório: 'cliente' ou 'empresa')",
    "contactEmail": "string (opcional, formato válido)",
    "contactPhone": "string (opcional, 10-11 dígitos)",
    "contactSubject": "string (obrigatório, 5-200 chars)",
    "contactMessage": "string (obrigatório, 10-1000 chars)"
}
```

**Nota:** Pelo menos um meio de contato (email ou telefone) deve ser fornecido.

#### Resposta de Sucesso (201)
```json
{
    "success": true,
    "message": "Mensagem enviada com sucesso! Entraremos em contato em breve.",
    "timestamp": "2025-01-XX XX:XX:XX",
    "data": {
        "id": 789,
        "protocolo": "CT000789"
    }
}
```

## 🔒 Segurança

### Proteções Implementadas

1. **Proteção contra Força Bruta**
   - Limite de tentativas por IP
   - Bloqueio automático de IPs suspeitos
   - Log detalhado de tentativas

2. **Validação de Dados**
   - Sanitização de entrada
   - Validação de CPF/CNPJ
   - Validação de email
   - Verificação de duplicatas

3. **Headers de Segurança**
   - CORS configurado
   - Headers de cache apropriados
   - Proteção contra XSS

4. **Auditoria**
   - Log completo de ações
   - Rastreamento de mudanças
   - Registro de IPs e User Agents

### Códigos de Status HTTP

- **200** - OK (sucesso)
- **201** - Created (recurso criado)
- **400** - Bad Request (dados inválidos)
- **401** - Unauthorized (não autorizado)
- **403** - Forbidden (acesso negado)
- **404** - Not Found (endpoint não encontrado)
- **405** - Method Not Allowed (método não permitido)
- **429** - Too Many Requests (muitas tentativas)
- **500** - Internal Server Error (erro interno)

## 📊 Logs e Monitoramento

### Logs Disponíveis

1. **System Logs** (`/logs/system_YYYY-MM-DD.log`)
   - Inicialização do sistema
   - Erros gerais
   - Ações importantes

2. **Database Logs** (tabela `logs_auditoria`)
   - Todas as operações CRUD
   - Dados antes/depois das mudanças
   - Informações de usuário e IP

3. **Security Logs** (tabelas `tentativas_login`, `bloqueios_ip`)
   - Tentativas de login
   - IPs bloqueados
   - Atividades suspeitas

### Monitoramento de Performance

- Timeout de 30 segundos para requisições
- Compressão GZIP habilitada
- Cache desabilitado para APIs
- Log de erros detalhado

## 🛠️ Desenvolvimento

### Estrutura da Classe Base

```php
abstract class ApiBase
{
    // Métodos principais
    abstract public function processRequest();
    protected function getAllowedMethods();
    
    // Respostas
    protected function sendSuccess($data, $message, $code);
    protected function sendError($message, $code, $errors);
    
    // Validações
    protected function validateRequired($fields, $data);
    protected function validateEmail($email);
    protected function validateCPF($cpf);
    protected function validateCNPJ($cnpj);
    
    // Segurança
    protected function checkBruteForce($ip);
    protected function sanitizeInput($data);
    
    // Utilitários
    protected function generateUUID();
    protected function hashPassword($password);
    protected function logAudit($userId, $action, $table, ...);
}
```

### Adicionando Nova API

1. Criar nova classe que estende `ApiBase`
2. Implementar método `processRequest()`
3. Definir métodos HTTP permitidos
4. Implementar validações específicas
5. Adicionar ao diretório apropriado

### Exemplo de Nova API

```php
<?php
require_once '../base/ApiBase.php';

class MinhaNovaApi extends ApiBase
{
    public function processRequest()
    {
        switch ($this->method) {
            case 'POST':
                $this->meuMetodo();
                break;
            default:
                $this->sendError('Método não permitido', 405);
        }
    }
    
    private function meuMetodo()
    {
        // Implementar lógica
        $this->sendSuccess($data, $message, 201);
    }
    
    protected function getAllowedMethods()
    {
        return ['POST'];
    }
}

$api = new MinhaNovaApi();
$api->processRequest();
?>
```

## 🧪 Testes

### Testando APIs com cURL

#### Cadastro de Cliente
```bash
curl -X POST http://localhost/ClubeMix/api/cliente/cadastro.php \
  -H "Content-Type: application/json" \
  -d '{
    "nome_completo": "João Silva",
    "cpf": "12345678901",
    "email": "joao@teste.com",
    "whatsapp": "11999999999",
    "data_nascimento": "1990-01-01",
    "cep": "01310100",
    "rua": "Av Paulista",
    "numero": "1000",
    "bairro": "Bela Vista",
    "cidade": "São Paulo",
    "estado": "SP",
    "senha": "minhasenha123"
  }'
```

#### Cadastro de Empresa
```bash
curl -X POST http://localhost/ClubeMix/api/empresa/cadastro.php \
  -H "Content-Type: application/json" \
  -d '{
    "razao_social": "Minha Empresa LTDA",
    "cnpj": "12345678000190",
    "email": "empresa@teste.com",
    "telefone": "1133334444",
    "cep": "01310100",
    "rua": "Av Paulista",
    "numero": "1000",
    "bairro": "Bela Vista",
    "cidade": "São Paulo",
    "estado": "SP",
    "segmento": "restaurante",
    "senha": "minhasenha123"
  }'
```

### Testando com JavaScript

```javascript
// Exemplo de uso no frontend
function cadastrarCliente(dados) {
    return $.ajax({
        url: 'api/cliente/cadastro.php',
        method: 'POST',
        data: JSON.stringify(dados),
        contentType: 'application/json',
        dataType: 'json'
    });
}

cadastrarCliente({
    nome_completo: 'João Silva',
    cpf: '12345678901',
    // ... outros campos
}).done(function(response) {
    console.log('Sucesso:', response);
}).fail(function(xhr) {
    console.error('Erro:', xhr.responseJSON);
});
```

## 📞 Suporte

Para dúvidas sobre as APIs:
- 📧 Email: dev@clubemix.com
- 📱 WhatsApp: (11) 99999-9999
- 📖 Documentação: `/api/README.md`

---

**Desenvolvido para o ClubeMix - Sistema de Bonificação e Afiliação** 🚀
