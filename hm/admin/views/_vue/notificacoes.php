<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#cupons',
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
      allestados:[],
      allcidades:[],
      estado:"",
      cidade:"",
      tipo: "",


    },
    methods: {

      listAllEstados: function() {
					this.allestados = [
						{"id":11,"sigla":"RO","nome":"Rondônia"},
						{"id":12,"sigla":"AC","nome":"Acre"},
						{"id":13,"sigla":"AM","nome":"Amazonas"},
						{"id":14,"sigla":"RR","nome":"Roraima"},
						{"id":15,"sigla":"PA","nome":"Pará"},
						{"id":16,"sigla":"AP","nome":"Amapá"},
						{"id":17,"sigla":"TO","nome":"Tocantins"},
						{"id":21,"sigla":"MA","nome":"Maranhão"},
						{"id":22,"sigla":"PI","nome":"Piauí"},
						{"id":23,"sigla":"CE","nome":"Ceará"},
						{"id":24,"sigla":"RN","nome":"Rio Grande do Norte"},
						{"id":25,"sigla":"PB","nome":"Paraíba"},
						{"id":26,"sigla":"PE","nome":"Pernambuco"},
						{"id":27,"sigla":"AL","nome":"Alagoas"},
						{"id":28,"sigla":"SE","nome":"Sergipe"},
						{"id":29,"sigla":"BA","nome":"Bahia"},
						{"id":31,"sigla":"MG","nome":"Minas Gerais"},
						{"id":32,"sigla":"ES","nome":"Espírito Santo"},
						{"id":33,"sigla":"RJ","nome":"Rio de Janeiro"},
						{"id":35,"sigla":"SP","nome":"São Paulo"},
						{"id":41,"sigla":"PR","nome":"Paraná"},
						{"id":42,"sigla":"SC","nome":"Santa Catarina"},
						{"id":43,"sigla":"RS","nome":"Rio Grande do Sul"},
						{"id":50,"sigla":"MS","nome":"Mato Grosso do Sul"},
						{"id":51,"sigla":"MT","nome":"Mato Grosso"},
						{"id":52,"sigla":"GO","nome":"Goiás"},
						{"id":53,"sigla":"DF","nome":"Distrito Federal"}]

				},
        buscaCidadeIbge: function(estado_selecionado) {
				axios.post('<?php echo API_ROOT ?>/usuarios/buscaCidadeIbge/',{
					estado: estado_selecionado,
					token: '<?php echo TK_ROOT ?>'

				})
					.then(res => {
							this.allcidades = res.data;
					})
					.catch(err => {
						console.log(err);
					});
			},

      ListAllCupons: function() {
    axios.post('<?php echo API ?>/notificacoes/listAll/', {
      id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allcupons = res.data;
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
  exportarPlanosParaCSV: function() {

      axios.post('<?php echo API ?>/notificacoes/exportarCsv/', {

        })
        .then(res => {
          if (res.data[0].status == 1) {
            window.location.href = "<?php echo API ?>/uploads/planilhas/exportarNotifica.csv";
            }
          })
          .catch(err => {
            console.log(err);
          });
        },

      saveCupons: function() {

        if(this.estado == ""){
          this.estado=null;
        }

        if(this.cidade == ""){
          this.cidade=null;
        }
        if(this.tipo == ""){
          this.tipo=null;
        }
      axios.post('<?php echo API ?>/notificacoes/save', {
      titulo: this.titulo,
      descricao: this.descricao,
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

      deleteCupons: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
    axios.post('<?php echo API ?>/notificacoes/delete/', {
        id: id,
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
      this.ListAllCupons();
      this.listAllEstados();
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
      this.listIdUser();
    },
  });
</script>
