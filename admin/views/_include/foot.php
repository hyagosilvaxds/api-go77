<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo JS ?>/libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo JS ?>/popper.min.js"></script>
<script src="<?php echo JS ?>/bootstrap.min.js"></script>
<!-- <script src="<?php echo PLUGINS ?>/perfect-scrollbar/perfect-scrollbar.min.js"></script> -->
<script src="<?php echo JS ?>/authentication/form-1.js"></script>
<script src="<?php echo PLUGINS; ?>/sweetalerts/sweetalert2.min.js"></script>
<script src="<?php echo PLUGINS; ?>/sweetalerts/custom-sweetalert.js"></script>
<script src="<?php echo PLUGINS ?>/notification/snackbar/snackbar.min.js"></script>
<script src="<?php echo JS ?>/app.js"></script>
<script src="<?php echo JS ?>/custom.js"></script>
<script src="<?php echo PLUGINS ?>/blockui/jquery.blockUI.min.js"></script>
<!-- END GLOBAL MANDATORY SCRIP TS -->

<!-- Sweet alert init js-->
<!-- <script src="<?php echo JS;?>/pages/sweet-alerts.init.js"></script> -->

<script src="<?php echo PLUGINS ?>/jquery.mask.js"></script>
<script src="<?php echo PLUGINS ?>/vuejs/vue.js"></script>
<script src="<?php echo PLUGINS ?>/vueplugins/v-mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>


<script>
	$(document).ready(function() {
		App.init();

		$(".mask-money").mask('#.##0,00', {
			reverse: true
		});
		$(".mask-money2").mask('#.##0.00', {
			reverse: true
		});

		$('.mask-nome').mask('A', {
			translation: {
				A: {
					pattern: /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]+$/g,
					recursive: true
				},
			},
		});
		$('.mask-cpf').mask('000.000.000-00');
		$('.mask-cnpj').mask('00.000.000/0000-00', {
			reverse: true
		});
		$('.mask-nascimento').mask('00/00/0000');
		$('.mask-cep').mask('00.000-000');
		$('.mask-num').mask('0#');

		var telMask = function(val) {
				return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
			},
			maskOptions = {
				onKeyPress: function(val, e, field, options) {
					field.mask(telMask.apply({}, arguments), options);
				}
			};
		$('.mask-fone').mask(telMask, maskOptions)
	})
</script>