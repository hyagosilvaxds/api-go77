<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#pedidos',
    data: {
      allpedidos: [],
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
      primeira_vez:true,
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
    },

    computed: {
      totalPages() {
        return Math.ceil(this.allpedidos.length / this.itemsPerPage);
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
        return this.allpedidos.slice(start, end);
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
        axios.post('<?php echo API ?>/pedidos/listPendentes/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.formSubmitted = true;
            this.empty = res.data[0].rows != 0 ? false : true
            this.allpedidos = res.data;
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
     
    saveEmpresa: function() {
        let fd = new FormData()
        fd.append("token", '<?php echo TK ?>')
        fd.append("nome", this.nome_empresa)
        fd.append("link", this.link_empresa)
        fd.append("saq", this.saq_empresa)
        fd.append("url", this.avatarUp)
        axios.post('<?php echo API ?>/pedidos/saveEmpresa/', fd, {
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
              this.listAllPedidos();
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

      listAllPedidos: function() {
        if (this.limparfiltro) {
          this.id_usuario = null;
          this.nome_filtro = null;
          this.dataDe_filtro = null;
          this.dataAte_filtro = null;
          this.listandoPendentes=false;
          this.cidade_filtro = "";
          this.estado_filtro = "";
        }
        if(this.primeira_vez == true){
          this.primeira_vez = false
          // Obter a data do primeiro dia do mês atual
          const hoje = new Date();
          const primeiroDia = new Date(hoje.getFullYear(), hoje.getMonth(), 1);

          // Obter a data do último dia do mês atual
          const ultimoDia = new Date(hoje.getFullYear(), hoje.getMonth() + 1, 0); // O dia 0 retorna o último dia do mês anterior

          // Formatar o primeiro dia como 'yyyy-mm-dd' (formato padrão)
          const anoInicio = primeiroDia.getFullYear();
          const mesInicio = String(primeiroDia.getMonth() + 1).padStart(2, '0');
          const diaInicio = String(primeiroDia.getDate()).padStart(2, '0');
          this.dataDe_filtro = `${anoInicio}-${mesInicio}-${diaInicio}`;

          // Formatar o último dia como 'yyyy-mm-dd' (formato padrão)
          const anoFim = ultimoDia.getFullYear();
          const mesFim = String(ultimoDia.getMonth() + 1).padStart(2, '0');
          const diaFim = String(ultimoDia.getDate()).padStart(2, '0');
          this.dataAte_filtro = `${anoFim}-${mesFim}-${diaFim}`;
        }
        axios.post('<?php echo API ?>/pedidos/listAllPedidos/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            id_usuario:this.id_usuario,
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
            this.allpedidos = res.data;
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
      
        axios.post('<?php echo API ?>/pedidos/exportarCsv/', {
          
        })
        .then(res => {
          if (res.data[0].status == 1) {
            window.location.href = "<?php echo API ?>/uploads/planilhas/exportarCadastros.csv";
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
      this.listAllPedidos();
    },
  ListIdCadastros: function(id) {
    axios.post('<?php echo API ?>/pedidos/listAllPedidos/', {
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
        axios.post('<?php echo API ?>/pedidos/aprovaCadastro/', {
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
                  this.listAllPedidos()
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
        axios.post('<?php echo API ?>/pedidos/reprovaCadastro/', {
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
                this.listAllPedidos()

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
      deletePedidos: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
        axios.post('<?php echo API ?>/pedidos/deletePedidos/', {
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
            this.listAllPedidos()

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
      this.listAllPedidos();
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
