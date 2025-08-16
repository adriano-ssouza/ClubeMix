# ClubeMix - Plataforma de Bonificação

## 📋 Descrição

O **ClubeMix** é uma plataforma inovadora de bonificação que conecta clientes e empresas, criando uma rede de benefícios em até 10 níveis de afiliação. A plataforma permite que clientes ganhem dinheiro de volta em suas compras e que empresas fidelizem clientes e aumentem suas vendas.

## 🎨 Design e Identidade Visual

- **Cores principais**: Verde (#28a745), Verde secundário (#20c997), Preto (#212529), Branco (#ffffff)
- **Fonte**: Roboto (Google Fonts)
- **Estilo**: Moderno, profissional, com gradientes sutis e animações suaves
- **Tema**: Plataforma de bonificação/cashback com sistema de afiliação

## 🚀 Funcionalidades

### Para Clientes
- ✅ Cadastro gratuito com código de indicação
- ✅ Sistema de bonificação em até 10 níveis
- ✅ PIX instantâneo para recebimento
- ✅ Suporte premium
- ✅ Sem taxas ocultas
- ✅ Ganhos ilimitados

### Para Empresas
- ✅ Cadastro gratuito de empresa
- ✅ Integração simples com sistemas
- ✅ Fidelização de clientes
- ✅ Relatórios detalhados
- ✅ Crescimento orgânico
- ✅ Suporte especializado

## 🛠️ Tecnologias Utilizadas

### Frontend
- **HTML5** - Estrutura semântica
- **CSS3** - Estilos modernos com variáveis CSS e flexbox/grid
- **JavaScript ES6+** - Interatividade e validações
- **Bootstrap 5** - Framework CSS responsivo
- **FontAwesome 6** - Ícones
- **Google Fonts** - Tipografia Roboto
- **jQuery** - Manipulação do DOM
- **jQuery Mask Plugin** - Máscaras para campos

### APIs Externas
- **ViaCEP** - Busca automática de endereços por CEP

## 📱 Responsividade

A página é totalmente responsiva e funciona perfeitamente em:
- 📱 Dispositivos móveis (320px+)
- 📱 Tablets (768px+)
- 💻 Desktops (1024px+)
- 🖥️ Telas grandes (1200px+)

## 🎯 Seções da Página

### 1. Navegação
- Logo com ícone de moedas
- Menu responsivo com hambúrguer para mobile
- Botões de call-to-action

### 2. Hero Section
- Título impactante com animação de digitação
- Sistema visual de afiliação com 10 níveis
- Botões de ação principais

### 3. Como Funciona
- Processo em 3 passos para clientes
- Processo em 3 passos para empresas
- Cards interativos com animações

### 4. Benefícios
- Cards destacando vantagens para clientes e empresas
- Lista de benefícios com ícones
- Call-to-action para cadastro

### 5. Parceiros
- Diferentes segmentos de empresas parceiras
- Cards com ícones e descrições
- Link para ver todas as empresas

### 6. Formulários de Cadastro
- Formulário completo para clientes
- Formulário completo para empresas
- Validações em tempo real
- Busca automática de endereço por CEP

### 7. Footer
- Informações da empresa
- Links institucionais e de suporte
- Redes sociais
- Links legais

## 🔧 Funcionalidades JavaScript

### Validações
- ✅ Validação de CPF com algoritmo oficial
- ✅ Validação de CNPJ com algoritmo oficial
- ✅ Validação de e-mail com regex
- ✅ Validação de telefone/WhatsApp
- ✅ Validação de CEP
- ✅ Validação de campos obrigatórios

### Máscaras
- ✅ CPF: 000.000.000-00
- ✅ CNPJ: 00.000.000/0000-00
- ✅ Telefone: (00) 0000-0000
- ✅ WhatsApp: (00) 00000-0000
- ✅ CEP: 00000-000

### Interações
- ✅ Smooth scroll para links internos
- ✅ Navbar com efeito de scroll
- ✅ Animações ao scroll
- ✅ Sistema de notificações
- ✅ Busca automática de endereço por CEP
- ✅ Efeitos hover nos cards
- ✅ Menu mobile responsivo
- ✅ Botão scroll to top

## 📁 Estrutura de Arquivos

```
ClubeMix/
├── public/
│   ├── index.html              # Página principal
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css       # Estilos personalizados
│   │   └── js/
│   │       └── scripts.js      # JavaScript principal
│   ├── cadastro_cliente.php    # Formulário cliente (PHP)
│   ├── cadastro_empresa.php    # Formulário empresa (PHP)
│   ├── login.php               # Página de login
│   └── includes/
│       ├── header.php          # Cabeçalho PHP
│       ├── footer.php          # Rodapé PHP
│       └── navbar.php          # Navegação PHP
├── docs/
│   ├── Definições_iniciais.md
│   ├── fases_desenvolvimento.md
│   └── orientacao_fase_1.md
├── estrutura_site.txt
└── README.md
```

## 🚀 Como Usar

### 1. Visualizar a Página
Abra o arquivo `public/index.html` em qualquer navegador moderno.

### 2. Desenvolvimento Local
Para desenvolvimento local, você pode usar:
- Servidor local do XAMPP (recomendado)
- Live Server do VS Code
- Python: `python -m http.server 8000`
- Node.js: `npx serve public`

### 3. Personalização
- **Cores**: Edite as variáveis CSS em `assets/css/style.css`
- **Conteúdo**: Modifique o HTML em `index.html`
- **Funcionalidades**: Ajuste o JavaScript em `assets/js/scripts.js`

## 🎨 Características de Design

### Glassmorphism
- Cards com fundo semi-transparente
- Efeito de blur (backdrop-filter)
- Bordas suaves e sombras

### Animações
- Fade in/out suaves
- Transições de 0.3s
- Efeitos hover interativos
- Animações ao scroll

### Gradientes
- Gradientes verdes para botões
- Gradientes de fundo nas seções
- Efeitos visuais modernos

## 📊 Performance

- ✅ Lazy loading para imagens
- ✅ Debounce para eventos de scroll
- ✅ Intersection Observer para animações
- ✅ CSS otimizado com variáveis
- ✅ JavaScript modular e eficiente

## 🔒 Segurança

- ✅ Validação client-side robusta
- ✅ Sanitização de dados
- ✅ Prevenção de XSS
- ✅ Validação de formulários

## 🌐 Compatibilidade

- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Mobile browsers

## 📞 Suporte

Para dúvidas ou sugestões:
- 📧 Email: contato@clubemix.com
- 📱 WhatsApp: (11) 99999-9999
- 🌐 Website: www.clubemix.com

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

---

**Desenvolvido com ❤️ para revolucionar o sistema de bonificação no Brasil!** 