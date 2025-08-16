<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClubeMix - Ganhe dinheiro de volta em suas compras</title>
    <meta name="description" content="ClubeMix é a plataforma inovadora de bonificação que conecta clientes e empresas, criando uma rede de benefícios em até 10 níveis de afiliação.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- NAVEGAÇÃO -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <i class="fas fa-coins me-2"></i>
                <span class="fw-bold">ClubeMix</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#como-funciona">Como Funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Benefícios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#parceiros">Parceiros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <a class="btn btn-outline-primary me-2" href="login.php">Entrar</a>
                    <a class="btn btn-primary me-2" href="#cadastro">Quero me cadastrar</a>
                    <a class="btn btn-success" href="#cadastro" id="btnParceiro">Quero ser parceiro</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold text-white mb-4">
                            Ganhe dinheiro de volta em suas compras
                        </h1>
                        <p class="lead text-white-50 mb-5">
                            ClubeMix é a plataforma inovadora de bonificação que conecta clientes e empresas, 
                            criando uma rede de benefícios em até 10 níveis de afiliação.
                        </p>
                        <div class="hero-buttons">
                            <a href="#cadastro" class="btn btn-light btn-lg me-3">
                                <i class="fas fa-user-plus me-2"></i>Cadastre-se grátis
                            </a>
                            <a href="#como-funciona" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-play me-2"></i>Como funciona
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="affiliation-system">
                        <h4 class="text-white text-center mb-4">Sistema de Afiliação</h4>
                        <div class="affiliation-levels">
                            <div class="level-item">
                                <div class="level-circle">1</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">2</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">3</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">4</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">5</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">6</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">7</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">8</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">9</div>
                                <div class="level-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="level-circle">10</div>
                            </div>
                        </div>
                        <p class="text-white-50 text-center mt-3">
                            Ganhe bonificações em até 10 níveis de indicação
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMO FUNCIONA SECTION -->
    <section id="como-funciona" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark mb-3">Como Funciona</h2>
                <p class="lead text-muted">Processo simples em 3 passos para começar a ganhar</p>
            </div>

            <!-- Seção Clientes -->
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-users text-primary me-2"></i>Para Clientes
                    </h3>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="step-number">1</div>
                        <h4>Cadastre-se</h4>
                        <p>Faça seu cadastro gratuito e receba seu código de indicação</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="step-number">2</div>
                        <h4>Consuma</h4>
                        <p>Faça compras em empresas parceiras usando seu código</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="step-number">3</div>
                        <h4>Ganhe</h4>
                        <p>Receba bonificações instantâneas via PIX</p>
                    </div>
                </div>
            </div>

            <!-- Seção Empresas -->
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-building text-primary me-2"></i>Para Empresas
                    </h3>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="step-number">1</div>
                        <h4>Cadastre-se</h4>
                        <p>Registre sua empresa na plataforma gratuitamente</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-plug"></i>
                        </div>
                        <div class="step-number">2</div>
                        <h4>Integre</h4>
                        <p>Conecte seu sistema e comece a receber indicações</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="step-number">3</div>
                        <h4>Cresça</h4>
                        <p>Aumente suas vendas com clientes fidelizados</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BENEFÍCIOS SECTION -->
    <section id="beneficios" class="benefits-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Para Clientes</h3>
                        <h5 class="text-muted">Ganhe dinheiro de volta em suas compras</h5>
                        <ul class="benefit-list">
                            <li><i class="fas fa-check text-success me-2"></i>PIX Instantâneo</li>
                            <li><i class="fas fa-check text-success me-2"></i>100% Seguro</li>
                            <li><i class="fas fa-check text-success me-2"></i>Suporte Premium</li>
                            <li><i class="fas fa-check text-success me-2"></i>Sem Taxas Ocultas</li>
                            <li><i class="fas fa-check text-success me-2"></i>Ganhos Ilimitados</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Para Empresas</h3>
                        <h5 class="text-muted">Fidelize clientes e aumente suas vendas</h5>
                        <ul class="benefit-list">
                            <li><i class="fas fa-check text-success me-2"></i>Fidelização de Clientes</li>
                            <li><i class="fas fa-check text-success me-2"></i>Crescimento Orgânico</li>
                            <li><i class="fas fa-check text-success me-2"></i>Relatórios Detalhados</li>
                            <li><i class="fas fa-check text-success me-2"></i>Integração Simples</li>
                            <li><i class="fas fa-check text-success me-2"></i>Suporte Especializado</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <h3 class="mb-4">Pronto para começar?</h3>
                <a href="#cadastro" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i>Cadastrar como Cliente
                </a>
                <a href="#cadastro" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-building me-2"></i>Cadastrar como Empresa
                </a>
            </div>
        </div>
    </section>

    <!-- PARCEIROS SECTION -->
    <section id="parceiros" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark mb-3">Empresas que confiam no ClubeMix</h2>
                <p class="lead text-muted">Rede crescente de parceiros em diversos segmentos</p>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="partner-card text-center">
                        <div class="partner-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4>Restaurantes</h4>
                        <p>Rede de restaurantes parceiros oferecendo descontos exclusivos</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="partner-card text-center">
                        <div class="partner-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <h4>Farmácias</h4>
                        <p>Farmácias parceiras com bonificações em medicamentos</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="partner-card text-center">
                        <div class="partner-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4>Serviços</h4>
                        <p>Prestadores de serviços com benefícios especiais</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="partner-card text-center">
                        <div class="partner-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h4>Varejo</h4>
                        <p>Lojas parceiras com cashback em compras</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary">
                    <i class="fas fa-eye me-2"></i>Veja todas as empresas
                </a>
            </div>
        </div>
    </section>

    <!-- FORMULÁRIOS DE CADASTRO SECTION -->
    <section id="cadastro" class="registration-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white mb-3">Comece a Ganhar Hoje</h2>
                <p class="lead text-white-50">Cadastre-se gratuitamente e comece a receber bonificações</p>
            </div>
            
            <div class="row">
                <!-- Cadastro Cliente -->
                <div class="col-lg-6 mb-4">
                    <div class="registration-card" id="cadastro-cliente">
                        <div class="card-header-custom">
                            <div class="card-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3>Cadastro de Cliente</h3>
                        </div>
                        <form id="clienteForm" class="registration-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp *</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cep" class="form-label">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="rua" class="form-label">Rua *</label>
                                    <input type="text" class="form-control" id="rua" name="rua" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero" class="form-label">Número *</label>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bairro" class="form-label">Bairro *</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="cidade" class="form-label">Cidade *</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">Selecione</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="codigoIndicacao" class="form-label">Código de Indicação (opcional)</label>
                                <input type="text" class="form-control" id="codigoIndicacao" name="codigoIndicacao">
                            </div>
                            
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha *</label>
                                <input type="password" class="form-control" id="senha" name="senha" required 
                                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}"
                                       title="A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial">
                                <small class="form-text text-muted">
                                    Mínimo 8 caracteres com letra maiúscula, minúscula, número e caractere especial
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termosCliente" required>
                                    <label class="form-check-label" for="termosCliente">
                                        Li e aceito os <a href="#" class="text-decoration-none">Termos de Uso</a> e 
                                        <a href="#" class="text-decoration-none">Política de Privacidade</a> *
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Cadastrar Cliente
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Cadastro Empresa -->
                <div class="col-lg-6 mb-4">
                    <div class="registration-card" id="cadastro-empresa">
                        <div class="card-header-custom">
                            <div class="card-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3>Cadastro de Empresa</h3>
                        </div>
                        <form id="empresaForm" class="registration-form">
                            <div class="mb-3">
                                <label for="razaoSocial" class="form-label">Razão Social *</label>
                                <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
                                <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cnpj" class="form-label">CNPJ *</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inscricaoEstadual" class="form-label">Inscrição Estadual *</label>
                                    <input type="text" class="form-control" id="inscricaoEstadual" name="inscricaoEstadual" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">Telefone *</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <!-- Espaço reservado para futuros campos -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emailEmpresa" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="emailEmpresa" name="emailEmpresa" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cepEmpresa" class="form-label">CEP *</label>
                                    <input type="text" class="form-control" id="cepEmpresa" name="cepEmpresa" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="ruaEmpresa" class="form-label">Rua *</label>
                                    <input type="text" class="form-control" id="ruaEmpresa" name="ruaEmpresa" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numeroEmpresa" class="form-label">Número *</label>
                                    <input type="text" class="form-control" id="numeroEmpresa" name="numeroEmpresa" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="complementoEmpresa" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complementoEmpresa" name="complementoEmpresa">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bairroEmpresa" class="form-label">Bairro *</label>
                                    <input type="text" class="form-control" id="bairroEmpresa" name="bairroEmpresa" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="cidadeEmpresa" class="form-label">Cidade *</label>
                                    <input type="text" class="form-control" id="cidadeEmpresa" name="cidadeEmpresa" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estadoEmpresa" class="form-label">Estado *</label>
                                    <select class="form-select" id="estadoEmpresa" name="estadoEmpresa" required>
                                        <option value="">Selecione</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="segmento" class="form-label">Segmento *</label>
                                <select class="form-select" id="segmento" name="segmento" required>
                                    <option value="">Selecione</option>
                                    <option value="restaurante">Restaurante</option>
                                    <option value="farmacia">Farmácia</option>
                                    <option value="varejo">Varejo</option>
                                    <option value="servicos">Serviços</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="senhaEmpresa" class="form-label">Senha *</label>
                                <input type="password" class="form-control" id="senhaEmpresa" name="senhaEmpresa" required 
                                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}"
                                       title="A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial">
                                <small class="form-text text-muted">
                                    Mínimo 8 caracteres com letra maiúscula, minúscula, número e caractere especial
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termosEmpresa" required>
                                    <label class="form-check-label" for="termosEmpresa">
                                        Li e aceito os <a href="#" class="text-decoration-none">Termos de Uso</a> e 
                                        <a href="#" class="text-decoration-none">Política de Privacidade</a> *
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-building me-2"></i>Cadastrar Empresa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEÇÃO DE CONTATO -->
    <section id="contato" class="contact-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark mb-3">Entre em Contato</h2>
                <p class="lead text-muted">Estamos aqui para ajudar! Escolha a melhor forma de falar conosco</p>
            </div>
            
            <div class="row">
                <!-- WhatsApp -->
                <div class="col-lg-6 mb-4">
                    <div class="contact-card whatsapp-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3>WhatsApp</h3>
                        <p class="mb-4">Fale conosco diretamente pelo WhatsApp para um atendimento rápido e personalizado.</p>
                        
                        <div class="whatsapp-options">
                            <a href="https://wa.me/5511999999999?text=Olá! Gostaria de saber mais sobre o ClubeMix" 
                               class="btn btn-success btn-lg mb-3 w-100" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Abrir WhatsApp
                            </a>
                            
                            <div class="contact-info">
                                <h5>Nosso número:</h5>
                                <p class="phone-number">(11) 99999-9999</p>
                                <small class="text-muted">
                                    Horário de atendimento:<br>
                                    Segunda a Sexta: 8h às 18h<br>
                                    Sábado: 8h às 12h
                                </small>
                                
                                <div class="whatsapp-image mt-4 d-none d-lg-block">
                                    <img src="https://images.unsplash.com/photo-1553484771-371a605b060b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                                         alt="Telemarketing - Atendimento WhatsApp" 
                                         class="img-fluid rounded-3 shadow-sm">
                                    <small class="text-muted d-block mt-2 text-center">
                                        <i class="fab fa-whatsapp me-1"></i>Suporte via WhatsApp
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulário de E-mail -->
                <div class="col-lg-6 mb-4">
                    <div class="contact-card email-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Envie um E-mail</h3>
                        <p class="mb-4">Prefere e-mail? Preencha o formulário abaixo e responderemos em breve.</p>
                        
                        <form id="contactForm" class="contact-form">
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Seu Nome *</label>
                                <input type="text" class="form-control" id="contactName" name="contactName" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contactEmail" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactPhone" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" id="contactPhone" name="contactPhone" placeholder="(11) 99999-9999">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="contactSubject" class="form-label">Você é: *</label>
                                <select class="form-select" id="contactSubject" name="contactSubject" required>
                                    <option value="">Selecione uma opção</option>
                                    <option value="cliente">Cliente interessado</option>
                                    <option value="empresa">Empresa interessada em ser parceira</option>
                                    <option value="usuario">Usuário da plataforma</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Sua Mensagem *</label>
                                <textarea class="form-control" id="contactMessage" name="contactMessage" rows="4" 
                                         placeholder="Descreva sua dúvida, sugestão ou como podemos ajudar..." required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-brand">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-coins me-2"></i>ClubeMix
                        </h5>
                        <p class="text-white-50">
                            A plataforma inovadora de bonificação que conecta clientes e empresas, 
                            criando uma rede de benefícios em até 10 níveis de afiliação.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Institucional</h6>
                    <ul class="footer-links">
                        <li><a href="#home">Início</a></li>
                        <li><a href="#como-funciona">Como Funciona</a></li>
                        <li><a href="#beneficios">Benefícios</a></li>
                        <li><a href="#parceiros">Parceiros</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Suporte</h6>
                    <ul class="footer-links">
                        <li><a href="#contato">Contato</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Redes Sociais</h6>
                    <div class="social-links">
                        <a href="#" target="_blank" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" class="social-link">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" target="_blank" class="social-link">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="footer-divider">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        &copy; <?php echo date("Y"); ?> ClubeMix. Todos os direitos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="footer-legal">
                        <li><a href="termos-de-uso.php" target="_blank">Termos de Uso</a></li>
                        <li><a href="politica-de-privacidade.php" target="_blank">Política de Privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
