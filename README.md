# ClubeMix

## Visão Geral
O ClubeMix é uma plataforma que conecta clientes e empresas parceiras, oferecendo cashback sobre o consumo de produtos ou serviços, além de um sistema de afiliação que recompensa indicações em múltiplos níveis.

## Objetivo do Projeto
- Facilitar o cadastro e relacionamento entre clientes e empresas conveniadas.
- Oferecer benefícios de cashback e afiliação para clientes.
- Prover ferramentas de gestão para representantes, empresas e administradores.

## Escopo
- Área pública: cadastro de clientes e empresas, apresentação do ClubeMix.
- Área restrita: escritórios virtuais para clientes, representantes, empresas e administradores, com funcionalidades específicas para cada perfil.

## Estrutura de Pastas
```
/
├── public/
│   ├── index.php
│   ├── cadastro_cliente.php
│   ├── cadastro_empresa.php
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── scripts.js
│   │   └── img/
│   │       └── ...
│   └── includes/
│       ├── header.php
│       ├── footer.php
│       └── navbar.php
├── src/
│   ├── controllers/
│   ├── models/
│   └── config/
├── templates/
├── docs/
└── README.md
```
- `public/`: arquivos acessíveis pelo navegador.
- `assets/`: CSS, JS e imagens.
- `includes/`: componentes reutilizáveis (cabeçalho, rodapé, menu).
- `src/`: lógica de backend (controllers, models, config).
- `templates/`: partes de HTML reutilizáveis.
- `docs/`: documentação.

## Fases de Desenvolvimento
1. **Fundacional e Infraestrutura**: requisitos, ambiente, banco de dados, arquitetura inicial.
2. **Área Pública**: frontend e backend para cadastro e apresentação.
3. **Área Restrita - Cliente**: escritório virtual, cashback, extrato, afiliados.
4. **Área Restrita - Representante**: gestão de empresas, indicadores, modo cliente.
5. **Área Restrita - Empresa**: gestão de dados, filiais, repasses.
6. **Área Restrita - Administrador**: painel administrativo, relatórios, monitoramento.
7. **Integrações e Serviços**: PagSeguro, WhatsApp, e-mail.
8. **Painéis e Monitoramento**: logs, status de serviços.
9. **Qualidade, Segurança e Lançamento**: testes, documentação, deploy.

## Como começar
1. Clone o repositório.
2. Configure o ambiente local (PHP, Composer, banco de dados, servidor web).
3. Siga a estrutura de pastas sugerida.
4. Consulte a documentação em `/docs` para detalhes técnicos e funcionais.

---

Para mais informações, consulte os arquivos em `docs/` e o documento de definições iniciais. 