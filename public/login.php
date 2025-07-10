<?php include 'includes/header.php'; ?>
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow p-4 border-0">
      <h2 class="fw-bold text-center mb-4 text-primary"><i class="bi bi-box-arrow-in-right me-2"></i>Login</h2>
      <p class="text-center mb-4">Acesse sua conta usando uma das opções abaixo:</p>
      <form method="post" action="#" class="mb-3">
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail" required>
        </div>
        <div class="mb-2">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <button type="submit" class="btn btn-primary px-4">Entrar</button>
          <a href="#" class="small text-muted ms-2 esqueci-senha-link">Esqueci minha senha</a>
        </div>
      </form>
      <div class="text-center text-muted small mb-2">ou</div>
      <div class="d-grid gap-3 mb-3">
        <a href="#" class="btn btn-outline-dark btn-lg d-flex align-items-center justify-content-center gap-2 google-login-btn">
          <i class="bi bi-google"></i> Entrar com Google
        </a>
        <a href="#" class="btn btn-outline-primary btn-lg d-flex align-items-center justify-content-center gap-2 facebook-login-btn">
          <i class="bi bi-facebook"></i> Entrar com Facebook
        </a>
      </div>
      <div class="text-center text-muted small mt-3">
        Ao continuar, você concorda com nossos <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a>.
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
<style>
.google-login-btn {
  border-color: #ea4335 !important;
  color: #ea4335 !important;
  transition: background 0.2s, color 0.2s;
}
.google-login-btn:hover {
  background: #ea4335 !important;
  color: #fff !important;
}
.facebook-login-btn {
  border-color: #1877f3 !important;
  color: #1877f3 !important;
  transition: background 0.2s, color 0.2s;
}
.facebook-login-btn:hover {
  background: #1877f3 !important;
  color: #fff !important;
}
.esqueci-senha-link {
  font-size: 0.95em;
  opacity: 0.7;
  transition: opacity 0.2s, color 0.2s;
}
.esqueci-senha-link:hover {
  opacity: 1;
  color: #1db954 !important;
  text-decoration: underline;
}
</style> 