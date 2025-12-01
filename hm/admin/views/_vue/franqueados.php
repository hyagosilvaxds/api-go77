<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#franqueados',
    data: {
      allfranqueados: [],
      allusuariosdados: [],
      id_usuario: null,
      nome_filtro: null,
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
      listandoPendentes:false,
      itemsPerPage: 20, // Defina o número de itens por página
      currentPage: 1, // Página atual

      allestados:[],
      allcidades:[],
      estado_filtro:"",
      cidade_filtro:"",

  
      cnpj_modal:null,
      nome_modal:null,
      fantasia_modal:null,
      razao_modal:null,
      ie_modal:null,
      email_modal:null,
      celular_modal:null,
      senha_modal:null,
      senha2_modal:null,

      cep_modal: null,
      estado_modal:"",
      cidade_modal: "",
      endereco_modal: null,
      bairro_modal: null,
      numero_modal: null,
      complemento_modal: null,

    },

    computed: {
      totalPages() {
        return Math.ceil(this.allfranqueados.length / this.itemsPerPage);
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
        return this.allfranqueados.slice(start, end);
      },
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
        teste: function() {
          console.log("teste")
        },
        listCnpj: function() {
				axios.post('<?php echo API_ROOT ?>/usuarios/listCnpj/',{
					cnpj: this.cnpj_modal,
					token: '72J77vQa'

				})
					.then(res => {
							this.nome_modal = res.data.nome_responsavel;	
              this.fantasia_modal = res.data.nome_fantasia;	
              this.razao_modal = res.data.razao_social;	
              this.ie_modal = res.data.inscricao_estadual;	
					})
					.catch(err => {
						console.log(err);
					});
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
      listPendentes: function() {

        this.listandoPendentes=true;
        axios.post('<?php echo API ?>/franqueados/listPendentes/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.formSubmitted = true;
            this.empty = res.data[0].rows != 0 ? false : true
            this.allfranqueados = res.data;
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
      saveCadastro: function() {

          if (this.senha_modal === this.senha2_modal) {
            if (this.senha_modal.length < 8) {
              swal({
                title: "Erro",
                text: "A senha deve ter no mínimo 8 caracteres.",
                icon: "error",
                button: "OK"
              });
              return
              }
              if (!/[A-Z]/.test(this.senha_modal)) {
              swal({
                title: "Erro",
                text: "A senha deve conter pelo menos uma letra maiúscula.",
                icon: "error",
                button: "OK"
              });
              return
              }

              axios.post('<?php echo API_ROOT ?>/usuarios/cadastroEmpresa/', {
            tipo:3, token: '<?php echo TK_ROOT ?>',
            documento:this.cnpj_modal,nome_responsavel:this.nome_modal,nome_fantasia:this.fantasia_modal,razao_social:this.razao_modal,ie:this.ie_modal,email:this.email_modal,
            celular:this.celular_modal,password:this.senha_modal,

            cep:this.cep_modal, estado:this.estado_modal, cidade:this.cidade_modal, bairro:this.bairro_modal,
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
            this.ListAllfranqueados();
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




          }else{
            swal({
						title: "Erro",
						text: "As senhas digitadas não estão iguais.",
						icon: "error",
						button: "OK",
						});
          }


      },
     
    saveEmpresa: function() {
        let fd = new FormData()
        fd.append("token", '<?php echo TK ?>')
        fd.append("nome", this.nome_empresa)
        fd.append("link", this.link_empresa)
        fd.append("saq", this.saq_empresa)
        fd.append("url", this.avatarUp)
        axios.post('<?php echo API ?>/franqueados/saveEmpresa/', fd, {
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
              this.ListAllfranqueados();
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

      ListAllfranqueados: function() {
        if (this.limparfiltro) {
          this.nome_filtro = null;
          this.dataDe_filtro = null;
          this.dataAte_filtro = null;
          this.listandoPendentes=false;
          this.cidade_filtro = "";
          this.estado_filtro = "";
        }
        axios.post('<?php echo API ?>/franqueados/listAllFranqueados/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            nome:this.nome_filtro,
            data_de:this.dataDe_filtro,
            data_ate:this.dataAte_filtro,
            cidade:this.cidade_filtro,
            estado:this. estado_filtro,
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.limparfiltro = false
            this.empty = res.data[0].rows != 0 ? false : true
            this.allfranqueados = res.data;
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
      
        axios.post('<?php echo API ?>/franqueados/exportarCsv/', {
          
        })
        .then(res => {
          if (res.data[0].status == 1) {
            window.location.href = "<?php echo API ?>/uploads/planilhas/exportarfranqueados.csv";
            }        
          })
          .catch(err => {
            console.log(err);
          });
        },
        
  LimparFiltro() {

      this.formSubmitted = false;
      this.limparfiltro = true;
      this.listandoPendentes=false;
      this.ListAllfranqueados();
    },
  ListIdfranqueados: function(id) {
    axios.post('<?php echo API ?>/franqueados/listAllfranqueados/', {
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
      aprovaCadastro: function(id) {
        if (confirm("Você deseja realmente Aprovar?")) {
        axios.post('<?php echo API ?>/franqueados/aprovaCadastro/', {
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
                if(this.listandoPendentes){
                  this.listPendentes()
                }else{
                  this.ListAllfranqueados()
                }

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
      reprovaCadastro: function(id) {
        if (confirm("Você deseja realmente reprovar?")) {
        axios.post('<?php echo API ?>/franqueados/reprovaCadastro/', {
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
                this.ListAllfranqueados()

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
      deleteCadastro: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
        axios.post('<?php echo API ?>/franqueados/deleteCadastro/', {
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
            this.ListAllfranqueados()

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
      this.ListAllfranqueados();
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
      this.listIdUser()
    },
  });
</script>
