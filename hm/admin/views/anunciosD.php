<!DOCTYPE html>
<html dir="ltr">


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/profile-information.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:44 GMT -->
<head>
<?php require_once 'views/_include/head.php'; ?>

<title>Detalhes do Anúncio | <?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo CSS ?>/app-assets/css/pages/page-profile.css">

</head>
<style>
    .hp-p1-body{
        margin-right:10px;
    }
    .img_doc{
        height:200px;
        width:auto;
    }
    .img_doc img{
        max-height:100%;
        max-width:100%;
    }
    .img_doc img{
        max-height:100%;
        max-width:100%;
        width:auto;
    }
</style>
<body>
<?php require_once 'views/_include/style/cadastrosD.php'; ?>

    <main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

            <div id="comprasDetalhes" class="hp-main-layout-content">
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
                        <div class="row bg-black-0 hp-bg-color-dark-100 rounded pe-16 pe-sm-20 mx-0">

                            <div class="col hp-profile-menu py-24 songoku justify-content-start">
                                <div class="w-100">
                                    <div class="hp-profile-menu-header mt-16 mt-lg-0 text-center">
                                    <a style="float:left;" href="<?php echo HOME_URI ?>/compras"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 2.25 2.25" xml:space="preserve"><path d="M1.508 2.164a.264.264 0 0 1-.188-.078l-.766-.765a.266.266 0 0 1-.077-.195A.266.266 0 0 1 .554.93L1.32.164a.264.264 0 0 1 .188-.078.266.266 0 0 1 .188.454l-.586.585.586.586a.266.266 0 0 1 0 .376.264.264 0 0 1-.188.078zm0-1.953a.14.14 0 0 0-.099.041l-.752.766c-.028.028-.026.065-.026.105v.005c0 .04-.002.077.026.105l.758.766a.13.13 0 0 0 .096.041.14.14 0 0 0 .097-.24l-.63-.631a.063.063 0 0 1 0-.088l.629-.63a.141.141 0 0 0 0-.199.14.14 0 0 0-.1-.041z"></path></svg></a>




                                        <!-- Adicionamos o botão para salvar a imagem -->
                                        <button class="btn btn-primary mt-30" @click="updateImg" v-if="previewImage">Salvar</button>

                                        <!-- <a :href="'<?php echo HOME_URI ?>/cadastrosD/'+allcompras.id_cliente" target="_blank"><h3 class="mt-24 mb-4">{{allcompras.nome}}</h3></a> -->
                                        <h3 class="mt-24 mb-4">Anúncio #{{allcompras.id}}</h3>
                                        <!-- <span>{{email_usuario}}</span> -->
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
                                            <a href="#" onclick="showLocalizacao()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Password me-16"></i>
                                                <span>Localização</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>

                                        <li class="mt-4 mb-16">
                                            <a href="#" onclick="showCupons()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Password me-16"></i>
                                                <span>Caracteríticas</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>

                                        <li class="mt-4 mb-16">
                                            <a href="#" onclick="showPagamentos()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Imagens</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li class="mt-4 mb-16" v-if="allcompras.id_categoria != 3">
                                            <a href="#" onclick="showEstatisticas()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Tipos</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li class="mt-4 mb-16" v-if="allcompras.id_categoria != 3">
                                            <a href="#" onclick="showPlanoAtual()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Reservas</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li class="mt-4 mb-16" v-if="allcompras.id_categoria == 3">
                                            <a href="#" onclick="showEstatisticas1()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Ingressos</span>

                                                <span class="hp-menu-item-line position-absolute opacity-0 h-100 top-0 end-0 bg-primary hp-bg-dark-0"></span>
                                            </a>
                                        </li>
                                        <li class="mt-4 mb-16" v-if="allcompras.id_categoria == 3">
                                            <a href="#" onclick="showPlanoAtual1()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-User me-16"></i>
                                                <span>Compras</span>

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
                                                <button @click="deleteAnuncio(allcompras.id)" class="btn btn-ghost btn-primary">Excluir Definitivamente</button>
                                            </div>

                                            <div class="col-12 hp-profile-content-list mt-8 pb-0 pb-sm-120">
                                                <ul>
                                                    <li class="">
                                                        <span class="hp-p1-body">Categoria</span>
                                                        <a :href="'<?php echo HOME_URI ?>/cadastrosD/'+allcompras.id_cliente" target="_blank">
                                                            <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.nome_categoria}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Subcategoria</span>
                                                        <a :href="'<?php echo HOME_URI ?>/fornecedoresD/'+allcompras.id_fornecedor" target="_blank">
                                                            <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.nome_subcategoria}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Nome</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.nome}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Checkin/Checkout</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.checkin}} - {{allcompras.checkout}}</span>
                                                    </li>
                                                    <li class="mt-18" v-if="allcompras.id_categoria == 3">
                                                        <span class="hp-p1-body">Data de/até</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.data_in}} - {{allcompras.data_out}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Endereço</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">
                                                            {{allcompras.end}}
                                                        </span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Status</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.status == 1 ? 'Ativo' : 'Inativo'}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Aprovado</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.status_aprovado == 1 ? 'Sim' : 'Não'}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Anúncio Finalizado</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.Finalizado == 1 ? 'Sim' : 'Não'}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Media Avaliações</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.media}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Descricao</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{allcompras.descricao}}</span>
                                                    </li>



                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-12 col-md-6">
                                                <h3>Endereço</h3>
                                            </div>

                                            <div class="col-12 col-md-6 hp-profile-action-btn text-end">
                                                <button class="btn btn-ghost btn-primary" data-bs-toggle="modal" data-bs-target="#editarEndereco">Editar</button>
                                            </div>

                                            <div class="col-12 hp-profile-content-list mt-8 pb-0 pb-sm-120">
                                                <ul>
                                                    <li class="">
                                                        <span class="hp-p1-body">CEP</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{cep}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Estado</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{estado}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Cidade</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{cidade}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Endereço</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{endereco}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Bairro</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{bairro}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Número</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{numero}}</span>
                                                    </li>
                                                    <li class="mt-18">
                                                        <span class="hp-p1-body">Complemento</span>
                                                        <span class="mt-0 mt-sm-4 hp-p1-body text-black-100 hp-text-color-dark-0">{{complemento}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>
                                </div> -->
                            </div>
                            <!-- DIV DE INFORMAÇÕES GERAIS -->

                            <!-- DIV DE ALTERAR SENHA -->
                            <div id="alterarSenha" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Trocar Senha</h2>
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

                            <!-- DIV DE APROVAR CADASTRO -->
                            <div id="aprovarUsuario" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Aprovar Usuário</h2>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">


                                                <form class="d-flex flex-column row mt-4" @submit.prevent="aprovarUsuario">

                                                    <div class="mb-24 col-12">
                                                        <label class="form-label">Nº do Paciente :</label>
                                                        <input type="text" class="form-control" @input="numero_paciente = $event.target.value.replace(/\D/g, '')" v-model="numero_paciente" placeholder="Nº do Paciente">
                                                    </div>
                                                    <div class="mb-24 col-12">
                                                        <label class="form-label">Nº do estudo :</label>
                                                        <input type="text" class="form-control" @input="numero_estudo = $event.target.value.replace(/\D/g, '')" v-model="numero_estudo" placeholder="Nº do estudo">
                                                    </div>
                                                    <div class="mb-24 col-12">
                                                        <label class="form-label">Nome da visita :</label>
                                                        <input type="text" class="form-control" v-model="nome_visita" placeholder="Nome da visita">
                                                    </div>

                                                    <div class="col-md-12 mt-4">
                                                        <button type="submit" class="btn btn-ghost btn-primary flutuar">Salvar</button>
                                                        </div>
                                                </form>


                                    </div>
                                </div>
                            </div>
                            <!-- DIV DE APROVAR CADASTRO -->

                            <!-- DIV DE ESTATÍSTICAS -->

                            <!-- DIV DE INFORMAÇÕES GERAIS -->
                            <div id="mostrarEstatisticas" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-12 col-md-6">
                                                <h3>Tipos</h3>
                                            </div>

                                            <div class="col-12">
                                                <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Nome</th>
                                                                    <th class="text-center">Adultos</th>
                                                                    <th class="text-center">Crianças</th>
                                                                    <th class="text-center">Quartos</th>
                                                                    <th class="text-center">Banheiros</th>
                                                                    <th class="text-center">Pets</th>
                                                                    <th class="text-center">Ações</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-if="rows_tipos == 0">
                                                                <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                                                            </tr>
                                                                <tr v-else v-for="tipo of alltipos">
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.nome}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.adultos}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.criancas}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.quartos}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.banheiros}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.pets == 1 ? 'Sim' : 'Não'}}</span>
                                                                  </td>

                                                                 <td class="text-center">
                                                                   <div class="actionbuttons">
                                                                      <svg data-bs-toggle="modal" @click="ListIdTipo(tipo.id)" data-bs-target="#updateCupom" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg>


                                                                   </div>
                                                                 </td>

                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>


                                </div>

                            </div>
                            <!-- DIV DE INFORMAÇÕES GERAIS -->


                            <!-- DIV DE INFORMAÇÕES GERAIS -->
                            <div id="mostrarEstatisticas1" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-12 col-md-6">
                                                <h3>Ingressos</h3>
                                            </div>

                                            <div class="col-12">
                                                <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Nome</th>
                                                                    <th class="text-center">Tipo</th>
                                                                    <th class="text-center">Valor</th>
                                                                    <th class="text-center">Qtd Total</th>
                                                                    <th class="text-center">Qtd Comprados</th>
                                                                    <th class="text-center">Qtd disponível</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-if="rows_ingressos == 0">
                                                                <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                                                            </tr>
                                                                <tr v-else v-for="tipo of allingressos">
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.nome}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.tipo}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.valor}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.qtd_total}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.qtd_comprados}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{tipo.qtd_disponivel}}</span>
                                                                  </td>


                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>


                                </div>

                            </div>
                            <!-- DIV DE INFORMAÇÕES GERAIS -->


                            <!-- DIV DE CUPOM -->
                            <div id="mostrarCupons" class="col pe-0 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Características</h2>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">
                                        <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80">
                                            <div class="table-responsive" style="overflow-x: auto;">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nome</th>

                                                        </tr>
                                                    </thead>

                                                      <tbody>
                                                      <tr v-if="rows_carac == 0">
                                                      <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                                      </tr>
                                                          <tr v-else v-for="cupons of allcaracteristicas">
                                                              <td class="text-center">
                                                                  <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{cupons.nome}}</span>
                                                              </td>

                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DIV DE CUPOM -->

                            <!-- DIV DE PAGAMENTOS -->
                            <div id="mostrarPagamentos" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Imagens</h2>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">
                                        <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Imagem</th>
                                                            <th class="text-center">Ação</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr v-if="rows_imagens == 0">
                                                        <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                                                    </tr>
                                                        <tr v-else v-for="img of allimagens">
                                                          <td class="ps-0 text-center photolist">
                                                             <div  style="height:50px;" class="avatar-item-company d-flex align-items-center justify-content-center imagerolltwo">
                                                               <a :href="'<?php echo ANUNCIOS ?>/'+img.url" target="_blank">
                                                                 <img  style="height:40px;" :src="'<?php echo ANUNCIOS;?>/'+img.url">
                                                               </a>
                                                             </div>
                                                         </td>

                                                         <td class="text-center">
                                                           <div class="actionbuttons">
                                                             <!-- <svg data-bs-toggle="modal" @click="ListIdCupons(cupons.id)" data-bs-target="#updateCupom" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg> -->
                                                             <button @click="deleteImagens(img.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>

                                                           </div>
                                                         </td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DIV DE PAGAMENTOS -->

                            <!-- DIV DE PLANOS -->
                            <div id="mostrarPlanos" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <form @submit.prevent="updatePlanos">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Reservas</h2>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">

                                        <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80 mb-24">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>

                                                            <th class="text-center">
                                                                Usuário
                                                            </th>

                                                            <th class="text-center">
                                                                Adultos
                                                            </th>
                                                            <th class="text-center">
                                                                Crianças
                                                            </th>
                                                            <th class="text-center">
                                                                Data de/até
                                                            </th>
                                                            <th class="text-center">
                                                                Valor
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr v-if="rows_reservas == 0">
                                                        <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                                                    </tr>
                                                        <tr v-else v-for="item of allreservas">
                                                          <td class="ps-0 text-center">
                                                              <a target="_blank" class="mb-0 fw-medium text-black-100 hp-text-color-dark-0" :href="'<?php echo HOME_URI ?>/cadastrosD/'+item.id_user">{{item.nome_user}}</a>
                                                          </td>
                                                          <td class="text-center">
                                                              <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.adultos}}</span>
                                                          </td>
                                                          <td class="text-center">
                                                              <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.criancas}}</span>
                                                          </td>
                                                          <td class="text-center">
                                                              <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.data_de}} - {{item.data_ate}}</span>
                                                          </td>
                                                          <td class="text-center">
                                                              <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.valor_final}}</span>
                                                          </td>

                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- DIV DE PLANOS -->

                            <!-- DIV DE LOCALIZAÇÃO -->
                            <div id="mostrarLocalizacao" class="col ps-16 ps-sm-32 py-24 py-sm-32 overflow-hidden hidden">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Localização</h2>
                                    </div>

                                    <div class="divider border-black-40 hp-border-color-dark-80"></div>

                                    <div class="col-12">
                                        <div class="rounded-top border-start border-end border-top border-black-40 hp-border-color-dark-80">
                                        <iframe :src="'https://maps.google.com/maps?q=' + latitude + ',' + longitude + '&z=14&amp;output=embed'" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DIV DE LOCALIZAÇÃO -->


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
                                            <input type="text" v-model="nome_usuario_update" class="form-control" placeholder="Nome">
                                        </div>

                                        <div class="col-6">
                                            <label for="displayName" class="form-label">Email</label>
                                            <input type="text" v-model="email" class="form-control" placeholder="Link" disabled>
                                        </div>
                                        <div class="col-6">
                                            <label for="displayName" class="form-label">Celular</label>
                                            <input type="text" v-model="celular" class="form-control" placeholder="Link" disabled>
                                        </div>

                                        <div class="col-6">
                                            <label for="address" class="form-label">Status</label>
                                            <select v-model="status_usuario_update" class="form-select">
                                                <option value="1">Ativo</option>
                                                <option value="2">Inativo</option>
                                            </select>

                                        </div>


                                        <div class="col-3">
                                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                                        </div>

                                        <div class="col-3">
                                            <div class="btn w-100" data-bs-dismiss="modal">Fechar</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editarEndereco" tabindex="-1" aria-labelledby="editarEnderecoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header py-16">
                                <h5 class="modal-title" id="editarEnderecoLabel">Editar Endereço</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider my-0"></div>

                            <div class="modal-body py-48">
                                <form @submit.prevent="updateendereco">
                                    <div class="row g-24">
                                        <div class="col-6">
                                            <label for="fullName" class="form-label">CEP</label>
                                            <input type="text" v-mask="'#####-###'" @blur.prevent="viacep" placeholder="CEP" v-model="cep_modal" class="form-control" placeholder="CEP">
                                        </div>

                                        <div class="col-6">
                                            <label for="displayName" class="form-label">Estado</label>
                                            <input type="text" maxlength="2" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '')" v-model="estado_modal" class="form-control" placeholder="Estado">
                                        </div>

                                        <div class="col-6">
                                            <label for="email" class="form-label">Cidade</label>
                                            <input type="text" v-model="cidade_modal" class="form-control" placeholder="Cidade">
                                        </div>

                                        <div class="col-6">
                                            <label for="phone" class="form-label">Endereço</label>
                                            <input type="text" v-model="endereco_modal" class="form-control" placeholder="Endereço">
                                        </div>

                                        <div class="col-4">
                                            <label for="address" class="form-label">Bairro</label>
                                            <input type="text" v-model="bairro_modal" class="form-control" placeholder="Bairro">
                                        </div>
                                        <div class="col-4">
                                            <label for="address" class="form-label">Número</label>
                                            <input type="text" v-model="numero_modal" class="form-control" placeholder="Nº">
                                        </div>
                                        <div class="col-4">
                                            <label for="address" class="form-label">Complemento</label>
                                            <input type="text" v-model="complemento_modal" class="form-control" placeholder="Complemento">
                                        </div>

                                        <div class="col-3">
                                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                                        </div>

                                        <div class="col-3">
                                            <div class="btn w-100" data-bs-dismiss="modal">Fechar</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- EDITAR CUPOM -->
                    <div class="modal fade" id="updateCupom" tabindex="-1" aria-labelledby="updateCupomLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                              <div class="modal-header py-16 px-24">
                                  <h5 class="modal-title" id="updateCupomLabel">Detalhes</h5>
                                  <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                      <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                  </button>
                              </div>


                                <div class="divider m-0"></div>

                                <div class="table-responsive">
                                    <div class="modal-header py-16 px-24">
                                        <h5 class="modal-title" id="updateCupomLabel">Imagens</h5>

                                    </div>
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Imagem</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="rows_imagens == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allimagensID" :key="item.id">
                                          <td class="ps-0 text-center photolist">
                                             <div  style="height:50px;" class="avatar-item-company d-flex align-items-center justify-content-center imagerolltwo">
                                               <a :href="'<?php echo ANUNCIOS ?>/'+item.url" target="_blank">
                                                 <img  style="height:40px;" :src="'<?php echo ANUNCIOS;?>/'+item.url">
                                               </a>
                                             </div>
                                         </td>

                                            <td class="text-center">
                                                <div class="actionbuttons">
                                                    <button @click="deleteImagensType(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                </div>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <div class="modal-header py-16 px-24">
                                        <h5 class="modal-title" id="updateCupomLabel">Camas</h5>

                                    </div>
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="rows_camas == 0">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Qtd</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allcamasID.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allcamasID" :key="item.id">
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.nome}}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.qtd}}</span>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                  <div class="modal-header py-16 px-24">
                                      <h5 class="modal-title" id="updateCupomLabel">Períodos disponíveis</h5>

                                  </div>
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="rows_periodos == 0">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data de/até</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Valor</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Taxa Limpeza</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Qtd</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allperiodosID.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allperiodosID" :key="item.id">
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.nome}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.data_de}} - {{item.data_ate}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.valor}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.taxa_limpeza}}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.qtd}}</span>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                  <div class="modal-header py-16 px-24">
                                      <h5 class="modal-title" id="updateCupomLabel">Reservas</h5>

                                  </div>
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">

                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Adultos</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Crianças</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data de/até</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Valor</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="rows_reservas == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else v-for="item of allreservasID" :key="item.id">

                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.adultos}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.criancas}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.data_de}} - {{item.data_ate}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="hp-p1-body text-black-100 hp-text-color-dark-0 fw-lighter">{{item.valor_final}}</span>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- EDITAR CUPOM -->
                    <!-- NOVO CUPOM -->
                    <div class="modal fade" id="saveNewCupom" tabindex="-1" aria-labelledby="saveNewCupomLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="saveNewCupomLabel">Novo Cupom</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>

                                <form @submit.prevent="saveCupons">
                                    <div class="modal-body">
                                        <div class="row gx-8">


                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="userName" class="form-label">

                                                        Data de
                                                    </label>
                                                    <input required type="date" v-model="data_inSave" class="form-control" id="userName2">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="email" class="form-label">
                                                        Data até
                                                    </label>
                                                    <input required type="date" v-model="data_outSave" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="status" class="form-label">

                                                        Tipo de cupom
                                                    </label>
                                                    <select required v-model="tipo_cupom" class="form-select">
                                                        <option value="" selected disabled>Selecione o tipo</option>
                                                        <option value="1">Porcentagem</option>
                                                        <option value="2">Valor</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div v-if="tipo_cupom == '1'" class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Percentual
                                                    </label>
                                                    <input required type="text" v-model="porcentagem_qtd" class="form-control" placeholder="Insira a porcentagem" id="name">
                                                </div>
                                            </div>
                                            <div v-if="tipo_cupom == '2'" class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Valor
                                                    </label>
                                                    <input required type="text" v-model="valor_qtd" class="form-control" placeholder="Insira o valor" id="name">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                        <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- NOVO CUPOM -->

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

                                        <li style="display:none;" class="mt-4 mb-16">
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
                                        <li style="display:block;" class="mt-4 mb-16">
                                            <a href="#" onclick="showEstatisticas()" class="position-relative text-black-80 hp-text-color-dark-30 hp-hover-text-color-primary-1 hp-hover-text-color-dark-0 py-12 px-24 d-flex align-items-center">
                                                <i class="iconly-Curved-Activity me-16"></i>
                                                <span>Orçamento</span>

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
<script src="<?php echo VUE ?>/anuncios.js"></script>
<?php require 'views/_include/foot.php'; ?>
<?php require 'views/_vue/anunciosD.php'; ?>
</body>


<!-- Mirrored from yoda.hypeople.studio/yoda-admin-template/html/ltr/vertical/profile-information.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 13:28:44 GMT -->
</html>
