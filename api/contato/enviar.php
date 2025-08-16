<?php
/**
 * =====================================================
 * CLUBEMIX - API FORMULÁRIO DE CONTATO
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: API para envio de mensagens de contato
 * =====================================================
 */

require_once dirname(__DIR__) . '/base/ApiBase.php';

class ContatoApi extends ApiBase
{
    /**
     * Processar requisição
     */
    public function processRequest()
    {
        switch ($this->method) {
            case 'POST':
                $this->enviarMensagem();
                break;
            default:
                $this->sendError('Método não permitido', 405);
        }
    }

    /**
     * Enviar mensagem de contato
     */
    private function enviarMensagem()
    {
        try {
            // Verificar proteção contra força bruta
            $this->checkBruteForce($_SERVER['REMOTE_ADDR']);
            
            // Sanitizar dados de entrada
            $data = $this->sanitizeInput($this->request);
            
            // Validar dados obrigatórios
            $errors = $this->validateContactData($data);
            
            if (!empty($errors)) {
                $this->sendError('Dados inválidos', 400, $errors);
            }
            
            // Salvar mensagem no banco
            $contatoId = $this->salvarMensagem($data);
            
            // Enviar notificação por email (opcional)
            $this->enviarNotificacaoEmail($data);
            
            // Log da ação
            logSystem('Nova mensagem de contato recebida', 'INFO', [
                'nome' => $data['contactName'],
                'email' => $data['contactEmail'] ?? null,
                'whatsapp' => $data['contactPhone'] ?? null,
                'tipo' => $data['contactType']
            ]);
            
            $this->sendSuccess([
                'id' => $contatoId,
                'protocolo' => 'CT' . str_pad($contatoId, 6, '0', STR_PAD_LEFT)
            ], 'Mensagem enviada com sucesso! Entraremos em contato em breve.', 201);
            
        } catch (Exception $e) {
            logSystem('Erro ao enviar mensagem de contato: ' . $e->getMessage(), 'ERROR', [
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->sendError('Erro interno do servidor. Tente novamente em alguns minutos.', 500);
        }
    }

    /**
     * Validar dados do contato
     */
    private function validateContactData($data)
    {
        $errors = [];
        
        // Campos obrigatórios
        $required = ['contactName', 'contactType', 'contactSubject', 'contactMessage'];
        $requiredErrors = $this->validateRequired($required, $data);
        $errors = array_merge($errors, $requiredErrors);
        
        // Validar tipo de contato
        if (isset($data['contactType']) && !empty($data['contactType'])) {
            $tiposValidos = ['cliente', 'empresa'];
            if (!in_array($data['contactType'], $tiposValidos)) {
                $errors['contactType'] = 'Tipo de contato inválido';
            }
        }
        
        // Validar se pelo menos um meio de contato foi fornecido
        $hasEmail = isset($data['contactEmail']) && !empty(trim($data['contactEmail']));
        $hasPhone = isset($data['contactPhone']) && !empty(trim($data['contactPhone']));
        
        if (!$hasEmail && !$hasPhone) {
            $errors['contact'] = 'Informe pelo menos um meio de contato (email ou WhatsApp)';
        }
        
        // Validar email se fornecido
        if ($hasEmail && !$this->validateEmail($data['contactEmail'])) {
            $errors['contactEmail'] = 'Email inválido';
        }
        
        // Validar telefone se fornecido
        if ($hasPhone) {
            $phone = preg_replace('/[^0-9]/', '', $data['contactPhone']);
            if (strlen($phone) < 10 || strlen($phone) > 11) {
                $errors['contactPhone'] = 'WhatsApp deve conter entre 10 e 11 dígitos';
            }
        }
        
        // Validar tamanho da mensagem
        if (isset($data['contactMessage']) && !empty($data['contactMessage'])) {
            if (strlen($data['contactMessage']) < 10) {
                $errors['contactMessage'] = 'Mensagem deve ter pelo menos 10 caracteres';
            }
            if (strlen($data['contactMessage']) > 1000) {
                $errors['contactMessage'] = 'Mensagem deve ter no máximo 1000 caracteres';
            }
        }
        
        // Validar tamanho do assunto
        if (isset($data['contactSubject']) && !empty($data['contactSubject'])) {
            if (strlen($data['contactSubject']) < 5) {
                $errors['contactSubject'] = 'Assunto deve ter pelo menos 5 caracteres';
            }
            if (strlen($data['contactSubject']) > 200) {
                $errors['contactSubject'] = 'Assunto deve ter no máximo 200 caracteres';
            }
        }
        
        return $errors;
    }

    /**
     * Salvar mensagem no banco
     */
    private function salvarMensagem($data)
    {
        // Primeiro, criar um ticket de suporte
        $numeroTicket = $this->gerarNumeroTicket();
        
        $sqlTicket = "INSERT INTO tickets_suporte (
                        numero_ticket, usuario_id, categoria, prioridade,
                        titulo, descricao, status, data_abertura, criado_em
                    ) VALUES (?, NULL, 'outros', 'media', ?, ?, 'aberto', NOW(), NOW())";
        
        $titulo = $data['contactSubject'];
        $descricao = $this->montarDescricaoContato($data);
        
        $this->db->execute($sqlTicket, [$numeroTicket, $titulo, $descricao]);
        $ticketId = $this->db->lastInsertId();
        
        // Adicionar mensagem inicial ao ticket
        $sqlMensagem = "INSERT INTO mensagens_ticket (
                            ticket_id, usuario_id, mensagem, tipo, lida, criado_em
                        ) VALUES (?, NULL, ?, 'cliente', FALSE, NOW())";
        
        $mensagem = $data['contactMessage'];
        $this->db->execute($sqlMensagem, [$ticketId, $mensagem]);
        
        return $ticketId;
    }

    /**
     * Gerar número único do ticket
     */
    private function gerarNumeroTicket()
    {
        do {
            $numero = 'CT' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $sql = "SELECT COUNT(*) as count FROM tickets_suporte WHERE numero_ticket = ?";
            $result = $this->db->fetch($sql, [$numero]);
        } while ($result['count'] > 0);
        
        return $numero;
    }

    /**
     * Montar descrição completa do contato
     */
    private function montarDescricaoContato($data)
    {
        $descricao = "CONTATO VIA SITE\n";
        $descricao .= "==================\n\n";
        $descricao .= "Nome: " . $data['contactName'] . "\n";
        $descricao .= "Tipo: " . ucfirst($data['contactType']) . "\n";
        
        if (isset($data['contactEmail']) && !empty($data['contactEmail'])) {
            $descricao .= "Email: " . $data['contactEmail'] . "\n";
        }
        
        if (isset($data['contactPhone']) && !empty($data['contactPhone'])) {
            $phone = $this->formatPhone($data['contactPhone']);
            $descricao .= "WhatsApp: " . formatPhone($phone) . "\n";
        }
        
        $descricao .= "Data: " . date('d/m/Y H:i:s') . "\n";
        $descricao .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Desconhecido') . "\n\n";
        $descricao .= "MENSAGEM:\n";
        $descricao .= "----------\n";
        $descricao .= $data['contactMessage'];
        
        return $descricao;
    }

    /**
     * Enviar notificação por email
     */
    private function enviarNotificacaoEmail($data)
    {
        // Aqui você pode implementar o envio de email
        // Por enquanto, apenas registramos no log
        
        if (!EMAIL_NOTIFICATIONS) {
            return;
        }
        
        $assunto = "[ClubeMix] Nova mensagem de contato: " . $data['contactSubject'];
        $destinatario = SYSTEM_EMAIL;
        
        $corpo = "Nova mensagem de contato recebida:\n\n";
        $corpo .= "Nome: " . $data['contactName'] . "\n";
        $corpo .= "Tipo: " . ucfirst($data['contactType']) . "\n";
        
        if (isset($data['contactEmail']) && !empty($data['contactEmail'])) {
            $corpo .= "Email: " . $data['contactEmail'] . "\n";
        }
        
        if (isset($data['contactPhone']) && !empty($data['contactPhone'])) {
            $corpo .= "WhatsApp: " . formatPhone($data['contactPhone']) . "\n";
        }
        
        $corpo .= "Assunto: " . $data['contactSubject'] . "\n";
        $corpo .= "Mensagem:\n" . $data['contactMessage'] . "\n\n";
        $corpo .= "Data: " . date('d/m/Y H:i:s') . "\n";
        
        // Log da tentativa de envio
        logSystem('Notificação de contato preparada para envio', 'INFO', [
            'destinatario' => $destinatario,
            'assunto' => $assunto
        ]);
        
        // Aqui você integraria com seu sistema de email preferido
        // mail($destinatario, $assunto, $corpo);
    }

    /**
     * Métodos HTTP permitidos
     */
    protected function getAllowedMethods()
    {
        return ['POST'];
    }
}

// Executar API
try {
    $api = new ContatoApi();
    $api->processRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno do servidor',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
}
?>
