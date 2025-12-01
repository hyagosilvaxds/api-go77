<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#cadastros',
    data: {
      allcadastros: [],
      allusuariosdados: [],
      id_usuario: null,
      nome_filtro: null,
      tipo_pagamento_filtro: null,
      email_filtro: null,
      dataDe_filtro: null,
      dataAte_filtro: null,
      empty_cad: null,
      empty_cadnull: null,
      empty:null,
      id_grupo_admin: "",
      categoria_update: "",
      status_update: "",
      limparfiltros:false,
      naopode:null,
      formSubmitted: false,
      mostrardiv: 1,
      previewImage: null,
      link_empresa: null,
      nome_empresa: null,
      saq_empresa: "",
      avatarUp:null,
      itemsPerPage: 20, // Defina o número de itens por página
      currentPage: 1, // Página atual
    },

    computed: {
      totalPages() {
        return Math.ceil(this.allcadastros.length / this.itemsPerPage);
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
        return this.allcadastros.slice(start, end);
      },
    },
    methods: {

      mostrarDivNew: function () {
      this.mostrardiv = 2;
    },
      esconderDivNew: function () {
      this.mostrardiv = 1;
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




    saveEmpresa: function() {
        let fd = new FormData()
        fd.append("token", '<?php echo TK ?>')
        fd.append("nome", this.nome_empresa)
        fd.append("link", this.link_empresa)
        fd.append("saq", this.saq_empresa)
        fd.append("url", this.avatarUp)
        axios.post('<?php echo API ?>/cadastros/saveEmpresa/', fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(res => {
          if (res.data[0].status == 1) {
            Swal.fire({
              title: 'Pronto!',
              text: "Empresa cadastrada com sucesso.",
              type: 'success',
              padding: '2em',
              confirmButtonColor: '#92db32',
              confirmButtonText: 'OK'
            }).then((result) => {
              this.previewImage = null;
              this.nome_empresa = null;
              this.link_empresa = null;
              this.saq_empresa = "";
              this.mostrardiv = 1;
              this.ListAllCadastros();
            })

          } else {
            Snackbar.show({
              text: 'Um erro aconteceu',
              actionTextColor: '#fff',
              backgroundColor: '#e7515a',
              showAction: false,
            })
          }
        })
        .catch(error => {
          console.log(error);
        })

    },


    changeAvatar: function(e) {
        this.avatarUp = e.target.files[0];
        console.log(e);
        let file = e.target.files;
        if (file && file[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.avatar = e.target.result;
                console.log(this.avatar);

                // Adicionando funcionalidades adicionais
                this.loadingPreview = true;
                this.previewImage = e.target.result;
                this.selectedImageUrl = e.target.result;
                console.log(this.selectedImageUrl);
                this.loadingPreview = false;
            };
            reader.readAsDataURL(file[0]);
        }
    },

      ListAllCadastros: function() {
        if (this.limparfiltro) {
        this.id_usuario = null;
        this.tipo_pagamento_filtro = null;
        this.dataDe_filtro = null;
        this.dataAte_filtro = null;
      }
    axios.post('<?php echo API ?>/reservas/lista/', {
        id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        id:this.id_usuario,
        tipo_pagamento:this.tipo_pagamento_filtro,
        data_de:this.dataDe_filtro,
        data_ate:this.dataAte_filtro,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.limparfiltro = false
        this.empty = res.data[0].rows != 0 ? false : true
        this.allcadastros = res.data;
        this.naopode = res.data[0].status == 4

        if (res.data[0].status == 4) {
          console.log(res.data.id);
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

        exportarPlanosParaCSV: function() {

        axios.post('<?php echo API ?>/cadastros/exportarCsv/', {

        })
        .then(res => {
          if (res.data[0].status == 1) {
            window.location.href = "<?php echo API ?>/uploads/planilhas/exportarCadastros.csv";
            }
          })
          .catch(err => {
            console.log(err);
          });
        },

  LimparFiltro() {

      this.formSubmitted = false;
      this.limparfiltro = true;
      this.ListAllCadastros();
    },
  ListIdCadastros: function(id) {
    axios.post('<?php echo API ?>/cadastros/listAllEmpresas/', {
      id_usuario:id,
        id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {

        this.allusuariosdados = res.data[0];
        this.categoria_update = res.data[0].id_grupo;
        this.status_update = res.data[0].status;
        this.nome_update = res.data[0].nome;
        this.email_update = res.data[0].email;
        this.celular_update = res.data[0].celular;
        this.id_update = res.data[0].id_usuario;

      })
      .catch(err => {
        console.log(err);
      });
  },

      updateUsuarios: function() {
    axios.post('<?php echo API ?>/usuarios/updateUsuarioAdmin/', {
      id_user: this.id_update,
        id_grupo:  this.categoria_update,
        nome: this.nome_update,
        email: this.email_update,
        celular: this.celular_update,
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
            this.ListAllUsers()
            $('#addNewUser').modal('hide')

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
      },
      deleteCadastro: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
        axios.post('<?php echo API ?>/cadastros/deleteCadastro/', {
        id_usuario:  id,
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
            this.ListAllCadastros()

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




    },
    created() {
      this.ListAllCadastros()
    },
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
