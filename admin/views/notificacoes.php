<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Notificações | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>
  <style>
    td{
        max-width:300px;
    }
  </style>


  <body>

    <main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

            <div id="cupons" class="hp-main-layout-content">
            <?php require 'views/_include/proibido.php'; ?>
                <div v-if="!naopode" class="row mb-32 gy-32">
                    <div class="col-12">
                        <div class="row align-items-center justify-content-between g-24">
                            <div class="col-12 col-md-6">
                                <h3>Gerenciamento de Notificações</h3>
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

                    <!-- <div class="col-12">


                        <div class="row g-32">
                            <div class="col-12 col-xl-12">
                                <div class="row g-32">
                                    <div class="col-12">
                                        <div class="card hp-project-ecommerce-table-card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>
                                                    <div class="col-3">
                                                        <label for="">Nome</label>
                                                        <input type="text" class="form-control ps-8" placeholder="Nome">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Email</label>
                                                        <input type="text" class="form-control ps-8" placeholder="E-mail">
                                                    </div>
                                                    <div class="col-3">
                                                        <button class="btn btn-outline-info down">
                                                            <i class="ri-search-line remix-icon"></i>
                                                            <span>Buscar</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div> -->
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
                                                            <h5 class="mb-0">Lista de Notificações</h5>
                                                            <div class="d-flex">
                                                            <button data-bs-toggle="modal" @click="limpamodal" data-bs-target="#addNewProd" class="btn btn-sm btn-primary">Novo</button>
                                                            <button @click="exportarPlanosParaCSV" class="btn btn-sm btn-primary">Exportar</button>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table align-middle mb-0">
                                                                <thead>
                                                                    <tr>


                                                                        <th>
                                                                            <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Título</span>
                                                                        </th>
                                                                        <th>
                                                                            <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Descrição</span>
                                                                        </th>
                                                                        <th>
                                                                            <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
                                                                        </th>

                                                                    </tr>
                                                                </thead>

                                                                <tbody>

                                                                <tr v-if="empty_notificacoes">
                                                                    <td colspan="3" class="text-center">Nenhum registro encontrado.</td>
                                                                </tr>

                                                                    <tr v-else v-for="cupom of allcupons">


                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cupom.titulo}}</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cupom.descricao}}</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cupom.data}}</span>
                                                                        </td>

                                                                        <td class="text-center">
                                                                            <div class="actionbuttons">
                                                                            <button @click="deleteCupons(cupom.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>

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

                    <!-- NOVO CUPOM -->
                    <div class="modal fade" id="addNewProd" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-16 px-24">
                                    <h5 class="modal-title" id="addNewProdLabel">Nova Notificação</h5>
                                    <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                    </button>
                                </div>

                                <div class="divider m-0"></div>

                                <form @submit.prevent="saveCupons">
                                    <div class="modal-body">
                                        <div class="row gx-8">


                                            <div  class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Título
                                                    </label>
                                                    <input type="text" maxlength="70" v-model="titulo" class="form-control" placeholder="Insira o título" id="name">
                                                </div>
                                            </div>
                                            <div  class="col-12 col-md-6">
                                                <div class="mb-24">
                                                    <label for="name" class="form-label">
                                                        Descrição
                                                    </label>
                                                    <input type="text" maxlength="70" v-model="descricao" class="form-control" placeholder="Insira a descrição" id="name">
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
    <?php require 'views/_vue/notificacoes.php'; ?>
</body>

</html>
