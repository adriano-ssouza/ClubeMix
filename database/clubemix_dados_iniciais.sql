-- =====================================================
-- CLUBEMIX - DADOS INICIAIS DO SISTEMA
-- =====================================================
-- Versão: 1.0
-- Data: 2025
-- Descrição: Dados iniciais para configuração do sistema
-- =====================================================

-- =====================================================
-- CONFIGURAÇÃO DOS NÍVEIS DE AFILIAÇÃO (1-10)
-- =====================================================
INSERT INTO `niveis_afiliacao` (`nivel`, `percentual_comissao`, `descricao`, `ativo`, `data_inicio_vigencia`) VALUES
(1, 5.00, 'Primeiro nível - Indicação direta', TRUE, NOW()),
(2, 3.00, 'Segundo nível - Indicação de segundo grau', TRUE, NOW()),
(3, 2.00, 'Terceiro nível - Indicação de terceiro grau', TRUE, NOW()),
(4, 1.50, 'Quarto nível - Indicação de quarto grau', TRUE, NOW()),
(5, 1.00, 'Quinto nível - Indicação de quinto grau', TRUE, NOW()),
(6, 0.80, 'Sexto nível - Indicação de sexto grau', TRUE, NOW()),
(7, 0.60, 'Sétimo nível - Indicação de sétimo grau', TRUE, NOW()),
(8, 0.40, 'Oitavo nível - Indicação de oitavo grau', TRUE, NOW()),
(9, 0.30, 'Nono nível - Indicação de nono grau', TRUE, NOW()),
(10, 0.20, 'Décimo nível - Indicação de décimo grau', TRUE, NOW());

-- =====================================================
-- CONFIGURAÇÕES GLOBAIS DO SISTEMA
-- =====================================================
INSERT INTO `configuracoes_sistema` (`chave`, `valor`, `descricao`, `tipo`, `data_inicio_vigencia`) VALUES

-- Configurações de Bonificação
('percentual_bonificacao_padrao', '5.00', 'Percentual padrão de bonificação para empresas', 'decimal', NOW()),
('valor_minimo_saque', '10.00', 'Valor mínimo para solicitação de saque', 'decimal', NOW()),
('taxa_saque', '0.00', 'Taxa cobrada sobre saques (em percentual)', 'decimal', NOW()),
('limite_saques_diarios', '3', 'Limite de saques por dia por cliente', 'number', NOW()),

-- Configurações de Segurança
('max_tentativas_login', '5', 'Máximo de tentativas de login antes do bloqueio', 'number', NOW()),
('tempo_bloqueio_login', '30', 'Tempo de bloqueio em minutos após exceder tentativas', 'number', NOW()),
('tempo_expiracao_token', '60', 'Tempo de expiração do token de recuperação de senha (minutos)', 'number', NOW()),

-- Configurações de Sistema
('site_nome', 'ClubeMix', 'Nome do site/plataforma', 'string', NOW()),
('site_email', 'contato@clubemix.com', 'Email principal do sistema', 'string', NOW()),
('site_telefone', '(11) 99999-9999', 'Telefone principal do sistema', 'string', NOW()),
('site_endereco', 'São Paulo, SP - Brasil', 'Endereço da empresa', 'string', NOW()),

-- Configurações de Notificações
('email_notificacoes_ativo', 'true', 'Ativar notificações por email', 'boolean', NOW()),
('whatsapp_notificacoes_ativo', 'true', 'Ativar notificações por WhatsApp', 'boolean', NOW()),

-- Configurações de Afiliação
('max_niveis_afiliacao', '10', 'Máximo de níveis de afiliação', 'number', NOW()),
('ativar_sistema_afiliacao', 'true', 'Ativar sistema de afiliação', 'boolean', NOW()),

-- Configurações de PIX
('pix_ativo', 'true', 'Sistema PIX ativo para pagamentos', 'boolean', NOW()),
('pix_chave_empresa', 'contato@clubemix.com', 'Chave PIX principal da empresa', 'string', NOW()),

-- Configurações de Manutenção
('sistema_manutencao', 'false', 'Sistema em manutenção', 'boolean', NOW()),
('mensagem_manutencao', 'Sistema temporariamente indisponível para manutenção.', 'Mensagem exibida durante manutenção', 'string', NOW());

-- =====================================================
-- USUÁRIO ADMINISTRADOR PADRÃO
-- =====================================================
-- Senha: admin123 (deve ser alterada no primeiro login)
INSERT INTO `usuarios` (
    `uuid`, 
    `tipo_usuario`, 
    `status`, 
    `email`, 
    `senha`, 
    `email_verificado_em`
) VALUES (
    UUID(), 
    'admin', 
    'ativo', 
    'admin@clubemix.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- admin123
    NOW()
);

-- =====================================================
-- TRIGGERS PARA AUDITORIA
-- =====================================================

-- Trigger para auditoria na tabela usuarios
DELIMITER $$
CREATE TRIGGER `tr_usuarios_insert` AFTER INSERT ON `usuarios`
FOR EACH ROW
BEGIN
    INSERT INTO `logs_auditoria` (
        `usuario_id`, `acao`, `tabela`, `registro_id`, 
        `dados_novos`, `endereco_ip`, `criado_em`
    ) VALUES (
        NEW.id, 'INSERT', 'usuarios', NEW.id,
        JSON_OBJECT(
            'uuid', NEW.uuid,
            'tipo_usuario', NEW.tipo_usuario,
            'email', NEW.email,
            'status', NEW.status
        ),
        @current_ip, NOW()
    );
END$$

CREATE TRIGGER `tr_usuarios_update` AFTER UPDATE ON `usuarios`
FOR EACH ROW
BEGIN
    INSERT INTO `logs_auditoria` (
        `usuario_id`, `acao`, `tabela`, `registro_id`, 
        `dados_anteriores`, `dados_novos`, `endereco_ip`, `criado_em`
    ) VALUES (
        NEW.id, 'UPDATE', 'usuarios', NEW.id,
        JSON_OBJECT(
            'uuid', OLD.uuid,
            'tipo_usuario', OLD.tipo_usuario,
            'email', OLD.email,
            'status', OLD.status
        ),
        JSON_OBJECT(
            'uuid', NEW.uuid,
            'tipo_usuario', NEW.tipo_usuario,
            'email', NEW.email,
            'status', NEW.status
        ),
        @current_ip, NOW()
    );
END$$

-- Trigger para auditoria na tabela transacoes
CREATE TRIGGER `tr_transacoes_insert` AFTER INSERT ON `transacoes`
FOR EACH ROW
BEGIN
    INSERT INTO `logs_auditoria` (
        `usuario_id`, `acao`, `tabela`, `registro_id`, 
        `dados_novos`, `endereco_ip`, `criado_em`
    ) VALUES (
        (SELECT usuario_id FROM clientes WHERE id = NEW.cliente_id), 
        'INSERT', 'transacoes', NEW.id,
        JSON_OBJECT(
            'uuid', NEW.uuid,
            'tipo', NEW.tipo,
            'valor', NEW.valor,
            'status', NEW.status
        ),
        @current_ip, NOW()
    );
END$$

CREATE TRIGGER `tr_transacoes_update` AFTER UPDATE ON `transacoes`
FOR EACH ROW
BEGIN
    INSERT INTO `logs_auditoria` (
        `usuario_id`, `acao`, `tabela`, `registro_id`, 
        `dados_anteriores`, `dados_novos`, `endereco_ip`, `criado_em`
    ) VALUES (
        (SELECT usuario_id FROM clientes WHERE id = NEW.cliente_id), 
        'UPDATE', 'transacoes', NEW.id,
        JSON_OBJECT(
            'status', OLD.status,
            'valor', OLD.valor
        ),
        JSON_OBJECT(
            'status', NEW.status,
            'valor', NEW.valor
        ),
        @current_ip, NOW()
    );
END$$

DELIMITER ;

-- =====================================================
-- VIEWS ÚTEIS PARA RELATÓRIOS
-- =====================================================

-- View para relatório de clientes com dados completos
CREATE VIEW `vw_clientes_completo` AS
SELECT 
    c.id,
    c.nome_completo,
    c.cpf,
    c.whatsapp,
    c.cidade,
    c.estado,
    c.codigo_indicacao,
    c.codigo_indicador,
    c.nivel_afiliacao,
    c.saldo_disponivel,
    c.total_ganho,
    u.email,
    u.status,
    u.criado_em,
    u.ultimo_login_sucesso
FROM clientes c
INNER JOIN usuarios u ON c.usuario_id = u.id
WHERE u.deletado_em IS NULL;

-- View para relatório de empresas ativas
CREATE VIEW `vw_empresas_ativas` AS
SELECT 
    e.id,
    e.razao_social,
    e.nome_fantasia,
    e.cnpj,
    e.telefone,
    e.cidade,
    e.estado,
    e.segmento,
    e.percentual_bonificacao,
    e.status_parceria,
    e.data_ativacao,
    u.email,
    u.status as status_usuario
FROM empresas e
INNER JOIN usuarios u ON e.usuario_id = u.id
WHERE u.deletado_em IS NULL 
AND e.status_parceria = 'ativa';

-- View para relatório financeiro de transações
CREATE VIEW `vw_transacoes_resumo` AS
SELECT 
    DATE(t.criado_em) as data_transacao,
    t.tipo,
    COUNT(*) as quantidade,
    SUM(t.valor) as valor_total,
    SUM(t.valor_liquido) as valor_liquido_total,
    t.status
FROM transacoes t
GROUP BY DATE(t.criado_em), t.tipo, t.status
ORDER BY data_transacao DESC;

-- View para rede de afiliação
CREATE VIEW `vw_rede_afiliacao` AS
SELECT 
    a.id,
    c1.nome_completo as cliente_nome,
    c1.codigo_indicacao as cliente_codigo,
    c2.nome_completo as indicador_nome,
    c2.codigo_indicacao as indicador_codigo,
    a.nivel_afiliacao,
    a.percentual_comissao,
    a.status,
    a.data_ativacao
FROM afiliacoes a
INNER JOIN clientes c1 ON a.cliente_id = c1.id
INNER JOIN clientes c2 ON a.indicador_id = c2.id
WHERE a.status = 'ativa';

-- =====================================================
-- PROCEDURES ÚTEIS
-- =====================================================

-- Procedure para gerar código de indicação único
DELIMITER $$
CREATE PROCEDURE `sp_gerar_codigo_indicacao`(
    OUT codigo_gerado VARCHAR(50)
)
BEGIN
    DECLARE codigo_temp VARCHAR(50);
    DECLARE codigo_existe INT DEFAULT 1;
    
    WHILE codigo_existe > 0 DO
        SET codigo_temp = CONCAT('CM', LPAD(FLOOR(RAND() * 999999), 6, '0'));
        
        SELECT COUNT(*) INTO codigo_existe 
        FROM clientes 
        WHERE codigo_indicacao = codigo_temp;
    END WHILE;
    
    SET codigo_gerado = codigo_temp;
END$$

-- Procedure para calcular comissões de afiliação
CREATE PROCEDURE `sp_calcular_comissoes_afiliacao`(
    IN bonificacao_id BIGINT,
    IN valor_bonificacao DECIMAL(10,2)
)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE cliente_atual BIGINT;
    DECLARE indicador_atual BIGINT;
    DECLARE nivel_atual INT;
    DECLARE percentual_atual DECIMAL(5,2);
    DECLARE valor_comissao DECIMAL(10,2);
    
    DECLARE cur_afiliacao CURSOR FOR
        SELECT a.cliente_id, a.indicador_id, a.nivel_afiliacao, na.percentual_comissao
        FROM afiliacoes a
        INNER JOIN niveis_afiliacao na ON a.nivel_afiliacao = na.nivel
        WHERE a.cliente_id = (SELECT cliente_id FROM bonificacoes WHERE id = bonificacao_id)
        AND a.status = 'ativa'
        AND na.ativo = TRUE
        ORDER BY a.nivel_afiliacao;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur_afiliacao;
    
    read_loop: LOOP
        FETCH cur_afiliacao INTO cliente_atual, indicador_atual, nivel_atual, percentual_atual;
        
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        SET valor_comissao = (valor_bonificacao * percentual_atual / 100);
        
        -- Inserir transação de comissão
        INSERT INTO transacoes (
            uuid, tipo, cliente_id, valor, valor_liquido, 
            descricao, status
        ) VALUES (
            UUID(), 'comissao', indicador_atual, valor_comissao, valor_comissao,
            CONCAT('Comissão nível ', nivel_atual, ' - Bonificação ID: ', bonificacao_id),
            'pendente'
        );
        
        -- Atualizar saldo do cliente
        UPDATE clientes 
        SET saldo_disponivel = saldo_disponivel + valor_comissao,
            total_ganho = total_ganho + valor_comissao
        WHERE id = indicador_atual;
        
    END LOOP;
    
    CLOSE cur_afiliacao;
END$$

DELIMITER ;

-- =====================================================
-- FUNÇÕES ÚTEIS
-- =====================================================

-- Função para validar CPF
DELIMITER $$
CREATE FUNCTION `fn_validar_cpf`(cpf VARCHAR(14))
RETURNS BOOLEAN
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE cpf_numeros VARCHAR(11);
    DECLARE soma INT DEFAULT 0;
    DECLARE resto INT;
    DECLARE dv1 INT;
    DECLARE dv2 INT;
    DECLARE i INT DEFAULT 1;
    
    -- Remove formatação
    SET cpf_numeros = REGEXP_REPLACE(cpf, '[^0-9]', '');
    
    -- Verifica se tem 11 dígitos
    IF LENGTH(cpf_numeros) != 11 THEN
        RETURN FALSE;
    END IF;
    
    -- Verifica se todos os dígitos são iguais
    IF cpf_numeros REGEXP '^([0-9])\\1{10}$' THEN
        RETURN FALSE;
    END IF;
    
    -- Calcula primeiro dígito verificador
    SET soma = 0;
    SET i = 1;
    WHILE i <= 9 DO
        SET soma = soma + (CAST(SUBSTRING(cpf_numeros, i, 1) AS UNSIGNED) * (11 - i));
        SET i = i + 1;
    END WHILE;
    
    SET resto = soma % 11;
    SET dv1 = IF(resto < 2, 0, 11 - resto);
    
    -- Calcula segundo dígito verificador
    SET soma = 0;
    SET i = 1;
    WHILE i <= 10 DO
        SET soma = soma + (CAST(SUBSTRING(cpf_numeros, i, 1) AS UNSIGNED) * (12 - i));
        SET i = i + 1;
    END WHILE;
    
    SET resto = soma % 11;
    SET dv2 = IF(resto < 2, 0, 11 - resto);
    
    -- Verifica se os dígitos calculados conferem
    RETURN (dv1 = CAST(SUBSTRING(cpf_numeros, 10, 1) AS UNSIGNED) 
            AND dv2 = CAST(SUBSTRING(cpf_numeros, 11, 1) AS UNSIGNED));
END$$

DELIMITER ;

COMMIT;
