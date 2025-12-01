<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Dashboard | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>


    <main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

            <div class="hp-main-layout-content">
                <div class="row mb-32 gy-32">
                    <!-- <div class="col-12">
                        <div class="row align-items-center justify-content-between g-24">
                            <div class="col-12 col-md-6">
                                <h3>Welcome back, Edward 👋</h3>
                                <p class="hp-p1-body mb-0">Your current status and analytics are here</p>
                            </div>

                            <div class="col hp-flex-none w-auto">
                                <select class="form-select">
                                    <option selected value="1">This Month</option>
                                    <option value="2">This Week</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <div  class="col-12">
                        <div id="dashboard" class="row g-32 mb-32">

                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-primary-4 hp-bg-color-dark-primary rounded-circle">
                                                    <i class="iconly-Light-People text-primary hp-text-color-dark-primary-2 lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.usuarios_qtd}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Usuários Cadastrados</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-primary-4 hp-bg-color-dark-primary rounded-circle">
                                                    <i class="iconly-Light-People text-primary hp-text-color-dark-primary-2 lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.anuncios_ativos}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Anúncios Ativos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-primary-4 hp-bg-color-dark-primary rounded-circle">
                                                    <i class="iconly-Light-People text-primary hp-text-color-dark-primary-2 lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.anuncios_pendentes}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Anúncios Pendentes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-secondary-4 hp-bg-color-dark-secondary rounded-circle">
                                                    <i class="iconly-Light-Buy text-secondary lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.qtd_reservas}} - {{this.allcards.valor_pagamentos}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Reservas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>







                            <!-- <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-warning-4 hp-bg-color-dark-warning rounded-circle">
                                                    <i class="iconly-Light-Ticket text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.valor_compras}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Valor das Compras</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-12 col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-16">
                                            <div class="col-12 hp-flex-none">
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                    <i class="iconly-Light-Discount text-danger lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allcards.total_agendamentos}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Total de Agendamentos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row g-32">
                            <div class="col-12 col-xl-12">
                                <div class="row g-32">
                                    <div class="col-12">
                                        <div class="card hp-card-6 hp-chart-text-color">
                                            <div class="card-body">
                                                <div class="row justify-content-between mb-16">
                                                    <div class="col-6">
                                                        <h4 class="me-8">Dados Gerais</h4>
                                                    </div>
                                                </div>

                                                <div id="analytics-revenue-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dadosdash">

                                        <div class="col-12 mt-40">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center justify-content-between mb-32">
                                                                <h5 class="mb-0">Últimos Usuários</h5>
                                                                <!-- <p class="hp-p1-body mb-0 fw-medium text-black-100 hp-text-color-dark-0">View all orders</p> -->
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table align-middle mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">ID</span>
                                                                            </th>

                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Cidade</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Detalhes</span>
                                                                            </th>

                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                    <tr v-if="empty_recibos">
                                                                        <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                                                    </tr>
                                                                        <tr v-else v-for="item of ultimoscompradores">

                                                                            <td class="ps-0 text-center">
                                                                                <span class="mb-0 fw-medium text-black-100 hp-text-color-dark-0">{{item.id}}</span>
                                                                            </td>



                                                                            <td class="ps-0 text-center">
                                                                                <a target="_blank" class="mb-0 fw-medium text-black-100 hp-text-color-dark-0" :href="'<?php echo HOME_URI ?>/cadastrosD/'+item.id">{{item.nome}}</a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.celular}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.data_cadastro}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" :href="'<?php echo HOME_URI ?>/cadastrosD/'+item.id">
                                                                                    <button type="button" class="btn btn-outline-info down">Detalhes</button>
                                                                                </a>
                                                                            </button>
                                                                            </td>
                                                                        </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-40">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center justify-content-between mb-32">
                                                                <h5 class="mb-0">Últimos Anúncios</h5>
                                                                <!-- <p class="hp-p1-body mb-0 fw-medium text-black-100 hp-text-color-dark-0">View all orders</p> -->
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table align-middle mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                          <th>
                                                                              <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">ID</span>
                                                                          </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Imagem</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Categoria</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Estado/Cidade</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Detalhes</span>
                                                                            </th>

                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                    <tr v-if="empty_recibos">
                                                                        <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                                                    </tr>
                                                                        <tr v-else v-for="item of ultimosrecibos">

                                                                          <td class="ps-0 text-center">
                                                                              <span class="mb-0 fw-medium text-black-100 hp-text-color-dark-0">{{item.id}}</span>
                                                                          </td>
                                                                          <td class="ps-0 text-center photolist">
                                                                            <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">

                                                                                  <div v-for="(value, index) in item.imagens" :key="index">
                                                                                        <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ANUNCIOS;?>/'+value.url">
                                                                                  </div>

                                                                            </div>
                                                                          </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome_categoria}}-{{item.nome_subcategoria}}</span>
                                                                            </td>

                                                                            <td class="ps-0 text-center">
                                                                                <a target="_blank" class="mb-0 fw-medium text-black-100 hp-text-color-dark-0" :href="'<?php echo HOME_URI ?>/anunciosD/'+item.id">{{item.nome}}</a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.estado}}-{{item.cidade}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.data_cadastro}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" :href="'<?php echo HOME_URI ?>/anuncios/'+item.id">
                                                                                    <button type="button" class="btn btn-outline-info down">Detalhes</button>
                                                                                </a>
                                                                            </button>
                                                                            </td>
                                                                        </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-40">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center justify-content-between mb-32">
                                                                <h5 class="mb-0">Últimas Reservas</h5>
                                                                <!-- <p class="hp-p1-body mb-0 fw-medium text-black-100 hp-text-color-dark-0">View all orders</p> -->
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table align-middle mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">ID</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Anúncio</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Pagamento</span>
                                                                            </th>

                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Usuário</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data de/até</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Valor</span>
                                                                            </th>
                                                                            <th>
                                                                                <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Detalhes</span>
                                                                            </th>

                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                    <tr v-if="empty_pedidos">
                                                                        <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                                                    </tr>
                                                                        <tr v-else v-for="item in allPedidos" :key="item.id">

                                                                            <td class="ps-0 text-center">
                                                                                <span class="mb-0 fw-medium text-black-100 hp-text-color-dark-0">{{item.id}}</span>
                                                                            </td>

                                                                            <td class="ps-0 text-center d-flex align-items-center justify-content-center">
                                                                                <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">

                                                                                    <div v-for="(anuncio, index) in item.anuncio" :key="index">
                                                                                      <div v-for="(value, index) in anuncio.imagens" :key="index">
                                                                                          <a target="_blank" :href="'<?php echo HOME_URI ?>/anuncioD/'+anuncio.id">
                                                                                            <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ANUNCIOS;?>/'+value.url">
                                                                                          </a>
                                                                                      </div>

                                                                                    </div>
                                                                                    <!--<img :src="'<?php echo ANUNCIOS;?>/'+item.anuncio.imagens.url">-->
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.tipo_pagamento}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" :href="'<?php echo HOME_URI ?>/cadastrosD/'+item.perfil.id">
                                                                                  <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.perfil.nome}}</span>
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.data_de}} - {{item.data_ate}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.valor_final}}</span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" :href="'<?php echo HOME_URI ?>/pedidosD/'+item.id">
                                                                                    <button type="button" class="btn btn-outline-info down">Detalhes</button>
                                                                                </a>
                                                                            </button>
                                                                            </td>
                                                                        </tr>

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

    <?php require_once 'views/_include/scripts.php'; ?>
    <?php require 'views/_include/foot.php'; ?>
    <?php require 'views/_vue/dashboard.php'; ?>
</body>

</html>
