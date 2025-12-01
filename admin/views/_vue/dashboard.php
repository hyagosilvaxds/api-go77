<script>
  Vue.use(VueMask.VueMaskPlugin)

  new Vue({
    el: '#dashboard',
    data: {
      allcards: [],
      graficosinfo: [],
      ultimosrecibos: [],
      ultimascompras: [],
      ultimoscompradores: [],
      usuarios12:null,
      usuarios11:null,
      usuarios10:null,
      usuarios9:null,
      usuarios8:null,
      usuarios7:null,
      usuarios6:null,
      usuarios5:null,
      usuarios4:null,
      usuarios3:null,
      usuarios2:null,
      usuarios1:null,

      fornecedores12:null,
      fornecedores11:null,
      fornecedores10:null,
      fornecedores9:null,
      fornecedores8:null,
      fornecedores7:null,
      fornecedores6:null,
      fornecedores5:null,
      fornecedores4:null,
      fornecedores3:null,
      fornecedores2:null,
      fornecedores1:null,

      franqueados12:null,
      franqueados11:null,
      franqueados10:null,
      franqueados9:null,
      franqueados8:null,
      franqueados7:null,
      franqueados6:null,
      franqueados5:null,
      franqueados4:null,
      franqueados3:null,
      franqueados2:null,
      franqueados1:null,

      empty_recibos:null,
      empty_compras:null,
      valor_maximo_grafico:100,
      url_foto: null,

    },
    methods: {
      cartoesDash: function() {
        axios.post('<?php echo API ?>/dashboard/cartoesDash/', {
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.allcards = res.data[0];
          })
          .catch(err => {
            console.log(err);
          });
      },
      graficosDash: function() {
        axios.post('<?php echo API ?>/dashboard/graficosDash/', {
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.graficosinfo = res.data;
            this.usuarios1 = res.data[0].usuarios_qtd
            this.usuarios2 = res.data[1].usuarios_qtd
            this.usuarios3 = res.data[2].usuarios_qtd
            this.usuarios4 = res.data[3].usuarios_qtd
            this.usuarios5 = res.data[4].usuarios_qtd
            this.usuarios6 = res.data[5].usuarios_qtd
            this.usuarios7 = res.data[6].usuarios_qtd
            this.usuarios8 = res.data[7].usuarios_qtd
            this.usuarios9 = res.data[8].usuarios_qtd
            this.usuarios10 = res.data[9].usuarios_qtd
            this.usuarios11 = res.data[10].usuarios_qtd
            this.usuarios12 = res.data[11].usuarios_qtd

            this.anuncios1 = res.data[0].anuncios_ativos
            this.anuncios2 = res.data[1].anuncios_ativos
            this.anuncios3 = res.data[2].anuncios_ativos
            this.anuncios4 = res.data[3].anuncios_ativos
            this.anuncios5 = res.data[4].anuncios_ativos
            this.anuncios6 = res.data[5].anuncios_ativos
            this.anuncios7 = res.data[6].anuncios_ativos
            this.anuncios8 = res.data[7].anuncios_ativos
            this.anuncios9 = res.data[8].anuncios_ativos
            this.anuncios10 = res.data[9].anuncios_ativos
            this.anuncios11 = res.data[10].anuncios_ativos
            this.anuncios12 = res.data[11].anuncios_ativos

            this.anunciosp1 = res.data[0].anuncios_pendentes
            this.anunciosp2 = res.data[1].anuncios_pendentes
            this.anunciosp3 = res.data[2].anuncios_pendentes
            this.anunciosp4 = res.data[3].anuncios_pendentes
            this.anunciosp5 = res.data[4].anuncios_pendentes
            this.anunciosp6 = res.data[5].anuncios_pendentes
            this.anunciosp7 = res.data[6].anuncios_pendentes
            this.anunciosp8 = res.data[7].anuncios_pendentes
            this.anunciosp9 = res.data[8].anuncios_pendentes
            this.anunciosp10 = res.data[9].anuncios_pendentes
            this.anunciosp11 = res.data[10].anuncios_pendentes
            this.anunciosp12 = res.data[11].anuncios_pendentes

            this.reservas1 = res.data[0].qtd_reservas
            this.reservas2 = res.data[1].qtd_reservas
            this.reservas3 = res.data[2].qtd_reservas
            this.reservas4 = res.data[3].qtd_reservas
            this.reservas5 = res.data[4].qtd_reservas
            this.reservas6 = res.data[5].qtd_reservas
            this.reservas7 = res.data[6].qtd_reservas
            this.reservas8 = res.data[7].qtd_reservas
            this.reservas9 = res.data[8].qtd_reservas
            this.reservas10 = res.data[9].qtd_reservas
            this.reservas11 = res.data[10].qtd_reservas
            this.reservas12 = res.data[11].qtd_reservas

            this.valor_maximo_grafico = res.data[0].valor_maximo_grafico

            this.renderChart();

          })
          .catch(err => {
            console.log(err);
          });
      },
      renderChart: function() {

        let optionsAnalyticsRevenue1 = {
          series: [
            {
                name: "Usuários Cadastrados",
                data: [
                this.usuarios1,
                this.usuarios2,
                this.usuarios3,
                this.usuarios4,
                this.usuarios5,
                this.usuarios6,
                this.usuarios7,
                this.usuarios8,
                this.usuarios9,
                this.usuarios10,
                this.usuarios11,
                this.usuarios12
                ],
            },
            {
                name: "Anúncios Ativos",
                data: [
                this.anuncios1,
                this.anuncios2,
                this.anuncios3,
                this.anuncios4,
                this.anuncios5,
                this.anuncios6,
                this.anuncios7,
                this.anuncios8,
                this.anuncios9,
                this.anuncios10,
                this.anuncios11,
                this.anuncios12
                ],
            },
            {
                name: "Anúncios Pendentes",
                data: [
                this.anunciosp1,
                this.anunciosp2,
                this.anunciosp3,
                this.anunciosp4,
                this.anunciosp5,
                this.anunciosp6,
                this.anunciosp7,
                this.anunciosp8,
                this.anunciosp9,
                this.anunciosp10,
                this.anunciosp11,
                this.anunciosp12
                ],
            },
            {
                name: "Total de Reservas",
                data: [
                this.reservas1,
                this.reservas2,
                this.reservas3,
                this.reservas4,
                this.reservas5,
                this.reservas6,
                this.reservas7,
                this.reservas8,
                this.reservas9,
                this.reservas10,
                this.reservas11,
                this.reservas12
                ],
            },




          ],
          chart: {
            id: "analytics-revenue-chart",
            fontFamily: "Manrope, sans-serif",
            type: "bar",
            height: 300,
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false,
            },
          },
          labels: {
            style: {
                fontSize: "14px",
            },
          },

          dataLabels: {
            enabled: false,
          },

          grid: {
            borderColor: "#DFE6E9",
            row: {
                opacity: 0.5,
            },
          },
          plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 2,
                columnWidth: "80%",
                endingShape: "rounded",
            },
            colors: {
                backgroundBarColors: ["#0063F7", "#00F7BF"],

            },
            barWidth: 15,
          },

          stroke: {
            show: true,
            width: 4,
            colors: ["transparent"],
          },
          xaxis: {
            axisTicks: {
                show: false,
                borderType: "solid",
                color: "#78909C",
                height: 6,
                offsetX: 0,
                offsetY: 0,
            },

            tickPlacement: "between",
            labels: {
                style: {
                    colors: ["636E72"],
                    fontSize: "14px",
                },
            },
            categories: [
                "Jan",
                "Fev",
                "Mar",
                "Abr",
                "Mai",
                "Jun",
                "Jul",
                "Ago",
                "Set",
                "Out",
                "Nov",
                "Dez",
            ],
          },
          legend: {
            horizontalAlign: "right",
            offsetX: 40,
            position: "top",
            markers: {
                radius: 12,
            },
          },
          yaxis: {
            labels: {
                style: {
                    colors: ["636E72"],
                    fontSize: "14px",
                },
                formatter: (value) => {
                    return value.toString();
                },
            },
            min: 0,
            max: this.valor_maximo_grafico,
            tickAmount: 4,
          },
        };

        if (document.querySelector("#analytics-revenue-chart")) {
          let chart = new ApexCharts(document.querySelector("#analytics-revenue-chart"), optionsAnalyticsRevenue1);
          chart.render();
        }
      }
    },
    created() {
      this.cartoesDash();
      this.graficosDash();
    },
  });

  new Vue({
    el: '#dadosdash',
    data: {
      ultimosrecibos: [],
      ultimascompras: [],
      allFornecedores:[],
      ultimoscompradores: [],
      empty_compras: null,
      empty_recibos: null,
      empty_compras:null,
      empty_pedidos:null,
      allPedidos: [],
      allCompras: [],
    },
    methods: {

      listCadastros: function() {
        axios.post('<?php echo API ?>/dashboard/listAnuncios/', {
            token: '<?php echo TK ?>',
            limite:5,
          })
          .then(res => {
            this.ultimosrecibos = res.data;
            this.empty_recibos = res.data[0].rows != 0 ? false : true
          })
          .catch(err => {
            console.log(err);
          });
      },
      listCompradores: function() {
        axios.post('<?php echo API ?>/dashboard/listLastUsuarios/', {
            token: '<?php echo TK ?>',
            limite:5,
          })
          .then(res => {
            this.ultimoscompradores = res.data;
            this.empty_recibos = res.data[0].rows != 0 ? false : true
          })
          .catch(err => {
            console.log(err);
          });
      },
      listPedidos: function() {
        axios.post('<?php echo API ?>/dashboard/listReservas/', {
            token: '<?php echo TK ?>',
            limite:5,
          })
          .then(res => {
            this.allPedidos = res.data;
            this.empty_pedidos = res.data[0].rows != 0 ? false : true


          })
          .catch(err => {
            console.log(err);
          });
      },

    },
    created() {
      this.listCadastros();
      this.listPedidos();
      this.listCompradores();
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
      nome_logado: null,
    },
    methods: {
      listIdUser: function() {
        axios.post('<?php echo API ?>/usuarios/listIdPerfil/', {
          id_usuario:'<?php echo $_SESSION['skipit_id'] ?>',
            token: '<?php echo TK ?>'
          })
          .then(res => {
            this.listalldata = res.data[0].avatar;
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
