<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#banners',
    data: {
      allbanners: [],
      empty:null,
      avatar: null,
      avatarupdate: null,
			avatarUp: null,
			status_update: "",
			nome_update: null,
			avatarUpdate: null,
			link_update: null,
			url_update: null,
			id_banner_update: null,
			nome_save: null,
			link_save: null,
			url_save: null,
      naopode:null,
      banner_update:null,

     
    },
   






    methods: {
      
    ListIdBanners: function(id) {
    axios.post('<?php echo API ?>/segmentos/listAllSegmentos', {
      id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
      id_segmento:id,
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.link_update = res.data[0].descricao;
        this.banner_update = res.data[0].url;
        this.nome_update = res.data[0].nome;
        this.id_banner_update = res.data[0].id;
        this.status_update = res.data[0].status;

      })
      .catch(err => {
        console.log(err);
      });
    },
    exportarPlanosParaCSV: function() {
      
      axios.post('<?php echo API ?>/segmentos/exportarCsv/', {
        
      })
      .then(res => {
        if (res.data[0].status == 1) {
          window.location.href = "<?php echo API ?>/uploads/planilhas/exportarSegmentos.csv";
          }        
        })
        .catch(err => {
          console.log(err);
        });
      },
   
   


        changeAvatar: function(e) {
					this.avatarUp = e.target.files[0]
					console.log(e)
					let file = e.target.files
					if (file && file[0]) {
						let reader = new FileReader
						reader.onload = e => {
							this.avatar = e.target.result
							console.log(this.avatar)
						}
						reader.readAsDataURL(file[0])
					}
				},

				updateImg: function() {
					let fd = new FormData()
					fd.append("nome", this.nome_save)
					fd.append("descricao", this.link_save)
					fd.append("token", '<?php echo TK ?>')
					fd.append("url", this.avatarUp)
					axios.post('<?php echo API ?>/segmentos/saveSegmento/', fd, {
							headers: {
								'Content-Type': 'multipart/form-data'
							}
						})
						.then(res => {
							if (res.data[0].status == 1) {
								Swal.fire({
									title: 'Pronto!',
									text: res.data[0].msg,
									type: 'success',
									padding: '2em',
									confirmButtonColor: '#92db32',
									confirmButtonText: 'OK'
								}).then((result) => {
									this.ListAllCupons()
                  $('#addNewProd').modal('hide')
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
        changeAvatarUpdate: function(e) {
					this.avatarUpdate = e.target.files[0]
					console.log(e)
					let file = e.target.files
					if (file && file[0]) {
						let reader = new FileReader
						reader.onload = e => {
							this.avatarupdate = e.target.result
							console.log(this.avatarupdate)
						}
						reader.readAsDataURL(file[0])
					}
				},

				updateImgUpdate: function() {
					let fd = new FormData()
					fd.append("id_segmento", this.id_banner_update)
					fd.append("nome", this.nome_update)
					fd.append("descricao", this.link_update)
					fd.append("status", this.status_update)
					fd.append("token", '<?php echo TK ?>')
					fd.append("url", this.avatarUpdate)
					axios.post('<?php echo API ?>/segmentos/updateSegmento/', fd, {
							headers: {
								'Content-Type': 'multipart/form-data'
							}
						})
						.then(res => {
							if (res.data[0].status == 1) {
								Swal.fire({
									title: 'Pronto!',
									text: res.data[0].msg,
									type: 'success',
									padding: '2em',
									confirmButtonColor: '#92db32',
									confirmButtonText: 'OK'
								}).then((result) => {
									this.ListAllCupons()
                  $('#addNewUser').modal('hide')
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

      ListAllCupons: function() {
      axios.post('<?php echo API ?>/segmentos/listAllSegmentos/', {
      id_grupo:  '<?php echo $_SESSION['id_grupo'] ?>',
      id_segmento:"",
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.allbanners = res.data;
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
  

      limpamodal(){

    this.nome_save=null
    this.link_save=null
    this.avatarUp=null

    },

      deleteBanners: function(id) {
        if (confirm("Você deseja realmente excluir?")) {
    axios.post('<?php echo API ?>/segmentos/deleteSegmento/', {
        id_segmento:  id,
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
