<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Configurações | <?php echo TITLE; ?></title>

  <?php require_once 'views/_include/head.php'; ?>


  <body>
  <?php require 'views/_include/style/configuracoes.php'; ?>
    <main class="hp-bg-color-dark-90 d-flex min-vh-100">
    <?php require 'views/_include/headeradm.php'; ?>

            <div id="config" class="hp-main-layout-content">
            <?php require 'views/_include/proibido.php'; ?>
                <div v-if="!naopode" class="row mb-32 gy-32">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Configurações</h3>
                        </div>

                        <!-- <div class="col hp-flex-none w-auto">
                            <select class="form-select">
                                <option selected value="1">This Month</option>
                                <option value="2">This Week</option>
                                <option value="3">This Year</option>
                            </select>
                        </div> -->
                    </div>
                </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col pe-md-32 pe-md-120">
                                        <h4>Configurações</h4>

                                        <!-- <p class="hp-p1-body">
                                            Basic usage example.
                                        </p> -->
                                    </div>

                                    <!-- <div class="col hp-flex-none w-auto">
                                        <button type="button" class="btn btn-text btn-icon-only show-code-btn">
                                            <i class="ri-code-s-slash-line hp-text-color-black-80 hp-text-color-dark-30 lh-1" style="font-size: 16px;"></i>
                                        </button>
                                    </div> -->

                                    <div class="col-12 mt-16">
                                        <form @submit.prevent="updateConfig">
                                            <div class="row g-24">
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Celular</label>
                                                    <input v-model="celular" v-mask="'(##) #####-####'" type="text" class="form-control" placeholder="Celular">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Perc Cartão %</label>
                                                    <input v-model="perc_cartao" type="text" min="0" max="100" class="form-control" placeholder="Perc Cartão %">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Perc PIX %</label>
                                                    <input v-model="perc_pix" type="text" min="0" max="100" class="form-control" placeholder="Perc PIX %">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Raio KM</label>
                                                    <input v-model="raio_km" type="number" min="0" max="10000" class="form-control" placeholder="Raio KM">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Perc Hospedagens %</label>
                                                    <input v-model="perc_imoveis" type="text" min="0" max="100" class="form-control" placeholder="Perc Hospedagens %">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Perc Experiências %</label>
                                                    <input v-model="perc_eventos" type="text" min="0" max="100" class="form-control" placeholder="Perc Experiências %">
                                                </div>
                                                <div class="col-4">
                                                    <label for="fullName" class="form-label">Tempo de cancelamento (segundos)</label>
                                                    <input v-model="tempo_cancelamento" type="number" min="0" max="1000" class="form-control" placeholder="Tempo de cancelamento (segundos)">
                                                </div>

                                                <!-- <div class="col-6">
                                                    <label for="address" class="form-label">Plataforma online?</label>
                                                    <select v-model="online" class="form-select">
                                                        <option value="1">Sim</option>
                                                        <option value="2">Não</option>
                                                    </select>

                                                </div> -->

                                                <div class="col-4">
                                                    <label for="displayName" class="form-label">Instagram</label>
                                                    <input type="text" v-model="instagram" class="form-control" placeholder="Instagram">
                                                </div>

                                                <div class="col-4">
                                                    <label for="email" class="form-label">Twitter</label>
                                                    <input type="text" v-model="twitter" class="form-control" placeholder="Twitter">
                                                </div>

                                                <div class="col-4">
                                                    <label for="phone" class="form-label">Facebook</label>
                                                    <input type="text" v-model="facebook" class="form-control" placeholder="Facebook">
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary flutuar">Salvar</button>
                                                </div>


                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col pe-md-32 pe-md-120">
                                        <h4>Endereço</h4>

                                    </div>



                                    <div class="col-12 mt-16">
                                        <form @submit.prevent="updateConfig">
                                            <div class="row g-24">
                                                <div class="col-6">
                                                    <label for="fullName" class="form-label">CEP</label>
                                                    <input type="text" v-mask="'#####-###'" @blur.prevent="viacep" v-model="cep" class="form-control" placeholder="CEP">
                                                </div>



                                                <div class="col-6">
                                                    <label for="displayName" class="form-label">Estado</label>
                                                    <input type="text" maxlength="2" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '')" v-model="estado" class="form-control" placeholder="Estado">
                                                </div>

                                                <div class="col-6">
                                                    <label for="email" class="form-label">Cidade</label>
                                                    <input type="text" v-model="cidade" class="form-control" placeholder="Cidade">
                                                </div>

                                                <div class="col-6">
                                                    <label for="phone" class="form-label">Endereço</label>
                                                    <input type="text" v-model="endereco" class="form-control" placeholder="Endereço">
                                                </div>

                                                <div class="col-6">
                                                    <label for="address" class="form-label">Bairro</label>
                                                    <input type="text" v-model="bairro" class="form-control" placeholder="Bairro">
                                                </div>
                                                <div class="col-6">
                                                    <label for="address" class="form-label">Número</label>
                                                    <input type="text" v-model="numero" class="form-control" placeholder="Nº">
                                                </div>


                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary flutuar">Salvar</button>
                                                </div>


                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div> -->




                </div>
            </div>

            <!-- <footer class="w-100 py-18 px-16 py-sm-24 px-sm-32 hp-bg-color-black-20 hp-bg-color-dark-90">
                <div class="row">
                    <div class="col-12">
                        <p class="hp-p1-body text-center hp-text-color-black-60 mb-8">Todos os direitos reservados à Meu APP Premium &#174; <?php echo date('Y'); ?> Desenvolvido por <a href="http://app5m.com.br/" target="_blank">App5M</a> - <a href="http://app5m.com.br/" target="_blank">Criação de Sites</a> - <a href="http://app5m.com.br/" target="_blank">Desenvolvimento de Aplicativos</a></p>
                    </div>
                </div>
            </footer> -->
        </div>
    </main>




    <div class="scroll-to-top">
        <button type="button" class="btn btn-primary btn-icon-only rounded-circle hp-primary-shadow">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="16px" width="16px" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M13 7.828V20h-2V7.828l-5.364 5.364-1.414-1.414L12 4l7.778 7.778-1.414 1.414L13 7.828z"></path>
                </g>
            </svg>
        </button>
    </div>

    <?php require 'views/_include/scripts.php'; ?>
    <?php require 'views/_include/foot.php'; ?>
    <?php require 'views/_vue/configuracoes.php'; ?>
</body>

</html>
