
        function showInfoGerais() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'block';
            document.getElementById('alterarSenha').style.display = 'none';
            
        }
    
        function showAlterarSenha() {
            toggleActiveClass(event.currentTarget);
            document.getElementById('infoGerais').style.display = 'none';
            document.getElementById('alterarSenha').style.display = 'block';
        }
        
        
    
        function toggleActiveClass(element) {
            // Remove a classe 'active' de todos os elementos com a classe 'active'
            document.querySelectorAll('.active').forEach(function (el) {
                el.classList.remove('active');
            });
    
            // Adiciona a classe 'active' ao elemento atual
            element.classList.add('active');
        }
