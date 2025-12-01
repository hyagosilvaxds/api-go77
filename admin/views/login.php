<?php

if (isset($_SESSION['skipit_id'])) {
    unset($_SESSION['skipit_id']);
}

if (isset($_SESSION['id_grupo'])) {
    unset($_SESSION['id_grupo']);
}


if (isset($_SESSION['avatar'])) {
    unset($_SESSION['avatar']);
}
?>
<!DOCTYPE html>
<html dir="ltr">


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:43 GMT -->
<head>
<?php require 'views/_include/login.php'; ?>
<?php require 'views/_include/head.php'; ?>

    <title>Login</title>


</head>

<body>
<?php require_once 'views/_include/style/login.php'; ?>
    <div class="row hp-authentication-page">
        <div class="hp-bg-black-20 hp-bg-color-dark-90 col-lg-6 col-12">
            <div class="row hp-image-row h-100 px-8 px-sm-16 px-md-0 pb-32 pb-sm-0 pt-32 pt-md-0">
                <div class="hp-logo-item m-16 m-sm-32 m-md-64 w-auto px-0 col-12">
                    <div class="hp-header-logo d-flex align-items-center">
                    <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                        

                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-dark.png" alt="logo">
                        
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
                            <h2 class="hp-text-color-black-100 hp-text-color-dark-0 mx-16 mx-lg-0 mb-16">Seja bem vindo ao painel ADM</h2>
                            <p class="h4 mb-0 fw-normal hp-text-color-black-80 hp-text-color-dark-30">Gerencie sua plataforma em tempo real agora mesmo!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 py-sm-64 py-lg-0" id="login">
            <div class="row align-items-center justify-content-center h-100 mx-4 mx-sm-n32">
                <div class="col-12 col-md-9 col-xl-7 col-xxxl-5 px-8 px-sm-0 pt-24 pb-48">
                        <div v-show="formFatores === 2" class="glass text-center">
                            <div class="title">
                                <h2 class="font-poppins text-black hp-text-color-dark-0">Verificação de dois fatores</h2>
                                <br>

                                <p class="font-poppins text-form text-black hp-text-color-dark-0">Digite o código enviado para o seu e-mail:</p>
                                <br>
                                <p class="font-poppins text-form text-black hp-text-color-dark-0">{{this.email}}</p>
                            </div>

                            <!-- form -->
                            <form action="" @submit.prevent="submitLogin" class="py-2">
                                <!-- <h4 class="font-poppins text-form">Coloque seu código de dois fatores abaixo:</h4> -->

                                <div class="col py-1 factor-input mb-30">
                                <input type="text" class="form-control hp-text-color-dark-0" maxlength="1" v-model="valor1" ref="input1" @input="focusNext(1)" @paste="handlePaste" />
                                <input type="text" class="form-control hp-text-color-dark-0" maxlength="1" v-model="valor2" ref="input2" @input="focusNext(2)" />
                                <input type="text" class="form-control hp-text-color-dark-0" maxlength="1" v-model="valor3" ref="input3" @input="focusNext(3)" />
                                <input type="text" class="form-control hp-text-color-dark-0" maxlength="1" v-model="valor4" ref="input4" />
                                </div>

                                <div class="col mb-20">
                                    <button type="submit" class="btn">Entrar</button>
                                </div>

                                <div class="py-1">
                                    <p class="font-poppins text-form text-black mb-2 hp-text-color-dark-0">Não recebeu seu código?</p>
                                    <p @click="doisFatores" v-if="showResendButton" class="font-poppins text-form text-black hp-text-color-dark-0"><a href="#" class="link">Enviar novamente</a></p>
                                    <p v-else class="font-poppins text-form text-black hp-text-color-dark-0">Enviar novamente em {{ countdown }} segundos.</p>
                                </div>
                            </form>
                        </div>
                    <div v-show="formFatores === 1">
                        <h1 class="mb-0 mb-sm-24 centerletter">Login</h1>
                        <p class="mt-sm-8 mt-sm-0 text-black-60 centerletter">Insira abaixo seus dados para realizar o login.</p>

                        <form class="mt-16 mt-sm-32 mb-8" @submit.prevent="doisFatores">
                            <div class="mb-16">
                                <label for="loginUsername" class="form-label">Email :</label>
                                <input type="text" required v-model="email" class="form-control" placeholder="insira seu e-mail" id="loginUsername">
                            </div>

                            <div class="mb-16">
                                <label for="loginPassword" class="form-label">Senha :</label>
                                <input type="password" required v-model="password" class="form-control" placeholder="Insira sua senha" id="loginPassword">
                            </div>

                            <div class="row align-items-center justify-content-center mb-16">
                            

                                <div class="col hp-flex-none w-auto">
                                    <a class="hp-button text-black-80 hp-text-color-dark-40" href="<?php echo HOME_URI ?>/recuperar">Esqueceu sua senha?</a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Entrar
                            </button>
                        </form>

                    
                        <div class="mt-48 mt-sm-96 col-12">
                            <p class="hp-p1-body text-center hp-text-color-black-60 mb-8">Todos os direitos reservados à App5M &#174; <?php echo date('Y'); ?> Desenvolvido por <a href="https://startups.app5m.com.br/" target="_blank">App5M</a> - <a href="https://startups.app5m.com.br/" target="_blank">Criação de Sites</a> - <a href="https://startups.app5m.com.br/" target="_blank">Desenvolvimento de Aplicativos</a></p>

                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'views/_include/scripts.php'; ?>
    <?php require 'views/_include/foot.php'; ?>
    <?php require 'views/_vue/login.php'; ?>
</body>


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:43 GMT -->
</html>