<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#testegeral',
    data: {
      allusuarios: [],
      allusuariosdados: [],
      listallmenusmanipulaveis: [],
      check_enviar: [],
      checkedMenus: {},
      email_admin: null,
      celular_admin: null,
      empty:null,
      nome_admin: null,
      nome_update: null,
      email_update: null,
      celular_update: null,
      valor_grupo:null,
      id_usuario: null,
      id_grupo_admin: "",
      categoria_update: "",
      status_update: "",
     
    },
    methods: {
      listAllMenusAdminManipular: function() {
        axios.post('<?php echo API ?>/usuarios/listAllMenusAdmin/', {
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.listallmenusmanipulaveis = res.data[0];
           
          })
          .catch(err => {
            console.log(err);
          });
      },
      trocarvalorfinanceiro(){
        this.valor_grupo=2
        this.ListIdUsuarios(this.valor_grupo)
      },
      trocarvalorusuario(){
        this.valor_grupo=3
        this.ListIdUsuarios(this.valor_grupo)
      },

      ListIdUsuarios(id) {
      axios.post('<?php echo API ?>/usuarios/listidchecks/', {
          id_grupo: id,
          token: '<?php echo TK ?>'
        })
        .then(res => {
          this.empty = res.data[0][0].rows != 0 ? false : true
          const id_menu_permitido = res.data[0].map(obj => obj.id_menu_permitido);
          this.listallmenusmanipulaveis.forEach(check => {
            this.$set(this.checkedMenus, check.id_menu, id_menu_permitido.includes(check.id_menu));
          });
          this.updateIdsMarcados();
        })
        .catch(err => {
          console.log(err);
        });
    },
    updateIdsMarcados() {
      this.ids_marcados = Object.keys(this.checkedMenus).filter(id => this.checkedMenus[id]);
    },


  checkEstaPermitido(id_menu) {
        if (this.resData && this.resData[0]) {
            // Verifica se existe um objeto na posição 0 do array
            const obj = this.resData[0];
            // Verifica se o objeto contém a propriedade id_menu_permitido
            if (obj.hasOwnProperty('id_menu_permitido')) {
                // Verifica se o id_menu atual está presente na lista id_menu_permitido
                return obj.id_menu_permitido.includes(id_menu);
            }
        }
        return false;
    },
      
      updateChecks: function() {
    axios.post('<?php echo API ?>/usuarios/updateMenusCheck/', {
        id_grupo:this.valor_grupo,
        id_menu:this.ids_marcados,
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
      saveChecks: function() {
    axios.post('<?php echo API ?>/usuarios/saveMenuCheck/', {
        id_grupo:this.valor_grupo,
        id_menu:this.ids_marcados,
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

    },
    created() {
      this.listAllMenusAdminManipular()
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
