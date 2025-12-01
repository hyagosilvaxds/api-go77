<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#chamados',
    data: {
      listallchamados: [],
      allsetores: [],
      id_usuario: null,
      nome_filtro: null,
      email_filtro: null,
      empty:null,
      dataDe_filtro: null,
      dataAte_filtro: null,
      numero_pedido: null,
      status_pedido: "",
      id_grupo_admin: "",
      categoria_update: "",
      status_update: "",
      limparfiltros:false,
      naopode:null,
      formSubmitted: false,
      status: "",
      setor: "",
      itemsPerPage: 20, // Defina o número de itens por página
      currentPage: 1, // Página atual
      updateInterval:null,
      id_chamado: null,
      status_chamado:null,
      isChatModalOpen: false,
      chatMessages: [],
      nome_usuario:'',
      newMessage: '',
    },
    methods: {

    openChatModal(id) {
      this.isChatModalOpen = true;
      // Carregar mensagens do chat do chamado com o ID `id`

    },
    closeChatModal() {
      this.isChatModalOpen = false;
    },
      sendMessage: function() {
        // Cria um novo objeto FormData
        const formData = new FormData();
      
        // Adiciona os dados ao FormData
        formData.append('id_grupo', '<?php echo $_SESSION['id_grupo'] ?>');
        formData.append('id_de', this.id_chamado);
        formData.append('id_para', this.id_usuario); // Corrigi a chave para 'id_para'
        formData.append('type', 1);
        formData.append('mensagem', this.newMessage);
        formData.append('id_chamado', this.id_chamado);
        formData.append('token', '<?php echo TK ?>');
      
        // Envia a solicitação POST com o FormData
        axios.post('<?php echo API_ROOT ?>/chamado/savechamado/', formData)
            .then(res => {
                if (res.data[0].status == 1) {
                    this.viewChamado(this.id_chamado, this.id_usuario, this.status_chamado, this.nome_usuario);
                    this.newMessage = '';
                } else {
                    Swal.fire({
                        title: res.data[0].msg,
                        icon: "error",
                        padding: "2em",
                        showConfirmButton: true,
                    });
                }
            })
            .catch(err => {
                console.log(err);
            });
    },
    reabrirChamado: function() {
        if (confirm("Você deseja realmente abrir?")) {
        axios.post('<?php echo API ?>/usuarios/reabrirChamado/', {
        id_chamado:  this.id_chamado,
        token: '<?php echo TK ?>'
        
        })
        .then(res => {
        if (res.data.status == 1) {
            console.log(res.data.id);
            Swal.fire({
              title: res.data.msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.listAllChamados();
            this.closeChatModal();
          } else {
            Swal.fire({
              title: res.data[0].msg,
              type: "error",
              padding: "2em",
              showConfirmButton: true,
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
      }
    },

    finalizarChamado: function() {
        if (confirm("Você deseja realmente finalizar?")) {
        axios.post('<?php echo API ?>/usuarios/finalizarChamado/', {
        id_chamado:  this.id_chamado,
        token: '<?php echo TK ?>'
        
        })
        .then(res => {
        if (res.data.status == 1) {
            console.log(res.data.id);
            Swal.fire({
              title: res.data.msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.listAllChamados();
            this.closeChatModal();
          } else {
            Swal.fire({
              title: res.data[0].msg,
              type: "error",
              padding: "2em",
              showConfirmButton: true,
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
      }
    },

    listAllSetores: function() {
        axios.post('<?php echo API ?>/usuarios/listAllSetores/', {
        id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allsetores = res.data;
      })
      .catch(err => {
        console.log(err);
      });
    },
    viewChamado: function(id_chamado,id_usuario,status,nome_usuario) {
        this.id_chamado = id_chamado;
        this.status_chamado = status;
        this.id_usuario=id_usuario;
        this.nome_usuario=nome_usuario;
        this.isChatModalOpen = true;

          axios.post('<?php echo API_ROOT ?>/chamado/listchamadoID/', {
          id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
          id_de: id_chamado,
          id_para:  id_usuario,
          token: '<?php echo TK ?>'
        })
        .then(res => {
          this.chatMessages = res.data.reverse();
        })
        .catch(err => {
          console.log(err);
        });
      },
    listAllChamados: function() {
        if (this.limparfiltro) {
        this.status = "";
        this.setor = "";
        }
        axios.post('<?php echo API ?>/usuarios/listAllChamados/', {
        id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        status:this.status,
        setor:this.setor,
        token: '<?php echo TK ?>'
       })
      .then(res => {
        console.log(res.data);
        this.limparfiltro = false
        this.listallchamados = res.data;
        this.empty = res.data[0].rows != 0 ? false : true
        this.naopode = res.data[0].status == 4
        if (res.data[0].status == 4) {
          Swal.fire({
            title: res.data[0].msg,
            type: "error",
            padding: "2em",
            showConfirmButton: true,
          }).then((result) => {
            // Redireciona para HOME_URI/dashboard após fechar o alerta
            window.location.href = "<?php echo HOME_URI ?>/dashboard";
          });
        }
      })
      .catch(err => {
        console.log(err);
      });
    },
    deletechat: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
        axios.post('<?php echo API_ROOT ?>/chamado/deletechat/', {
        id:  id,
        token: '<?php echo TK ?>'
        
        })
        .then(res => {
        if (res.data.status == 1) {
            this.viewChamado(this.id_chamado, this.id_usuario, this.status_chamado,this.nome_usuario);

          } else {
            Swal.fire({
              title: res.data[0].msg,
              type: "error",
              padding: "2em",
              showConfirmButton: true,
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
      }
    },
    deleteChamado: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
        axios.post('<?php echo API ?>/usuarios/deleteChamado/', {
        id_chamado:  id,
        token: '<?php echo TK ?>'
        
        })
        .then(res => {
        if (res.data.status == 1) {
            console.log(res.data.id);
            Swal.fire({
              title: res.data.msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.listAllChamados()

          } else {
            Swal.fire({
              title: res.data[0].msg,
              type: "error",
              padding: "2em",
              showConfirmButton: true,
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
      }
    },
    LimparFiltro() {
      this.limparfiltro = true;
      this.listAllChamados();
    },
    goToPage(page) {
        this.currentPage = page;
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      onPageChange: function(page) {
        this.currentPage = page;
      },
      startAutoUpdate() {
      // Define o intervalo de atualização se ainda não estiver definido
      if (this.updateInterval === null) {
        this.updateInterval = setInterval(() => {
          if (this.isChatModalOpen) {
            this.viewChamado(this.id_chamado, this.id_usuario, this.status_chamado,this.nome_usuario);
          }
        }, 10000); // Atualiza a cada 5 segundos
      }
    },
    stopAutoUpdate() {
      // Limpa o intervalo se estiver definido
      if (this.updateInterval !== null) {
        clearInterval(this.updateInterval);
        this.updateInterval = null;
      }
    }
     
    },
    created() {
      this.listAllChamados();
      this.listAllSetores();
      setInterval(() => {
            this.listAllChamados();
        }, 30000);
    },
    beforeDestroy() {
    this.stopAutoUpdate();
    },
    computed: {
      totalPages() {
        return Math.ceil(this.listallchamados.length / this.itemsPerPage);
      },
      pages() {
        const pagesArray = [];
        for (let i = 1; i <= this.totalPages; i++) {
          pagesArray.push(i);
        }
        return pagesArray;
      },
      paginatedData() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = this.currentPage * this.itemsPerPage;
        return this.listallchamados.slice(start, end);
      },
      
    },
    watch: {
    isChatModalOpen(newValue) {
      if (newValue) {
        this.startAutoUpdate();
      } else {
        this.stopAutoUpdate();
      }
    }
  }


  });

  new Vue({
    el: '#menuslaterais',
    data: {
      listallmenus: [],
    },
    methods: {
      listAllMenusAdmin: function() {
        axios.post('<?php echo API ?>/usuarios/listAllMenusAdmin/', {
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.listallmenus = res.data[0];
           
          })
          .catch(err => {
            console.log(err);
          });
      },
    },
    created() {
      this.listAllMenusAdmin()
    },
  });
  new Vue({
    el: '#menuscelular',
    data: {
      listallmenus: [],
    },
    methods: {
      listAllMenusAdmin: function() {
        axios.post('<?php echo API ?>/usuarios/listAllMenusAdmin/', {
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.listallmenus = res.data[0];
           
          })
          .catch(err => {
            console.log(err);
          });
      },
    },
    created() {
      this.listAllMenusAdmin()
    },
  });
  new Vue({
    el: '#imguser',
    data: {
      listalldata: [],
    },
    methods: {
      listIdUser: function() {
        axios.post('<?php echo API ?>/usuarios/listIdPerfil/', {
          id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.listalldata = res.data[0].avatar;
          })
          .catch(err => {
            console.log(err);
          });
      },
    },
    created() {
      this.listIdUser()
    },
  });
  new Vue({
    el: '#nomelogado',
    data: {
      nome_logado: null,
    },
    methods: {
      listIdUser: function() {
        axios.post('<?php echo API ?>/usuarios/listIdPerfil/', {
          id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.nome_logado = res.data[0].nome;
          })
          .catch(err => {
            console.log(err);
          });
      },
    },
    created() {
      this.listIdUser()
    },
  });
</script>
