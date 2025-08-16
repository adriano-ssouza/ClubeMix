// ===== CLUBEMIX - SCRIPTS PRINCIPAIS =====

// ===== SISTEMA DE DEBUG/TRACKING =====
const DEBUG_ENABLED = window.location.search.includes('debug=true') || 
                     localStorage.getItem('clubemix_debug') === 'true';

function debugLog(functionName, message, data = null) {
    if (!DEBUG_ENABLED) return;
    
    const timestamp = new Date().toISOString();
    const logStyle = 'background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;';
    
    console.group(`%cClubeMix Debug - ${functionName}`, logStyle);
    console.log(`⏰ Timestamp: ${timestamp}`);
    console.log(`📝 Message: ${message}`);
    
    if (data) {
        console.log('📊 Data:', data);
    }
    
    console.trace('📍 Stack Trace:');
    console.groupEnd();
}

// Função global para ativar/desativar debug via console
window.clubemixDebug = function(enable = true) {
    if (enable) {
        localStorage.setItem('clubemix_debug', 'true');
        console.log('%cClubeMix Debug ATIVADO! 🐛', 'background: #28a745; color: white; padding: 5px; font-size: 14px;');
    } else {
        localStorage.removeItem('clubemix_debug');
        console.log('%cClubeMix Debug DESATIVADO! ❌', 'background: #dc3545; color: white; padding: 5px; font-size: 14px;');
    }
    location.reload();
};

$(document).ready(function() {
    
    // Log inicial se debug estiver ativo
    if (DEBUG_ENABLED) {
        console.log('%cClubeMix Debug Mode ATIVO! 🐛🔍', 'background: #17a2b8; color: white; padding: 10px; font-size: 16px; font-weight: bold;');
        console.log('%cPara desativar: clubemixDebug(false)', 'background: #6c757d; color: white; padding: 5px;');
        debugLog('System', 'Sistema inicializado com debug ativo');
    }
    
    // ===== NAVBAR SCROLL EFFECT =====
    $(window).scroll(function() {
        if ($(window).scrollTop() > 50) {
            $('#mainNavbar').addClass('scrolled');
        } else {
            $('#mainNavbar').removeClass('scrolled');
        }
    });

    // ===== SMOOTH SCROLL PARA LINKS INTERNOS =====
    function smoothScrollTo(targetId) {
        const target = document.getElementById(targetId.replace('#', ''));
        if (target) {
            const offsetTop = target.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
            
            // Adicionar classe ativa ao link
            $('.nav-link').removeClass('active');
            $(`.nav-link[href="${targetId}"]`).addClass('active');
            
            // Fechar menu mobile se estiver aberto
            $('.navbar-collapse').collapse('hide');
        }
    }
    
    // Event listener para links internos
    $(document).on('click', 'a[href^="#"]', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        
        console.log('Navegando para:', href);
        smoothScrollTo(href);
    });
    
    // Método alternativo usando jQuery animate como fallback
    $(document).on('click', '.nav-link, .btn[href^="#"]', function(e) {
        e.preventDefault();
        
        const href = $(this).attr('href');
        const target = $(href);
        
        if (target.length) {
            const offsetTop = target.offset().top - 80;
            
            $('html, body').stop().animate({
                scrollTop: offsetTop
            }, 800, 'easeInOutQuart');
            
            // Adicionar classe ativa
            $('.nav-link').removeClass('active');
            if ($(this).hasClass('nav-link')) {
                $(this).addClass('active');
            }
            
            // Fechar menu mobile
            $('.navbar-collapse').collapse('hide');
        }
    });

    // ===== MÁSCARAS PARA CAMPOS =====
    $('#cpf').mask('000.000.000-00');
    $('#cnpj').mask('00.000.000/0000-00');
    $('#whatsapp').mask('(00) 00000-0000');
    $('#telefone').mask('(00) 0000-0000');
    $('#cep').mask('00000-000');
    $('#cepEmpresa').mask('00000-000');
    $('#contactPhone').mask('(00) 00000-0000');

    // ===== BUSCA AUTOMÁTICA DE ENDEREÇO POR CEP =====
    $('#cep').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '');
        
        if (cep.length === 8) {
            buscarCep(cep, 'cliente');
        }
    });

    $('#cepEmpresa').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '');
        
        if (cep.length === 8) {
            buscarCep(cep, 'empresa');
        }
    });

    function buscarCep(cep, tipo) {
        debugLog('buscarCep', `Iniciando busca de CEP: ${cep} para tipo: ${tipo}`, { cep, tipo });
        
        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
            debugLog('buscarCep', 'Resposta recebida da API ViaCEP', data);
            if (!data.erro) {
                if (tipo === 'cliente') {
                    $('#rua').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                    $('#numero').focus();
                } else {
                    $('#ruaEmpresa').val(data.logradouro);
                    $('#bairroEmpresa').val(data.bairro);
                    $('#cidadeEmpresa').val(data.localidade);
                    $('#estadoEmpresa').val(data.uf);
                    $('#numeroEmpresa').focus();
                }
                showNotification('Endereço preenchido automaticamente!', '', 'success', 800);
            } else {
                showNotification('CEP não encontrado!', '', 'error', 800);
            }
        }).fail(function(xhr, status, error) {
            debugLog('buscarCep', 'Erro na busca de CEP', { xhr, status, error, cep, tipo });
            showNotification('Erro ao buscar CEP!', '', 'error', 800);
        });
    }

    // ===== VALIDAÇÃO DE CPF =====
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');
        
        if (cpf.length !== 11) return false;
        
        // Verifica se todos os dígitos são iguais
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        // Validação do primeiro dígito verificador
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        let dv1 = resto < 2 ? 0 : resto;
        
        // Validação do segundo dígito verificador
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        let dv2 = resto < 2 ? 0 : resto;
        
        return parseInt(cpf.charAt(9)) === dv1 && parseInt(cpf.charAt(10)) === dv2;
    }

    // ===== VALIDAÇÃO DE CNPJ =====
    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]/g, '');
        
        if (cnpj.length !== 14) return false;
        
        // Verifica se todos os dígitos são iguais
        if (/^(\d)\1{13}$/.test(cnpj)) return false;
        
        // Validação do primeiro dígito verificador
        let multiplicadores = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        let soma = 0;
        for (let i = 0; i < 12; i++) {
            soma += parseInt(cnpj.charAt(i)) * multiplicadores[i];
        }
        let resto = soma % 11;
        let dv1 = resto < 2 ? 0 : 11 - resto;
        
        // Validação do segundo dígito verificador
        multiplicadores = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        soma = 0;
        for (let i = 0; i < 13; i++) {
            soma += parseInt(cnpj.charAt(i)) * multiplicadores[i];
        }
        resto = soma % 11;
        let dv2 = resto < 2 ? 0 : 11 - resto;
        
        return parseInt(cnpj.charAt(12)) === dv1 && parseInt(cnpj.charAt(13)) === dv2;
    }

    // ===== VALIDAÇÃO DE EMAIL =====
    function validarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // ===== SUBMISSÃO DO FORMULÁRIO DE CLIENTE =====
    $('#clienteForm').on('submit', function(e) {
        e.preventDefault();
        debugLog('clienteForm', 'Formulário de cliente submetido');
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Desabilitar botão e mostrar loading
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="loading"></span> Cadastrando...');
        
        // Preparar dados do formulário
        const formData = new FormData(this);
        const data = {
            nome_completo: formData.get('nome'),
            cpf: formData.get('cpf'),
            email: formData.get('email'),
            whatsapp: formData.get('whatsapp'),
            data_nascimento: formData.get('dataNascimento'),
            cep: formData.get('cep'),
            rua: formData.get('rua'),
            numero: formData.get('numero'),
            complemento: formData.get('complemento'),
            bairro: formData.get('bairro'),
            cidade: formData.get('cidade'),
            estado: formData.get('estado'),
            codigo_indicacao: formData.get('codigoIndicacao'),
            senha: formData.get('senha')
        };
        
        // Fazer requisição para API
        debugLog('clienteForm', 'Enviando dados para API de cliente', { url: '../api/cliente/cadastro.php', data });
        
        makeApiRequest('../api/cliente/cadastro.php', data)
            .done(function(response) {
                debugLog('clienteForm', 'Resposta de sucesso recebida da API', response);
                // Sucesso
                showNotification(
                    'Cadastro Realizado!',
                    response.message || 'Cliente cadastrado com sucesso! Bem-vindo ao ClubeMix!',
                    'success',
                    2000,
                    true
                );
                
                // Limpar formulário
                form[0].reset();
                
                // Log para debug
                console.log('Cliente cadastrado:', response.data);
            })
            .fail(function(xhr, textStatus, errorThrown) {
                // Erro
                handleApiError(xhr, textStatus, errorThrown);
            })
            .always(function() {
                // Restaurar botão
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
            });
    });

    // ===== SUBMISSÃO DO FORMULÁRIO DE EMPRESA =====
    $('#empresaForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Desabilitar botão e mostrar loading
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="loading"></span> Cadastrando...');
        
        // Preparar dados do formulário
        const formData = new FormData(this);
        const data = {
            razao_social: formData.get('razaoSocial'),
            nome_fantasia: formData.get('nomeFantasia'),
            cnpj: formData.get('cnpj'),
            inscricao_estadual: formData.get('inscricaoEstadual'),
            email: formData.get('emailEmpresa'),
            telefone: formData.get('telefone'),
            cep: formData.get('cepEmpresa'),
            rua: formData.get('ruaEmpresa'),
            numero: formData.get('numeroEmpresa'),
            complemento: formData.get('complementoEmpresa'),
            bairro: formData.get('bairroEmpresa'),
            cidade: formData.get('cidadeEmpresa'),
            estado: formData.get('estadoEmpresa'),
            segmento: formData.get('segmento'),
            senha: formData.get('senhaEmpresa')
        };
        
        // Fazer requisição para API
        makeApiRequest('../api/empresa/cadastro.php', data)
            .done(function(response) {
                // Sucesso
                showNotification(
                    'Empresa Cadastrada!',
                    response.message || 'Empresa cadastrada com sucesso! Aguarde aprovação da parceria.',
                    'success',
                    2000,
                    true
                );
                
                // Limpar formulário
                form[0].reset();
                
                // Log para debug
                console.log('Empresa cadastrada:', response.data);
            })
            .fail(function(xhr, textStatus, errorThrown) {
                // Erro
                handleApiError(xhr, textStatus, errorThrown);
            })
            .always(function() {
                // Restaurar botão
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
            });
    });

    // ===== SUBMISSÃO DO FORMULÁRIO DE CONTATO =====
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Desabilitar botão e mostrar loading
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="loading"></span> Enviando...');
        
        // Preparar dados do formulário
        const formData = new FormData(this);
        const data = {
            contactName: formData.get('contactName'),
            contactType: formData.get('contactType'),
            contactEmail: formData.get('contactEmail'),
            contactPhone: formData.get('contactPhone'),
            contactSubject: formData.get('contactSubject'),
            contactMessage: formData.get('contactMessage')
        };
        
        // Fazer requisição para API
        makeApiRequest('../api/contato/enviar.php', data)
            .done(function(response) {
                // Sucesso
                showNotification(
                    'Mensagem Enviada!',
                    response.message || 'Mensagem enviada com sucesso! Entraremos em contato em breve.',
                    'success',
                    2000,
                    true
                );
                
                // Limpar formulário
                form[0].reset();
                
                // Log para debug
                console.log('Mensagem enviada:', response.data);
            })
            .fail(function(xhr, textStatus, errorThrown) {
                // Erro
                handleApiError(xhr, textStatus, errorThrown);
            })
            .always(function() {
                // Restaurar botão
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
            });
    });

    // ===== SISTEMA DE NOTIFICAÇÕES CENTRALIZADAS =====
    function showNotification(title, message = '', type = 'info', duration = 5000, showOverlay = false) {
        // Se message está vazio, usar title como message
        if (!message && title) {
            message = title;
            title = getNotificationTitle(type);
        }
        
        // Remover notificações existentes
        $('.notification').remove();
        $('.notification-overlay').remove();
        
        // Criar overlay se necessário
        if (showOverlay) {
            const overlay = $('<div class="notification-overlay"></div>');
            $('body').append(overlay);
            setTimeout(() => overlay.addClass('show'), 10);
        }
        
        // Criar container se não existir
        if (!$('.notification-container').length) {
            $('body').append('<div class="notification-container"></div>');
        }
        
        // Definir ícone baseado no tipo
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        // Criar notificação
        const notification = $(`
            <div class="notification ${type}">
                <div class="notification-content">
                    <div class="notification-icon">
                        <i class="${icons[type] || icons.info}"></i>
                    </div>
                    <div class="notification-body">
                        <div class="notification-title">${title}</div>
                        <div class="notification-text">${message}</div>
                    </div>
                </div>
                <button class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
        
        // Adicionar ao container
        $('.notification-container').append(notification);
        
        // Mostrar notificação
        setTimeout(() => {
            notification.addClass('show');
        }, 100);
        
        // Auto-remover se duration > 0
        if (duration > 0) {
            setTimeout(() => {
                hideNotification();
            }, duration);
        }
        
        // Evento de fechar
        notification.find('.notification-close').on('click', hideNotification);
        
        // Fechar overlay clicando nele
        if (showOverlay) {
            $('.notification-overlay').on('click', hideNotification);
        }
        
        function hideNotification() {
            notification.removeClass('show');
            $('.notification-overlay').removeClass('show');
            
            setTimeout(() => {
                notification.remove();
                $('.notification-overlay').remove();
            }, 400);
        }
    }
    
    // Títulos padrão para notificações
    function getNotificationTitle(type) {
        const titles = {
            success: 'Sucesso!',
            error: 'Erro!',
            warning: 'Atenção!',
            info: 'Informação'
        };
        return titles[type] || titles.info;
    }
    
    // ===== FUNÇÕES AUXILIARES PARA APIs =====
    function makeApiRequest(url, data, method = 'POST') {
        debugLog('makeApiRequest', `Fazendo requisição ${method} para ${url}`, { url, method, data });
        
        return $.ajax({
            url: url,
            method: method,
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            timeout: 30000
        }).done(function(response, textStatus, xhr) {
            debugLog('makeApiRequest', `Requisição bem-sucedida para ${url}`, { response, textStatus, status: xhr.status });
        }).fail(function(xhr, textStatus, errorThrown) {
            debugLog('makeApiRequest', `Erro na requisição para ${url}`, { 
                url, 
                status: xhr.status, 
                statusText: xhr.statusText,
                textStatus, 
                errorThrown, 
                responseText: xhr.responseText,
                responseJSON: xhr.responseJSON 
            });
        });
    }
    
    function handleApiError(xhr, textStatus, errorThrown) {
        let message = 'Erro interno do servidor. Tente novamente em alguns minutos.';
        let title = 'Erro!';
        
        if (xhr.responseJSON) {
            const response = xhr.responseJSON;
            title = response.message || title;
            
            if (response.errors) {
                // Mostrar primeiro erro encontrado
                const firstError = Object.values(response.errors)[0];
                message = firstError || message;
            } else {
                message = response.message || message;
            }
        } else if (textStatus === 'timeout') {
            title = 'Tempo Esgotado!';
            message = 'A requisição demorou muito para responder. Verifique sua conexão e tente novamente.';
        } else if (textStatus === 'error') {
            title = 'Erro de Conexão!';
            message = 'Não foi possível conectar ao servidor. Verifique sua conexão com a internet.';
        }
        
        showNotification(title, message, 'error', 7000, true);
        
        // Log do erro para debug
        console.error('API Error:', {
            url: xhr.responseURL,
            status: xhr.status,
            statusText: xhr.statusText,
            response: xhr.responseJSON,
            textStatus: textStatus,
            errorThrown: errorThrown
        });
    }

    // ===== ANIMAÇÕES AO SCROLL =====
    function animateOnScroll() {
        $('.step-card, .benefit-card, .partner-card, .registration-card').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate__animated animate__fadeInUp');
            }
        });
    }

    // ===== DESTACAR SEÇÃO ATIVA NA NAVEGAÇÃO =====
    function highlightActiveSection() {
        const scrollPosition = $(window).scrollTop() + 100;
        
        $('section[id]').each(function() {
            const currentSection = $(this);
            const sectionTop = currentSection.offset().top;
            const sectionBottom = sectionTop + currentSection.outerHeight();
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                const currentId = currentSection.attr('id');
                $('.nav-link').removeClass('active');
                $(`.nav-link[href="#${currentId}"]`).addClass('active');
            }
        });
    }

    $(window).on('scroll', function() {
        animateOnScroll();
        highlightActiveSection();
    });
    
    animateOnScroll(); // Executar na carga inicial
    highlightActiveSection(); // Executar na carga inicial

    // ===== VALIDAÇÃO EM TEMPO REAL =====
    $('#cpf').on('input', function() {
        const cpf = $(this).val();
        if (cpf.length === 14) {
            if (validarCPF(cpf)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });

    $('#cnpj').on('input', function() {
        const cnpj = $(this).val();
        if (cnpj.length === 18) {
            if (validarCNPJ(cnpj)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });

    $('input[type="email"]').on('input', function() {
        const email = $(this).val();
        if (email.length > 0) {
            if (validarEmail(email)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });

    // ===== EFEITOS HOVER NOS CARDS =====
    $('.step-card, .benefit-card, .partner-card, .registration-card').hover(
        function() {
            $(this).find('.step-icon, .benefit-icon, .partner-icon, .card-icon').addClass('animate__animated animate__pulse');
        },
        function() {
            $(this).find('.step-icon, .benefit-icon, .partner-icon, .card-icon').removeClass('animate__animated animate__pulse');
        }
    );

    // ===== CONTADOR ANIMADO =====
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.text(target);
                clearInterval(timer);
            } else {
                element.text(Math.floor(start));
            }
        }, 16);
    }

    // ===== LAZY LOADING PARA IMAGENS =====
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ===== MENU MOBILE =====
    $('.navbar-toggler').on('click', function() {
        $(this).toggleClass('active');
    });

    // Fechar menu ao clicar em um link
    $('.navbar-nav .nav-link').on('click', function() {
        $('.navbar-collapse').collapse('hide');
        $('.navbar-toggler').removeClass('active');
    });

    // ===== SCROLL TO TOP =====
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            if (!$('#scrollToTop').length) {
                $('body').append(`
                    <button id="scrollToTop" class="scroll-to-top-btn" title="Voltar ao topo">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                `);
            }
            $('#scrollToTop').addClass('show').fadeIn(300);
        } else {
            $('#scrollToTop').removeClass('show').fadeOut(300);
        }
    });

    $(document).on('click', '#scrollToTop', function(e) {
        e.preventDefault();
        
        console.log('Botão scroll to top clicado');
        
        // Método 1: jQuery animate
        $('html, body').stop().animate({ 
            scrollTop: 0 
        }, 800, 'swing', function() {
            console.log('Scroll jQuery concluído');
        });
        
        // Método 2: Scroll nativo como fallback
        setTimeout(() => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }, 50);
        
        // Efeito visual no botão
        $(this).addClass('clicked');
        setTimeout(() => {
            $(this).removeClass('clicked');
        }, 200);
    });

    // ===== PREVENIR ENVIO DE FORMULÁRIO COM ENTER =====
    $('form').on('keypress', function(e) {
        if (e.which === 13 && e.target.type !== 'textarea') {
            e.preventDefault();
        }
    });

    // ===== FOCUS NO PRIMEIRO CAMPO DOS FORMULÁRIOS =====
    $('.registration-card').on('shown.bs.modal', function() {
        $(this).find('input:first').focus();
    });

    // ===== LIMPAR VALIDAÇÕES AO MUDAR CAMPO =====
    $('.form-control, .form-select').on('input change', function() {
        $(this).removeClass('is-valid is-invalid');
    });

    // ===== EFEITO DE DIGITAÇÃO NO HERO =====
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.html('');
        
        function type() {
            if (i < text.length) {
                element.html(element.html() + text.charAt(i));
                i++;
                setTimeout(type, speed);
            }
        }
        
        type();
    }

    // Executar efeito de digitação quando a página carregar
    setTimeout(() => {
        const heroTitle = $('.hero-content h1');
        const originalText = heroTitle.text();
        typeWriter(heroTitle, originalText, 50);
    }, 1000);

    // ===== INTERSEÇÃO OBSERVER PARA ANIMAÇÕES =====
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.step-card, .benefit-card, .partner-card').forEach(el => {
            observer.observe(el);
        });
    }

    // ===== PERFORMANCE: DEBOUNCE PARA SCROLL =====
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const debouncedScroll = debounce(animateOnScroll, 10);
    $(window).on('scroll', debouncedScroll);

    // ===== DIRECIONAMENTO BOTÃO PARCEIRO =====
    $('#btnParceiro').on('click', function(e) {
        e.preventDefault();
        
        // Primeiro, rolar para a seção de cadastro
        const target = $('#cadastro');
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 1000, function() {
                // Após chegar na seção, focar no formulário de empresa
                setTimeout(() => {
                    $('#cadastro-empresa').get(0).scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    
                    // Destacar o card da empresa
                    $('#cadastro-empresa').addClass('highlight-card');
                    setTimeout(() => {
                        $('#cadastro-empresa').removeClass('highlight-card');
                    }, 2000);
                }, 500);
            });
        }
        
        // Fechar menu mobile se estiver aberto
        $('.navbar-collapse').collapse('hide');
    });

    // ===== INICIALIZAÇÃO FINAL =====
    console.log('ClubeMix - Scripts carregados com sucesso!');
    
    // Teste de navegação
    console.log('Seções disponíveis:');
    $('section[id]').each(function() {
        console.log('- #' + $(this).attr('id'));
    });

});

// ===== NAVEGAÇÃO SIMPLES (FALLBACK) =====
document.addEventListener('DOMContentLoaded', function() {
    // Função de scroll simples
    function scrollToSection(sectionId) {
        const section = document.querySelector(sectionId);
        if (section) {
            const offsetTop = section.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    }
    
    // Adicionar listeners para todos os links de navegação
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            console.log('Clique detectado:', href);
            scrollToSection(href);
        });
    });
}); 