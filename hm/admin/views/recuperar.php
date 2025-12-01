<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Recuperar | <?php echo TITLE; ?></title>
 
  <?php require 'views/_include/login.php'; ?>
  <?php require 'views/_include/head.php'; ?>
  

  <body>
    <div id="formulario" class="row hp-authentication-page">
        <div class="hp-bg-black-20 hp-bg-color-dark-90 col-lg-6 col-12">
            <div class="row hp-image-row h-100 px-8 px-sm-16 px-md-0 pb-32 pb-sm-0 pt-32 pt-md-0">
                <div class="hp-logo-item m-16 m-sm-32 m-md-64 w-auto px-0 col-12">
                    <div class="hp-header-logo d-flex align-items-center">
                        <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                            

                            <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logoapp_oficial.png" alt="logo">
                            <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/app5mclaro.png" alt="logo">
                            
                        </a>

                       
                    </div>
                </div>

                <div class="col-12 px-0">
                    <div class="row h-100 w-100 mx-0 align-items-center justify-content-center">
                        <div class="hp-bg-item text-center mb-32 mb-md-0 px-0 col-12">
                            <img class="hp-dark-none m-auto w-100" src="https://yoda.hypeople.studio/yoda-admin-template/app-assets/img/pages/authentication/authentication-bg.svg" alt="Background Image">
                            <img class="hp-dark-block m-auto w-100" src="https://yoda.hypeople.studio/yoda-admin-template/app-assets/img/pages/authentication/authentication-bg-dark.svg" alt="Background Image">
                        </div>

                        <div class="hp-text-item text-center col-xl-9 col-12">
                            <h2 class="hp-text-color-black-100 hp-text-color-dark-0 mx-16 mx-lg-0 mb-16"> Very good works are waiting for you </h2>
                            <p class="h4 mb-0 fw-normal hp-text-color-black-80 hp-text-color-dark-30"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 py-sm-64 py-lg-0">
            <div class="row align-items-center justify-content-center h-100 mx-4 mx-sm-n32">
                <div class="col-12 col-md-9 col-xl-7 col-xxxl-5 px-8 px-sm-0 pt-24 pb-48">
                    <h1 class="mb-0 mb-sm-24 centerletter">Recuperar Senha</h1>
                    <p class="mt-sm-8 mt-sm-0 text-black-60 centerletter">Informe abaixo seu email para recuperar sua senha.</p>

                    <form class="mt-16 mt-sm-32 mb-8" @submit.prevent="recuperarsenha">
                        <div class="mb-24">
                            <label for="recoverEmail" class="form-label">E-mail:</label>
                            <input required type="email" v-model="email" class="form-control" id="recoverEmail" placeholder="Insira seu E-mail">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Enviar
                        </button>
                    </form>

                    <div class="col-12 hp-form-info text-center">
                        <span class="text-black-80 hp-text-color-dark-40 hp-caption me-4">Voltar ao</span>
                        <a class="text-primary-1 hp-text-color-dark-primary-2 hp-caption" href="<?php echo HOME_URI ?>/login">Login</a>
                    </div>

                    <div class="mt-48 mt-sm-96 col-12">
                        <p class="hp-p1-body text-center hp-text-color-black-60 mb-8">Todos os direitos reservados à Meu APP Premium &#174; <?php echo date('Y'); ?> Desenvolvido por <a href="http://app5m.com.br/" target="_blank">App5M</a> - <a href="http://app5m.com.br/" target="_blank">Criação de Sites</a> - <a href="http://app5m.com.br/" target="_blank">Desenvolvimento de Aplicativos</a></p>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'views/_include/scripts.php'; ?>
    <?php require 'views/_include/foot.php'; ?>
    <?php require 'views/_vue/recuperar.php'; ?>
</body>

</html>
