<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Segmentos | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/head.php'; ?>



  <body>

  <?php require_once 'views/_include/style/banners.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
<?php require 'views/_include/headeradm.php'; ?>

        <div id="banners" class="hp-main-layout-content">
        <?php require 'views/_include/proibido.php'; ?>
            <div v-if="!naopode" class="row mb-32 gy-32">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Segmentos</h3>
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
                                                        <h5 class="mb-0">Lista de Segmentos</h5>
                                                        <div class="d-flex">
                                                        <button data-bs-toggle="modal" @click="limpamodal" data-bs-target="#addNewProd" class="btn btn-sm btn-primary">Novo</button>  
                                                        <button @click="exportarPlanosParaCSV" class="btn btn-sm btn-primary">Exportar</button>
                                                        </div>
                                                    </div></div>

                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0" id="sortable-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Imagem</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Descrição</span>
                                                                    </th>
                                                                  
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                                    </th>
                                                                    <!-- <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Alterar Ordem</span>
                                                                    </th> -->
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ações</span>
                                                                    </th>
                                                                    
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                
                                                                
                                                                    <tr style="cursor:pointer;" v-for="banner of allbanners">
                                                                        <td class="ps-0 text-center photolist">
                                                                            <div class="avatar-item d-flex align-items-center justify-content-center imageroll">
                                                                                <a target="_blank" :href="'<?php echo CATEGORIAS ?>/' + banner.url">
                                                                                <img :src="'<?php echo CATEGORIAS ?>/' + banner.url" class="w-100">
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{banner.nome}}</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{banner.descricao}}</span>
                                                                        </td>
                              
                                                                        <td class="text-center">
                                                                            <span class="mb-0 text-black-80 hp-text-color-dark-30">{{banner.status === 1 ? 'Ativo' : 'Inativo'}}</span>
                                                                        </td>
                                                                     
                                                                        <td class="text-center">
                                                                            <div class="actionbuttons">
                                                                            <svg @click="ListIdBanners(banner.id)" data-bs-toggle="modal" data-bs-target="#addNewUser" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg>
                                                                            <button @click="deleteBanners(banner.id)" type="button" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
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
                <!-- EDITAR PRODUTO -->
                <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewUserLabel">Editar Segmento</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form @submit.prevent="updateImgUpdate">
                                <div class="modal-body">
                                    <div class="row gx-8">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-24 central">
                                                
                                                <a target="_blank" :href="'<?php echo CATEGORIAS ?>/' + banner_update">
                                                    <img :src="'<?php echo CATEGORIAS ?>/' + banner_update" class="imgupdatebanner">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    
                                                    Nome
                                                </label>
                                                <input type="text" v-model="nome_update" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">
                                                    
                                                   Descrição
                                                </label>
                                                <input type="text" v-model="link_update" placeholder="Descrição" class="form-control" id="email">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="status" class="form-label">
                                                    Status
                                                </label>
                                                <select v-model="status_update" class="form-select" id="status">
                                       
                                                    <option value="1">Ativo</option>
                                                    <option value="2">Inativo</option>
                                        
                                                </select>
                                            </div>
                                        </div>
                                        

                                        

                                        <div class="col-12 col-md-12">
                                            <label class="form-label" for="">
                                                URL
                                            </label>
                                            <div class="input-group mb-5">
                                                
                                                <input type="file" @change="changeAvatarUpdate" class="form-control" id="inputGroupFile02">
                                                <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                                            </div>
                                            <!-- <span><strong>Você deve enviar no formato de 1200px de largura por 500px de altura.</strong></span> -->
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
                <!-- EDITAR BANNER -->
                <!-- NOVO BANNER -->
                <div class="modal fade" id="addNewProd" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewProdLabel">Novo Segmento</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form @submit.prevent="updateImg">
                                <div class="modal-body">
                                    <div class="row gx-8">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    
                                                    Nome
                                                </label>
                                                <input type="text" v-model="nome_save" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">
                                                    
                                                   Descrição
                                                </label>
                                                <input type="text" v-model="link_save" placeholder="Descrição" class="form-control" id="email">
                                            </div>
                                        </div>

                                        
                                        

                                        

                                        <div class="col-12 col-md-12">
                                            <label class="form-label" for="">
                                                URL
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
                                    <div class="divider"></div>

                                    <button type="submit" class="m-0 btn btn-primary">Salvar</button>
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
<?php require 'views/_vue/segmentos.php'; ?>
</body>

</html>
