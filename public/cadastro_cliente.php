<?php include 'includes/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-3 text-primary">Cadastro de Cliente</h2>
      <form>
        <div class="mb-3">
          <label for="nome" class="form-label">Nome Completo</label>
          <input type="text" class="form-control" id="nome" name="nome" required placeholder="Digite seu nome completo">
        </div>
        <div class="mb-3">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" required placeholder="Apenas números">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" required placeholder="Seu e-mail">
        </div>
        <div class="mb-3">
          <label for="whatsapp" class="form-label">WhatsApp</label>
          <input type="tel" class="form-control" id="whatsapp" name="whatsapp" required placeholder="(99) 99999-9999">
        </div>
        <div class="mb-3">
          <label for="indicador" class="form-label">Quem te indicou? <span class="text-muted">(opcional)</span></label>
          <input type="text" class="form-control" id="indicador" name="indicador" placeholder="Nome ou código do amigo">
        </div>
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      </form>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?> 