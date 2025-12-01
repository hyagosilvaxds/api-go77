<script>
  Vue.use(VueMask.VueMaskPlugin)
  new Vue({
    el: '#formulario',
    data: {
      email:null,
      mensagem:[],
      token_senha:window.location.href.split("recuperar-sucesso/")[1],
      verifica:null,
      password:null,
      password2:null,
      aparecer: false,
      validationColorLength: '',
      validationColorUpperCase: '',
      
    },
    methods: {

      verificatoken: function() {
  axios.post('<?php echo API ?>/usuarios/verificatoken/', {
      token_senha: this.token_senha,
    })
    .then(res => {
      this.verifica = res.data;
      if (this.verifica[0].status === "02") {
        window.location.href = "<?php echo HOME_URI; ?>/login";
      }
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

updatepasswordtoken: function() {
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
        axios.post('<?php echo API ?>/usuarios/updatepasswordtoken/', {
            password: this.password,
            token: this.token_senha
        })
        .then(res => {
            console.log(res.data.status)
            if (res.data[0].status == "01") {
                Swal.fire({
                    title: res.data[0].msg,
                    type: "success",
                    padding: "2em",
                    showConfirmButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                    onClose: () => {
                        window.location.href = "<?php echo HOME_URI; ?>/login/";
                    }
                });
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
}
     

    },
    created() {
      this.verificatoken()
        

      },
      
		})
	</script>