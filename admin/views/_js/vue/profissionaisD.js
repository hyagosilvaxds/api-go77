
        function showInfoGerais() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'block';
            document.getElementById('alterarSenha').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'none';
        }
    
        function showAlterarSenha() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'block';
        }
        function showEstatisticas() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'block';
        }
        function showPagamentos() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'block';
        }
        function showLocalizacao() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'block';
        }
       
        function showDocumentos() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'none';
            document.getElementById('mostrarEstatisticas').style.display = 'none';
            document.getElementById('mostrarPagamentos').style.display = 'none';
            document.getElementById('mostrarLocalizacao').style.display = 'none';
            document.getElementById('mostrarDocumentos').style.display = 'block';
        }
        
    
        function toggleActiveClass(element) {
            // Remove a classe 'active' de todos os elementos com a classe 'active'
            document.querySelectorAll('.active').forEach(function (el) {
                el.classList.remove('active');
            });
    
            // Adiciona a classe 'active' ao elemento atual
            element.classList.add('active');
        }
