<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Pedidos | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/head.php'; ?>
  

  <body>


  <?php require 'views/_include/style/cadastros.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

        <div class="hp-main-layout-content">
            <div id="pedidos" class="row mb-32 gy-32">
                
            <?php require 'views/_include/proibido.php'; ?>

                <div v-if="!naopode" class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Pedidos</h3>

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
                    

                    <div v-show="mostrardiv == '1'" class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <form action="" @submit.prevent="listAllPedidos()">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>
                                                    <div class="col-2">
                                                        <label for="">ID</label>
                                                        <input type="text" v-model="id_usuario" class="form-control ps-8" placeholder="ID">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="">Nome</label>
                                                        <input type="text" v-model="nome_filtro" class="form-control ps-8" placeholder="Comprador">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Data de</label>
                                                        <input type="date" v-model="dataDe_filtro" class="form-control ps-8">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Data até</label>
                                                        <input type="date" v-model="dataAte_filtro" class="form-control ps-8">
                                                    </div>
                                                    <div class="col-md-2 col-sm-4">
                                                        <div class="form-group">
                                                            <label>Estado</label>
                                                            <select v-model="estado_filtro" class="form-control" @blur.prevent="buscaCidadeIbge(estado_filtro)">
                                                                <option value="" selected disabled>Selecione o estado</option>
                                                                <option v-for="estado of allestados" :value="estado.sigla">{{estado.sigla}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="form-group">
                                                            <label>Cidade </label>
                                                            <select v-model="cidade_filtro" class="form-control">
                                                                <option value="" selected disabled>Selecione a cidade</option>
                                                                <option v-for="cidade of allcidades" :value="cidade.nome">{{cidade.nome}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
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
                                                        <h5 class="mb-0">Lista de Pedidos</h5>
                                                        <div>
                                                            <!-- <button @click="exportarPlanosParaCSV" class="btn btn-sm btn-primary">Exportar</button> -->
                                                            <!-- <button @click="listPendentes" class="btn btn-sm btn-primary">Pendentes</button> -->
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
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Logotipo</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Local</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Categoria</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data</span>
                                                                    </th>

                                                                    <!-- <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Cidade</span>
                                                                    </th>
                                                                    
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                                    </th> -->
                                                                    <!-- <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Plano</span>
                                                                    </th> -->
                                                                    <!-- <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Data de Nascimento</span>
                                                                    </th> -->
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ações</span>
                                                                    </th>
                                                                    
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr v-if="empty">
                                                                <td colspan="10" class="text-center">Nenhum registro encontrado.</td>
                                                            </tr>
                                                                <tr v-if="!empty" v-for="pedidos of paginatedData" :key="pedidos.id_cotacao">
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.id_cotacao}}</span>
                                                                    </td>
                                                                    <td class="ps-0 text-center photolist">
                                                                        <div class="avatar-item-company d-flex align-items-center justify-content-center imagerolltwo">
                                                                            <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo AVATAR;?>/'+pedidos.avatar_user">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.nome}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.cidade}}-{{pedidos.estado}}</span>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.categoria_nome}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.data_cadastro}}</span>
                                                                    </td>
                                          
                                                                    <!-- <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{pedidos.nome_plano}}</span>
                                                                    </td> -->
                                                                    <!-- <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">15/08/1996</span>
                                                                    </td> -->

                                                             
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                            <a :href="'<?php echo HOME_URI ?>/pedidosD/'+pedidos.id_cotacao"><svg style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg></a>
                                                                        <button @click="deletePedidos(pedidos.id_cotacao)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                                        
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
<?php require 'views/_vue/pedidos.php'; ?>
</body>

</html>
