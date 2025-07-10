<?php include 'includes/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-3 text-primary">Cadastro de Empresa</h2>
      <form>
        <div class="mb-3">
          <label for="nome_empresa" class="form-label">Nome da Empresa</label>
          <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" required placeholder="Digite o nome da empresa">
        </div>
        <div class="mb-3">
          <label for="cnpj" class="form-label">CNPJ</label>
          <input type="text" class="form-control" id="cnpj" name="cnpj" required placeholder="Apenas números">
        </div>
        <div class="mb-3">
          <label for="email_empresa" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email_empresa" name="email_empresa" required placeholder="E-mail para contato">
        </div>
        <div class="mb-3">
          <label for="telefone_empresa" class="form-label">Telefone</label>
          <input type="tel" class="form-control" id="telefone_empresa" name="telefone_empresa" required placeholder="(99) 99999-9999">
        </div>
        <div class="mb-3">
          <label for="cidade" class="form-label">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade" required placeholder="Cidade da empresa">
        </div>
        <button type="submit" class="btn btn-primary w-100">Solicitar Contato</button>
      </form>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?> 