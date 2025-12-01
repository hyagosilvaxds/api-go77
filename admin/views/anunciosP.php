<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Anúncios Pendentes | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>


  <?php require 'views/_include/style/cadastros.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

        <div class="hp-main-layout-content">
            <div id="cadastros" class="row mb-32 gy-32">

            <?php require 'views/_include/proibido.php'; ?>

                <div v-if="!naopode" class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Anúncios Pendentes</h3>

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
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-32">
                                                        <h5 class="mb-0">Lista de anúncios</h5>
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
                                                                      <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
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
                                                                <tr v-if="!empty" v-for="cadastros of paginatedData" :key="cadastros.id">
                                                                  <td class="text-center">
                                                                      <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.id}}</span>
                                                                  </td>
                                                                  <td class="ps-0 text-center photolist">
                                                                    <div class="avatar-item-company d-flex align-items-center justify-content-center rounded-circle imageroll">

                                                                          <div v-for="(value, index) in cadastros.imagens" :key="index">
                                                                                <img onerror="this.src='<?php echo AVATAR ?>/placeholder.png';" :src="'<?php echo ANUNCIOS;?>/'+value.url">
                                                                          </div>

                                                                    </div>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.nome}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.nome_categoria}} - {{cadastros.nome_subcategoria}}</span>
                                                                  </td>

                                                                  <td class="text-center">
                                                                      <a target="_blank" :href="'<?php echo HOME_URI ?>/cadastrosD/'+cadastros.id_user">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.nome_user}}</span>
                                                                      </a>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.estado}} - {{cadastros.cidade}}</span>
                                                                  </td>
                                                                  <td class="text-center">
                                                                      <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.data}}</span>
                                                                  </td>
                                                                    <td class="text-center">
                                                                        <button  v-if="cadastros.status_aprovado == 1" @click="reprovaCadastro(cadastros.id)" class="btn btn-sm btn-success">Ativo</button>
                                                                        <button  v-else @click="aprovaCadastro(cadastros.id)" class="btn btn-sm btn-danger">Inativo</button>
                                                                        <!-- <span class="mb-0 text-black-80 hp-text-color-dark-30">{{cadastros.status_aprovado == 1 ? 'Ativo' : 'Inativo'}}</span> -->
                                                                    </td>


                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                            <a :href="'<?php echo HOME_URI ?>/anunciosD/'+cadastros.id"><svg style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg></a>

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
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form @submit.prevent="atualizaTaxa">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Taxas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Taxa mensal</label>
                                                <input type="number" class="form-control" v-model="taxa_mes" id="input1" min="0" step="0.01" name="input1">
                                            </div>
                                            <div class="mb-3">
                                                <label for="input2" class="form-label">Comissão %</label>
                                                <input type="number" class="form-control" v-model="taxa_perc" id="input2" min="0" step="0.01"  name="input2">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </form>
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
<?php require 'views/_vue/anunciosP.php'; ?>
</body>

</html>
