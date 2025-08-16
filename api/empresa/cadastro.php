<?php
/**
 * =====================================================
 * CLUBEMIX - API CADASTRO DE EMPRESA
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: API para cadastro de novas empresas
 * =====================================================
 */

require_once dirname(__DIR__) . '/base/ApiBase.php';

class EmpresaCadastroApi extends ApiBase
{
    /**
     * Processar requisição
     */
    public function processRequest()
    {
        switch ($this->method) {
            case 'POST':
                $this->cadastrarEmpresa();
                break;
            default:
                $this->sendError('Método não permitido', 405);
        }
    }

    /**
     * Cadastrar nova empresa
     */
    private function cadastrarEmpresa()
    {
        try {
            // Verificar proteção contra força bruta
            $this->checkBruteForce($_SERVER['REMOTE_ADDR']);
            
            // Sanitizar dados de entrada
            $data = $this->sanitizeInput($this->request);
            
            // Validar dados obrigatórios
            $errors = $this->validateCompanyData($data);
            
            if (!empty($errors)) {
                $this->sendError('Dados inválidos', 400, $errors);
            }
            
            // Verificar se email já existe
            if ($this->emailExists($data['email'])) {
                $this->sendError('Email já cadastrado no sistema', 400, [
                    'email' => 'Este email já está em uso'
                ]);
            }
            
            // Verificar se CNPJ já existe
            if ($this->cnpjExists($data['cnpj'])) {
                $this->sendError('CNPJ já cadastrado no sistema', 400, [
                    'cnpj' => 'Este CNPJ já está em uso'
                ]);
            }
            
            // Iniciar transação
            $this->db->beginTransaction();
            
            try {
                // Criar usuário
                $usuarioId = $this->criarUsuario($data);
                
                // Criar empresa
                $empresaId = $this->criarEmpresa($data, $usuarioId);
                
                // Confirmar transação
                $this->db->commit();
                
                // Log de auditoria
                $this->logAudit($usuarioId, 'INSERT', 'empresas', $empresaId, null, [
                    'razao_social' => $data['razao_social'],
                    'email' => $data['email'],
                    'cnpj' => $data['cnpj']
                ]);
                
                // Buscar dados da empresa criada
                $empresa = $this->buscarEmpresaCriada($empresaId);
                
                $this->sendSuccess($empresa, 'Empresa cadastrada com sucesso! Aguarde aprovação da parceria.', 201);
                
            } catch (Exception $e) {
                $this->db->rollback();
                throw $e;
            }
            
        } catch (Exception $e) {
            logSystem('Erro ao cadastrar empresa: ' . $e->getMessage(), 'ERROR', [
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->sendError('Erro interno do servidor. Tente novamente em alguns minutos.', 500);
        }
    }

    /**
     * Validar dados da empresa
     */
    private function validateCompanyData($data)
    {
        $errors = [];
        
        // Campos obrigatórios
        $required = [
            'razao_social', 'cnpj', 'email', 'telefone', 'segmento',
            'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'senha'
        ];
        
        $requiredErrors = $this->validateRequired($required, $data);
        $errors = array_merge($errors, $requiredErrors);
        
        // Validações específicas
        if (isset($data['email']) && !empty($data['email'])) {
            if (!$this->validateEmail($data['email'])) {
                $errors['email'] = 'Email inválido';
            }
        }
        
        if (isset($data['cnpj']) && !empty($data['cnpj'])) {
            if (!$this->validateCNPJ($data['cnpj'])) {
                $errors['cnpj'] = 'CNPJ inválido';
            }
        }
        
        if (isset($data['cep']) && !empty($data['cep'])) {
            $cep = preg_replace('/[^0-9]/', '', $data['cep']);
            if (strlen($cep) !== 8) {
                $errors['cep'] = 'CEP deve conter 8 dígitos';
            }
        }
        
        if (isset($data['senha']) && !empty($data['senha'])) {
            $passwordErrors = $this->validatePasswordStrength($data['senha']);
            if (!empty($passwordErrors)) {
                $errors['senha'] = implode(', ', $passwordErrors);
            }
        }
        
        if (isset($data['telefone']) && !empty($data['telefone'])) {
            $phone = preg_replace('/[^0-9]/', '', $data['telefone']);
            if (strlen($phone) < 10 || strlen($phone) > 11) {
                $errors['telefone'] = 'Telefone deve conter entre 10 e 11 dígitos';
            }
        }
        
        if (isset($data['estado']) && !empty($data['estado'])) {
            if (strlen($data['estado']) !== 2) {
                $errors['estado'] = 'Estado deve conter 2 caracteres';
            }
        }
        
        // Validar segmento
        $segmentosValidos = [
            'restaurante', 'farmacia', 'supermercado', 'loja_roupas', 
            'posto_combustivel', 'loja_eletronicos', 'pet_shop', 
            'salao_beleza', 'academia', 'loja_calcados', 'padaria',
            'lanchonete', 'loja_casa_construcao', 'clinica_medica',
            'oficina_mecanica', 'loja_moveis', 'floricultura',
            'papelaria', 'loja_esportes', 'outros'
        ];
        
        if (isset($data['segmento']) && !empty($data['segmento'])) {
            if (!in_array($data['segmento'], $segmentosValidos)) {
                $errors['segmento'] = 'Segmento inválido';
            }
        }
        
        return $errors;
    }

    /**
     * Criar usuário
     */
    private function criarUsuario($data)
    {
        $sql = "INSERT INTO usuarios (
                    uuid, tipo_usuario, status, email, senha, criado_em
                ) VALUES (?, 'empresa', 'pendente', ?, ?, NOW())";
        
        $uuid = $this->generateUUID();
        $senhaHash = $this->hashPassword($data['senha']);
        
        $this->db->execute($sql, [$uuid, $data['email'], $senhaHash]);
        
        return $this->db->lastInsertId();
    }

    /**
     * Criar empresa
     */
    private function criarEmpresa($data, $usuarioId)
    {
        $sql = "INSERT INTO empresas (
                    usuario_id, razao_social, nome_fantasia, cnpj, inscricao_estadual,
                    telefone, cep, rua, numero, complemento, bairro, cidade, estado,
                    segmento, percentual_bonificacao, status_parceria, criado_em
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendente', NOW())";
        
        $cnpjLimpo = preg_replace('/[^0-9]/', '', $data['cnpj']);
        $telefoneLimpo = $this->formatPhone($data['telefone']);
        $cepLimpo = preg_replace('/[^0-9]/', '', $data['cep']);
        $nomeFantasia = isset($data['nome_fantasia']) ? $data['nome_fantasia'] : null;
        $inscricaoEstadual = isset($data['inscricao_estadual']) ? $data['inscricao_estadual'] : null;
        $complemento = isset($data['complemento']) ? $data['complemento'] : null;
        
        $params = [
            $usuarioId,
            $data['razao_social'],
            $nomeFantasia,
            $cnpjLimpo,
            $inscricaoEstadual,
            $telefoneLimpo,
            $cepLimpo,
            $data['rua'],
            $data['numero'],
            $complemento,
            $data['bairro'],
            $data['cidade'],
            strtoupper($data['estado']),
            $data['segmento'],
            DEFAULT_BONUS_PERCENTAGE
        ];
        
        $this->db->execute($sql, $params);
        
        return $this->db->lastInsertId();
    }

    /**
     * Buscar dados da empresa criada
     */
    private function buscarEmpresaCriada($empresaId)
    {
        $sql = "SELECT 
                    e.id,
                    e.razao_social,
                    e.nome_fantasia,
                    e.cnpj,
                    e.telefone,
                    e.segmento,
                    e.percentual_bonificacao,
                    e.status_parceria,
                    u.email,
                    u.status,
                    u.uuid
                FROM empresas e
                INNER JOIN usuarios u ON e.usuario_id = u.id
                WHERE e.id = ?";
        
        $empresa = $this->db->fetch($sql, [$empresaId]);
        
        if ($empresa) {
            // Formatar dados para resposta
            $empresa['cnpj'] = formatCNPJ($empresa['cnpj']);
            $empresa['telefone'] = formatPhone($empresa['telefone']);
            $empresa['percentual_bonificacao'] = number_format($empresa['percentual_bonificacao'], 2, ',', '.');
        }
        
        return $empresa;
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
    $api = new EmpresaCadastroApi();
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
