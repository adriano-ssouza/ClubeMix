Especificação do Site ClubeMix
Versão: 1.0
Data: 27/06/2025
Autor: Adriano da Silva Souza

1. Introdução
1.1 Objetivo do Documento
Este documento detalha a estrutura, funcionalidades, regras de negócio, navegação, layout e requisitos não funcionais para o desenvolvimento do site 

www.clubemix.com.br.

1.2 Escopo
O ClubeMix é uma plataforma que intermedia a relação entre clientes e estabelecimentos conveniados, oferecendo cashback (um percentual do valor pago de volta) sobre o consumo de produtos ou serviços.

Além do cashback direto, os clientes podem receber uma participação no cashback de outros clientes que indicarem, em um sistema de afiliação de até cinco níveis.

Dessa forma, a plataforma beneficia:


Clientes consumidores: com cashback e participações de seus afiliados.


Empresas conveniadas: fidelizando clientes e gerando uma corrente de consumo.

2. Objetivo do Site
O site é dividido em área pública (não logada) e área restrita (logada).

2.1 Área Pública (Não Logada)

Atrair Clientes: 

Permitir o cadastro de novos clientes, com a opção de informar quem o indicou.

O processo de cadastro inclui confirmação por e-mail para ativação da conta.

Após a ativação, o cliente pode consumir nos estabelecimentos conveniados e, informando seu CPF, se torna elegível para receber os benefícios.


Atrair Empresas Parceiras: 

Disponibilizar um formulário para que empresas interessadas possam solicitar o contato de um representante de sua região.

2.2 Área Restrita (Logada)
Para Clientes:
Escritório Virtual:

Visualizar e editar dados de cadastro (pessoais, contato, endereço, chave PIX) , como Nome Completo, CPF, data de nascimento, e-mail e WhatsApp.

Acessar uma URL exclusiva para compartilhar e cadastrar afiliados.

Registrar informações bancárias para receber o saldo via PIX.

Enviar a nota fiscal de consumo para reivindicar o cashback e consultar o status da solicitação.

Em caso de rejeição, é possível abrir um ticket de atendimento.

Para evitar duplicidade, a nota fiscal será validada pelos seguintes atributos: CNPJ da loja, CPF do cliente, data e hora da compra e número sequencial único.

Visualizar o extrato completo, incluindo reivindicações, créditos, solicitações de resgate e saques efetuados.

Solicitar o resgate do saldo disponível.

Consultar a quantidade de afiliados diretos (primeiro nível) , com acesso ao nome, e-mail, telefone e a quantidade de compras que geraram repasse no mês vigente e no anterior.

Abrir tickets de atendimento para dúvidas e problemas.

Para Representantes:
Escritório Virtual:

Gerenciar suas informações de cadastro.

Cadastrar novas empresas, seus contatos e lojas/filiais.

Após a ativação da empresa por e-mail, o representante se torna o primeiro "cliente" do estabelecimento, recebendo a afiliação de novos clientes que se cadastrarem sem indicação.

Gerenciar as empresas cadastradas por ele, consultando informações e colaboradores.

É possível solicitar alterações cadastrais, que dependem da aprovação de um administrador.

Visualizar relatórios e indicadores de repasse das empresas e suas filiais.

Receber alertas de login sobre pendências de repasse, com um aviso fixo na tela até a resolução.

Alternar a visualização para o modo "cliente", utilizando todas as funcionalidades de um cliente.

Um representante pode ser cliente de qualquer empresa conveniada, independentemente de quem a cadastrou.

Para Empresas:
Escritório Virtual:

Visualizar os dados da empresa, incluindo o representante que a cadastrou.

Gerenciar filiais e colaboradores, atribuindo papéis como "Vendedor".

Analisar e processar as solicitações de repasse, com a opção de aprovar ou rejeitar.

As solicitações mais antigas são exibidas primeiro.

As solicitações aprovadas são somadas para o repasse diário ao ClubeMix.

Consultar relatórios de solicitações, aprovações, rejeições e valores (calculados e transferidos).

Para Administradores:
Escritório Virtual:

Cadastrar representantes com perfis (financeiro, suporte).

Acessar relatórios e indicadores completos da plataforma:

Representantes, Empresas e Clientes.

Movimentações financeiras e Lucro.

Tickets de atendimento (gerados, atendidos, não atendidos).

Solicitações, aprovações, rejeições, omissões e pagamentos de repasse.

Indicadores de tempo de atendimento e omissão de repasses.

Gerenciar a equipe de atendimento de tickets.

Consultar e atender tickets.

Enviar mensagens e alertas para representantes e/ou clientes via pop-up.

3. Definições das Funcionalidades
Funcionalidades da Área Pública:

Página inicial: Apresentação do ClubeMix, seus benefícios e chamadas para ação ("Cadastre-se", "Quero ser parceiro").


Cadastro de Cliente: Formulário de dados pessoais com campo opcional para indicação e validação por e-mail.


Cadastro de Empresas: Formulário para solicitar contato de um representante com base na localização.


Blog/Novidades: Conteúdo sobre parceiros, cashback e novidades da plataforma.

Funcionalidades da Área Logada (Escritórios Virtuais)
Perfil Cliente:
Consulta e edição de dados pessoais e chave Pix.

URL personalizada para indicação de afiliados.

Upload de nota fiscal para solicitar cashback.

Abertura de tickets para contestação e suporte.

Solicitação de saque via Pix e acompanhamento do extrato.

Consulta de afiliados diretos.

Perfil Representante:
Gestão de dados cadastrais.

Cadastro de empresas e suas filiais.

Visualização de indicadores de desempenho das empresas.

Recebimento de alertas sobre pendências.

Modo de visualização como cliente.

Perfil Empresa:
Visualização e edição de dados cadastrais.

Gestão de filiais e colaboradores com diferentes níveis de acesso (Gerente, Supervisor, Vendedor).

Análise (aprovação/rejeição) de solicitações de repasse.

Acesso a relatórios detalhados.

Perfil Administrador:
Gestão de representantes e equipe de suporte.

Acesso a relatórios estratégicos sobre finanças, atendimentos e desempenho.

Monitoramento de indicadores de lucro/prejuízo.

Ferramenta para envio de mensagens e alertas.

4. Regras de Negócio

Percentual de Cashback: O administrador define uma faixa de negociação para o cashback (ex: 5% a 30%). O valor acordado entre o representante e a empresa servirá de base para os cálculos de repasse.

Distribuição do Cashback:


ClubeMix: Retém 20% do valor do cashback negociado.


Cliente Consumidor (e rede de afiliados): O restante é distribuído em até 10 níveis de afiliação, com 8% do valor do cashback para cada nível.

Exemplo de Cálculo:

Compra: R$ 100,00

Cashback negociado: 10% (R$ 10,00)


Retenção ClubeMix (20% de R$10): R$ 2,00 


Repasse por nível de afiliado (8% de R$10): R$ 0,80 


Valores não distribuídos: Quando um cliente não possui uma rede completa de afiliados, os valores dos níveis vazios são transferidos para o ClubeMix e para o representante responsável pelo cadastro da empresa.

Prazos e Condições:

Apenas notas de estabelecimentos conveniados são válidas.

O prazo para a empresa solicitar o repasse é de 30 dias após a emissão da nota fiscal.

As empresas têm 1 dia útil para aprovar ou rejeitar uma solicitação.

A rejeição deve ser justificada por e-mail.

Solicitações não respondidas são escaladas para o representante. Se a pendência persistir por 7 dias, notificações são enviadas.

O pagamento do repasse pela empresa conveniada deve ocorrer no dia seguinte ao recebimento do relatório.

Acesso e Inatividade:

Representantes acessam apenas dados de suas empresas e clientes diretos.

Contas inativas por mais de 180 dias serão suspensas, com reativação via suporte.

5. Processamento de Pagamento

Plataforma Escolhida: PagSeguro.

Requisitos:

Preparar integrações para pagamento via PIX (QR Code e Copia e Cola).

Integrar relatórios do PagSeguro.

Utilizar webhooks para confirmação automática de pagamentos.

Implementar o split de pagamento para o repasse automático.

6. Navegabilidade e Usabilidade

Design: Layout "clean" com destaque para a proposta de valor e CTAs claros.


Navegação: Menu fixo, breadcrumbs, e fluxos de cadastro guiados.


Conteúdo: Textos objetivos e ícones claros.


Acessibilidade: Compatibilidade com leitores de tela e navegação por teclado (WCAG 2.1 AA).


Responsividade: Design adaptável para desktops, tablets e smartphones.

7. Layout

Identidade Visual: Paleta de cores baseada em verde, branco e preto.

Estrutura:

Uso de cards para exibir estatísticas.

Cabeçalho com logotipo e menu principal.

Rodapé com links institucionais e redes sociais.

Grid flexível para garantir a responsividade.

Comunicação:

Permitir que o Administrador insira banners de aviso (10x15) com opção de fechar, direcionados para todos os usuários ou para públicos específicos (clientes, supervisores).

8. Requisitos Não Funcionais
Segurança:

Criptografia HTTPS.

Seguir as práticas do OWASP Top 10.

Controle de acesso baseado em papéis (Role-Based Access Control).

Performance:

Tempo de resposta inferior a 2 segundos para 95% das requisições.

Uso de cache para páginas estáticas.

Escalabilidade:

Arquitetura baseada em microserviços.

Uso de balanceamento de carga e elasticidade em nuvem.

Compatibilidade:

Suporte aos navegadores Chrome, Firefox, Edge e Safari.

Compatibilidade com os principais dispositivos móveis.

Tecnologia:


Backend: PHP.


Frontend: Bootstrap.

Desenvolvimento e Manutenção:

Documentação de todas as funções (entrada, saída, objetivo).

Criação de um painel de logs para rastrear ações de usuários (sucesso e erro), acessível apenas por desenvolvedores.

Painel para monitorar o status dos serviços e integrações (envio de e-mail, WhatsApp, PagSeguro).