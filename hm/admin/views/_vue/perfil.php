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
      dataNascimento_usuario: null,
      documento_usuario: null,
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
      nome_update: null,
      email_update: null,
      celular_update: null,
      documento_update: null,
      dataNascimento_update: null,
      avataruser: null,
      validationColorLength: '',
      validationColorUpperCase: '',
      aparecer: false,
     
    },
    methods: {
      
  ListIdCadastros: function() {
    axios.post('<?php echo API ?>/usuarios/listIdPerfil/', {
      id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
        id_grupo: '<?php echo $_SESSION['id_grupo'] ?>',
        token: '<?php echo TK ?>'
      })
      .then(res => {
        this.avataruser = res.data[0].avatar;
        this.nome_usuario = res.data[0].nome;
        this.email_usuario = res.data[0].email;
        this.celular_usuario = res.data[0].celular;
        this.documento_usuario = res.data[0].documento;
        this.nome_update = res.data[0].nome;
        this.email_update = res.data[0].email;
        this.celular_update = res.data[0].celular;
        this.documento_update = res.data[0].documento;
        this.dataNascimento_usuario = res.data[0].data_nascimento_view;
        this.dataNascimento_update = res.data[0].data_nascimento;

        
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
        fd.append("id_user",'<?php echo $_SESSION['skipit_id'] ?>')
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
        return; // Sai da função se a senha for muito curta
    }

    if (!/[A-Z]/.test(this.password)) {
        Swal.fire({
            title: "A senha deve conter pelo menos uma letra maiúscula.",
            type: "error",
            padding: "2em",
            showConfirmButton: true,
        });
        return; // Sai da função se a senha não contiver letra maiúscula
    }
    if (this.password === this.password2) {
        axios.post('<?php echo API ?>/cadastros/updatepassword/', {
          id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
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
        axios.post('<?php echo API ?>/cadastros/updateCadastro/', {
            id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
            nome:this.nome_update,
            email:this.email_update,
            documento:this.documento_update,
            celular:this.celular_update,
            data_nascimento:this.dataNascimento_update,
            status_aprovado:1,
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

      

        
    },
    created() {
      this.ListIdCadastros(),
      this.listAllPagamentos(),
      this.EstatisticasGerais(),
      this.listAllPlanos()
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
