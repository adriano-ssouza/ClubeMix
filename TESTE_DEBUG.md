# 🐛 Sistema de Debug ClubeMix - Instruções

## 🔧 **PROBLEMA IDENTIFICADO E CORRIGIDO**

**Erro encontrado:** Havia uma redeclaração do método `processRequest()` na classe `ApiBase.php`, causando erro fatal e impedindo o funcionamento das APIs.

**Correção aplicada:** Renomeado o método privado `processRequest()` para `processRequestData()` para evitar conflito com o método abstrato.

## 🚀 **Como Ativar o Sistema de Debug**

### **Método 1: Via URL**
Acesse a página com o parâmetro `debug=true`:
```
http://localhost/ClubeMix/public/index.php?debug=true
```

### **Método 2: Via Console do Navegador**
1. Abra o console do navegador (F12)
2. Digite: `clubemixDebug(true)`
3. A página será recarregada com debug ativo

### **Para Desativar:**
Digite no console: `clubemixDebug(false)`

## 📊 **O que o Debug Mostra**

Quando ativo, o sistema registra logs detalhados de:

- ✅ **Submissão de formulários**
- ✅ **Requisições AJAX para APIs**
- ✅ **Respostas das APIs (sucesso/erro)**
- ✅ **Busca de CEP via ViaCEP**
- ✅ **Dados enviados e recebidos**
- ✅ **Códigos de status HTTP**
- ✅ **Stack traces para rastreamento**

## 🧪 **Teste das APIs**

### **1. Teste Básico**
Acesse: `http://localhost/ClubeMix/test_api.html`

Este arquivo testa:
- Conectividade básica com as APIs
- Resposta do endpoint de teste
- Comportamento correto dos métodos HTTP

### **2. Teste do Formulário de Cliente**
1. Ative o debug: `?debug=true`
2. Preencha o formulário de cliente
3. Clique em "Cadastrar"
4. Observe os logs no console

## 🔍 **Como Interpretar os Logs**

### **Log de Sucesso:**
```javascript
ClubeMix Debug - makeApiRequest
⏰ Timestamp: 2025-01-XX...
📝 Message: Fazendo requisição POST para api/cliente/cadastro.php
📊 Data: { url, method, data }
```

### **Log de Erro:**
```javascript
ClubeMix Debug - makeApiRequest
⏰ Timestamp: 2025-01-XX...
📝 Message: Erro na requisição para api/cliente/cadastro.php
📊 Data: { status: 404, statusText: "Not Found", ... }
```

## 🛠️ **Possíveis Problemas e Soluções**

### **Erro 404 - Not Found**
- ✅ **Corrigido:** Erro de sintaxe PHP na classe base
- Verifique se o Apache está rodando
- Confirme que o mod_rewrite está ativo

### **Erro 500 - Internal Server Error**
- Verifique os logs do PHP no XAMPP
- Confirme conexão com banco de dados
- Verifique permissões de arquivos

### **Erro de CORS**
- ✅ **Configurado:** Headers CORS no `.htaccess`
- Verifique se o `.htaccess` está sendo lido

## 📝 **Estrutura de Debug Implementada**

```javascript
// Logs automáticos em:
- buscarCep()           // Busca de endereço
- clienteForm submit    // Submissão do formulário
- makeApiRequest()      // Requisições AJAX
- handleApiError()      // Tratamento de erros
```

## 🎯 **Próximos Passos para Teste**

1. **Ative o debug** via URL ou console
2. **Teste o formulário** de cadastro de cliente
3. **Observe os logs** no console do navegador
4. **Reporte qualquer erro** com os logs completos

## 📞 **Se Ainda Houver Problemas**

Envie os seguintes dados:

1. **Screenshot dos logs** do console
2. **Mensagem de erro** completa
3. **Status HTTP** retornado
4. **URL** sendo acessada
5. **Dados** sendo enviados (sem senhas)

---

**O sistema de debug está pronto e o erro principal foi corrigido! 🚀**
