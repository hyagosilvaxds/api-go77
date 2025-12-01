<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#users',
    data: {
      allusuarios: [],
      allusuariosdados: [],
      email_admin: null,
      celular_admin: null,
      nome_admin: null,
      nome_update: null,
      email_update: null,
      celular_update: null,
      empty:null,
      id_usuario: null,
      usuario_busca: null,
      email_busca: null,
      id_grupo_admin: "",
      categoria_update: "",
      status_update: "",
      skipitId: '<?php echo $_SESSION['skipit_id'] ?>',
      limparfiltros:false,
      naopode:null,
      formSubmitted: false,
     
    },
    methods: {
      ListAllUsers: function() {
        if (this.limparfiltro) {
        this.usuario_busca = null;
        this.email_busca = null;
      }
    axios.post('<?php echo API ?>/usuarios/listAllUsuariosAdmin/', {
        id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        nome_usuario:this.usuario_busca,
        email_usuario:this.email_busca,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.limparfiltro = false
        this.allusuarios = res.data;
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
      exportarPlanosParaCSV: function() {
      
      axios.post('<?php echo API ?>/usuarios/exportarCsv/', {
          
        })
        .then(res => {
          if (res.data[0].status == 1) {
            window.location.href = "<?php echo API ?>/uploads/planilhas/exportarUsuarios.csv";
            }        
          })
          .catch(err => {
            console.log(err);
          });
        },
  LimparFiltro() {
      this.limparfiltro = true;
      this.ListAllUsers();
    },
  ListIdUsuarios: function(id) {
    axios.post('<?php echo API ?>/usuarios/listAllUsuariosAdmin/', {
      id_user:id,
        id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allusuariosdados = res.data[0];
        this.categoria_update = res.data[0].id_grupo;
        this.status_update = res.data[0].status_aprovado;
        this.nome_update = res.data[0].nome;
        this.email_update = res.data[0].email;
        this.celular_update = res.data[0].celular;
        this.id_update = res.data[0].id_usuario;
        
      })
      .catch(err => {
        console.log(err);
      });
  },
      saveUsuarios: function() {
    axios.post('<?php echo API ?>/usuarios/saveUsuarioAdmin/', {
        id_grupo:  this.id_grupo_admin,
        nome: this.nome_admin,
        email: this.email_admin,
        celular: this.celular_admin,
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
            $('#addNewProd').modal('hide')

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
      updateUsuarios: function() {
    axios.post('<?php echo API ?>/usuarios/updateUsuarioAdmin/', {
      id_user: this.id_update,
        id_grupo:  this.categoria_update,
        nome: this.nome_update,
        email: this.email_update,
        celular: this.celular_update,
        status: this.status_update,
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
      deleteUsuarios: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
    axios.post('<?php echo API ?>/usuarios/deleteUsuario/', {
        id_user:  id,
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

      limpamodal(){

      this.nome_admin=null
      this.email_admin=null
      this.celular_admin=null
      this.id_grupo_admin=""

      },

        
    },
    created() {
      this.ListAllUsers()
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
