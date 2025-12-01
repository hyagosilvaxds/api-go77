<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Recuperar | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/login.php'; ?>
  <?php require 'views/_include/head.php'; ?>
  
  <?php require_once 'views/_include/style/recuperar-sucesso.php'; ?>
  <body>
    <div class="row hp-authentication-page">
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

        <div id="formulario" class="col-12 col-lg-6 py-sm-64 py-lg-0">
            <div class="row align-items-center justify-content-center h-100 mx-4 mx-sm-n32">
                <div class="col-12 col-md-9 col-xl-7 col-xxxl-5 px-8 px-sm-0 pt-24 pb-48">
                    <h1 class="mb-0 mb-sm-24 centerletter">Recuperar Senha</h1>
                    <p class="mt-sm-8 mt-sm-0 text-black-60 centerletter">Insira abaixo sua nova senha.</p>

                    <form class="mt-16 mt-sm-32 mb-8" @submit.prevent="updatepasswordtoken">
                        <div class="mb-24">
                            <label for="resetPassword" class="form-label">Senha :</label>
                            <input @focus="aparecer = true" @blur="aparecer = false" @input="validatePassword" type="password" class="form-control" v-model="password" id="resetPassword" placeholder="Insira sua nova senha">
                            <div v-if="aparecer" class="cor-input mt-1">
                                <span class="alignall" :style="{ color: validationColorLength }">
                                    <svg style="margin-right: 5px;" class="mr-3" :style="{ fill: validationColorLength }" width="20" height="20" viewBox="0 0 2.4 2.4" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m1.46.804-.385.462-.135-.162a.15.15 0 1 0-.23.192l.25.3a.15.15 0 0 0 .23 0l.5-.6a.15.15 0 1 0-.23-.192Z"/>
                                        <path d="M1.2 0a1.2 1.2 0 1 0 1.2 1.2A1.201 1.201 0 0 0 1.2 0Zm0 2.1a.9.9 0 1 1 .9-.9.901.901 0 0 1-.9.9Z"/>
                                    </svg> Deve ter no mínimo 8 caracteres.
                                </span>
                                
                                <span class="alignall" :style="{ color: validationColorUpperCase }">
                                    <svg style="margin-right: 5px;" class="mr-3" :style="{ fill: validationColorUpperCase }" width="20" height="20" viewBox="0 0 2.4 2.4" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m1.46.804-.385.462-.135-.162a.15.15 0 1 0-.23.192l.25.3a.15.15 0 0 0 .23 0l.5-.6a.15.15 0 1 0-.23-.192Z"/>
                                        <path d="M1.2 0a1.2 1.2 0 1 0 1.2 1.2A1.201 1.201 0 0 0 1.2 0Zm0 2.1a.9.9 0 1 1 .9-.9.901.901 0 0 1-.9.9Z"/>
                                    </svg> Deve ter uma letra maiúscula.
                                </span>
                            </div>
                        </div>

                        <div class="mb-24">
                            <label for="resetConfirmPassword" class="form-label">Confirmar Senha :</label>
                            <input type="password" class="form-control" v-model="password2" id="resetConfirmPassword" placeholder="Confirme sua nova senha">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Recuperar Senha
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
    <?php require 'views/_vue/recuperar-sucesso.php'; ?>
</body>

</html>
