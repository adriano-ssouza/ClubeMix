# Orientações para a Fase 1: Fundacional e Infraestrutura

## Objetivo
Estabelecer a base técnica, estrutural e organizacional do projeto, garantindo que todos os pré-requisitos estejam prontos para o desenvolvimento das próximas fases.

---

## 1. Levantamento de Requisitos Detalhado

- **Revisão do Documento de Definições**
  - Ler e validar todos os requisitos funcionais e não funcionais.
  - Identificar pontos críticos, dependências e possíveis dúvidas.
  - Realizar reuniões rápidas (se necessário) para esclarecimentos.

- **Mapeamento dos Fluxos Principais**
  - Desenhar fluxos de cadastro, login, cashback, repasse, tickets e integrações.
  - Definir papéis de usuários (cliente, representante, empresa, administrador).
  - Especificar regras de negócio essenciais (ex: cálculo de cashback, split de pagamento, prazos).

- **Documentação**
  - Criar/atualizar documentação técnica inicial (README, diagramas de fluxo, glossário de termos).

---

## 2. Configuração de Ambiente

- **Repositório de Código**
  - Criar repositório Git (GitHub, GitLab ou Bitbucket).
  - Definir convenções de branch, commit e pull request.
  - Configurar arquivos .gitignore e políticas de versionamento.

- **Ambiente de Desenvolvimento**
  - Instalar e configurar PHP, Composer, servidor web (Apache/Nginx), banco de dados (MySQL/MariaDB).
  - Instalar Bootstrap e dependências front-end (via npm/yarn, se aplicável).
  - Definir estrutura inicial de pastas do projeto (src, public, config, docs, etc).

- **Arquitetura Inicial**
  - Definir padrão de arquitetura (MVC, microserviços, etc).
  - Planejar RBAC (controle de acesso baseado em papéis).
  - Especificar camadas de serviço, repositório e entidades.

---

## 3. Banco de Dados

- **Modelagem**
  - Criar diagrama ER (Entidade-Relacionamento) com as principais tabelas:
    - Usuários (clientes, representantes, administradores)
    - Empresas e filiais
    - Transações (cashback, repasses)
    - Tickets de atendimento
    - Logs de ações
    - Afiliados e indicações

- **Scripts de Criação**
  - Escrever scripts SQL para criação das tabelas e constraints.
  - Versionar scripts de banco (migrations).

- **Configuração de Acesso**
  - Definir usuários e permissões do banco de dados para ambientes de dev, teste e produção.

---

## 4. Infraestrutura de Segurança e Qualidade

- **Segurança**
  - Configurar HTTPS no ambiente local (self-signed certificate).
  - Planejar criptografia de dados sensíveis (senhas, chaves Pix).
  - Definir políticas de acesso e autenticação.

- **Qualidade**
  - Configurar ferramentas de lint (PHP CodeSniffer, ESLint).
  - Planejar estrutura de testes automatizados (PHPUnit, etc).
  - Definir pipeline inicial de CI/CD (opcional nesta fase, mas recomendado).

---

## 5. Entregáveis da Fase 1

- Repositório Git configurado e documentado.
- Ambiente local funcional para todos os desenvolvedores.
- Estrutura inicial de pastas e arquivos do projeto.
- Scripts de banco de dados versionados.
- Documentação dos fluxos principais e arquitetura.
- Plano de RBAC e segurança inicial definido.

---

## Sugestão de Atividades (Kanban/Sprint)

1. Revisar e detalhar requisitos e fluxos.
2. Criar repositório e configurar ambiente local.
3. Definir e documentar arquitetura inicial.
4. Modelar banco de dados e criar scripts.
5. Configurar ferramentas de qualidade e segurança.
6. Validar entregáveis e documentar lições aprendidas. 