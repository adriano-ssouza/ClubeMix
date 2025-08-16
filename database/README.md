# ClubeMix - Banco de Dados

## 📋 Visão Geral

Este diretório contém todos os arquivos relacionados ao banco de dados do sistema ClubeMix, incluindo schema, dados iniciais e configurações.

## 📁 Estrutura de Arquivos

```
database/
├── clubemix_schema.sql          # Schema completo do banco
├── clubemix_dados_iniciais.sql  # Dados iniciais do sistema
└── README.md                    # Esta documentação
```

## 🚀 Instalação do Banco de Dados

### 1. Criação do Banco

```sql
CREATE DATABASE clubemix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Execução do Schema

```bash
mysql -u root -p clubemix < database/clubemix_schema.sql
```

### 3. Inserção dos Dados Iniciais

```bash
mysql -u root -p clubemix < database/clubemix_dados_iniciais.sql
```

## 📊 Estrutura do Banco

### Tabelas Principais

#### 👥 **Usuários e Autenticação**
- `usuarios` - Dados base de todos os usuários
- `clientes` - Dados específicos de clientes
- `empresas` - Dados específicos de empresas
- `sessoes` - Sessões ativas
- `redefinicoes_senha` - Tokens de recuperação

#### 💰 **Sistema Financeiro**
- `transacoes` - Histórico de todas as transações
- `bonificacoes` - Bonificações por compra
- `comissoes_afiliacao` - Comissões da rede de afiliação
- `contas_bancarias` - Dados bancários dos clientes
- `saques` - Solicitações de saque

#### 🌐 **Sistema de Afiliação**
- `niveis_afiliacao` - Configuração dos 10 níveis
- `afiliacoes` - Rede de indicações

#### 🎫 **Suporte**
- `tickets_suporte` - Chamados de suporte
- `mensagens_ticket` - Conversas dos tickets

#### ⚙️ **Sistema**
- `configuracoes_sistema` - Configurações globais
- `logs_auditoria` - Log de todas as atividades

#### 🔒 **Segurança**
- `tentativas_login` - Log de tentativas de login
- `bloqueios_ip` - IPs bloqueados

### Níveis de Afiliação

O sistema suporta até **10 níveis** de afiliação com os seguintes percentuais padrão:

| Nível | Percentual | Descrição |
|-------|------------|-----------|
| 1 | 5.00% | Indicação direta |
| 2 | 3.00% | Segundo grau |
| 3 | 2.00% | Terceiro grau |
| 4 | 1.50% | Quarto grau |
| 5 | 1.00% | Quinto grau |
| 6 | 0.80% | Sexto grau |
| 7 | 0.60% | Sétimo grau |
| 8 | 0.40% | Oitavo grau |
| 9 | 0.30% | Nono grau |
| 10 | 0.20% | Décimo grau |

## 🔧 Configurações do Sistema

### Configurações Padrão

- **Percentual de bonificação**: 5.00%
- **Valor mínimo para saque**: R$ 10,00
- **Taxa de saque**: 0.00%
- **Máximo de tentativas de login**: 5
- **Tempo de bloqueio**: 30 minutos

### Usuário Administrador Padrão

- **Email**: admin@clubemix.com
- **Senha**: admin123
- ⚠️ **IMPORTANTE**: Altere a senha no primeiro login!

## 📈 Views Disponíveis

### `vw_clientes_completo`
Dados completos dos clientes com informações de usuário.

### `vw_empresas_ativas`
Empresas com parceria ativa.

### `vw_transacoes_resumo`
Resumo financeiro das transações por data e tipo.

### `vw_rede_afiliacao`
Visualização da rede de afiliação ativa.

## 🔄 Procedures e Funções

### Procedures

#### `sp_gerar_codigo_indicacao()`
Gera código único de indicação para clientes.

#### `sp_calcular_comissoes_afiliacao()`
Calcula e distribui comissões da rede de afiliação.

### Funções

#### `fn_validar_cpf()`
Valida CPF usando algoritmo oficial.

## 🛡️ Segurança

### Auditoria
- Todas as operações críticas são registradas em `logs_auditoria`
- Triggers automáticos para usuários e transações

### Proteção contra Força Bruta
- Limite de tentativas de login por IP
- Bloqueio automático de IPs suspeitos
- Log detalhado de tentativas

### Soft Delete
- Usuários não são excluídos fisicamente
- Campo `deletado_em` para exclusão lógica

## 📊 Índices de Performance

### Índices Estratégicos
```sql
-- Afiliações
idx_afiliacoes_cliente_nivel_status

-- Transações
idx_transacoes_cliente_tipo_criado

-- Bonificações
idx_bonificacoes_cliente_data_status

-- Comissões
idx_comissoes_afiliado_nivel_status
```

## 🔍 Consultas Úteis

### Verificar Rede de Afiliação
```sql
SELECT * FROM vw_rede_afiliacao 
WHERE cliente_codigo = 'CM123456';
```

### Resumo Financeiro Mensal
```sql
SELECT 
    YEAR(criado_em) as ano,
    MONTH(criado_em) as mes,
    tipo,
    COUNT(*) as quantidade,
    SUM(valor) as total
FROM transacoes 
WHERE status = 'processado'
GROUP BY YEAR(criado_em), MONTH(criado_em), tipo;
```

### Top 10 Clientes por Ganhos
```sql
SELECT nome_completo, total_ganho, saldo_disponivel
FROM vw_clientes_completo 
ORDER BY total_ganho DESC 
LIMIT 10;
```

## 🚨 Backup e Manutenção

### Backup Diário
```bash
mysqldump -u root -p --single-transaction --routines --triggers clubemix > backup_$(date +%Y%m%d).sql
```

### Limpeza de Logs
```sql
-- Remover logs de auditoria antigos (90 dias)
DELETE FROM logs_auditoria 
WHERE criado_em < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Remover tentativas de login antigas (30 dias)
DELETE FROM tentativas_login 
WHERE criado_em < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

## 🔗 Relacionamentos Principais

```
usuarios (1) --> (N) clientes
usuarios (1) --> (N) empresas
clientes (1) --> (N) transacoes
clientes (1) --> (N) afiliacoes
empresas (1) --> (N) bonificacoes
```

## 📞 Suporte

Para dúvidas sobre o banco de dados:
- 📧 Email: dev@clubemix.com
- 📱 WhatsApp: (11) 99999-9999

---

**Desenvolvido para o ClubeMix - Sistema de Bonificação e Afiliação** 🚀
