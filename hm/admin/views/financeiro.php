<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Financeiro | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>

  <?php require 'views/_include/style/financeiro.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
<?php require_once 'views/_include/headeradm.php'; ?>

        <div id="financeiro" class="hp-main-layout-content">
        <?php require 'views/_include/proibido.php'; ?>
            <div v-if="!naopode" class="row mb-32 gy-32">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Financeiro</h3>
                        </div>

                        <!-- <div class="col hp-flex-none w-auto">
                            <select class="form-select">
                                <option selected value="1">This Month</option>
                                <option value="2">This Week</option>
                                <option value="3">This Year</option>
                            </select>
                        </div> -->
                    </div>
                </div>

                <div class="col-12">


                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                            <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <form action="" @submit.prevent="ListAllCadastros">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>
                                                    <div class="col-3">
                                                        <label for="">Nome</label>
                                                        <input type="text" v-model="nome_filtro" class="form-control ps-8" placeholder="Nome">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Email</label>
                                                        <input type="text" v-model="email_filtro" class="form-control ps-8" placeholder="E-mail">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Data de</label>
                                                        <input type="date" v-model="dataDe_filtro" class="form-control ps-8">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Data até</label>
                                                        <input type="date" v-model="dataAte_filtro" class="form-control ps-8">
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="submit" @click="formSubmitted = true" class="btn btn-outline-info down w-100">
                                                            <i class="ri-search-line remix-icon"></i>
                                                            <span>Buscar</span>
                                                        </button>
                                                    </div>
                                                </form>
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
                <div class="col-12">


                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-32">
                                                        <h5 class="mb-0">Financeiro</h5>
                                                        <div class="d-flex">
                                                            <button @click="exportarPlanosParaCSV" class="btn btn-sm btn-primary">Exportar</button>
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
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Anúncio</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Tipo de Pagamento</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Total</span>
                                                                    </th>

                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
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
                                                            <tr v-if="empty">
                                                                <td colspan="7" class="text-center">Nenhum registro encontrado.</td>
                                                            </tr>
                                                                <tr v-if="!empty" v-for="financeiro of paginatedData" :key="financeiro.id">

                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{financeiro.id}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a target="_blank" class="mb-0 text-black-80 hp-text-color-dark-30" :href="'<?php echo HOME_URI ?>/cadastrosD/'+financeiro.id_usuario">{{financeiro.nome_usuario}}</a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                    <a target="_blank" class="mb-0 text-black-80 hp-text-color-dark-30" :href="'<?php echo HOME_URI ?>/anunciosD/'+financeiro.id_anuncio">{{financeiro.nome_anuncio}}</a>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{financeiro.tipo_pagamento}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{financeiro.valor_final}} <br/>{{financeiro.valor_admin}} <br/>{{financeiro.valor_anunciante}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{financeiro.data}} - {{financeiro.hora}}</span>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <span  v-if="financeiro.status == 'Pago'" class="badge bg-success-4 hp-bg-dark-success text-success border-success">{{financeiro.status}}</span>
                                                                        <span  v-if="financeiro.status == 'Aprovado'" class="badge bg-success-4 hp-bg-dark-success text-success border-success">{{financeiro.status}}</span>
                                                                        <span  v-if="financeiro.status == 'Ativa'" class="badge bg-success-4 hp-bg-dark-success text-success border-success">{{financeiro.status}}</span>
                                                                        <span  v-if="financeiro.status == 'Finalizado'" class="badge bg-success-4 hp-bg-dark-success text-success border-success">{{financeiro.status}}</span>
                                                                        <span v-if="financeiro.status == 'Pendente'" class="badge bg-warning-4 hp-bg-dark-warning text-warning border-warning">{{financeiro.status}}</span>
                                                                        <span v-if="financeiro.status == 'Rejeitado'"  class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">{{financeiro.status}}</span>
                                                                         <span v-if="financeiro.status == 'Cancelado'"  class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">{{financeiro.status}}</span>
                                                                         <span v-if="!financeiro.status"  class="badge bg-warning-4 hp-bg-dark-warning text-warning border-warning">Aguardando</span>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <a class="btn btn-sm btn-primary" :href="'<?php echo HOME_URI ?>/financeiroD/'+financeiro.id">Detalhes</a>
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


                    </div>
                </div>
                <div class="pagination pagetop">
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

                <!-- EDITAR PRODUTO -->
                <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewUserLabel">Editar Usuário</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form>
                                <div class="modal-body">
                                    <div class="row gx-8">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">

                                                    Categoria
                                                </label>
                                                <select class="form-select">
                                                    <option value="1">Admin</option>
                                                    <option value="2">Financeiro</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">

                                                    Status
                                                </label>
                                                <select class="form-select">
                                                    <option value="1">Ativo</option>
                                                    <option value="2">Inativo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">

                                                    Nome
                                                </label>
                                                <input type="text" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>


                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">

                                                   Email
                                                </label>
                                                <input type="text" placeholder="Email" class="form-control" id="email">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">

                                                   Celular
                                                </label>
                                                <input type="text" placeholder="Celular" class="form-control" id="email">
                                            </div>
                                        </div>








                                    </div>
                                </div>

                                <div class="modal-footer pt-0 px-24 pb-24">
                                    <div class="divider"></div>

                                    <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- EDITAR BANNER -->
                <!-- NOVO BANNER -->
                <div class="modal fade" id="addNewProd" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewProdLabel">Novo Usuário</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form>
                                <div class="modal-body">
                                    <div class="row gx-8">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">

                                                    Categoria
                                                </label>
                                                <select class="form-select">
                                                    <option value="1">Admin</option>
                                                    <option value="2">Financeiro</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">

                                                    Nome
                                                </label>
                                                <input type="text" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>


                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">

                                                   Email
                                                </label>
                                                <input type="text" placeholder="Email" class="form-control" id="email">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">

                                                   Celular
                                                </label>
                                                <input type="text" placeholder="Celular" class="form-control" id="email">
                                            </div>
                                        </div>








                                    </div>
                                </div>

                                <div class="modal-footer pt-0 px-24 pb-24">
                                    <div class="divider"></div>

                                    <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- EDITAR PRODUTO -->
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
<?php require 'views/_vue/financeiro.php'; ?>
</body>

</html>
