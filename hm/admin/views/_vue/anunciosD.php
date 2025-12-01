<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#comprasDetalhes',
    data: {
      allcompras: [],
      allcaracteristicas: [],
      allimagens: [],
      alltipos: [],
      allreservas: [],
      allingressos: [],
      allcompras: [],

      rows_imagens: null,
      rows_carac: null,
      rows_tipos: null,
      rows_ingressos: null,
      rows_reservas: null,
      rows_compras: null,
      rows_periodos: null,
      rows_camas: null,

      allimagensID: [],
      allcamasID: [],
      allperiodosID: [],
      allreservasID: [],

      allusuariosdados: [],
      allpagamentos: [],
      allestatisticas: [],
      planocompleto: [],
      listallplanos: [],
      listallcupons: [],
      id_usuario: window.location.href.split("anunciosD/")[1].split("#")[0],
      nome_visita: null,
      numero_estudo: null,
      saldo_atual:null,
      numero_paciente: null,
      nome_usuario: null,
      cpf_usuario: null,
      email_usuario: null,
      porcentagem_consumida: null,
      celular_usuario: null,
      status_usuario: "",
      data_nascimento_usuario: null,
      nome_usuario_update: null,
      cpf_usuario_update: null,
      email_usuario_update: null,
      celular_usuario_update: null,
      status_usuario_update: "",
      id_plano: "",
      inicio_plano: null,
      data_nascimento_update: null,
      validade_plano: null,
      cep: null,
      estado: null,
      cidade: null,
      endereco: null,
      bairro: null,
      numero: null,
      complemento: null,
      cep_modal: null,
      estado_modal: null,
      cidade_modal: null,
      endereco_modal: null,
      bairro_modal: null,
      numero_modal: null,
      complemento_modal: null,
      avatar_user: null,
      latitude: null,
      longitude: null,
      password:null,
      password2:null,
      dias_restantes:null,
      previewImage: null,
      selectedImageUrl: null,
      avatarUp: null,
      empty_cupom:null,
      cod: null,
      empty_pagamentos: null,
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
      status: null,
      chave: null,
      status_update: "",
      id_cupom_update:null,
      validationColorLength: '',
      validationColorUpperCase: '',
      aparecer: false,
      empty:null,
      link:null,
      link_update:null,
      saq:null,
      saq_update:"",
      email:null,
      celular:null,


    },
    methods: {

      listAllCompras: function() {
        axios.post('<?php echo API ?>/anuncios/listID/', {
            id:this.id_usuario,
            id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
      .then(res => {

        this.allcompras=res.data[0]
        this.allcaracteristicas = res.data[0].caracteristicas
        this.rows_carac = res.data[0].caracteristicas[0].rows

        this.allimagens = res.data[0].imagens
        this.rows_imagens = res.data[0].imagens[0].rows

        this.alltipos = res.data[0].tipos
        this.rows_tipos = res.data[0].tipos[0].rows

        this.allingressos = res.data[0].ingressos
        this.rows_ingressos = res.data[0].ingressos[0].rows

        this.allreservas = res.data[0].reservas
        this.rows_reservas = res.data[0].reservas[0].rows

        this.latitude = res.data[0].latitude
        this.longitude = res.data[0].longitude

      })
      .catch(err => {
        console.log(err);
      });
  },

    ListIdTipo: function(id) {

      axios.post('<?php echo API ?>/anuncios/listtiposID/', {
          id: id,
          id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
          token: '<?php echo TK ?>'
        })
    .then(res => {


      this.allimagensID = res.data[0].imagens
      this.rows_imagens = res.data[0].imagens[0].rows

      this.allcamasID = res.data[0].camas
      this.rows_camas = res.data[0].camas[0].rows

      this.allperiodosID = res.data[0].periodos
      this.rows_periodos = res.data[0].periodos[0].rows

      this.allreservasID = res.data[0].reservas
      this.rows_reservas = res.data[0].reservas[0].rows

    })
    .catch(err => {
      console.log(err);
    });
  },

  ListIdDadosAprovados: function() {
    axios.post('<?php echo API ?>/compras/ListIdDadosAprovados/', {
      id_usuario:this.id_usuario,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.nome_visita = res.data[0].nome_visita;
        this.numero_estudo = res.data[0].n_estudo;
        this.numero_paciente = res.data[0].n_paciente;

      })
      .catch(err => {
        console.log(err);
      });
  },

  openFileInput() {

            document.getElementById('avatarInput').click();
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
        handleFileInputChange(event) {
            const file = event.target.files[0];
            if (file) {

                this.loadingPreview = true;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;

                    this.selectedImageUrl = e.target.result;
                    console.log(this.selectedImageUrl)
                    this.loadingPreview = false;
                };
                reader.readAsDataURL(file);
            }
        },
         updateImg: function() {
        let fd = new FormData()
        fd.append("token", '<?php echo TK ?>')
        fd.append("id_user", this.id_usuario)
        fd.append("url", this.avatarUp)
        axios.post('<?php echo API ?>/usuarios/updateavatar/', fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(res => {
          if (res.data[0].status == 1) {
            Swal.fire({
              title: 'Pronto!',
              text: "Imagem alterada com sucesso.",
              type: 'success',
              padding: '2em',
              confirmButtonColor: '#92db32',
              confirmButtonText: 'OK'
            }).then((result) => {
              this.previewImage = null;
              this.ListIdCadastros()
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

  viacep(){

  if( this.cep_modal.length > 8){
    let url = `https://viacep.com.br/ws/${this.cep_modal}/json/`
    axios.get(url)
    .then((res)=> {
      console.log(res.data)
      this.estado_modal=res.data.uf
      this.cidade_modal=res.data.localidade
      this.bairro_modal=res.data.bairro
      this.complemento_modal=res.data.complemento
      this.endereco_modal=res.data.logradouro
    })
  }
  },

      updateendereco: function() {
          axios.post('<?php echo API ?>/compras/updateEndereco/', {
            id_usuario: this.id_usuario,
              token: '<?php echo TK ?>', cep:this.cep_modal, estado:this.estado_modal, cidade:this.cidade_modal, bairro:this.bairro_modal,
			  endereco:this.endereco_modal, numero:this.numero_modal, complemento:this.complemento_modal
            })
            .then(res => {
              this.update_endereco = res.data
              if (res.data.status == 1) {
            console.log(res.data.id);
            Swal.fire({
              title: res.data.msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.ListIdCadastros()
            this.listAllPagamentos()
            this.EstatisticasGerais()
            this.listAllPlanos()
            $('#editarEndereco').modal('hide')
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
      updatePlanos: function() {
          axios.post('<?php echo API ?>/compras/updatePlanos/', {
            id_usuario: this.id_usuario,
            id_plano: this.id_plano,
            validade_plano: this.validade_plano,
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
            this.ListIdCadastros()
            this.EstatisticasGerais()

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
      aprovarUsuario: function() {
          axios.post('<?php echo API ?>/usuarios/aprovarUsuario/', {
            id_usuario: this.id_usuario,
            numero_paciente: this.numero_paciente,
            numero_estudo: this.numero_estudo,
            nome_visita: this.nome_visita,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              if (res.data[0].status == 1) {
            Swal.fire({
              title: res.data[0].msg,
              type: "success",
              padding: "2em",
              showConfirmButton: true,
            });
            this.ListIdCadastros()

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
  listAllPagamentos: function() {
    axios.post('<?php echo API ?>/compras/listAllPagamentos/', {
      id_usuario:this.id_usuario,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allpagamentos = res.data;
        this.empty_pagamentos = res.data[0].rows != 0 ? false : true

      })
      .catch(err => {
        console.log(err);
      });
  },
  listAllCupons: function() {
    axios.post('<?php echo API ?>/compras/listAllCupons/', {
      id_usuario:this.id_usuario,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.listallcupons = res.data;
        this.empty_cupom = res.data[0].rows != 0 ? false : true

      })
      .catch(err => {
        console.log(err);
      });
  },
  ListIdCupons: function(id) {
    axios.post('<?php echo API ?>/compras/ListIdCupons/', {
      id_cupom:id,
        token: '<?php echo TK ?>'
      })
      .then(res => {
       this.data_inUpdate = res.data[0].data_inUpdate
       this.data_outUpdate = res.data[0].data_outUpdate
       this.tipo_cupom_update = res.data[0].tipo;
       this.valor_qtd_update = res.data[0].valor;
       this.porcentagem_qtd_update = res.data[0].porcentagem;
       this.id_cupom_update = res.data[0].id;
       this.status_update = res.data[0].status;

      })
      .catch(err => {
        console.log(err);
      });
  },
  updateCupons: function() {
        let valorUp;
        if (this.tipo_cupom_update === 1 || this.tipo_cupom_update === '1') {
          valorUp = this.porcentagem_qtd_update;
        } else if (this.tipo_cupom_update === 2 || this.tipo_cupom_update === '2') {
          valorUp = this.valor_qtd_update;
        }
      axios.post('<?php echo API ?>/compras/updateCupons', {
        id_cupom:this.id_cupom_update,
      tipo_desc: this.tipo_cupom_update,
      valor: valorUp,
      data_in: this.data_inUpdate,
      data_out: this.data_outUpdate,
      id_usuario:this.id_usuario,
      status:this.status_update,
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
            this.listAllCupons()
            $('#updateCupom').modal('hide')

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
  listAllPlanos: function() {
    axios.post('<?php echo API ?>/compras/listAllPlanos/', {
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.listallplanos = res.data;

      })
      .catch(err => {
        console.log(err);
      });
  },
                validatePassword() {
                    if (this.password.length >= 8) {
                        this.validationColorLength = '#00d100';
                    } else {
                        this.validationColorLength = 'black';
                    }

                    if (/[A-Z]/.test(this.password)) {
                        this.validationColorUpperCase = '#00d100';
                    } else {
                        this.validationColorUpperCase = 'black';
                    }
                },
  updatepassword: function() {
    if (this.password.length < 8) {
        Swal.fire({
            title: "A senha deve ter pelo menos 8 caracteres.",
            type: "error",
            padding: "2em",
            showConfirmButton: true,
        });
        return;
    }

    if (!/[A-Z]/.test(this.password)) {
        Swal.fire({
            title: "A senha deve conter pelo menos uma letra maiúscula.",
            type: "error",
            padding: "2em",
            showConfirmButton: true,
        });
        return;
    }
    if (this.password === this.password2) {
        axios.post('<?php echo API ?>/compras/updatepassword/', {
          id_usuario:this.id_usuario,
            password: this.password,
            token: '<?php echo TK ?>'
        })
        .then(res => {
            console.log(res.data.status)
            if (res.data[0].status == "01") {
                Swal.fire({
                    title: res.data[0].msg,
                    type: "success",
                    padding: "2em",
                    showConfirmButton: true,

                });
                this.password = null;
                this.password2 = null;
            } else {
                Swal.fire({
                    title: res.data[0].msg,
                    type: "error",
                    padding: "2em",
                    showConfirmButton: true,
                })
            }
        })
        .catch(err => {
            console.log(err)
        });
    } else {
        Swal.fire({
            title: "As senhas não coincidem.",
            type: "error",
            padding: "2em",
            showConfirmButton: true,
        });
    }
},
  updateCadastro: function() {
        axios.post('<?php echo API ?>/compras/updateCadastro/', {
            id_usuario:this.id_usuario,
            nome:this.nome_usuario_update,
            link:this.link_update,
            saq:this.saq_update,
            status_aprovado:this.status_usuario_update,
            token:'<?php echo TK ?>'
        })
        .then(res => {
            console.log(res.data.status)
            if (res.data.status == "01") {
                Swal.fire({
                    title: res.data.msg,
                    type: "success",
                    padding: "2em",
                    showConfirmButton: true,

                });
                this.ListIdCadastros()

                $('#editarUsuario').modal('hide')
            } else {
                Swal.fire({
                    title: res.data[0].msg,
                    type: "error",
                    padding: "2em",
                    showConfirmButton: true,
                })
            }
        })
        .catch(err => {
            console.log(err)
        });

},
  EstatisticasGerais: function() {
    axios.post('<?php echo API ?>/compras/EstatisticasGerais/', {
      id_usuario:this.id_usuario,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allestatisticas = res.data[0];

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
      saveCupons: function() {
        let valorP;
        if (this.tipo_cupom === 1 || this.tipo_cupom === '1') {
          valorP = this.porcentagem_qtd;
        } else if (this.tipo_cupom === 2 || this.tipo_cupom === '2') {
          valorP = this.valor_qtd;
        }
      axios.post('<?php echo API ?>/compras/saveCupons', {
      tipo_desc: this.tipo_cupom,
      valor: valorP,
      data_in: this.data_inSave,
      data_out: this.data_outSave,
      id_usuario:this.id_usuario,
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
            $('#saveNewCupom').modal('hide')
            this.listAllCupons()

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
      limpamodalcupons(){

      this.tipo_cupom=""
      this.valor_qtd=null
      this.porcentagem_qtd=null
      this.data_outSave=null
      this.data_inSave=null
      },

      deleteAnuncio: function(id) {
      axios.post('<?php echo API ?>/anuncios/excluir', {
          id:  id,
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
            window.location.href = "<?php echo HOME_URI ?>/anuncios";

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

      deleteImagens: function(id) {
      axios.post('<?php echo API ?>/anuncios/excluirimagens', {
          id:  id,
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
            this.listAllCompras()

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

      deleteImagensType: function(id) {
      axios.post('<?php echo API ?>/anuncios/excluir_imagens_type', {
          id:  id,
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
            this.ListIdTipo()
            this.listAllCompras()

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
    axios.post('<?php echo API ?>/compras/deleteCadastro/', {
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
            this.listAllCompras()

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
      watch:{
      'valor_qtd' () {
                var valor_qtd = this.valor_qtd.replace(/\D/g, '')
                valor_qtd = (valor_qtd / 100).toFixed(2) + ''
                valor_qtd = valor_qtd.replace('.', ',')
                valor_qtd = valor_qtd.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                valor_qtd = valor_qtd.replace(/(\d)(\d{3}),/g, '$1.$2,')
                this.valor_qtd = 'R$ ' + valor_qtd
            },
      'valor_qtd_update' () {
                var valor_qtd_update = this.valor_qtd_update.replace(/\D/g, '')
                valor_qtd_update = (valor_qtd_update / 100).toFixed(2) + ''
                valor_qtd_update = valor_qtd_update.replace('.', ',')
                valor_qtd_update = valor_qtd_update.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                valor_qtd_update = valor_qtd_update.replace(/(\d)(\d{3}),/g, '$1.$2,')
                this.valor_qtd_update = 'R$ ' + valor_qtd_update
            },
          },
    created() {
      this.listAllCompras();


    },
  });

  new Vue({
    el: '#menuslaterais',
    data: {
      listallmenus: [],
      availableIcons: [
        'iconly-Curved-Wallet',
        'iconly-Curved-Setting',
        'iconly-Curved-Location',
        'iconly-Light-Activity'
      ],
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
      getRandomIconClass() {
      // Gere um índice aleatório com base na quantidade de ícones disponíveis
      const randomIndex = Math.floor(Math.random() * this.availableIcons.length);
      // Retorna a classe do ícone correspondente ao índice aleatório
      return this.availableIcons[randomIndex];
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
