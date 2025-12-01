<script>
  Vue.use(VueMask.VueMaskPlugin)
  new Vue({
    el: '#formulario',
    data: {
      email:null,
      mensagem:[],
      
    },
    methods: {

      recuperarsenha: function() {
    axios.post('<?php echo API ?>/usuarios/recuperarsenha/', {
        email: this.email
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
    })
}
     

    },
    created() {
        

      },
      
		})
	</script>