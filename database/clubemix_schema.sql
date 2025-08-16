-- =====================================================
-- CLUBEMIX - SISTEMA COMPLETO DE BANCO DE DADOS
-- =====================================================
-- Versão: 1.1 (Tradução para PT-BR)
-- Data: 2025
-- Descrição: Schema completo para plataforma de bonificação e afiliação
-- =====================================================

-- Configurações iniciais
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- =====================================================
-- 1. TABELA USUARIOS (Usuários Base)
-- =====================================================
CREATE TABLE `usuarios` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `uuid` VARCHAR(36) UNIQUE NOT NULL COMMENT 'Identificador público único',
  `tipo_usuario` ENUM('cliente', 'empresa', 'admin') NOT NULL,
  `status` ENUM('ativo', 'inativo', 'pendente', 'suspenso') DEFAULT 'pendente',
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `email_verificado_em` TIMESTAMP NULL,
  `token_lembrete` VARCHAR(100) NULL,
  
  -- Campos de segurança (proteção contra força bruta)
  `tentativas_login_falhas` INT DEFAULT 0 COMMENT 'Contador de tentativas falhadas',
  `ultima_tentativa_login_falha` TIMESTAMP NULL COMMENT 'Última tentativa falhada',
  `ultimo_login_sucesso` TIMESTAMP NULL COMMENT 'Último login bem-sucedido',
  `conta_bloqueada` BOOLEAN DEFAULT FALSE COMMENT 'Conta bloqueada temporariamente',
  `data_bloqueio_conta` TIMESTAMP NULL COMMENT 'Data do bloqueio da conta',
  `motivo_bloqueio` VARCHAR(255) NULL COMMENT 'Motivo do bloqueio',
  `ultimo_ip_login` VARCHAR(45) NULL COMMENT 'Último IP de login',
  `ultimo_user_agent_login` TEXT NULL COMMENT 'Último user agent',
  
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletado_em` TIMESTAMP NULL COMMENT 'Soft delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. TABELA CLIENTES (Dados Específicos de Clientes)
-- =====================================================
CREATE TABLE `clientes` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` BIGINT UNSIGNED NOT NULL,
  `nome_completo` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(14) UNIQUE NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `whatsapp` VARCHAR(20) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `rua` VARCHAR(255) NOT NULL,
  `numero` VARCHAR(20) NOT NULL,
  `complemento` VARCHAR(100) NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `codigo_indicacao` VARCHAR(50) UNIQUE NOT NULL COMMENT 'Código único do cliente',
  `codigo_indicador` VARCHAR(50) NULL COMMENT 'Código de quem indicou',
  `nivel_afiliacao` INT DEFAULT 0 COMMENT 'Nível atual na rede',
  `saldo_disponivel` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Saldo para saque',
  `total_ganho` DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Total histórico',
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  INDEX `idx_cpf` (`cpf`),
  INDEX `idx_codigo_indicacao` (`codigo_indicacao`),
  INDEX `idx_codigo_indicador` (`codigo_indicador`),
  INDEX `idx_nivel_afiliacao` (`nivel_afiliacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. TABELA EMPRESAS (Dados Específicos de Empresas)
-- =====================================================
CREATE TABLE `empresas` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` BIGINT UNSIGNED NOT NULL,
  `razao_social` VARCHAR(255) NOT NULL,
  `nome_fantasia` VARCHAR(255) NULL,
  `cnpj` VARCHAR(18) UNIQUE NOT NULL,
  `inscricao_estadual` VARCHAR(20) NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `rua` VARCHAR(255) NOT NULL,
  `numero` VARCHAR(20) NOT NULL,
  `complemento` VARCHAR(100) NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `segmento` VARCHAR(100) NOT NULL,
  `percentual_bonificacao` DECIMAL(5,2) NOT NULL COMMENT 'Percentual de bonificação para clientes',
  `status_parceria` ENUM('pendente', 'ativa', 'suspensa', 'cancelada') DEFAULT 'pendente',
  `data_ativacao` TIMESTAMP NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  INDEX `idx_cnpj` (`cnpj`),
  INDEX `idx_status_parceria` (`status_parceria`),
  INDEX `idx_segmento` (`segmento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. TABELA NIVEIS_AFILIACAO (Configuração dos Níveis)
-- =====================================================
CREATE TABLE `niveis_afiliacao` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nivel` INT UNIQUE NOT NULL COMMENT 'Nível na rede (1-10)',
  `percentual_comissao` DECIMAL(5,2) NOT NULL COMMENT 'Percentual de comissão',
  `descricao` VARCHAR(255) NOT NULL,
  `ativo` BOOLEAN DEFAULT TRUE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX `idx_nivel` (`nivel`),
  INDEX `idx_ativo` (`ativo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. TABELA AFILIACOES (Rede de Indicações)
-- =====================================================
CREATE TABLE `afiliacoes` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `cliente_id` BIGINT UNSIGNED NOT NULL COMMENT 'Cliente que recebe comissão',
  `indicador_id` BIGINT UNSIGNED NOT NULL COMMENT 'Cliente que indicou (patrocinador direto)',
  `nivel_afiliacao` INT NOT NULL COMMENT 'Nível na rede (1-10)',
  `percentual_comissao` DECIMAL(5,2) NOT NULL COMMENT 'Percentual de comissão para este nível',
  `status` ENUM('ativa', 'inativa', 'suspensa', 'cancelada') DEFAULT 'ativa',
  `data_ativacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_desativacao` TIMESTAMP NULL,
  `motivo_desativacao` VARCHAR(255) NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`indicador_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_afiliacao_cliente_indicador` (`cliente_id`, `indicador_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. TABELA TRANSACOES (Histórico de Transações)
-- =====================================================
CREATE TABLE `transacoes` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `uuid` VARCHAR(36) UNIQUE NOT NULL COMMENT 'Identificador público único',
  `tipo` ENUM('bonificacao', 'comissao', 'saque', 'estorno') NOT NULL,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `empresa_id` BIGINT UNSIGNED NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `valor_liquido` DECIMAL(10,2) NOT NULL,
  `descricao` TEXT NOT NULL,
  `status` ENUM('pendente', 'processado', 'cancelado', 'estornado') DEFAULT 'pendente',
  `data_processamento` TIMESTAMP NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`empresa_id`) REFERENCES `empresas`(`id`) ON DELETE SET NULL,
  INDEX `idx_uuid` (`uuid`),
  INDEX `idx_status` (`status`),
  INDEX `idx_criado_em` (`criado_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. TABELA BONIFICACOES (Bonificações por Compra)
-- =====================================================
CREATE TABLE `bonificacoes` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `transacao_id` BIGINT UNSIGNED NOT NULL,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `empresa_id` BIGINT UNSIGNED NOT NULL,
  `valor_compra` DECIMAL(10,2) NOT NULL,
  `percentual_bonificacao` DECIMAL(5,2) NOT NULL,
  `valor_bonificacao` DECIMAL(10,2) NOT NULL,
  `cpf_nota` VARCHAR(14) NOT NULL,
  `numero_nota` VARCHAR(50) NOT NULL,
  `data_compra` DATE NOT NULL,
  `status` ENUM('pendente', 'processada', 'rejeitada') DEFAULT 'pendente',
  `observacoes` TEXT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`transacao_id`) REFERENCES `transacoes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`empresa_id`) REFERENCES `empresas`(`id`) ON DELETE CASCADE,
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. TABELA COMISSOES_AFILIACAO (Comissões por Indicação)
-- =====================================================
CREATE TABLE `comissoes_afiliacao` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `transacao_id` BIGINT UNSIGNED NOT NULL,
  `cliente_id` BIGINT UNSIGNED NOT NULL COMMENT 'Cliente que recebe a comissão',
  `afiliado_id` BIGINT UNSIGNED NOT NULL COMMENT 'Cliente que gerou a comissão',
  `afiliacao_id` BIGINT UNSIGNED NOT NULL,
  `nivel_afiliacao` INT NOT NULL,
  `valor_compra_original` DECIMAL(10,2) NOT NULL,
  `percentual_comissao` DECIMAL(5,2) NOT NULL,
  `valor_comissao` DECIMAL(10,2) NOT NULL,
  `bonificacao_origem_id` BIGINT UNSIGNED NOT NULL,
  `status` ENUM('pendente', 'processada', 'cancelada') DEFAULT 'pendente',
  `data_processamento` TIMESTAMP NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`transacao_id`) REFERENCES `transacoes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`afiliado_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`afiliacao_id`) REFERENCES `afiliacoes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`bonificacao_origem_id`) REFERENCES `bonificacoes`(`id`) ON DELETE CASCADE,
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. TABELA CONTAS_BANCARIAS (Dados Bancários)
-- =====================================================
CREATE TABLE `contas_bancarias` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `tipo_conta` ENUM('corrente', 'poupanca') NOT NULL,
  `banco` VARCHAR(100) NOT NULL,
  `agencia` VARCHAR(20) NOT NULL,
  `conta` VARCHAR(20) NOT NULL,
  `pix_chave` VARCHAR(255) NOT NULL,
  `pix_tipo` ENUM('cpf', 'cnpj', 'email', 'celular', 'aleatoria') NOT NULL,
  `ativo` BOOLEAN DEFAULT TRUE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  INDEX `idx_pix_chave` (`pix_chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. TABELA SAQUES (Solicitações de Saque)
-- =====================================================
CREATE TABLE `saques` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `conta_bancaria_id` BIGINT UNSIGNED NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `taxa` DECIMAL(10,2) DEFAULT 0.00,
  `valor_liquido` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pendente', 'processando', 'processado', 'rejeitado') DEFAULT 'pendente',
  `data_solicitacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_processamento` TIMESTAMP NULL,
  `observacoes` TEXT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`conta_bancaria_id`) REFERENCES `contas_bancarias`(`id`) ON DELETE CASCADE,
  INDEX `idx_data_solicitacao` (`data_solicitacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. TABELA TICKETS_SUPORTE (Chamados de Suporte)
-- =====================================================
CREATE TABLE `tickets_suporte` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `numero_ticket` VARCHAR(20) UNIQUE NOT NULL,
  `usuario_id` BIGINT UNSIGNED NOT NULL,
  `categoria` ENUM('cadastro', 'financeiro', 'tecnico', 'outros') NOT NULL,
  `prioridade` ENUM('baixa', 'media', 'alta', 'urgente') DEFAULT 'media',
  `titulo` VARCHAR(255) NOT NULL,
  `descricao` TEXT NOT NULL,
  `status` ENUM('aberto', 'em_andamento', 'aguardando_cliente', 'fechado') DEFAULT 'aberto',
  `responsavel_id` BIGINT UNSIGNED NULL COMMENT 'Admin/Usuário de suporte responsável',
  `data_abertura` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_fechamento` TIMESTAMP NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`responsavel_id`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL,
  INDEX `idx_numero_ticket` (`numero_ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. TABELA MENSAGENS_TICKET (Conversas dos Tickets)
-- =====================================================
CREATE TABLE `mensagens_ticket` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ticket_id` BIGINT UNSIGNED NOT NULL,
  `usuario_id` BIGINT UNSIGNED NOT NULL,
  `mensagem` TEXT NOT NULL,
  `tipo` ENUM('cliente', 'admin', 'sistema') NOT NULL,
  `lida` BOOLEAN DEFAULT FALSE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`ticket_id`) REFERENCES `tickets_suporte`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 13. TABELA CONFIGURACOES_SISTEMA (Configurações Globais)
-- =====================================================
CREATE TABLE `configuracoes_sistema` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `chave` VARCHAR(100) NOT NULL COMMENT 'Chave da configuração',
  `valor` TEXT NOT NULL,
  `descricao` TEXT NOT NULL,
  `tipo` ENUM('string', 'number', 'boolean', 'json', 'decimal') NOT NULL,
  `versao` INT NOT NULL DEFAULT 1 COMMENT 'Versão da configuração',
  `data_inicio_vigencia` TIMESTAMP NOT NULL,
  `data_fim_vigencia` TIMESTAMP NULL COMMENT 'NULL = vigente',
  `ativo` BOOLEAN DEFAULT TRUE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  UNIQUE KEY `uk_chave_versao` (`chave`, `versao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 14. TABELA LOGS_AUDITORIA (Log de Atividades)
-- =====================================================
CREATE TABLE `logs_auditoria` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` BIGINT UNSIGNED NULL,
  `acao` VARCHAR(100) NOT NULL,
  `tabela` VARCHAR(100) NOT NULL,
  `registro_id` BIGINT NULL,
  `dados_anteriores` JSON NULL,
  `dados_novos` JSON NULL,
  `endereco_ip` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 15. TABELA SESSOES (Sessões de Usuário)
-- =====================================================
CREATE TABLE `sessoes` (
  `id` VARCHAR(255) PRIMARY KEY,
  `usuario_id` BIGINT UNSIGNED NULL,
  `endereco_ip` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `dados` TEXT NOT NULL,
  `ultima_atividade` INT NOT NULL,
  
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 16. TABELA REDEFINICOES_SENHA
-- =====================================================
CREATE TABLE `redefinicoes_senha` (
  `email` VARCHAR(255) PRIMARY KEY,
  `token` VARCHAR(255) NOT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  INDEX `idx_email` (`email`),
  INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 17. TABELAS DE SEGURANÇA (Proteção contra Força Bruta)
-- =====================================================

-- Tabela de tentativas de login
CREATE TABLE `tentativas_login` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `endereco_ip` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NULL,
  `user_agent` TEXT NULL,
  `sucesso` BOOLEAN DEFAULT FALSE,
  `tentativa_em` TIMESTAMP NOT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de bloqueios de IP
CREATE TABLE `bloqueios_ip` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `endereco_ip` VARCHAR(45) UNIQUE NOT NULL,
  `motivo` VARCHAR(255) NOT NULL,
  `bloqueado_ate` TIMESTAMP NULL COMMENT 'NULL = permanente',
  `contagem_tentativas` INT DEFAULT 0,
  `primeira_tentativa_em` TIMESTAMP NOT NULL,
  `ultima_tentativa_em` TIMESTAMP NOT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ÍNDICES ESTRATÉGICOS PARA PERFORMANCE
-- =====================================================

CREATE INDEX `idx_afiliacoes_cliente_nivel_status` ON `afiliacoes`(`cliente_id`, `nivel_afiliacao`, `status`);
CREATE INDEX `idx_transacoes_cliente_tipo_criado` ON `transacoes`(`cliente_id`, `tipo`, `criado_em`);
CREATE INDEX `idx_bonificacoes_cliente_data_status` ON `bonificacoes`(`cliente_id`, `data_compra`, `status`);
CREATE INDEX `idx_comissoes_afiliado_nivel_status` ON `comissoes_afiliacao`(`afiliado_id`, `nivel_afiliacao`, `status`);

COMMIT;
