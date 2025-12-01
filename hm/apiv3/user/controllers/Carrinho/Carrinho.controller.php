<?php

require_once MODELS . '/Carrinho/Carrinho.class.php';
//require_once MODELS . '/Produtos/Produtos.class.php';
// require_once MODELS . '/Pedidos/Pedidos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/CarrinhoHelper.class.php';


class CarrinhoController
{

    public function __construct()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
    }


    public function add_item_carrinho()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();

        //limpa carrinho
        $del = $carrinho->limparCarrinho($this->input->id_carrinho);

        foreach($this->input->produtos as $value){
            $result = $carrinho->addItem($this->input->id_carrinho, $value->id, moneySQL($value->valor));
        }



        jsonReturn(array($result));
    }

    // public function add_item_carrinho_derivados()
    // {

    //     $this->secure->tokens_secure($this->input->token);

    //     $carrinho =  new Carrinho();

    //     $result = $carrinho->addItemDerivados($this->input->id_item, $this->input->id_derivado, $this->input->qtd_derivado);

    //     jsonReturn(array($result));
    // }

    public function list_itens_carrinho()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();

        $itens['itens'] = $carrinho->itenscarrinho($this->input->id_carrinho);

        //Conta qtd no carrinho

        $qtd_atual = 0;
        $valor_total = 0;
        $valor_minimo=0;

        foreach ($itens['itens'] as $item) {

            $valor_total =  $valor_total + moneySQL($item['valor']);

        }

        $itens['valor_total'] = moneyView($valor_total);



        jsonReturn($itens);



    }

    public function carrinho_aberto()
    {
        $this->secure->tokens_secure($this->input->token);
        $carrinho =  new Carrinho();

        $result = $carrinho->carrinhoAberto($this->input->id_user);

        if ($result['carrinho_aberto'] == "") {
            $carrinhoOBJ['carrinho_aberto'] = $carrinho->save($this->input->id_user);
        } else {
            $carrinhoOBJ = $result;
        }

        jsonReturn(array($carrinhoOBJ));
    }

    public function update_item_carrinho()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();
        $produtos =  new Produtos();

        $id_produto =  $carrinho->getIdProduto($this->input->id);
        $DadosProduto = $produtos->getEstoque($id_produto);

        $qtd = 1;

        if ($this->input->op == 1) { // +

                if ($DadosProduto['estoque'] == 1) {

                  $qtd_final = $carrinho->getQtd($this->input->id);

                  if($DadosProduto['qtd'] < $qtd_final){

                    $array['status'] = '02';
                    $array['msg'] = 'Produto não possui estoque.';

                    jsonReturn(array($array));

                    exit;

                  }else{

                    $qtd_final = $qtd_final + 1;
                    $qtd_final_produto = $DadosProduto['qtd'] - 1;

                  }

                }else{
                  $qtd_final =  $carrinho->getQtd($this->input->id) + $qtd;
                }


        }
        if($this->input->op == 2) {

            $qtd_produto =  $carrinho->getQtd($this->input->id);

            if ($qtd_produto == 1) {

                $qtd_final = 1;
                $qtd_final_produto = $DadosProduto['qtd'];
            } else {
                $qtd_final =  $qtd_produto - $qtd;
                $qtd_final_produto = $DadosProduto['qtd'] + 1;
            }
        }
        if($this->input->valor > 0){
            $qtd_final =  $this->input->valor;
        }

        // print_r($qtd_final);exit;
        $result = $carrinho->updateItem($this->input->id, $qtd_final);
        $result2 = $produtos->updateQTD($id_produto, $qtd_final_produto);

        jsonReturn(array($result));
    }

    public function delete_item_carrinho()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();


        $result = $carrinho->removeItem($this->input->id);

        jsonReturn(array($result));
    }

    public function limparCarrinho()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();


        $result = $carrinho->limparCarrinho($this->input->id_carrinho);

        jsonReturn(array($result));
    }

    public function nomear()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();

        $result = $carrinho->nomear(
          $this->input->id,
          cryptitem($this->input->nome),
          cryptitem($this->input->email),
          cryptitem($this->input->celular)
        );

        jsonReturn(array($result));
    }

    public function leitura()
    {

        $this->secure->tokens_secure($this->input->token);

        $carrinho =  new Carrinho();

        $result = $carrinho->leitura(cryptitem($this->input->qrcode));

        jsonReturn(array($result));
    }


    // public function search_carrinho_aberto()
    // {
    //     $carrinho =  new Carrinho();

    //     $result = $carrinho->verificaCarrinhoAberto($this->input->id_user);

    //     jsonReturn(array($result));
    // }

    // public function addcupom()
    // {

    //     $this->secure->tokens_secure($this->input->token);

    //     $carrinho =  new Carrinho();

    //     $result = $carrinho->addCupom($this->input->id_item, moneySQL($this->input->valor_desc), $this->input->cod);

    //     jsonReturn(array($result));
    // }
}
