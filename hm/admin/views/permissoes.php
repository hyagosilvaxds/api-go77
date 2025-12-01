<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Permissões | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/head.php'; ?>
  

  <body>

<?php require 'views/_include/style/permissoes.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
<?php require 'views/_include/headeradm.php'; ?>

        <div class="hp-main-layout-content">
            <div id="testegeral" class="row mb-32 gy-32">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>
                            <a href="usuarios"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 2.25 2.25" xml:space="preserve"><path d="M1.508 2.164a.264.264 0 0 1-.188-.078l-.766-.765a.266.266 0 0 1-.077-.195A.266.266 0 0 1 .554.93L1.32.164a.264.264 0 0 1 .188-.078.266.266 0 0 1 .188.454l-.586.585.586.586a.266.266 0 0 1 0 .376.264.264 0 0 1-.188.078zm0-1.953a.14.14 0 0 0-.099.041l-.752.766c-.028.028-.026.065-.026.105v.005c0 .04-.002.077.026.105l.758.766a.13.13 0 0 0 .096.041.14.14 0 0 0 .097-.24l-.63-.631a.063.063 0 0 1 0-.088l.629-.63a.141.141 0 0 0 0-.199.14.14 0 0 0-.1-.041z"></path></svg></a>
                                Gerenciamento de Permissões</h3>
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
                                                        <h5 class="mb-0">Lista de Permissões</h5>
                                                        <!-- <div>
                                                            <a class="btn btn-sm btn-primary" href="permissoes">Permissões</a>
                                                        <button data-bs-toggle="modal" data-bs-target="#addNewProd" class="btn btn-sm btn-primary">Novo</button>  
                                                        </div>  -->
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                     
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ação</span>
                                                                    </th>
                                                                    
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                
                                                                
                                                                <tr>
                                                                    
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Financeiro</span>
                                                                    </td>
                                                                   
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <button data-bs-toggle="modal" @click="trocarvalorfinanceiro" data-bs-target="#addNewUser" class="btn btn-sm btn-info sideside">Configurações</button>
                                                                    </div>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Usuário Admin</span>
                                                                    </td>
                                                                   
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <button data-bs-toggle="modal" @click="trocarvalorusuario" data-bs-target="#addNewUser" class="btn btn-sm btn-info sideside">Configurações</button>
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
                <!-- EDITAR MENUS -->
                <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div v-if="empty" class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewUserLabel">Adicionar Permissões</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form @submit.prevent="saveChecks">
                                <div class="modal-body">
                                    <div class="row gx-8">
                                <div class="lindt">
                                <div v-for="check of listallmenusmanipulaveis" :key="check.id_menu" class="form-check col-3 mt-4">
                                <input class="form-check-input" type="checkbox" :value="check.id_menu" @change="updateIdsMarcados" v-model="checkedMenus[check.id_menu]">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ check.nome_menu }}
                                </label>
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
                        <div v-else class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewProdLabel">Editar Permissões</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form @submit.prevent="updateChecks">
                                <div class="modal-body">
                                    <div class="row gx-8">
                                <div class="lindt">
                                <div v-for="check of listallmenusmanipulaveis" :key="check.id_menu" class="form-check col-3 mt-4">
                                <input class="form-check-input" type="checkbox" :value="check.id_menu" @change="updateIdsMarcados" v-model="checkedMenus[check.id_menu]">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ check.nome_menu }}
                                </label>
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
                <!-- EDITAR MENUS -->
               
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
<?php require 'views/_vue/checks.php'; ?>
</body>

</html>
