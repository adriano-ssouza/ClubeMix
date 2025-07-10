<?php include 'includes/header.php'; ?>

<!-- Carrossel Hero -->
<div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner rounded-4 shadow-lg">
    <div class="carousel-item active" style="background: linear-gradient(90deg, #1db954 0%, #111 100%); min-height: 340px;">
      <div class="container py-5 text-white d-flex flex-column justify-content-center align-items-center" style="min-height: 340px;">
        <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Bem-vindo ao <span style="color:#fff;">Clube<span style="color:#1db954;">Mix</span></span>!</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">Bonificação, facilidade e segurança para você e sua empresa.</p>
      </div>
    </div>
    <div class="carousel-item" style="background: linear-gradient(90deg, #111 0%, #1db954 100%); min-height: 340px;">
      <div class="container py-5 text-white d-flex flex-column justify-content-center align-items-center" style="min-height: 340px;">
        <h2 class="fw-bold mb-3 animate__animated animate__fadeInDown">Ganhe bonificação em cada compra!</h2>
        <p class="lead animate__animated animate__fadeInUp">Indique amigos, consuma em parceiros e aumente seus ganhos.</p>
      </div>
    </div>
    <div class="carousel-item" style="background: linear-gradient(90deg, #1db954 0%, #222 100%); min-height: 340px;">
      <div class="container py-5 text-white d-flex flex-column justify-content-center align-items-center" style="min-height: 340px;">
        <h2 class="fw-bold mb-3 animate__animated animate__fadeInDown">Empresas parceiras crescem mais!</h2>
        <p class="lead animate__animated animate__fadeInUp">Fidelize clientes e aumente seu faturamento com o ClubeMix.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Próximo</span>
  </button>
</div>

<!-- CTAs principais -->
<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-auto">
      <a href="cadastro_cliente.php" class="btn btn-lg btn-primary shadow cta-animate me-2"><i class="bi bi-person-plus-fill me-2"></i>Quero ser Cliente</a>
      <a href="cadastro_empresa.php" class="btn btn-lg btn-outline-dark shadow cta-animate"><i class="bi bi-building me-2"></i>Sou Empresa</a>
    </div>
  </div>
</div>

<!-- Sessão: Como funciona para o Cliente -->
<section class="my-5 py-4">
  <div class="container">
    <h2 class="fw-bold text-primary mb-4 text-center">Como funciona para o Cliente?</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-person-plus display-5 text-primary"></i></div>
            <h5 class="card-title">1. Cadastre-se</h5>
            <p class="card-text small">Preencha seus dados de forma simples e gratuita.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.1s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-shop-window display-5 text-primary"></i></div>
            <h5 class="card-title">2. Consuma</h5>
            <p class="card-text small">Compre em empresas parceiras e informe seu CPF.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.2s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-receipt-cutoff display-5 text-primary"></i></div>
            <h5 class="card-title">3. Envie a Nota</h5>
            <p class="card-text small">Envie a nota fiscal pelo site para receber sua bonificação.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.3s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-people-fill display-5 text-primary"></i></div>
            <h5 class="card-title">4. Indique Amigos</h5>
            <p class="card-text small">Compartilhe seu link e ganhe bonificação nas compras deles.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.4s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-cash-coin display-5 text-primary"></i></div>
            <h5 class="card-title">5. Receba</h5>
            <p class="card-text small">Acompanhe seus ganhos e solicite saque via Pix.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sessão: Como funciona para a Empresa -->
<section class="my-5 py-4">
  <div class="container">
    <h2 class="fw-bold text-primary mb-4 text-center">Como funciona para a Empresa?</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-building display-5 text-primary"></i></div>
            <h5 class="card-title">1. Cadastre-se</h5>
            <p class="card-text small">Solicite contato e cadastre sua empresa gratuitamente.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.1s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-people-fill display-5 text-primary"></i></div>
            <h5 class="card-title">2. Fidelize Clientes</h5>
            <p class="card-text small">Receba clientes fidelizados e aumente o movimento.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.2s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-receipt-cutoff display-5 text-primary"></i></div>
            <h5 class="card-title">3. Aprove/Rejeite</h5>
            <p class="card-text small">Acompanhe solicitações de bonificação e aprove ou rejeite facilmente.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.3s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-bar-chart-line-fill display-5 text-primary"></i></div>
            <h5 class="card-title">4. Relatórios</h5>
            <p class="card-text small">Receba relatórios claros e faça repasses de forma simples.</p>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-6">
        <div class="card step-card text-center h-100 animate__animated animate__fadeInUp" style="animation-delay:0.4s;">
          <div class="card-body">
            <div class="step-icon mb-2"><i class="bi bi-headset display-5 text-primary"></i></div>
            <h5 class="card-title">5. Suporte</h5>
            <p class="card-text small">Conte com o suporte do ClubeMix para crescer ainda mais!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sessão FAQ -->
<section id="faq" class="my-5 py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm bg-white" style="border-radius: 18px;">
          <div class="p-4">
            <h2 class="fw-bold text-primary mb-3"><i class="bi bi-question-circle me-2"></i>Perguntas Frequentes (FAQ)</h2>
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    O que é a bonificação do ClubeMix?
                  </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    É um valor que você recebe de volta ao consumir em empresas parceiras e enviar sua nota fiscal pelo site.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                    Como faço para indicar amigos?
                  </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Após se cadastrar, você terá acesso a um link exclusivo para compartilhar com seus amigos. Quando eles se cadastrarem, você passa a receber bonificação pelas compras deles também.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    Como a empresa recebe o valor das bonificações?
                  </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    As empresas recebem relatórios detalhados e realizam o repasse das bonificações de forma simples e segura, conforme as regras do ClubeMix.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    Preciso pagar para participar?
                  </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Não! O cadastro e a participação no ClubeMix são totalmente gratuitos para clientes e empresas.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sessão Contato -->
<section id="contato" class="my-5 py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm bg-light" style="border-radius: 18px;">
          <div class="p-4">
            <h2 class="fw-bold text-primary mb-3"><i class="bi bi-envelope me-2"></i>Fale Conosco</h2>
            <form>
              <div class="mb-3">
                <label for="nomeContato" class="form-label">Seu nome</label>
                <input type="text" class="form-control" id="nomeContato" name="nomeContato" required>
              </div>
              <div class="mb-3">
                <label for="emailContato" class="form-label">Seu e-mail</label>
                <input type="email" class="form-control" id="emailContato" name="emailContato" required>
              </div>
              <div class="mb-3">
                <label for="mensagemContato" class="form-label">Mensagem</label>
                <textarea class="form-control" id="mensagemContato" name="mensagemContato" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Enviar mensagem</button>
            </form>
            <div class="mt-3">
              <i class="bi bi-whatsapp text-success"></i> Ou fale direto pelo WhatsApp: <a href="https://wa.me/5599999999999" target="_blank" class="text-success">(99) 99999-9999</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Botão flutuante WhatsApp -->
<a href="https://wa.me/5599999999999" target="_blank" class="whatsapp-float" aria-label="Fale conosco pelo WhatsApp">
  <i class="bi bi-whatsapp"></i>
</a>
<style>
.cta-animate {
  transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
}
.cta-animate:hover {
  transform: scale(1.07);
  box-shadow: 0 4px 24px #1db95455;
  background: #1db954 !important;
  color: #fff !important;
}
.step-card {
  border-radius: 16px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}
.step-card:hover {
  transform: translateY(-6px) scale(1.04);
  box-shadow: 0 8px 32px #1db95433;
  border: 1.5px solid #1db95433;
}
.step-icon {
  transition: color 0.2s, transform 0.2s;
}
.step-card:hover .step-icon {
  color: #1db954 !important;
  transform: scale(1.15);
}
.whatsapp-float {
  position: fixed;
  left: 24px;
  bottom: 24px;
  z-index: 9999;
  background: #25d366;
  color: #fff;
  border-radius: 50%;
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
  transition: background 0.2s;
}
.whatsapp-float:hover {
  background: #128c7e;
  color: #fff;
  text-decoration: none;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<?php include 'includes/footer.php'; ?> 