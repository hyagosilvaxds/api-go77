<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#config',
    data: {

      manutencao: "",
      empty:null,
      whatsapp:null,
      online:null,
      instagram:null,
      twitter:null,
      facebook:null,
      cep:null,
      estado:null,
      cidade:null,
      endereco:null,
      bairro:null,
      numero:null,
      complemento:null,
      naopode:null,
      email:null,
      celular:null,

      perc_cartao:null,
      perc_pix:null,
      raio_km:null,
      perc_imoveis:null,
      perc_eventos:null,
      tempo_cancelamento:null,

      valor_min:null,
      valor_max:null,
    },
    methods: {

      listConfig: function() {
    axios.post('<?php echo API ?>/configuracoes/listAllConfiguracoes/', {
      id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {

        this.celular = res.data[0].whatsapp;
        this.email = res.data[0].email;
        this.cep = res.data[0].cep;
        this.estado = res.data[0].estado;
        this.cidade = res.data[0].cidade;
        this.endereco = res.data[0].endereco;
        this.bairro = res.data[0].bairro;
        this.numero = res.data[0].numero;
        this.perc_cartao = res.data[0].perc_cartao;
        this.perc_pix = res.data[0].perc_pix;
        this.raio_km = res.data[0].raio_km;
        this.perc_imoveis = res.data[0].perc_imoveis;
        this.perc_eventos = res.data[0].perc_eventos;
        this.tempo_cancelamento = res.data[0].tempo_cancelamento;

        this.facebook = res.data[0].facebook;
        this.twitter = res.data[0].twitter;
        this.instagram = res.data[0].instagram;


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


      updateConfig: function() {
        axios.post('<?php echo API ?>/configuracoes/updateConfig', {
      celular: this.celular,
      perc_cartao: this.perc_cartao,
      perc_pix: this.perc_pix,
      perc_imoveis: this.perc_imoveis,
      perc_eventos: this.perc_eventos,
      raio_km: this.raio_km,
      tempo_cancelamento: this.tempo_cancelamento,
      instagram: this.instagram,
      facebook: this.facebook,
      twitter: this.twitter,

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
            this.listConfig()

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

  viacep(){

  if( this.cep.length > 8){
    let url = `https://viacep.com.br/ws/${this.cep}/json/`
    axios.get(url)
    .then((res)=> {
      console.log(res.data)
      this.estado=res.data.uf
      this.cidade=res.data.localidade
      this.bairro=res.data.bairro
      this.complemento=res.data.complemento
      this.endereco=res.data.logradouro
    })
  }
  },

    },

    watch:{
        'perc_cartao' () {
                var perc_cartao = this.perc_cartao.replace(/\D/g, '')
                perc_cartao = (perc_cartao / 100).toFixed(2) + ''
                perc_cartao = perc_cartao.replace(',', '.')
                perc_cartao = perc_cartao.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                perc_cartao = perc_cartao.replace(/(\d)(\d{3}),/g, '$1.$2,')
                this.perc_cartao = perc_cartao
            },
        'perc_pix' () {
                      var perc_pix = this.perc_pix.replace(/\D/g, '')
                      perc_pix = (perc_pix / 100).toFixed(2) + ''
                      perc_pix = perc_pix.replace(',', '.')
                      perc_pix = perc_pix.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                      perc_pix = perc_pix.replace(/(\d)(\d{3}),/g, '$1.$2,')
                      this.perc_pix = perc_pix
          },
        'perc_eventos' () {
                    var perc_eventos = this.perc_eventos.replace(/\D/g, '')
                    perc_eventos = (perc_eventos / 100).toFixed(2) + ''
                    perc_eventos = perc_eventos.replace(',', '.')
                    perc_eventos = perc_eventos.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                    perc_eventos = perc_eventos.replace(/(\d)(\d{3}),/g, '$1.$2,')
                    this.perc_eventos = perc_eventos
                },
        'perc_imoveis' () {
                          var perc_imoveis = this.perc_imoveis.replace(/\D/g, '')
                          perc_imoveis = (perc_imoveis / 100).toFixed(2) + ''
                          perc_imoveis = perc_imoveis.replace(',', '.')
                          perc_imoveis = perc_imoveis.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                          perc_imoveis = perc_imoveis.replace(/(\d)(\d{3}),/g, '$1.$2,')
                          this.perc_imoveis = perc_imoveis

          },
    },

    created() {

      this.listConfig()


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
