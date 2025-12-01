<!DOCTYPE html>
<html dir="ltr">


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/profile-information.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:44 GMT -->
<head>
<?php require_once 'views/_include/head.php'; ?>

<title>Detalhes do cadastro | <?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>/app-assets/css/pages/page-profile.css">

</head>

<body>
    <style>
        .alignall{
			display: flex;
    		align-items: center;
		}
        .cor-input{
      display: flex;
    flex-direction: column;
	align-items: flex-start;
    }
    </style>
<?php require_once 'views/_include/style/cadastrosD.php'; ?>
    
    <main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

            <div id="cadastrosDetalhess" class="hp-main-layout-content">
                <div class="row mb-32 gy-32">
                    <!-- <div class="col-12">
                        <div class="row justify-content-between gy-32">
                            <div class="col hp-flex-none w-auto">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="index.html">Home</a>
                                        </li>

                                        <li class="breadcrumb-item">
                                            <a href="javascript:;">Pages</a>
                                        </li>

                                        <li class="breadcrumb-item active">
                                            Profile
                                        </li>
                                    </ol>
                                </nav>
                            </div>

                            <div class="col hp-flex-none w-auto">
                                <div class="row g-16">
                                    <div class="col hp-flex-none w-auto">
                                        <button class="btn btn-ghost btn-primary me-14">Action</button>
                                    </div>

                                    <div class="col hp-flex-none w-auto">
                                        <button type="button" class="btn btn-primary btn-icon-only">
                                            <i class="ri-settings-4-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-12">

                        <div class="row hp-profile-mobile-menu-btn bg-black-0 hp-bg-color-dark-100 rounded py-12 px-8 px-sm-12 mb-16 mx-0">
                            <div class="d-inline-block" data-bs-toggle="offcanvas" data-bs-target="#profileMobileMenu" aria-controls="profileMobileMenu">
                                <button type="button" class="btn btn-text btn-icon-only">
                                    <i class="ri-menu-fill hp-text-color-black-80 hp-text-color-dark-30 lh-1" style="font-size: 24px;"></i>
                                </button>
                            </div>
                        </div>
                        

                        <div class="row bg-black-0 hp-bg-color-dark-100 rounded pe-16 pe-sm-32 mx-0">


                        <div class="hp-profile-mobile-menu offcanvas offcanvas-start" tabindex="-1" id="profileMobileMenu" aria-labelledby="profileMobileMenuLabel">
                                <div class="offcanvas-header">
                                        <div class="hp-menu-header-btn mb-12 text-end">
                                            <div class="d-inline-block" id="profile-menu-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <button type="button" class="btn btn-text btn-icon-only">
                                                    <i class="ri-more-2-line text-black-100 hp-text-color-dark-30 lh-1 lorden"></i>
                                                </button>
                                            </div>

                                            <ul class="dropdown-menu" aria-labelledby="profile-menu-dropdown">
                                                <li>
                                                    <a @click="openFileInput" class="dropdown-item" href="javascript:;">Alterar Imagem</a>
                                                </li>
                                            </ul>
                                        </div>

                                    <div class="d-inline-block" id="profile-menu-dropdown" data-bs-dismiss="offcanvas" aria-label="Close">
                                        <button type="button" class="btn btn-text btn-icon-only">
                                            <i class="ri-close-fill text-black-80 lh-1" style="font-size: 24px;"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="offcanvas-body p-0">











                                <div class="col hp-profile-menu py-24 songoku justify-content-start">
                                <div class="w-100">
                                    <div class="hp-profile-menu-header mt-16 mt-lg-0 text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="d-inline-block position-relative">
                                                <!-- Adicionamos um container para a visualização do avatar -->
                                                <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle imagelogo">
                                                    <!-- Adicionamos uma tag img com um atributo v-bind para exibir o preview da imagem selecionada -->
                                                    <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" class="largo" :src="previewImage || '<?php echo AVATAR;?>/'+avatar_user">
                                                </div>
                                                <!-- Adicionamos o input de arquivo -->
                                                <input type="file" id="avatarInput" style="display:none;" accept="image/*" @change="changeAvatar">
                                            </div>
                                        </div>

                                        <!-- Adicionamos o botão para salvar a imagem -->
                                        <button class="btn btn-primary mt-30" @click="updateImg" v-if="previewImage">Salvar</button>

                                        <h3 class="mt-24 mb-4">{{nome_usuario}}</h3>
                                        <span>{{email_usuario}}</span>
                                    </div>
                                </div>

                                <!-- MENUS LATERAIS DA DIV PRINCIPAL -->

                                <div class="hp-profile-menu-body w-100 text-start mt-48 mt-lg-0">
                                    <ul class="me-n1 mx-lg-n12">
                                    <li class="mt-4 mb-16">
                                            <a href="#" onclick="showInfoGerais()"  class="active position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Dados</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        
                                        <li  class="mt-4 mb-16">
                                            <a href="#" onclick="showAlterarSenha()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Password me-16"></i>
                                                <span>Alterar Senha</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showAprovarUsuario()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Aprovar Usuário</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showLocalizacao()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Location me-16"></i>
                                                <span>Localização</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showPlanoAtual()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Setting me-16"></i>
                                                <span>Plano Atual</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showPagamentos()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Wallet me-16"></i>
                                                <span>Pagamentos</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showEstatisticas()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Activity me-16"></i>
                                                <span>Estatísticas</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li style="display:none;" class="mt-4 mb-16">
                                            <a href="#" onclick="showCupons()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Light-PaperPlus me-16"></i>
                                                <span>Cupom</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="hp-profile-menu-footer">
                                    <div class="quadrado"></div>
                                </div>
                            </div>
                                </div>
                            </div>








                            <div class="col hp-profile-menu py-24 songoku justify-content-start">
                                <div class="w-100">
                                    <div class="hp-profile-menu-header mt-16 mt-lg-0 text-center mb-20">
                                        <div class="hp-menu-header-btn mb-12 text-end">
                                            <div class="d-inline-block" id="profile-menu-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <button type="button" class="btn btn-text btn-icon-only">
                                                    <i class="ri-more-2-line text-black-100 hp-text-color-dark-30 lh-1 lorden"></i>
                                                </button>
                                            </div>

                                            <ul class="dropdown-menu" aria-labelledby="profile-menu-dropdown">
                                                <li>
                                                    <a @click="openFileInput" class="dropdown-item" href="javascript:;">Trocar Avatar</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <div class="d-inline-block position-relative">
                                                <!-- Adicionamos um container para a visualização do avatar -->
                                                <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle imagelogo">
                                                    <!-- Adicionamos uma tag img com um atributo v-bind para exibir o preview da imagem selecionada -->
                                                    <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" class="largo" :src="previewImage || '<?php echo AVATAR;?>/'+avataruser">
                                                </div>
                                                <!-- Adicionamos o input de arquivo -->
                                                <input type="file" id="avatarInput" style="display:none;" accept="image/*" @change="changeAvatar">
                                            </div>
                                        </div>

                                        <!-- Adicionamos o botão para salvar a imagem -->
                                        <button class="btn btn-primary mt-30" @click="updateImg" v-if="previewImage">Salvar</button>

                                        <h3 class="mt-24 mb-4">{{nome_usuario}}</h3>
                                        <span>{{email_usuario}}</span>
                                    </div>
                                </div>

                                <!-- MENUS LATERAIS DA DIV PRINCIPAL -->

                                <div class="hp-profile-menu-body w-100 text-start mt-48 mt-lg-0">
                                    <ul class="me-n1 mx-lg-n12">
                                        <li class="mt-4 mb-16">
                                            <a href="#" onclick="showInfoGerais()"  class="active position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Dados</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        
                                        <li class="mt-4 mb-16">
                                            <a href="#" onclick="showAlterarSenha()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Password me-16"></i>
                                                <span>Alterar Senha</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="hp-profile-menu-footer">
                                    <div class="quadrado"></div>
                                </div>
                            </div>

                            <!-- MENUS LATERAIS DA DIV PRINCIPAL -->
                            
                            <!-- DIV DE INFORMAÇÕES GERAIS -->
                            <div id="infoGerais" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-12 col-md-6">
                                                <h3>Informações gerais</h3>
                                            </div>

                                            <div class="col-12 col-md-6 hp-profile-action-btn text-end">
                                                <button class="btn btn-ghost btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuario">Editar</button>
                                            </div>

                                            <div class="col-12 hp-profile-content-list mt-8 pb-0 pb-sm-40">
                                                <ul>
                                                    <li class="">
                                                        <span class="hp-p1-body">Nome</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{nome_usuario}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Email</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{email_usuario}}</span>
                                                    </li>
                                                   
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>
                                </div>
                                
                            </div>
                            <!-- DIV DE INFORMAÇÕES GERAIS -->

                            <!-- DIV DE ALTERAR SENHA -->
                            <div id="alterarSenha" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Trocar Senha</h2>
                                        <p class="hp-p1-body mb-0">Escolha uma nova senha para este usuário.</p>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">
                                      
                                           
                                                <form class="d-flex flex-column row mt-4" @submit.prevent="updatepassword">
                                                    
                                                    <div class="mb-24 col-12">
                                                        <label for="profileNewPassword" class="form-label">Nova Senha :</label>
                                                        <input @focus="aparecer = true" @blur="aparecer = false" @input="validatePassword" type="password" class="form-control" v-model="password" id="profileNewPassword" placeholder="Nova Senha">
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

                                                    <div class="mb-24 col-12">
                                                        <label for="profileConfirmPassword" class="form-label">Confirmar Senha :</label>
                                                        <input type="password" class="form-control" v-model="password2" id="profileConfirmPassword" placeholder="Confirmar Senha">
                                                    </div>

                                                    <div class="col-md-12 mt-4">
                                                        <input type="submit" name="submit_plan_cad" value="Salvar" class="btn btn-ghost btn-primary flutuar" />
                                                        </div>
                                                </form>
                                           
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- DIV DE ALTERAR SENHA -->


                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editarUsuario" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header py-16">
                                <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuário</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider my-0"></div>

                            <div class="modal-body py-48">
                                <form @submit.prevent="updateCadastro">
                                    <div class="row g-24">
                                        <div class="col-6">
                                            <label for="fullName" class="form-label">Nome</label>
                                            <input type="text" v-model="nome_update" class="form-control" placeholder="Nome">
                                        </div>

                                        <div class="col-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="text" v-model="email_update" class="form-control" placeholder="E-mail">
                                        </div>

                                       
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                                        </div>

                                        <div class="col-6">
                                            <div class="btn w-100" data-bs-dismiss="modal">Fechar</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- <footer class="w-100 py-18 px-16 py-sm-24 px-sm-32 hp-bg-color-black-20 hp-bg-color-dark-90">
                <div class="row">
                    <div class="col-12">
                        <p class="hp-p1-body text-center hp-text-color-black-60 mb-8">Todos os direitos reservados à Meu APP Premium &#174; <?php echo date('Y'); ?> Desenvolvido por <a href="http://app5m.com.br/" target="_blank">App5M</a> - <a href="http://app5m.com.br/" target="_blank">Criação de Sites</a> - <a href="http://app5m.com.br/" target="_blank">Desenvolvimento de Aplicativos</a></p>
                    </div>
                </div>
            </footer> -->
        </div>
    </main>

  

   

    <div class="scroll-to-top">
        <button type="button" class="btn btn-primary btn-icon-only rounded-circle hp-primary-shadow">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="16px" width="16px" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M13 7.828V20h-2V7.828l-5.364 5.364-1.414-1.414L12 4l7.778 7.778-1.414 1.414L13 7.828z"></path>
                </g>
            </svg>
        </button>
    </div>

    <?php require 'views/_include/scripts.php'; ?>
<script src="<?php echo VUE ?>/perfil.js"></script>
<?php require 'views/_include/foot.php'; ?>
<?php require 'views/_vue/perfil.php'; ?>
</body>


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/profile-information.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:44 GMT -->
</html>