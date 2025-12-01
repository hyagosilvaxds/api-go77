<?php

require_once MODELS . '/Paginas.class.php';

class PaginasController extends Paginas
{

    public function __construct()
    {
        $this->model = new Paginas();
    }

    //comissoes
    public function comissoes()
    {
        $this->load = load_view($action = 'comissoes', null, null, null, null);
    }
    //pagamentos
    public function pagamentos()
    {
        $this->load = load_view($action = 'pagamentos', null, null, null, null);
    }
    //categoriasR
    public function categoriasR()
    {
        $this->load = load_view($action = 'categoriasR', null, null, null, null);
    }
    //testeee
    public function testeee()
    {
        $this->load = load_view($action = 'testeee', null, null, null, null);
    }
    //financeiroD
    public function financeiroD()
    {
        $this->load = load_view($action = 'financeiroD', null, null, null, null);
    }
    //comprasD
    public function comprasD()
    {
        $this->load = load_view($action = 'comprasD', null, null, null, null);
    }
    //recibosD
    public function recibosD()
    {
        $this->load = load_view($action = 'recibosD', null, null, null, null);
    }
    //agendamentosD
    public function agendamentosD()
    {
        $this->load = load_view($action = 'agendamentosD', null, null, null, null);
    }
    //produtosC
    public function produtosC()
    {
        $this->load = load_view($action = 'produtosC', null, null, null, null);
    }
    //produtosSC
    public function produtosSC()
    {
        $this->load = load_view($action = 'produtosSC', null, null, null, null);
    }
    //subcategorias
    public function subcategorias()
    {
        $this->load = load_view($action = 'subcategorias', null, null, null, null);
    }
    //shop
    public function shop()
    {
        $this->load = load_view($action = 'shop', null, null, null, null);
    }
    //shopD
    public function shopD()
    {
        $this->load = load_view($action = 'shopD', null, null, null, null);
    }
    //financeiro
    public function financeiro()
    {
        $this->load = load_view($action = 'financeiro', null, null, null, null);
    }
    //log
    public function log()
    {
        $this->load = load_view($action = 'log', null, null, null, null);
    }
    //permissoes
    public function permissoes()
    {
        $this->load = load_view($action = 'permissoes', null, null, null, null);
    }
    //usuarios
    public function usuarios()
    {
        $this->load = load_view($action = 'usuarios', null, null, null, null);
    }
    //configuracoes
    public function configuracoes()
    {
        $this->load = load_view($action = 'configuracoes', null, null, null, null);
    }
    //cadastros
    public function cadastros()
    {
        $this->load = load_view($action = 'cadastros', null, null, null, null);
    }
    //cadastrosD
    public function cadastrosD()
    {
        $this->load = load_view($action = 'cadastrosD', null, null, null, null);
    }

        //pedidos
        public function pedidos()
        {
            $this->load = load_view($action = 'pedidos', null, null, null, null);
        }
        //pedidosD
        public function pedidosD()
        {
            $this->load = load_view($action = 'pedidosD', null, null, null, null);
        }
            //compras
        public function anuncios()
        {
            $this->load = load_view($action = 'anuncios', null, null, null, null);
        }
        public function anunciosP()
        {
            $this->load = load_view($action = 'anunciosP', null, null, null, null);
        }
        public function anunciosD()
        {
            $this->load = load_view($action = 'anunciosD', null, null, null, null);
        }



        //cadastros
        public function fornecedores()
        {
            $this->load = load_view($action = 'fornecedores', null, null, null, null);
        }
        //fornecedoresD
        public function fornecedoresD()
        {
            $this->load = load_view($action = 'fornecedoresD', null, null, null, null);
        }

    //cadastros
    public function franqueados()
    {
        $this->load = load_view($action = 'franqueados', null, null, null, null);
    }
    //franqueadosD
    public function franqueadosD()
    {
        $this->load = load_view($action = 'franqueadosD', null, null, null, null);
    }

    //profissionais
    public function profissionais()
    {
        $this->load = load_view($action = 'profissionais', null, null, null, null);
    }
    //profissionaisD
    public function profissionaisD()
    {
        $this->load = load_view($action = 'profissionaisD', null, null, null, null);
    }
    //profissionaisP
    public function profissionaisP()
    {
        $this->load = load_view($action = 'profissionaisP', null, null, null, null);
    }
    //estabelecimentos
    public function estabelecimentos()
    {
        $this->load = load_view($action = 'estabelecimentos', null, null, null, null);
    }
    //estabelecimentos
    public function estatisticas()
    {
        $this->load = load_view($action = 'estatisticas', null, null, null, null);
    }
    //estabelecimentosD
    public function estabelecimentosD()
    {
        $this->load = load_view($action = 'estabelecimentosD', null, null, null, null);
    }
    //estabelecimentosP
    public function estabelecimentosP()
    {
        $this->load = load_view($action = 'estabelecimentosP', null, null, null, null);
    }
    //banners
    public function banners()
    {
        $this->load = load_view($action = 'banners', null, null, null, null);
    }
    //segmentos
    public function segmentos()
    {
        $this->load = load_view($action = 'segmentos', null, null, null, null);
    }
    //CATEGORIAS
    public function categorias()
    {
        $this->load = load_view($action = 'categorias', null, null, null, null);
    }
    //SETORES
    public function setores()
    {
        $this->load = load_view($action = 'setores', null, null, null, null);
    }
    //CADASTRO DE VENDAS
    public function cadastro_venda()
    {
        $this->load = load_view($action = 'cadastro-venda', null, null, null, null);
    }
    //UPDATE DE PRODUTO
    public function update_produto()
    {
        $this->load = load_view($action = 'update-produto', null, null, null, null);
    }
    //CADASTRO DE PRODUTO
    public function cadastro_produto()
    {
        $this->load = load_view($action = 'cadastro-produto', null, null, null, null);
    }
    //UPDATE VENDA
    public function update_venda()
    {
        $this->load = load_view($action = 'update-venda', null, null, null, null);
    }
    //VENDAS
    public function geral()
    {
        $this->load = load_view($action = 'geral', null, null, null, null);
    }
    public function notificacoes()
    {
        $this->load = load_view($action = 'notificacoes', null, null, null, null);
    }
    public function planos()
    {
        $this->load = load_view($action = 'planos', null, null, null, null);
    }
    public function vendas()
    {
        $this->load = load_view($action = 'vendas', null, null, null, null);
    }
    public function dashboard()
    {
        $this->load = load_view($action = 'dashboard', null, null, null, null);
    }
    //CLIENTES
    public function clientes()
    {
        $this->load = load_view($action = 'clientes', null, null, null, null);
    }
    //AGENDA
    public function horario()
    {
        $this->load = load_view($action = 'horario', null, null, null, null);
    }
    public function agendamentos()
    {
        $this->load = load_view($action = 'agendamentos', null, null, null, null);
    }
    //SUCESSO
    public function sucesso()
    {
        $this->load = load_view($action = 'sucesso', null, null, null, null);
    }
    //PRODUTOS
    public function produtos()
    {
        $this->load = load_view($action = 'produtos', null, null, null, null);
    }
    //PRODUTOS COTAÇÃO
    public function produtos_cotacao()
    {
        $this->load = load_view($action = 'produtos-cotacao', null, null, null, null);
    }
    //ENDEREÇOS
    public function dados()
    {
        $this->load = load_view($action = 'dados', null, null, null, null);
    }
    //MARTELO STEP-1
    public function step1_martelo()
    {
        $this->load = load_view($action = 'step1-martelo', null, null, null, null);
    }
    //MARTELO STEP-2
    public function step2_martelo()
    {
        $this->load = load_view($action = 'step2-martelo', null, null, null, null);
    }
    //PAGAMENTO STEP-1
    public function step_1()
    {
        $this->load = load_view($action = 'step-1', null, null, null, null);
    }
    //PAGAMENTO STEP-2
    public function step_2()
    {
        $this->load = load_view($action = 'step-2', null, null, null, null);
    }
    //PAGAMENTO
    public function pagamento()
    {
        $this->load = load_view($action = 'pagamento', null, null, null, null);
    }
    //COMPRAS
    public function detalhes_compras()
    {
        $this->load = load_view($action = 'detalhes-compras', null, null, null, null);
    }
    //MARTELO
    public function martelo()
    {
        $this->load = load_view($action = 'martelo', null, null, null, null);
    }
    //DETALHES ORÇAMENTO
    public function detalhes_orcamento()
    {
        $this->load = load_view($action = 'detalhes-orcamento', null, null, null, null);
    }
    //DETALHES COTAÇÃO
    public function detalhes_cotacao()
    {
        $this->load = load_view($action = 'detalhes-cotacao', null, null, null, null);
    }
    //LOGIN
    public function login()
    {
        $this->load = load_view($action = 'login', null, null, null, null);
    }

    //PAINEL
    public function painel()
    {
        $this->load = load_view($action = 'painel', null, null, null, null);
    }
    //recibos
    public function recibos()
    {
        $this->load = load_view($action = 'recibos', null, null, null, null);
    }


    //RECUPERAR
    public function recuperar()
    {
        $this->load = load_view($action = 'recuperar', null, null, null, null);
    }
    //cupons
    public function cupons()
    {
        $this->load = load_view($action = 'cupons', null, null, null, null);
    }

    //CADASTRO
    public function cadastro()
    {
        $this->load = load_view($action = 'cadastro', null, null, null, null);
    }

    //PERFIL
    public function perfil()
    {
        $this->load = load_view($action = 'perfil', null, null, null, null);
    }

    //Cotações
    public function cotacoes()
    {
        $this->load = load_view($action = 'cotacoes', null, null, null, null);
    }

    //adicionar-cotacao
    public function adicionar_cotacao()
    {
        $this->load = load_view($action = 'adicionar-cotacao', null, null, null, null);
    }

    //FILAS
    public function filas()
    {
        $this->load = load_view($action = 'filas', null, null, null, null);
    }

    //FILAS
    public function filas_detalhes()
    {
        $this->load = load_view($action = 'filas-detalhes', null, null, null, null);
    }

    //CARRINHO
    public function carrinho()
    {
        $this->load = load_view($action = 'carrinho', null, null, null, null);
    }
    //AVALIAÇÕES
    public function avaliacoes()
    {
        $this->load = load_view($action = 'avaliacoes', null, null, null, null);
    }


    //AGENDA HORARIOS
    public function agenda_horarios()
    {
        $this->load = load_view($action = 'agenda-horarios', null, null, null, null);
    }
    //AGENDA
    public function agenda()
    {
        $this->load = load_view($action = 'agenda', null, null, null, null);
    }
    //NOVA SENHA
    public function nova_senha()
    {
        $this->load = load_view($action = 'nova-senha', null, null, null, null);
    }
    //RECUPERAR SUCESSO
    public function recuperar_sucesso()
    {
        $this->load = load_view($action = 'recuperar-sucesso', null, null, null, null);
    }
    //RECUPERAR PASSWORD
    public function recuperar_password()
    {
        $this->load = load_view($action = 'recuperar-password', null, null, null, null);
    }
    //CHAMADOS
    public function chamados()
    {
        $this->load = load_view($action = 'chamados', null, null, null, null);
    }
    public function reservas()
    {
        $this->load = load_view($action = 'reservas', null, null, null, null);
    }
    public function reservasD()
    {
        $this->load = load_view($action = 'reservasD', null, null, null, null);
    }
    public function empresasD()
    {
        $this->load = load_view($action = 'empresasD', null, null, null, null);
    }
}
