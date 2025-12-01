<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#compras',
    data: {
      allcompras: [],
      allusuariosdados: [],
      allmotivos: [],
      allcarac: [],
      allcamas: [],
      allcategorias: [],
      allsubcategorias: [],

      id_motivo: null,
      nome_motivo: null,
      tipo_motivo: null,
      taxado_motivo: null,
      taxa_motivo: null,
      status_motivo: null,

      nome_motivo_update: null,
      tipo_motivo_update: null,
      taxado_motivo_update: null,
      taxa_motivo_update: null,
      status_motivo_update: null,

      id_carac: null,
      categoria_carac: null,
      nome_carac: null,
      status_carac: null,

      categoria_carac_update: null,
      nome_carac_update: null,
      status_carac_update: null,

      id_cama: null,
      nome_cama: null,
      status_cama: null,

      nome_cama_update: null,
      status_cama_update: null,

      id_categoria: null,
      id_subcategoria: null,
      nome_subcategoria: null,
      status_subcategoria: null,

      id_categoria: null,
      id_categoria_filtro: null,
      id_subcategoria: null,
      nome_subcategoria_update: null,
      categoria_subcategoria_update: null,
      status_subcategoria_update: null,


      id_usuario: null,
      nome_filtro: null,
      email_filtro: null,
      dataDe_filtro: null,
      dataAte_filtro: null,
      primeira_vez:true,

      vendas_qtd:0,
      valor_total:0,
      total_comissoes:0,


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

      comprador_filtro:null,
      fornecedor_filtro:null,
    },

    computed: {
      totalPages() {
        return Math.ceil(this.allcompras.length / this.itemsPerPage);
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
        return this.allcompras.slice(start, end);
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
        axios.post('<?php echo API ?>/compras/listPendentes/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.formSubmitted = true;
            this.empty = res.data[0].rows != 0 ? false : true
            this.allcompras = res.data;
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
        axios.post('<?php echo API ?>/compras/saveEmpresa/', fd, {
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
              this.listAllCompras();
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

      listAllCompras: function() {
        if (this.limparfiltro) {
          this.id_usuario = null;
          this.id_categoria_filtro = null;
          
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
        axios.post('<?php echo API ?>/anuncios/lista/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            id:  this.id_usuario,
            id_categoria:  this.id_categoria_filtro,
            limite:  10000,
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.limparfiltro = false
            this.empty = res.data[0].rows != 0 ? false : true
            this.allcompras = res.data;


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

        axios.post('<?php echo API ?>/compras/exportarCsv/', {

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
      this.listAllCompras();
    },
  ListIdCadastros: function(id) {
    axios.post('<?php echo API ?>/compras/listAllCompras/', {
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


      aprovaCadastro: function(id) {
        if (confirm("Você deseja realmente Aprovar?")) {
        axios.post('<?php echo API ?>/compras/aprovaCadastro/', {
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
                  this.listAllCompras()
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
        axios.post('<?php echo API ?>/compras/reprovaCadastro/', {
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
          }
      },
      deleteCompras: function(id) {
          if (confirm("Você deseja realmente excluir?")) {
          axios.post('<?php echo API ?>/compras/deleteCompras/', {
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
        }
      },

      //START CARACTERISTICAS
      listCarac: function() {

        axios.post('<?php echo API ?>/anuncios/listaCaracteristicas', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.empty = res.data[0].rows != 0 ? false : true
            this.allcarac = res.data;


          })
          .catch(err => {
            console.log(err);
          });
        },

        listCaracID: function() {

          axios.post('<?php echo API ?>/anuncios/listaCaracteristicas', {
              id: this.id_carac,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              this.nome_carac_update = res.data[0].nome;
              this.categoria_carac_update = res.data[0].id_categoria;
              this.status_carac_update = res.data[0].status;

            })
            .catch(err => {
              console.log(err);
            });
          },

        saveCarac: function() {
					let fd = new FormData()
					fd.append("id_categoria", this.categoria_carac)
					fd.append("nome", this.nome_carac)
          fd.append("url", this.avatarUp)
					fd.append("token", '<?php echo TK ?>')

					axios.post('<?php echo API ?>/anuncios/adicionarCaracteristica/', fd, {
							headers: {
								'Content-Type': 'multipart/form-data'
							}
						})
						.then(res => {

              console.log("retorno: " + res.data)

							if (res.data.status == 1) {
								Swal.fire({
									title: 'Pronto!',
									text: res.data.msg,
									type: 'success',
									padding: '2em',
									confirmButtonColor: '#92db32',
									confirmButtonText: 'OK'
								}).then((result) => {
									this.listCarac()
                  $('#listCarac').modal('hide')
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

        updateCarac: function() {
          axios.post('<?php echo API ?>/anuncios/updateCaracteristica/', {

              id: this.id_carac,
              nome:  this.nome_carac_update,
              id_categoria:  this.categoria_carac_update,
              status: this.status_carac_update,
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
                  this.listCarac()
                  $('#UpdateCarac').modal('hide')

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

        deleteCarac: function(id) {
            if (confirm("Você deseja realmente excluir?")) {
            axios.post('<?php echo API ?>/anuncios/excluirCaracteristica/', {
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
                this.listCarac()

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
      //END CARACTERISTICAS

      //START MOTIVOS
      listMotivos: function() {

        axios.post('<?php echo API ?>/anuncios/listaMotivos/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.empty = res.data[0].rows != 0 ? false : true
            this.allmotivos = res.data;


          })
          .catch(err => {
            console.log(err);
          });
        },

        listMotivosID: function() {

          console.log("id_motivo:" + this.id_motivo)

          axios.post('<?php echo API ?>/anuncios/listaMotivos/', {
              id:  this.id_motivo,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              this.nome_motivo_update = res.data[0].nome;
              this.tipo_motivo_update = res.data[0].tipo;
              this.taxado_motivo_update = res.data[0].taxado;
              this.taxa_motivo_update = res.data[0].taxa_perc;
              this.status_motivo_update = res.data[0].status;


            })
            .catch(err => {
              console.log(err);
            });
          },

      saveMotivos: function(id) {

        axios.post('<?php echo API ?>/anuncios/adicionarMotivo/', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            nome: this.nome_motivo,
            tipo: this.tipo_motivo,
            taxado: this.taxado_motivo,
            taxa_perc: this.taxa_motivo,
            status: 1,
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.nome_motivo = ""
            this.tipo_motivo = ""
            this.taxado_motivo = ""
            this.taxa_motivo = ""

            this.listAllCompras()
            this.listMotivos()
            this.nome_materia = null
          })
          .catch(err => {
            console.log(err);
          });
      },

      updateMotivos: function() {
        axios.post('<?php echo API ?>/anuncios/updateMotivo/', {

            id: this.id_motivo,
            nome:  this.nome_motivo_update,
            tipo:  this.tipo_motivo_update,
            taxado: this.taxado_motivo_update,
            taxa_perc: this.taxa_motivo_update,
            status: this.status_motivo_update,
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
                this.listMotivos()

                $('#listMotivos').modal('hide')
                $('#UpdateMotivos').modal('hide')

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

      deleteMotivos: function(id) {
          if (confirm("Você deseja realmente excluir?")) {
          axios.post('<?php echo API ?>/anuncios/excluirMotivo/', {
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
              this.listMotivos()

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
      //END MOTIVOS

      //START CAMAS
      listCamas: function() {

        axios.post('<?php echo API ?>/anuncios/listaCamas', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.empty = res.data[0].rows != 0 ? false : true
            this.allcamas = res.data;


          })
          .catch(err => {
            console.log(err);
          });
        },

        listCamasID: function() {

          axios.post('<?php echo API ?>/anuncios/listaCamas', {
              id: this.id_cama,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              this.nome_cama_update = res.data[0].nome;
              this.status_cama_update = res.data[0].status;

            })
            .catch(err => {
              console.log(err);
            });
          },

        saveCamas: function() {
					let fd = new FormData()
					fd.append("nome", this.nome_cama)
          fd.append("url", this.avatarUp)
					fd.append("token", '<?php echo TK ?>')

					axios.post('<?php echo API ?>/anuncios/adicionarCama/', fd, {
							headers: {
								'Content-Type': 'multipart/form-data'
							}
						})
						.then(res => {

              console.log("retorno: " + res.data)

							if (res.data.status == 1) {
								Swal.fire({
									title: 'Pronto!',
									text: res.data.msg,
									type: 'success',
									padding: '2em',
									confirmButtonColor: '#92db32',
									confirmButtonText: 'OK'
								}).then((result) => {
									this.listCamas()
                  $('#listCamas').modal('hide')
                  $('#UpdateCama').modal('hide')
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

        updateCamas: function() {
          axios.post('<?php echo API ?>/anuncios/updateCama/', {

              id: this.id_cama,
              nome:  this.nome_cama_update,
              status: this.status_cama_update,
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
                  this.listCamas()
                  $('#listCamas').modal('hide')
                  $('#UpdateCama').modal('hide')

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

        deleteCamas: function(id) {
            if (confirm("Você deseja realmente excluir?")) {
            axios.post('<?php echo API ?>/anuncios/excluirCama/', {
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
                this.listCamas()

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

      //END CAMAS

      //START CATEGORIAS E SUBCATEGORIAS
      listCategorias: function() {

        axios.post('<?php echo API ?>/anuncios/listaCategorias', {
            id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {

            this.empty = res.data[0].rows != 0 ? false : true
            this.allcategorias = res.data;


          })
          .catch(err => {
            console.log(err);
          });
        },

        listSubcategorias: function() {

          axios.post('<?php echo API ?>/anuncios/listasubCategorias', {
              id_categoria:  this.id_categoria,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              this.empty = res.data[0].rows != 0 ? false : true
              this.allcategorias = res.data;


            })
            .catch(err => {
              console.log(err);
            });
          },

        listSubcategoriaID: function() {

          axios.post('<?php echo API ?>/anuncios/listasubCategorias', {
              id: this.id_subcategoria,
              token: '<?php echo TK ?>'
            })
            .then(res => {

              this.nome_subcategoria_update = res.data[0].nome;
              this.categoria_subcategoria_update = res.data[0].id_categoria;
              this.status_subcategoria_update = res.data[0].status;

            })
            .catch(err => {
              console.log(err);
            });
          },

        saveSubcategoria: function() {
					let fd = new FormData()

          fd.append("id_categoria", this.id_categoria)
					fd.append("nome", this.nome_subcategoria)
          fd.append("url", this.avatarUp)
					fd.append("token", '<?php echo TK ?>')

					axios.post('<?php echo API ?>/anuncios/adicionarSubcategoria/', fd, {
							headers: {
								'Content-Type': 'multipart/form-data'
							}
						})
						.then(res => {


							if (res.data.status == 1) {
								Swal.fire({
									title: 'Pronto!',
									text: res.data.msg,
									type: 'success',
									padding: '2em',
									confirmButtonColor: '#92db32',
									confirmButtonText: 'OK'
								}).then((result) => {
									this.listCategorias()
                  this.listSubcategorias()

                  $('#listCategorias').modal('hide')
                  $('#listSubcategorias').modal('hide')

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

        updateSubcategoria: function() {
          axios.post('<?php echo API ?>/anuncios/updateSubcategoria/', {

              id: this.id_subcategoria,
              id_categoria: this.categoria_subcategoria_update,
              nome:  this.nome_subcategoria_update,
              status: this.status_subcategoria_update,
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
                  this.listCategorias()
                  this.listSubcategorias()

                  $('#listCategorias').modal('hide')
                  $('#listSubcategorias').modal('hide')
                  $('#updateSubcategoria').modal('hide')

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

        deleteSubcategoria: function(id) {
            if (confirm("Você deseja realmente excluir?")) {
            axios.post('<?php echo API ?>/anuncios/excluirSubcategoria/', {
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
                this.listCategorias()
                this.listSubcategorias()

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

      //END CATEGORIAS E SUBCATEGORIAS


    },

    watch:{
    'taxa_motivo' () {
              var taxa_motivo = this.taxa_motivo.replace(/\D/g, '')
              taxa_motivo = (taxa_motivo / 100).toFixed(2) + ''
              taxa_motivo = taxa_motivo.replace(',', '.')
              taxa_motivo = taxa_motivo.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
              taxa_motivo = taxa_motivo.replace(/(\d)(\d{3}),/g, '$1.$2,')
              this.taxa_motivo =  taxa_motivo
      },
      'taxa_motivo_update' () {
              var taxa_motivo_update = this.taxa_motivo_update.replace(/\D/g, '')
              taxa_motivo_update = (taxa_motivo_update / 100).toFixed(2) + ''
              taxa_motivo_update = taxa_motivo_update.replace(',', '.')
              taxa_motivo_update = taxa_motivo_update.replace(/(\d)(\d{3})(\d{3}),/g, '$1.$2.$3,')
              taxa_motivo_update = taxa_motivo_update.replace(/(\d)(\d{3}),/g, '$1.$2,')
              this.taxa_motivo_update =  taxa_motivo_update
        },

    },

    created() {
      this.listAllCompras();
      this.listAllEstados();
      this.listMotivos();
      this.listCarac();
      this.listCamas();
      this.listCategorias();
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
