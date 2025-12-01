<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Anúncios | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>


  <?php require 'views/_include/style/cadastros.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

        <div class="hp-main-layout-content">
            <div id="compras" class="row mb-32 gy-32">

            <?php require 'views/_include/proibido.php'; ?>

                <div v-if="!naopode" class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Anúncios</h3>

                        </div>


                    </div>
                </div>

                <div v-if="!naopode" class="col-12">


                    <div v-show="mostrardiv == '1'" class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <form action="" @submit.prevent="listAllCompras()">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>
                                                    <div class="col-2">
                                                        <label for="">ID</label>
                                                        <input type="text" v-model="id_usuario" class="form-control ps-8" placeholder="ID">
                                                    </div>

                                                    <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Categoria </label>
                                                          <select v-model="id_categoria_filtro" class="form-select">
                                                              <option value="" selected>Selecione...</option>
                                                              <option value="1">Hospedagens</option>
                                                              <option value="2">Experiências</option>
                                                              <option value="3">Eventos</option>
                                                          </select>
                                                      </div>
                                                    </div>
                                                    <!--<div class="col-3">
                                                        <label for="">Data de</label>
                                                        <input type="date" v-model="dataDe_filtro" class="form-control ps-8">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Data até</label>
                                                        <input type="date" v-model="dataAte_filtro" class="form-control ps-8">
                                                    </div>-->

                                                    <div class="col-2">
                                                        <button type="submit" @click="formSubmitted = true" class="btn btn-outline-info down w-100">
                                                            <i class="ri-search-line remix-icon"></i>
                                                            <span>Buscar</span>
                                                        </button>
                                                    </div>
                                                </form>
                                                    <div class="morten">
                                                        <!-- <button @click.prevent="listPendentes()" type="button" class="btn btn-outline-danger down w-100 p-0">
                                                            <span>Pendentes</span>
                                                        </button> -->
                                                    </div>
                                                    <div v-if="formSubmitted" class="morten">
                                                        <button @click.prevent="LimparFiltro()" type="button" class="btn btn-outline-info down w-100 p-0">
                                                        <svg class="trashcann" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="19" height="19" fill="currentColor"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"/></svg>
                                                            <span>Limpar Filtros</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
                <div v-if="!naopode" class="col-12">


                    <div v-show="mostrardiv == '1'" class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-32">
                                                        <h5 class="mb-0">Lista de Anúncios</h5>
                                                        <div>
                                                          <a href="<?php echo HOME_URI ?>/anunciosP" class="btn  btn-primary flutuar mb-4">Pendentes</a>
                                                          <button type="button" data-bs-toggle="modal" data-bs-target="#listCategorias" class="btn  btn-primary flutuar mb-4">Categorias</button>
                                                          <button type="button" data-bs-toggle="modal" data-bs-target="#listCarac" class="btn btn-primary flutuar mb-4">Características</button>
                                                          <button type="button" data-bs-toggle="modal" data-bs-target="#listCamas" class="btn btn-primary flutuar mb-4">Camas</button>
                                                          <button type="button" data-bs-toggle="modal" data-bs-target="#listMotivos" class="btn btn-primary flutuar mb-4">Motivos de Cancelamento</button>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0">
                                                            <thead>
                                                                <tr v-if="!empty">
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">ID</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Imagem</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Categoria</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Usuário</span>
                                                                    </th>

                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Estado/Cidade</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
                                                                    </th>

                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ações</span>
                                                                    </th>

                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-if="empty">
                                                                <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                                            </tr>
                                                                <tr v-if="!empty" v-for="compras of paginatedData" :key="compras.id_cotacao">
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.id}}</span>
                                                                    </td>
                                                                    <td class="ps-0 text-center photolist">
                                                                      <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">

                                                                            <div v-for="(value, index) in compras.imagens" :key="index">
                                                                                  <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ANUNCIOS;?>/'+value.url">
                                                                            </div>

                                                                      </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.nome}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.nome_categoria}} - {{compras.nome_subcategoria}}</span>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <a target="_blank" :href="'<?php echo HOME_URI ?>/cadastrosD/'+compras.id_user">
                                                                          <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.nome_user}}</span>
                                                                        </a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.estado}} - {{compras.cidade}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{compras.data}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                            <a :href="'<?php echo HOME_URI ?>/anunciosD/'+compras.id"><svg style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg></a>

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
                                </div>
                            </div>
                        </div>
                        <div class="pagination pagetop nice">
                            <ul class="pagination">

                                <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                    <button class="page-link" @click="prevPage">&laquo;</button>
                                </li>
                                <li class="page-item" v-for="page in pages" :key="page" :class="{ 'active': page === currentPage }">
                                    <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                                </li>
                                <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                    <button class="page-link" @click="nextPage">&raquo;</button>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <!-- MODAL MOTIVOS CANCELAMENTO -->
                    <div class="modal fade" id="listMotivos" tabindex="-2" aria-labelledby="listMateriaPrimaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="listMateriaPrimaLabel">Motivos de cancelamento</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>
                                <form @submit.prevent="saveMotivos">
                                    <div class="modal-body">
                                        <div class="row gx-8">
                                            <div class="col-3 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input required type="text" v-model="nome_motivo" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Tipo
                                                    </label>
                                                    <select required v-model="tipo_motivo" class="form-select">
                                                        <option value="1">Usuário</option>
                                                        <option value="2">Anunciante</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Taxado
                                                    </label>
                                                    <select required v-model="taxado_motivo" class="form-select">
                                                        <option value="1">Sim</option>
                                                        <option value="2">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        % Taxa
                                                    </label>
                                                    <input required type="number" v-model="taxa_motivo" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 d-flex flex-column-reverse">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">

                                                    </label>
                                                    <button type="submit" class="m-0 btn btn-primary">Adicionar</button>
                                                </div>

                                            </div>
                                            <div class="divider"></div>
                                            <div class="table-responsive">
                                                <table class="table align-middle mb-0">
                                                    <thead>
                                                        <tr v-if="!empty">
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                            </th>
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Tipo</span>
                                                            </th>
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Taxado</span>
                                                            </th>
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">% Taxa</span>
                                                            </th>
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                            </th>
                                                            <th>
                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                            </th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr v-if="allmotivos.rows == 0">
                                                        <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                                    </tr>
                                                    <tr v-else  v-for="item of allmotivos" :key="item.id">
                                                        <td class="text-center">
                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.tipo == 1 ? 'Usuário' : 'Anunciante'}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.taxado == 1 ? 'Sim' : 'Não'}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.taxa_perc}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.status == 1 ? 'Ativo' : 'Inativo'}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="actionbuttons">
                                                              <button type="button"  @click="id_motivo = item.id;listMotivosID();"   data-bs-toggle="modal" data-bs-target="#UpdateMotivos" class="iconly-Light-Edit hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                              <button type="button" @click="deleteMotivos(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="UpdateMotivos" tabindex="-1" aria-labelledby="listMateriaPrimaLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="listMateriaPrimaLabel">Editar Motivo</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>
                                <form @submit.prevent="updateMotivos">
                                    <div class="modal-body">
                                        <div class="row gx-8">
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input required type="text" v-model="nome_motivo_update" class="form-control" required/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Tipo
                                                    </label>
                                                    <select v-model="tipo_motivo_update" class="form-select" required>
                                                        <option value="1">Usuário</option>
                                                        <option value="2">Anunciante</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Taxa
                                                    </label>
                                                    <select v-model="taxado_motivo_update" class="form-select" required>
                                                        <option value="1">Sim</option>
                                                        <option value="2">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        % Taxa
                                                    </label>
                                                    <input required type="number" v-model="taxa_motivo_update" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Status
                                                    </label>
                                                    <select v-model="status_motivo_update" class="form-select" required>
                                                        <option value="1">Ativo</option>
                                                        <option value="2">Inativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 d-flex flex-column-reverse">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">

                                                    </label>
                                                    <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL MOTIVOS CANCELAMENTO -->


                    <!-- MODAL CARACTERÍSTICAS -->
                    <div class="modal fade" id="listCarac" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="addNewProdLabel">Características</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>

                                <form @submit.prevent="saveCarac">
                                    <div class="modal-body">
                                        <div class="row gx-8">

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input type="text" v-model="nome_carac" class="form-control" placeholder="Nome" id="name">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                  <label for="address" class="form-label">Categoria</label>
                                                  <select v-model="categoria_carac" class="form-select">
                                                      <option :value="1">Hospedagens</option>
                                                      <option :value="2">Experiências</option>
                                                      <option :value="3">Eventos</option>
                                                  </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="">
                                                    Ícone (SVG)
                                                </label>
                                                <div class="input-group mb-5">

                                                    <input required @change="changeAvatar" type="file" class="form-control" id="inputGroupFile02">

                                                    <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                                                </div>
                                                <!-- <span><strong>Você deve enviar no formato de 1200px de largura por 500px de altura.</strong></span> -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">

                                        <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                    </div>
                                </form>

                                <div class="divider"></div>


                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Categoria</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ícone</span>
                                                </th>

                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allcarac.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allcarac" :key="item.id">
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome_categoria}}</span>
                                            </td>
                                            <td class="ps-0 text-center photolist">
                                              <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                    <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ICON;?>/'+item.url" width="30">
                                              </div>
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.status == 1 ? 'Ativo' : 'Inativo'}}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="actionbuttons">
                                                  <button type="button"  @click="id_carac = item.id;listCaracID();"   data-bs-toggle="modal" data-bs-target="#UpdateCarac" class="iconly-Light-Edit hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                  <button type="button" @click="deleteCarac(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                </div>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="UpdateCarac" tabindex="-1" aria-labelledby="listMateriaPrimaLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="listMateriaPrimaLabel">Editar Característica</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>
                                <form @submit.prevent="updateCarac">
                                    <div class="modal-body">
                                        <div class="row gx-8">
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input required type="text" v-model="nome_carac_update" class="form-control" required/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Categoria
                                                    </label>
                                                    <select v-model="categoria_carac_update" class="form-select" required>
                                                        <option :value="1">Hospedagens</option>
                                                        <option :value="2">Experiências</option>
                                                        <option :value="3">Eventos</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Status
                                                    </label>
                                                    <select v-model="status_carac_update" class="form-select" required>
                                                        <option value="1">Ativo</option>
                                                        <option value="2">Inativo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3 d-flex flex-column-reverse">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">

                                                    </label>
                                                    <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL CARACTERÍSTICAS -->

                    <!-- MODAL CAMAS -->
                    <div class="modal fade" id="listCamas" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="addNewProdLabel">Camas</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>

                                <form @submit.prevent="saveCamas">
                                    <div class="modal-body">
                                        <div class="row gx-8">

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input type="text" v-model="nome_cama" class="form-control" placeholder="Nome" id="name">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="">
                                                    Ícone (SVG)
                                                </label>
                                                <div class="input-group mb-5">

                                                    <input required @change="changeAvatar" type="file" class="form-control" id="inputGroupFile02">

                                                    <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                                                </div>
                                                <!-- <span><strong>Você deve enviar no formato de 1200px de largura por 500px de altura.</strong></span> -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">

                                        <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                    </div>
                                </form>

                                <div class="divider"></div>


                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ícone</span>
                                                </th>

                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allcamas.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allcamas" :key="item.id">
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome}}</span>
                                            </td>

                                            <td class="ps-0 text-center photolist">
                                              <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                    <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ICON;?>/'+item.url" width="30">
                                              </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.status == 1 ? 'Ativo' : 'Inativo'}}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="actionbuttons">
                                                  <button type="button"  @click="id_cama = item.id;listCamasID();"   data-bs-toggle="modal" data-bs-target="#UpdateCama" class="iconly-Light-Edit hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                  <button type="button" @click="deleteCamas(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                </div>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="UpdateCama" tabindex="-1" aria-labelledby="listMateriaPrimaLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="listMateriaPrimaLabel">Editar Cama</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>
                                <form @submit.prevent="updateCamas">
                                    <div class="modal-body">
                                        <div class="row gx-8">
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input required type="text" v-model="nome_cama_update" class="form-control" required/>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Status
                                                    </label>
                                                    <select v-model="status_cama_update" class="form-select" required>
                                                        <option value="1">Ativo</option>
                                                        <option value="2">Inativo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3 d-flex flex-column-reverse">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">

                                                    </label>
                                                    <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL CAMAS -->

                    <!-- MODAL CATEGORIAS E SUBCATEGORIAS -->
                    <div class="modal fade" id="listCategorias" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="addNewProdLabel">Categorias</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>


                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>

                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allcarac.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allcategorias" :key="item.id">

                                          <td class="text-center">
                                              <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome}}</span>
                                          </td>

                                            <td class="text-center">
                                                <div class="actionbuttons">
                                                  <button type="button"  @click="id_categoria = item.id;listSubcategorias();" data-bs-toggle="modal" data-bs-target="#listSubcategorias" class="iconly-Light-Edit hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                </div>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="listSubcategorias" tabindex="-1" aria-labelledby="addNewProdLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="addNewProdLabel1">Subcategorias</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>


                                <form @submit.prevent="saveSubcategoria">
                                    <div class="modal-body">
                                        <div class="row gx-8">

                                            <div class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input type="text" v-model="nome_subcategoria" class="form-control" placeholder="Nome" id="name">
                                                </div>
                                            </div>



                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="">
                                                    Ícone (SVG)
                                                </label>
                                                <div class="input-group mb-5">

                                                    <input required @change="changeAvatar" type="file" class="form-control" id="inputGroupFile02">

                                                    <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                                                </div>
                                                <!-- <span><strong>Você deve enviar no formato de 1200px de largura por 500px de altura.</strong></span> -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">

                                        <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                    </div>
                                </form>

                                <div class="divider m-0"></div>


                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr v-if="!empty">
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ícone</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                </th>
                                                <th>
                                                    <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-if="allcarac.rows == 0">
                                            <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                        <tr v-else  v-for="item of allcategorias" :key="item.id">

                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome}}</span>
                                            </td>
                                            <td class="ps-0 text-center photolist">
                                              <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                    <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ICON;?>/'+item.url" width="30">
                                              </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.status == 1 ? 'Ativo' : 'Inativo'}}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="actionbuttons">
                                                  <button type="button"  @click="id_subcategoria = item.id;listSubcategoriaID();"   data-bs-toggle="modal" data-bs-target="#updateSubcategoria" class="iconly-Light-Edit hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                  <button type="button" @click="deleteSubcategoria(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                </div>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateSubcategoria" tabindex="-1" aria-labelledby="listMateriaPrimaLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="listMateriaPrimaLabel">Editar Subcategoria</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>
                                <form @submit.prevent="updateSubcategoria">
                                    <div class="modal-body">
                                        <div class="row gx-8">
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                        Nome
                                                    </label>
                                                    <input required type="text" v-model="nome_subcategoria_update" class="form-control" required/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Categoria
                                                    </label>
                                                    <select v-model="categoria_subcategoria_update" class="form-select" required>
                                                        <option :value="1">Hospedagens</option>
                                                        <option :value="2">Experiências</option>
                                                        <option :value="3">Eventos</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">
                                                      Status
                                                    </label>
                                                    <select v-model="status_subcategoria_update" class="form-select" required>
                                                        <option value="1">Ativo</option>
                                                        <option value="2">Inativo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3 d-flex flex-column-reverse">
                                                <div class="mb-24">
                                                    <label for="" class="form-label">

                                                    </label>
                                                    <button type="submit" class="m-0 btn btn-primary">Salvar</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer pt-0 px-24 pb-24">
                                        <div class="divider"></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL CATEGORIAS E SUBCATEGORIAS -->

                    <div v-show="mostrardiv == '2'" class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h5>Novo item</h5>
                                                <form @submit.prevent="saveEmpresa">
                                                    <div class="modal-body">
                                                        <div class="row gx-8">

                                                            <div class="col-12 col-md-12">
                                                                <div class="mb-24">
                                                                    <label for="status" class="form-label">

                                                                        Logotipo
                                                                    </label>

                                                                       <div class="imagediv">
                                                                            <img v-if="previewImage" class="imagepreview" :src="previewImage">
                                                                            <input type="file" id="avatarInput" class="form-control" accept="image/*" @change="changeAvatar">
                                                                        </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-24">
                                                                    <label for="name" class="form-label">

                                                                        Nome
                                                                    </label>
                                                                    <input type="text" maxlength="20" required v-model="nome_empresa" class="form-control" placeholder="Insira o nome da empresa" id="name">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-24">
                                                                    <label for="name" class="form-label">

                                                                        Link
                                                                    </label>
                                                                    <input type="text" required v-model="link_empresa" class="form-control" placeholder="Insira o link" id="name">
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-24">
                                                                    <label for="status" class="form-label">

                                                                        SAQ
                                                                    </label>
                                                                    <select required v-model="saq_empresa" class="form-select" id="status">
                                                                        <option value="" selected disabled>Sim ou não?</option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="2">Não</option>
                                                                    </select>
                                                                </div>
                                                            </div>









                                                        </div>
                                                    </div>

                                                    <div class="modal-footer pt-0 px-24 pb-24">


                                                        <button @click="esconderDivNew" type="button" class="m-0 btn btn-primary">Voltar</button>
                                                        <button type="submit" class="m-5 btn btn-primary">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- <?php require 'views/_include/footer.php'; ?> -->
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
<?php require 'views/_include/foot.php'; ?>
<?php require 'views/_vue/anuncios.php'; ?>
</body>

</html>
