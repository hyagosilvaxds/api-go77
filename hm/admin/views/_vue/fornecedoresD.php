<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#cadastrosDetalhess',
    data: {
      allcadastros: [],
      allusuariosdados: [],
      allpagamentos: [],
      allestatisticas: [],
      planocompleto: [],
      listallplanos: [],
      listallcupons: [],
      id_usuario: window.location.href.split("fornecedoresD/")[1].split("#")[0],
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

      
      nome_responsavel_update:null,
      tempo_resposta_update:null,
      cnpj_update:null,
      razao_social_update:null,
      ie_update:null,

      taxa_mensal_update:null,
      taxa_perc_update:null,

      allestados:[],
      allcidades:[],
      allcategorias:[],
      userCategorias:[],
      categoria_modal:"",
     
    },
    methods: {
      
      pegaDadosEndereco: function(id,cep,estado,cidade,endereco,bairro,numero,complemento) {
        this.buscaCidadeIbge(estado);
      this.id_endereco=id;
      this.cep_modal=cep;
      this.estado_modal=estado;
      this.cidade_modal=cidade;
      this.endereco_modal= endereco;
      this.bairro_modal=bairro;
      this.numero_modal=numero;
      this.complemento_modal= complemento;

  },
  buscaCidadeIbge: function(estado_selecionado) {
				axios.post('<?php echo API_ROOT ?>/usuarios/buscaCidadeIbge/',{
					estado: estado_selecionado,
					token: '72J77vQa'

				})
					.then(res => {
							this.allcidades = res.data;	
					})
					.catch(err => {
						console.log(err);
					});
			},
  ListIdCadastros: function() {
    axios.post('<?php echo API ?>/fornecedores/listAllFornecedores/', {
        id_usuario:this.id_usuario,
        id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allusuariosdados = res.data[0];
        this.status_usuario = res.data[0].status;
        this.nome_usuario = res.data[0].nome;
        this.avatar_user = res.data[0].avatar_user;
        this.link = res.data[0].link;
        this.link_update = res.data[0].link;
        this.saq = res.data[0].saq;

        this.email = res.data[0].email;
        this.celular = res.data[0].celular;

        this.saq_update = res.data[0].saq_update;
        this.status_usuario_update = res.data[0].status_aprovado;
        this.nome_usuario_update = res.data[0].nome;

        this.nome_responsavel_update = res.data[0].nome_responsavel;
        this.tempo_resposta_update = res.data[0].tempo_resposta;
        this.cnpj_update = res.data[0].documento;
        this.razao_social_update = res.data[0].razao_social;
        this.ie_update = res.data[0].ie;

        this.taxa_mensal_update = res.data[0].taxa_mensal;
        this.taxa_perc_update = res.data[0].taxa_perc;
        this.EstatisticasGerais();
       

        
      })
      .catch(err => {
        console.log(err);
      });
  },

  ListIdDadosAprovados: function() {
    axios.post('<?php echo API ?>/cadastros/ListIdDadosAprovados/', {
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

  listCategoriasUser: function() {
      axios.post('<?php echo API ?>/fornecedores/listCategoriasUser/', {

      id_user:this.id_usuario,
      token: '<?php echo TK ?>'
    })
    .then(res => {

      this.userCategorias = res.data
      
    })
    .catch(err => {
      console.log(err)
    })
  },
  deleteCategorias: function(id) {
      axios.post('<?php echo API ?>/fornecedores/deleteCategorias/', {

      id_user: this.id_usuario,
      id_categoria:id,
      token: '<?php echo TK ?>'
    })
    .then(res => {

      if (res.data.status == 1) {
            Swal.fire({
              title: "Categoria removida!",
              type: "success",
              padding: "2em",
              showConfirmButton: true,
          });
          this.listCategoriasUser()
      } else {
        Swal.fire({
          title: "Ocorreu um erro!",
          type: "error",
          padding: "2em",
          showConfirmButton: true,
        });
      }
      
    })
    .catch(err => {
      console.log(err)
    })
  },
  saveCategoria: function() {
      axios.post('<?php echo API ?>/fornecedores/addCategoria/', {

      id_user: this.id_usuario,
      id_categoria:this.categoria_modal,
      token: '<?php echo TK ?>'
    })
    .then(res => {

      if (res.data.status == 1) {
            Swal.fire({
              title: "Categoria adicionada!",
              type: "success",
              padding: "2em",
              showConfirmButton: true,
          });
          this.listCategoriasUser()
          $('#saveNewCupom').modal('hide')
      } else {
        Swal.fire({
          title: "Ocorreu um erro!",
          type: "error",
          padding: "2em",
          showConfirmButton: true,
        });
      }
      
    })
    .catch(err => {
      console.log(err)
    })
  },
  listCategorias: function() {
      axios.post('<?php echo API_ROOT ?>/usuarios/listCategorias/', {

      id_user:this.id_usuario,
      token: '<?php echo TK_ROOT ?>'
    })
    .then(res => {

      this.allcategorias = res.data
      
    })
    .catch(err => {
      console.log(err)
    })
  },
  updateendereco: function() {
          axios.post('<?php echo API_ROOT ?>/usuarios/updateEndereco/', {
            id_endereco: this.id_endereco,
              token: '<?php echo TK_ROOT ?>', cep:this.cep_modal, estado:this.estado_modal, cidade:this.cidade_modal, bairro:this.bairro_modal,
			  endereco:this.endereco_modal, numero:this.numero_modal, complemento:this.complemento_modal
            })
            .then(res => {
              this.update_endereco = res.data
              if (res.data[0].status == 1) {
            console.log(res.data[0].id);
            Swal.fire({
              title: res.data[0].msg,
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
      updatePlanos: function() {
          axios.post('<?php echo API ?>/cadastros/updatePlanos/', {
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
    axios.post('<?php echo API ?>/cadastros/listAllPagamentos/', {
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
    axios.post('<?php echo API ?>/cadastros/listAllCupons/', {
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
    axios.post('<?php echo API ?>/cadastros/ListIdCupons/', {
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
      axios.post('<?php echo API ?>/cadastros/updateCupons', {
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
    axios.post('<?php echo API ?>/cadastros/listAllPlanos/', {
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
        axios.post('<?php echo API ?>/cadastros/updatepassword/', {
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
buscaCNPJ: function() {
				axios.post('<?php echo API_ROOT ?>/usuarios/listCnpj/',{
					cnpj: this.cnpj_update,
					token: '<?php echo TK_ROOT ?>'

				})
				.then(res => {
			
					if(res.data.razao_social){
						// this.situacao_cadastral = res.data.situacao_cadastral;
						this.nome_responsavel_update = res.data.nome_responsavel;
						this.nome_usuario_update = res.data.nome_fantasia;
						this.razao_social_update = res.data.razao_social;
						this.ie_update = res.data.inscricao_estadual;
					}
	
				})
				.catch(err => {
					console.log(err);
				});
			},
  updateCadastro: function() {
        axios.post('<?php echo API ?>/fornecedores/updateCadastro/', {
            id_usuario:this.id_usuario,
            nome:this.nome_usuario_update,
            nome_responsavel:this.nome_responsavel_update,
            tempo_resposta:this.tempo_resposta_update,
            cnpj:this.cnpj_update,
            razao_social:this.razao_social_update,
            ie:this.ie_update,
            status_aprovado:this.status_usuario_update,
            taxa_mensal:this.taxa_mensal_update,
            taxa_perc:this.taxa_perc_update,
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
    axios.post('<?php echo API ?>/fornecedores/EstatisticasGerais/', {
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
      axios.post('<?php echo API ?>/cadastros/saveCupons', {
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
    this.categoria_modal=""
      this.tipo_cupom=""
      this.valor_qtd=null
      this.porcentagem_qtd=null
      this.data_outSave=null
      this.data_inSave=null
      },

      deleteCupons: function(id) {
    axios.post('<?php echo API ?>/cupons/deleteCupom/', {
        id_cupom:  id,
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
      },
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

      

        
    },
      watch:{
        'taxa_mensal_update' () {
                var taxa_mensal_update = this.taxa_mensal_update.replace(/\D/g, '')
                taxa_mensal_update = (taxa_mensal_update / 100).toFixed(2) + ''
                taxa_mensal_update = taxa_mensal_update.replace('.', ',')
                taxa_mensal_update = taxa_mensal_update.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
                taxa_mensal_update = taxa_mensal_update.replace(/(\d)(\d{3}),/g, '$1.$2,')
                this.taxa_mensal_update = 'R$ ' + taxa_mensal_update
            },
            // 'taxa_perc_update' () {
            //     var taxa_perc_update = this.taxa_perc_update.replace(/\D/g, '')
            //     taxa_perc_update = (taxa_perc_update / 100).toFixed(2) + ''
            //     taxa_perc_update = taxa_perc_update.replace('.', ',')
            //     taxa_perc_update = taxa_perc_update.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
            //     taxa_perc_update = taxa_perc_update.replace(/(\d)(\d{3}),/g, '$1.$2,')
            //     this.taxa_perc_update = taxa_perc_update
            // },
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
      this.ListIdCadastros();
      this.listAllEstados();
      this.listCategorias();
      this.listCategoriasUser();
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
