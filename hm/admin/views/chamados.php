<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<style>
    /* Estilos CSS aqui */
    .modal-content {
      position: relative;
      display: flex;
      flex-direction: column;
      width: 100%;
      pointer-events: auto;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 0.3rem;
      outline: 0;
    }
    .modal-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      padding: 1rem 1rem;
      border-bottom: 1px solid #e9ecef;
      border-top-left-radius: 0.3rem;
      border-top-right-radius: 0.3rem;
    }
    .modal-body {
      position: relative;
      flex: 1 1 auto;
      padding: 1rem;
    }
    .modal-footer {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 1rem;
      border-top: 1px solid #e9ecef;
    }
    
    .chat-box {
      max-height: 400px;
      overflow-y: auto;
    }
    .message {
      margin-bottom: 1rem;
    }
    .modal-header .close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #000; /* Ajuste a cor conforme necessário */
    opacity: 0.5; /* Tornar o "X" mais discreto */
}

.modal-header .close:hover {
    opacity: 1; /* Maior visibilidade ao passar o mouse */
}

.modal-header .close span {
    display: block;
}
/* Estilo para mensagens enviadas pelo usuário */
.my-message {
    background-color: #e1ffc7;
    padding: 5px;
    border-radius: 5px;
    margin: 5px;
    width: fit-content;
}
.parent-right{
    display: flex;
    justify-content: flex-end; /* Alinha os filhos à direita */
}
.parent-left{
    display: flex;
    justify-content: flex-start; /* Alinha os filhos à direita */
}

/* Estilo para mensagens recebidas */
.other-message {
    text-align: left;
    background-color: #f1f1f1;
    padding: 5px;
    border-radius: 5px;
    margin: 5px;
    width:fit-content;
}
.context-menu {
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.context-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.context-menu li {
    padding: 8px 12px;
    cursor: pointer;
}

.context-menu li:hover {
    background: #f5f5f5;
}
.message-container {
    position: relative;
    padding: 5px;
}

.delete-container {
    position: absolute;
    right: 0;
    top: 0;
    display: none; /* Oculta o botão de deletar por padrão */
}

.message-container:hover .delete-container {
    display: block; /* Mostra o botão de deletar apenas no hover */
}

.delete-button {
    background: none;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 16px;
}

.delete-button:hover {
    color: darkred;
}

  </style>

  <title>Chamados | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/head.php'; ?>
  

  <body>


  <?php require 'views/_include/style/cadastros.php'; ?>
<main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

        <div class="hp-main-layout-content">
            <div id="chamados" class="row mb-32 gy-32">
                
            <?php require 'views/_include/proibido.php'; ?>

                <div v-if="!naopode" class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Chamados</h3>

                        </div>
                    </div>
                </div>

                <div v-if="!naopode" class="col-12">
                    

                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <form action="" @submit.prevent="listAllChamados">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5>Faça sua pesquisa</h5>

                                                    <div class="col-3">
                                                        <label for="">Status</label>
                                                        <select v-model="status" class="form-select">
                                                            <option value="" selected disabled>Selecione o status</option>
                                                            <option value="1">Finalizado</option>
                                                            <option value="2">Em Andamento</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="">Setor</label>
                                                        <select v-model="setor" class="form-select">
                                                            <option value="" selected disabled>Selecione o setor</option>
                                                            <option v-for="item of allsetores" :value="item.id">{{item.nome}}</option>
                                                        </select>
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
  <!-- Modal de Chat -->
<div v-if="isChatModalOpen" class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chamado id# {{id_chamado}} {{nome_usuario}}</h5>
                <button type="button" class="close" data-dismiss="modal" @click="closeChatModal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="chat-box" style="max-height: 400px; overflow-y: auto;">
                    <div v-for="message in chatMessages" :key="message.id"
                         :class="{'parent-right': message.id_de == id_chamado, 'parent-left': message.id_de != id_chamado}"
                         class="message-container">
                        <div :class="{'my-message': message.id_de == id_chamado, 'other-message': message.id_de != id_chamado}">
                            <strong>{{ message.id_de == id_chamado ? 'Admin' : nome_usuario }}:</strong> {{ message.mensagem }}
                            <div style="display:flex;flex-direction:row-reverse;font-size:12px;color:grey;">
                                <div>{{message.data}}</div>
                                <div class="delete-container">
                                    <button v-if="message.id_de == id_chamado" @click="deletechat(message.id)" class="delete-button" title="Deletar Mensagem">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input v-model="newMessage" @keyup.enter="sendMessage" type="text" class="form-control" placeholder="Digite sua mensagem...">
                <button v-if="status_chamado == 1" type="button" class="btn btn-link" @click="reabrirChamado">Reabrir</button>
                <button v-else type="button" class="btn btn-danger" @click="finalizarChamado">Finalizar Chamado</button>
                <button type="button" class="btn btn-primary" @click="sendMessage">Enviar</button>
            </div>
        </div>
    </div>
</div>

  

                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-32">
                                                        <h5 class="mb-0">Lista de Chamados</h5>
                                                        <div>
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
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Usuário</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Setor</span>
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
                                                                <tr v-if="!empty" v-for="item of listallchamados" :key="item.id">
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.id}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome_usuario}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.nome_setor}}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">{{item.status == 1 ? 'Finalizado' : 'Em andamento'}}</span>
                                                                    </td>

                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <button @click="viewChamado(item.id,item.id_usuario,item.status,item.nome_usuario)" class="iconly-Light-Show hp-cursor-pointer hp-transition hp-hover-text-color-primary-1 text-black-80 bg-transparent border-0"></button>

                                                                        <button @click="deleteChamado(item.id)" class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                                        
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
<?php require 'views/_vue/chamados.php'; ?>
</body>

</html>
