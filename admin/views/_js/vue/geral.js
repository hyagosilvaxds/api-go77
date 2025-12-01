new Vue({
  el: '#geral',
  data: {
    mostrardiv: 1,
  },
  methods: {
    mostrarDivNew: function () {
      this.mostrardiv = 2;
    },
    mostrarDivEdit: function () {
      this.mostrardiv = 3;
    },
  },
  created() {

  },
});