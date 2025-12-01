<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Detalhes do Financeiro | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS ?>/app-assets/css/pages/page-invoice.css">

  <body>


<main class="hp-bg-color-dark-90 d-flex min-vh-100">

<?php require_once 'views/_include/headeradm.php'; ?>
        <div class="hp-main-layout-content">
                <div class="row mb-32 gy-32">
                    <!-- <div class="col-12 hp-print-none">
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
                                            Invoice
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
                                            <i class="ri-settings-4-line" style="font-size: 16px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div id="financeiro" class="col-12">
                        <div class="row g-32">
                            <div class="col-12 col-xl-8">
                                <div id="invoice" class="card border-none hp-invoice-card">
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-lg-6">
                                                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                                                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <p class="hp-p1-body mb-16 text-end">ID #{{this.allcadastros.id}}</p>
                                            </div>


                                        </div>

                                        <div class="divider"></div>

                                        <div class="row justify-content-between">
                                            <div class="col-12 col-md-4 pb-16 hp-print-info">

                                                <p>Tipo: {{this.allcadastros.tipo_pagamento}}</p>
                                                <p>Usuário {{this.allcadastros.nome_usuario}}</p>
                                                <p>Anúncio {{this.allcadastros.nome_anuncio}}</p>
                                            </div>

                                            <div class="col-12 col-md-4 pb-16 hp-print-info">

                                                <p>Data: {{this.allcadastros.data}}</p>
                                                <p>Horário: {{this.allcadastros.hora}}</p>
                                                <p>Status: {{this.allcadastros.status}}</p>

                                            </div>

                                        </div>
                                        <div>
                                        <span>TOKEN: {{this.allcadastros.token}}</span>
                                        </div>
                                        <div class="divider"></div>



                                        <div class="row justify-content-end">
                                            <div class="col-12 col-xl-3 pb-16 hp-print-checkout">
                                              
                                              <div class="row align-items-center justify-content-between">
                                                  <p class="hp-badge-text hp-flex-none w-auto">Valor Final</p>
                                                  <h5 class="mb-4 hp-flex-none w-auto">{{this.allcadastros.valor_final}}</h5>
                                              </div>
                                              <div class="row align-items-center justify-content-between">
                                                  <p class="hp-badge-text hp-flex-none w-auto">Valor Anunciante</p>
                                                  <h5 class="mb-4 hp-flex-none w-auto">{{this.allcadastros.valor_anunciante}}</h5>
                                              </div>
                                              <div class="row align-items-center justify-content-between">
                                                  <p class="hp-badge-text hp-flex-none w-auto">Valor Admin</p>
                                                  <h5 class="mb-4 hp-flex-none w-auto">{{this.allcadastros.valor_admin}}</h5>
                                              </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-4 hp-print-none">
                                <div class="card border-none mb-32">
                                    <div class="card-body">
                                        <!-- <button type="button" class="btn btn-primary w-100">
                                            <i class="ri-mail-send-line remix-icon" style="font-size: 16px;"></i>
                                            <span>Send Invoice</span>
                                        </button>

                                        <button type="button" class="btn btn-primary w-100 mt-16 btn-ghost">
                                            <i class="ri-download-2-line remix-icon" style="font-size: 16px;"></i>
                                            <span>Download</span>
                                        </button> -->

                                        <div onclick="window.print()">
                                            <button type="button" class="btn btn-primary w-100 mt-16 btn-ghost">
                                                <i class="ri-printer-line remix-icon" style="font-size: 16px;"></i>
                                                <span>Imprimir</span>
                                            </button>
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
<?php require 'views/_vue/financeiroD.php'; ?>
</body>

</html>
