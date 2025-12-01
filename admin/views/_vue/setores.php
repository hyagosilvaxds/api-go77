<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#setores',
    data: {
      allcupons: [],
      id_user: null,
      cod: null,
      tipo_desc: null,
      valor: null,
      data_in: null,
      data_out: null,
      data_inSave: null,
      data_outSave: null,
      porcentagem_qtd: null,
      valor_qtd: null,
      tipo_cupom: "",
      data_inUpdate: null,
      data_outUpdate: null,
      porcentagem_qtd_update: null,
      valor_qtd_update: null,
      tipo_cupom_update: "",
      status_update: "",
      empty:null,
      empty_notificacoes:null,
      id_cupom_update:null,
      naopode:null,
      titulo:null,
      descricao:null,

     
    },
    methods: {
      


      ListAllCupons: function() {
        console.log("testeeeeeeeeeeeeee");
    axios.post('<?php echo API ?>/usuarios/listAllSetores/', {
      id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allcupons = res.data;
        console.log(this.allcupons);
        this.empty_notificacoes = res.data[0].rows != 0 ? false : true
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
  // exportarPlanosParaCSV: function() {
      
  //     axios.post('<?php echo API ?>/notificacoes/exportarCsv/', {
          
  //       })
  //       .then(res => {
  //         if (res.data[0].status == 1) {
  //           window.location.href = "<?php echo API ?>/uploads/planilhas/exportarNotifica.csv";
  //           }        
  //         })
  //         .catch(err => {
  //           console.log(err);
  //         });
  //       },

  saveSetor: function() {
    axios.post('<?php echo API ?>/usuarios/saveSetor', {
    nome: this.nome,
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
          this.ListAllCupons()
          $('#addNewProd').modal('hide')

        } else {
          Swal.fire({
            title: res.data.msg,
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
      
      
    limpamodal(){

      this.titulo=null
      this.descricao=null

    },
    
    deleteSetor: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
    axios.post('<?php echo API ?>/usuarios/deleteSetor/', {
        id: id,
        token: '<?php echo TK ?>'
        
      })
      .then(res => {
        if (res.data.status == 1) {
            Swal.fire({
              title: res.data.msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.ListAllCupons()

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
      this.ListAllCupons()
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
