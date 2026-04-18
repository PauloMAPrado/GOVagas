<?php
// View: src/app/Views/pages/rec_senha.php
// Tela de recuperação de senha - rec_senha.php
?>

<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Recuperar Senha<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
/* Page-specific styles to match the provided design */
.recover-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 62vh;
  padding: 40px 0;
}

.recover-card {
  width: 570px;
  max-width: 92%;
  padding: 28px 36px;
  border-radius: 12px;
  box-shadow: 0 16px 38px rgba(16, 24, 40, 0.12);
  background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,250,250,0.96));
  text-align: center;
}

.recover-card label {
  display: block;
  text-align: left;
  color: #36407a;
  font-weight: 600;
  margin-bottom: 10px;
  font-size: 1.02rem;
}

.recover-card input[type="email"] {
  width: 100%;
  padding: 12px 16px;
  border-radius: 12px;
  border: 1px solid rgba(0,0,0,0.22);
  outline: none;
  font-size: 1rem;
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
  box-sizing: border-box;
  max-width: 95%;
}

.recover-card input[type="email"]:focus {
  box-shadow: 0 6px 18px rgba(59,84,150,0.12);
  border-color: rgba(60,90,180,0.35);
}

.btn-send {
  margin-top: 18px;
  display: inline-block;
  padding: 10px 28px;
  border-radius: 20px;
  background: linear-gradient(180deg,#cfe0ff,#a9c6ff);
  border: none;
  box-shadow: 0 8px 20px rgba(59,84,150,0.18);
  color: #0f254f;
  font-weight: 600;
  cursor: pointer;
  transform: translateZ(0);
}

.btn-send:active {
  transform: translateY(1px);
}

.alert {
  background: linear-gradient(180deg,#e6f0ff,#dbe8ff);
  color: #0f254f;
  padding: 10px 14px;
  border-radius: 8px;
  margin-bottom: 12px;
  font-weight: 600;
  box-shadow: 0 6px 18px rgba(59,84,150,0.08);
  text-align: left;
}

.alert-error {
  background: linear-gradient(180deg,#ffe6e6,#ffdede);
  color: #5a1b1b;
  padding: 10px 14px;
  border-radius: 8px;
  margin-bottom: 12px;
  font-weight: 600;
  box-shadow: 0 6px 18px rgba(150,40,40,0.06);
  text-align: left;
}

@media (max-width:600px) {
  .recover-card { padding: 18px 20px; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="recover-wrap">
  <div class="recover-card card">
    <?php if (session()->getFlashdata('status')): ?>
      <div class="alert"><?= esc(session()->getFlashdata('status')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <div id="client-error" style="display:none" class="alert-error"></div>
    <form method="post" action="/recuperar/enviar">
      <label for="email">E-mail para Recuperação</label>
      <input id="email" name="email" type="email" placeholder="seu@email.com" required>
      <div style="text-align:center">
        <button type="submit" class="btn-send">Enviar Código</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var form = document.querySelector('.recover-card form');
  var email = document.getElementById('email');
  var clientError = document.getElementById('client-error');

  function isValidEmail(v) {
    // simple RFC-like check
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
  }

  form.addEventListener('submit', function(e){
    clientError.style.display = 'none';
    var val = (email.value || '').trim();
    if (!isValidEmail(val)) {
      e.preventDefault();
      clientError.textContent = 'E-mail inválido. Informe um endereço de e-mail válido.';
      clientError.style.display = 'block';
      email.focus();
      return false;
    }
    // allow normal submit — server will redirect to /nova-senha when valid
  });
});
</script>
<?= $this->endSection() ?>
