<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Estatísticas | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>

<?php require 'views/_include/style/estatisticas.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
<?php require 'views/_include/headeradm.php'; ?>


        <div class="hp-main-layout-content">
            <div id="estatisticas" class="row mb-32 gy-32">
            <?php require 'views/_include/proibido.php'; ?>
                <div v-if="!naopode" class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Estatísticas</h3>
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

                <div v-if="!naopode" class="col-12">


                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <form action="" @submit.prevent="ListAllEstatisticas">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>
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
                <div v-if="!naopode" class="col-12">

                        <div class="row g-32 mb-32">

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
                                                <h3 class="mb-4 mt-8">{{this.allstats.usuarios_qtd}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Total de Cadastros</p>
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
                                                    <i class="iconly-Light-People text-primary hp-text-color-dark-primary-2 lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.chat_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Chat de conversas</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-warning-4 hp-bg-color-dark-warning rounded-circle">
                                                    <i class="iconly-Light-People text-primary hp-text-color-dark-primary-2 lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.avaliacoes_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Total de Avaliações</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                    <i class="iconly-Light-Ticket text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.favoritos_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Total de Favoritos</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                    <i class="iconly-Light-Ticket text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.anuncios_aprovados_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Anúncios Aprovados</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.anuncios_pendentes_qtd}}</h3>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.anuncios_1_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Anúncios Hospedagens</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.anuncios_2_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Anúncios Experiências</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.reservas_confirmadas_qtd}} - {{this.allstats.reservas_confirmadas_valor}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Reservas Confirmadas</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.reservas_pendente_qtd}} - {{this.allstats.reservas_pendente_valor}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Reservas Pendentes</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.reservas_canceladas_qtd}} - {{this.allstats.reservas_canceladas_valor}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Reservas Canceladas</p>
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
                                                <div class="avatar-item d-flex align-items-center justify-content-center avatar-lg bg-danger-4 hp-bg-color-dark-danger rounded-circle">
                                                <i class="iconly-Light-TicketStar text-warning lorden"></i>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <h3 class="mb-4 mt-8">{{this.allstats.notificacoes_qtd}}</h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Notificações</p>
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
                                                <h3 class="mb-4 mt-8">{{this.allstats.android_qtd}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Android</p>
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
                                                <h3 class="mb-4 mt-8">{{this.allstats.ios_qtd}}<span class="hp-badge-text ms-8 text-primary hp-text-color-dark-primary-2"></span></h3>
                                                <p class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">IOS</p>
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
<?php require 'views/_vue/estatisticas.php'; ?>
</body>

</html>
