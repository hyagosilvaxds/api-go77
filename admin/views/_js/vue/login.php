<script>
new Vue({
  el: '#login',
  data: {
      email: null,
      password: null,
      formFatores: 1,
      codigo:null,
      valor1:'',
      valor2:'',
      valor3:'',
      valor4:'',
  },
  methods: {
      submitLogin: async function() {
          const codigoFator = this.combinedValue();
          const login = await axios.post('<?php echo API ?>/usuarios/login/', {
              email: this.email,
              password: this.password,
              codigo: codigoFator,
              token: '<?php echo TK ?>'
          })

          console.log(login)

          if (login.data[0].status != "02") {
              const ses = await this.session(login.data)
              if (ses) {
                  swal({
                      title: 'Olá, ' + login.data[0].nome,
                      text: 'Você está entrando no Beta Beauty.',
                      timer: 4000,
                      padding: '2em',
                      onOpen: function() {
                          swal.showLoading()
                      }
                  }).then(function(result) {
                      if (result.dismiss === swal.DismissReason.timer) {
                          window.location.href = "<?php echo HOME_URI; ?>/painel"
                      }
                  })
              }
          } else {
              Snackbar.show({
                  text: 'Login ou senha incorretas. Tente novamente',
                  pos: 'bottom-left',
                  showAction: false,
                  backgroundColor: '#e7515a',
                  duration: 5000,
              });
          }
      },

      doisFatores: function() {
        
        axios.post('<?php echo API ?>/usuarios/doisFatores', {
          email: this.email,
          password: this.password,
          token: '<?php echo TK ?>'
          })
          .then(res => {
            if(res.data[0].status == 1){
              this.formFatores = 2
            console.log("teste executado")
            Swal.fire({
              title: res.data[0].msg,
              type: 'success',
              padding: '2em'})
          }
          else{
            Swal.fire({
              title: res.data[0].msg,
              type: 'error',
              padding: '2em'})
          }
        })
        .catch(error => console.log(error))
      },

      focusNext(inputNumber) {
      if (inputNumber < 4) {
        const nextInput = this.$refs[`input${inputNumber + 1}`];
        if (nextInput) {
          nextInput.focus();
        }
      }
    },

    combinedValue() {
    return `${this.valor1}${this.valor2}${this.valor3}${this.valor4}`;
  },



      session: function(data) {
          axios.post('<?php echo HOME_URI; ?>/views/_include/gerasession.php', {
              id: data[0].id,
          })
          return true
      },

      mostrarSenha: function() {
          var togglePassword = document.getElementById("toggle-password");

          if (togglePassword) {
              togglePassword.addEventListener('click', function() {
                  var x = document.getElementById("password");
                  if (x.type === "password") {
                      x.type = "text";
                  } else {
                      x.type = "password";
                  }
              });
          }
      }
  }
});
</script>