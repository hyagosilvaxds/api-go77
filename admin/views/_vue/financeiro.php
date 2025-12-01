<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#financeiro',
    data: {
      allcadastros: [],
      allusuariosdados: [],
      id_usuario: null,
      nome_filtro: null,
      email_filtro: null,
      empty:null,
      dataDe_filtro: null,
      dataAte_filtro: null,
      id_grupo_admin: "",
      categoria_update: "",
      status_update: "",
      limparfiltros:false,
      naopode:null,
      formSubmitted: false,
      itemsPerPage: 10, // Defina o número de itens por página
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
      ListAllCadastros: function() {
        if (this.limparfiltro) {
        this.nome_filtro = null;
        this.email_filtro = null;
        this.dataDe_filtro = null;
        this.dataAte_filtro = null;
      }
    axios.post('<?php echo API ?>/financeiro/listAllFinanceiro/', {
        id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        nome:this.nome_filtro,
        email:this.email_filtro,
        data_de:this.dataDe_filtro,
        data_ate:this.dataAte_filtro,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.limparfiltro = false
        this.allcadastros = res.data;
        this.empty = res.data[0].rows != 0 ? false : true
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

    exportarPlanosParaCSV: function() {
      
      axios.post('<?php echo API ?>/financeiro/exportarCsv/', {
        
      })
      .then(res => {
        if (res.data[0].status == 1) {
          window.location.href = "<?php echo API ?>/uploads/planilhas/exportarFinanceiro.csv";
          }        
        })
        .catch(err => {
          console.log(err);
        });
      },
    LimparFiltro() {
      this.limparfiltro = true;
      this.ListAllCadastros();
    },
      deleteCadastro: function(id) {
      axios.post('<?php echo API ?>//estabelecimentos/deleteEstabelecimento/', {
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
      },
      ReprovarProfissional: function(id) {
    axios.post('<?php echo API ?>/estabelecimentos/ReprovarEstabelecimento/', {
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
