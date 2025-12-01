<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#estatisticas',
    data: {
      allstats: [],
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
      naopode:null,
      formSubmitted: false,
      limparfiltro:false,
    },
    methods: {
      ListAllEstatisticas: function() {
        if (this.limparfiltro) {
        this.dataDe_filtro = null;
        this.dataAte_filtro = null;
      }
    axios.post('<?php echo API ?>/estatisticas/listAll/', {
        id_grupo:'<?php echo $_SESSION['id_grupo'] ?>',
        data_de:this.dataDe_filtro,
        data_ate:this.dataAte_filtro,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.limparfiltro = false
        this.allstats = res.data[0];
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
    LimparFiltro() {
      this.limparfiltro = true;
      this.ListAllEstatisticas();
    },
    },
    created() {
      this.ListAllEstatisticas()
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
