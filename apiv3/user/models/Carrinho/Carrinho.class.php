<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
// require_once MODELS . '/Produtos/Produtos.class.php';

class Carrinho extends Conexao
{

    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        // $this->helper = new CarrinhoHelper();
        $this->tabela_carrinho = "app_carrinho";
        $this->tabela_carrinho_conteudo = "app_carrinho_conteudo";
    }

    public function calc($valor, $qtd)
    {
        $valor_total = ($qtd * $valor);
        return $valor_total;
    }

    public function carrinhoAberto($id_user)
    {

        $sql = $this->mysqli->prepare("
        SELECT id
        FROM app_carrinho
        WHERE app_users_id='$id_user'
        and status=1
        ORDER BY id DESC
        LIMIT 1
        ");
        $sql->execute();
        $sql->bind_result($this->id_aberto);
        $sql->store_result();
        $sql->fetch();

        return array("carrinho_aberto" => $this->id_aberto);
    }

    public function addItem($id_carrinho, $id_type, $valor)
    {

        $sql = $this->mysqli->prepare("INSERT INTO `$this->tabela_carrinho_conteudo` (app_carrinho_id, app_anuncios_ing_types_id, valor, lido)
        VALUES ('$id_carrinho', '$id_type', '$valor', '2')");

        $sql->execute();

        $id_novo_item = $sql->insert_id;

        if ($id_novo_item != 0) {
            $array['status'] = '01';
            $array['msg'] = 'Ingresso(s) inseridos no carrinho.';
            $array['id'] = $id_novo_item;
        } else {
            $array['status'] = '02';
            $array['msg'] = 'Um erro inesperado aconteceu.';
        }

        return $array;
    }

    public function addItemDerivados($id_item, $id_derivado, $qtd)
    {

        $sql = $this->mysqli->prepare("INSERT INTO `$this->tabela_carrinho_conteudo_derivados` (id_carrinho_conteudo, id_derivado, qtd)
        VALUES ('$id_item', '$id_derivado', '$qtd')");

        $sql->execute();
    }

    public function updateItem($id, $qtd)
    {


        $sql = $this->mysqli->prepare("UPDATE `$this->tabela_carrinho_conteudo` set qtd = '$qtd'  WHERE id = '$id'");

        $sql->execute();

        $array['status'] = '01';
        $array['msg'] = 'Produto Atualizado.';

        return $array;
    }
    public function updateItemInsert($id, $qtd)
    {

        $sql = $this->mysqli->prepare("UPDATE `$this->tabela_carrinho_conteudo` set qtd = qtd+$qtd  WHERE id = '$id'");

        $sql->execute();

        $array['status'] = '01';
        $array['msg'] = 'Produto Atualizado.';

        return $array;
    }

    public function verificaCarrinhoAberto($id_user)
    {

        $sql = $this->mysqli->prepare("
        SELECT id
        FROM app_carrinho
        WHERE status=1 and id_de='$id_user'
        ORDER BY id DESC
        LIMIT 1
        ");
        $sql->execute();
        $sql->bind_result($this->id_aberto);
        $sql->store_result();
        $sql->fetch();

        return array("carrinho_aberto_encontrado" => $this->id_aberto);
    }

    public function save($app_users_id)
    {

        $status = 1;

        $sql = $this->mysqli->prepare("INSERT INTO `$this->tabela_carrinho` (app_users_id, data, status) VALUES ('$app_users_id', '$this->data_atual', '$status')");
        $sql->execute();
        $id_novo = $sql->insert_id;

        return $id_novo;
    }

    public function itensCarrinho($id_carrinho)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.valor, b.tipo, b.nome
        FROM `app_carrinho_conteudo` as a
        INNER JOIN `app_anuncios_ing_types` as b ON a.app_anuncios_ing_types_id = b.id
        WHERE a.app_carrinho_id = '$id_carrinho'
        GROUP BY a.id

        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->valor, $this->tipo, $this->nome);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        } else {
            while ($row = $sql->fetch()) {

                $param['id'] = $this->id;
                $param['nome_ingresso'] = $this->nome;
                $param['tipo'] = tipoIngressos($this->tipo);
                $param['valor'] = moneyView($this->valor);


                $lista[] = $param;
            }
        }
        return $lista;
    }

    public function itensCarrinhoDerivado($id_item)
    {

        $produto = new Produtos();

        $sql = $this->mysqli->prepare("
        SELECT cart_deriv.qtd, prod_deriv.nome
        FROM `$this->tabela_carrinho_conteudo_derivados` as cart_deriv
        LEFT JOIN `$produto->tabela_derivados` as prod_deriv on cart_deriv.id_derivado = prod_deriv.id
        WHERE cart_deriv.id_carrinho_conteudo = '$id_item'


        ");
        $sql->execute();
        $sql->bind_result($this->qtd_derivado, $this->nome_derivado);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $param['rows'] = $rows;
            $derivados[] = $param;
        } else {
            while ($row = $sql->fetch()) {
                $param['nome_derivado'] = $this->nome_derivado;
                $param['qtd_derivado'] = $this->qtd_derivado;
                $derivados[] = $param;
            }
        }
        return $derivados;
    }

    public function itensPesoComprimentoLarguraAltura($id_carrinho)
    {

        $produto = new Produtos();

        $sql = $this->mysqli->prepare("
        SELECT cart.id, cart.app_carrinho_id, cart.app_produtos_id, prod.nome, prod.peso * cart.qtd, prod.comprimento * cart.qtd, prod.largura * cart.qtd, prod.altura * cart.qtd
        FROM `$this->tabela_carrinho_conteudo` as cart
        LEFT JOIN `$produto->tabela_produtos` as prod on prod.id = cart.app_produtos_id
        WHERE cart.app_carrinho_id = '$id_carrinho'

        ");
        $sql->execute();
        $sql->bind_result($this->id_item, $this->id_carrinho, $this->id_produto, $this->nome_produto, $this->peso_total, $this->comprimento_total, $this->largura_total, $this->altura_total);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        } else {
            while ($row = $sql->fetch()) {
                $param['AmountPackages'] = 1;
                $param['Weight'] = $this->peso_total;
                $param['Length'] = $this->comprimento_total;
                $param['Height'] = $this->largura_total;
                $param['Width'] = $this->altura_total;

                $lista[] = $param;
            }
        }
        return $lista;
    }

    public function valorTotalCarrinho($id_carrinho)
    {

        $sql = $this->mysqli->prepare("SELECT sum(valor) FROM `$this->tabela_carrinho_conteudo` WHERE app_carrinho_id='$id_carrinho'");
        $sql->execute();
        $sql->bind_result($this->total_carrinho);
        $sql->store_result();
        $sql->fetch();

        return $this->total_carrinho;
    }
    public function categoriaByCarrinho($id_carrinho)
    {

        $sql = $this->mysqli->prepare("SELECT b.id_categoria
        FROM `$this->tabela_carrinho`AS a
        INNER JOIN `app_users` AS b  ON a.app_users_id = b.id
         WHERE a.id='$id_carrinho'");
        $sql->execute();
        $sql->bind_result($this->id_categoria);
        $sql->store_result();
        $sql->fetch();

        // print_r($this->id_categoria);exit;
        return $this->id_categoria;
    }

    public function verificaStatus($valor_minimo,$valor_atual,$qtd_minimo,$qtd_atual)
    {
        if( (($valor_minimo > 0) AND ($valor_minimo <= $valor_atual))       OR      (($qtd_minimo > 0) AND ( $qtd_minimo <= $qtd_atual))){
            $resultado = 1;
        }
        else{
            $resultado = 2;
        }

        return $resultado;
    }
    public function verificaQtdMinima($id_categoria)
    {

        $sql = $this->mysqli->prepare("SELECT qtd_minima FROM `app_categorias` WHERE id='$id_categoria'");
        $sql->execute();
        $sql->bind_result($this->qtd_minima);
        $sql->store_result();
        $sql->fetch();

        return $this->qtd_minima;
    }
    public function verificaValorMinimo($id_categoria)
    {

        $sql = $this->mysqli->prepare("SELECT valor_minimo FROM `app_categorias` WHERE id='$id_categoria'");
        $sql->execute();
        $sql->bind_result($this->valor_minimo);
        $sql->store_result();
        $sql->fetch();


        return ($this->valor_minimo);
    }
    public function valorTotalCarrinhoCupom($id_carrinho, $perc)
    {

        $sql = $this->mysqli->prepare("SELECT sum(valor_total) FROM `$this->tabela_carrinho_conteudo` WHERE app_carrinho_id='$id_carrinho'");
        $sql->execute();
        $sql->bind_result($this->total_carrinho);
        $sql->store_result();
        $sql->fetch();

        $valor_com_desconto = $this->total_carrinho - (($this->total_carrinho * $perc) / 100);
        $valor_desconto = $this->total_carrinho * ($perc / 100);

        $array['total'] = $valor_com_desconto;
        $array['valor_desconto'] = $valor_desconto;

        return $array;

    }

    public function verificaItem($id_carrinho,$id_produto)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_carrinho_conteudo` WHERE app_carrinho_id='$id_carrinho' AND app_produtos_id='$id_produto'");
        $sql->execute();
        $sql->bind_result($this->id_conteudo);
        $sql->store_result();
        $rows = $sql->num_rows();
        $sql->fetch();

        return $this->id_conteudo ;
    }

    public function pesoTotalCarrinho($id_carrinho)
    {

        $produto = new Produtos();

        $sql = $this->mysqli->prepare("
        SELECT SUM(prod.peso * cart.qtd) AS peso_total
        FROM `$this->tabela_carrinho_conteudo` as cart
        LEFT JOIN `$produto->tabela_produtos` as prod on prod.id = cart.app_produtos_id
        WHERE cart.app_carrinho_id = '$id_carrinho'
        ");
        $sql->execute();
        $sql->bind_result($this->peso_total_carrinho);
        $sql->store_result();
        $sql->fetch();

        return $this->peso_total_carrinho;
    }

    public function getIdProduto($id)
    {

        $sql = $this->mysqli->prepare("SELECT app_produtos_id FROM `$this->tabela_carrinho_conteudo` WHERE id='$id'");
        $sql->execute();
        $sql->bind_result($this->id_produto);
        $sql->store_result();
        $sql->fetch();

        return $this->id_produto;
    }

    public function getQtd($id)
    {

        $sql = $this->mysqli->prepare("SELECT qtd FROM `$this->tabela_carrinho_conteudo` WHERE id='$id'");
        $sql->execute();
        $sql->bind_result($this->qtd);
        $sql->store_result();
        $sql->fetch();

        return $this->qtd;
    }

    public function buscarCarrinho($id)
    {

        $sql = $this->mysqli->prepare("SELECT app_carrinho_id FROM `app_pedidos` WHERE id='$id'");
        $sql->execute();
        $sql->bind_result($this->carrinho_id);
        $sql->store_result();
        $sql->fetch();

        // print_r($this->carrinho_id);exit;
        return $this->carrinho_id;
    }

    public function buscarCarrinhoToken($token)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id_carrinho
        FROM `app_pedidos` as a
        INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
        WHERE b.token='$token'
         ");
        $sql->execute();
        $sql->bind_result($this->carrinho_id);
        $sql->store_result();
        $sql->fetch();

        // print_r($this->carrinho_id);exit;
        return $this->carrinho_id;
    }

    public function removeItem($id)
    {

        $sql = $this->mysqli->prepare("DELETE FROM `$this->tabela_carrinho_conteudo` WHERE id='$id'");

        $sql->execute();

        $array['status'] = '01';
        $array['msg'] = 'Ingresso removido.';

        return $array;
    }


    public function limparCarrinho($id_carrinho)
    {

        $sql = $this->mysqli->prepare("DELETE FROM `$this->tabela_carrinho_conteudo` WHERE app_carrinho_id='$id_carrinho'");

        $sql->execute();

        $array['status'] = '01';
        $array['msg'] = 'O carrinho está vazio.';

        return $array;
    }

    public function fecharCarrinho($id_carrinho)
    { // atualizar na notificação do pagamento caso seja aprovado

        $sql_cadastro = $this->mysqli->prepare("UPDATE `$this->tabela_carrinho` SET status='2' WHERE id='$id_carrinho'");
        $sql_cadastro->execute();
    }

    public function VerificaCupom($cupom, $id)
    {


      $sql = $this->mysqli->prepare("SELECT perc, data_validade FROM `$this->tabela_cupons` WHERE id_user='$id' AND cod='$cupom'");
        $sql->execute();
        $sql->bind_result($this->perc, $this->data_validade);
        $sql->store_result();
        $rows = $sql->num_rows();
        $sql->fetch();

        $array['rows'] = $rows;
        $array['data_validade'] = $this->data_validade;
        $array['perc'] = $this->perc;

        return $array;
    }

    public function CountIngressos($id_carrinho)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_carrinho_conteudo` WHERE app_carrinho_id='$id_carrinho'");
        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        } else {
            while ($row = $sql->fetch()) {

                $param['id'] = $id;
                $param['rows'] = $rows;

                $lista[] = $param;
            }
        }
        return $lista;
    }

    public function updateIngressos($id, $qrcode)
    {


        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_carrinho_conteudo` SET qrcode='$qrcode' WHERE id='$id'");
        $sql_cadastro->execute();
    }

    public function validaQrcode($qrcode)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.valor, a.nome, a.email, a.celular, a.lido, b.tipo, b.nome, c.app_anuncios_id
        FROM `app_carrinho_conteudo` as a
        INNER JOIN `app_anuncios_ing_types` as b ON a.app_anuncios_ing_types_id = b.id
        INNER JOIN `app_reservas` as c ON a.app_carrinho_id = c.id_carrinho
        WHERE a.qrcode='$qrcode'
        ");
        $sql->execute();
        $sql->bind_result($valor,$nome,$email,$celular,$lido,$tipo,$nome_ingresso,$id_anuncio);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $array['status'] = '02';
            $array['msg'] = 'QRCODE inválido, tente outros dados';

        }
        elseif ($lido == 1) {
          $array['status'] = '02';
          $array['msg'] = 'QRCODE já validado, tente outros dados';
        }

        elseif ($nome == null) {
          $array['status'] = '02';
          $array['msg'] = 'Você precisa nomear seu ingresso, para depois efetuar a leitura.';
        }
        else{


          $model_anuncios = New Anuncios();

          $array['status'] = '01';
          $array['msg'] = 'QRCODE válido';
          $array['nome'] = decryptitem($nome);
          $array['email'] = decryptitem($email);
          $array['celular'] = decryptitem($celular);
          $array['tipo'] = tipoIngressos($tipo);
          $array['nome_ingresso'] = $nome_ingresso;
          $array['valor'] = moneyView($valor);
          $array['nome'] = decryptitem($nome);
          $array['anuncio'] = $model_anuncios->listID($id_anuncio);
        }

        return $array;
    }

    public function nomear($id, $nome, $email, $celular)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_carrinho_conteudo` SET nome='$nome', email='$email', celular='$celular' WHERE id='$id'");
        $sql_cadastro->execute();

        $array['status'] = 01;
        $array['nome'] = decryptitem($nome);
        $array['email'] = decryptitem($email);
        $array['celular'] = decryptitem($celular);
        $array['msg'] = "Ingresso nomeado com sucesso.";

        return $array;
    }

    /**
     * Nomear ingresso e enviar por email
     */
    public function nomearComEmail($id, $nome, $email, $celular)
    {
        // Atualiza dados do portador
        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_carrinho_conteudo` SET nome=?, email=?, celular=? WHERE id=?");
        $sql_cadastro->bind_param("sssi", $nome, $email, $celular);
        $sql_cadastro->execute();

        // Busca dados completos do ingresso para enviar por email
        $dados_ingresso = $this->getDadosIngressoCompleto($id);

        if (!$dados_ingresso) {
            return [
                'status' => '02',
                'msg' => 'Ingresso não encontrado.'
            ];
        }

        // Envia email com o ingresso
        $emailService = new Emails();
        $email_enviado = $emailService->enviarIngresso(
            decryptitem($email),
            decryptitem($nome),
            $dados_ingresso
        );

        return [
            'status' => '01',
            'nome' => decryptitem($nome),
            'email' => decryptitem($email),
            'celular' => decryptitem($celular),
            'email_enviado' => $email_enviado ? true : false,
            'msg' => $email_enviado ? "Ingresso nomeado e enviado por email com sucesso." : "Ingresso nomeado, mas houve falha no envio do email."
        ];
    }

    /**
     * Buscar dados completos do ingresso para email
     */
    public function getDadosIngressoCompleto($id_ingresso)
    {
        $sql = $this->mysqli->prepare("
            SELECT 
                cc.id,
                cc.qrcode,
                cc.valor,
                cc.nome as nome_portador,
                cc.email as email_portador,
                cc.celular as celular_portador,
                ait.nome as tipo_ingresso,
                a.nome as nome_evento,
                a.data_in as data_evento,
                a.checkin as hora_evento
            FROM app_carrinho_conteudo cc
            INNER JOIN app_anuncios_ing_types ait ON cc.app_anuncios_ing_types_id = ait.id
            INNER JOIN app_anuncios a ON ait.app_anuncios_id = a.id
            WHERE cc.id = ?
        ");
        $sql->bind_param("i", $id_ingresso);
        $sql->execute();
        $result = $sql->get_result();

        if ($row = $result->fetch_assoc()) {
            // Formata a data do evento
            $data_formatada = '';
            if (!empty($row['data_evento'])) {
                $data = new DateTime($row['data_evento']);
                $data_formatada = $data->format('d/m/Y');
                if (!empty($row['hora_evento'])) {
                    $data_formatada .= ' às ' . substr($row['hora_evento'], 0, 5);
                }
            }

            // Tenta decriptar o qrcode, se falhar usa o valor original
            $qrcode_valor = '';
            if (!empty($row['qrcode'])) {
                $decrypted = @decryptitem($row['qrcode']);
                $qrcode_valor = !empty($decrypted) ? $decrypted : $row['qrcode'];
            }

            return [
                'id' => $row['id'],
                'qrcode' => $qrcode_valor,
                'valor' => floatval($row['valor']),
                'tipo_ingresso' => $row['tipo_ingresso'],
                'nome_evento' => $row['nome_evento'],
                'local' => 'Consulte o evento para mais informações',
                'data_evento' => $data_formatada ?: 'A definir'
            ];
        }

        return null;
    }

    /**
     * Reenviar ingresso por email
     */
    public function reenviarIngresso($id_ingresso)
    {
        // Busca dados do ingresso
        $sql = $this->mysqli->prepare("SELECT nome, email FROM app_carrinho_conteudo WHERE id = ?");
        $sql->bind_param("i", $id_ingresso);
        $sql->execute();
        $result = $sql->get_result();
        $ingresso = $result->fetch_assoc();

        if (!$ingresso || empty($ingresso['nome']) || empty($ingresso['email'])) {
            return [
                'status' => '02',
                'msg' => 'Ingresso não nomeado. Nomeie o ingresso antes de reenviar.'
            ];
        }

        $dados_ingresso = $this->getDadosIngressoCompleto($id_ingresso);

        if (!$dados_ingresso) {
            return [
                'status' => '02',
                'msg' => 'Ingresso não encontrado.'
            ];
        }

        // Envia email
        $emailService = new Emails();
        $email_enviado = $emailService->enviarIngresso(
            decryptitem($ingresso['email']),
            decryptitem($ingresso['nome']),
            $dados_ingresso
        );

        return [
            'status' => $email_enviado ? '01' : '02',
            'msg' => $email_enviado ? 'Ingresso reenviado com sucesso.' : 'Falha ao reenviar ingresso.'
        ];
    }

    /**
     * Listar ingressos de uma reserva/carrinho
     */
    public function listarIngressosReserva($id_carrinho)
    {
        $sql = $this->mysqli->prepare("
            SELECT 
                cc.id,
                cc.qrcode,
                cc.valor,
                cc.nome,
                cc.email,
                cc.celular,
                cc.lido,
                ait.nome as tipo_ingresso,
                a.nome as nome_evento
            FROM app_carrinho_conteudo cc
            INNER JOIN app_anuncios_ing_types ait ON cc.app_anuncios_ing_types_id = ait.id
            INNER JOIN app_anuncios a ON ait.app_anuncios_id = a.id
            WHERE cc.app_carrinho_id = ?
        ");
        $sql->bind_param("i", $id_carrinho);
        $sql->execute();
        $result = $sql->get_result();

        $ingressos = [];
        while ($row = $result->fetch_assoc()) {
            $ingressos[] = [
                'id' => $row['id'],
                'tipo_ingresso' => $row['tipo_ingresso'],
                'nome_evento' => $row['nome_evento'],
                'valor' => number_format($row['valor'], 2, ',', '.'),
                'nomeado' => !empty($row['nome']),
                'nome_portador' => $row['nome'] ? decryptitem($row['nome']) : null,
                'email_portador' => $row['email'] ? decryptitem($row['email']) : null,
                'celular_portador' => $row['celular'] ? decryptitem($row['celular']) : null,
                'validado' => $row['lido'] == 1,
                'qrcode' => $row['qrcode'] ? decryptitem($row['qrcode']) : null
            ];
        }

        return $ingressos;
    }

    public function leitura($qrcode){

        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_carrinho_conteudo` SET lido='1' WHERE qrcode='$qrcode'");
        $sql_cadastro->execute();

        $array['status'] = 01;
        $array['msg'] = "Ingresso validado com sucesso.";

        return $array;
    }

    public function IngressosInfo($id_anuncio){

      $sql = $this->mysqli->prepare("
          SELECT
          (SELECT COUNT(c.id) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED')) as qtd_total,

          (SELECT SUM(c.valor) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED')) as valor_total,


          (SELECT COUNT(c.id) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='1') as qtd_masc_total,

          (SELECT SUM(c.valor) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='1') as valor_masc_total,

          (SELECT COUNT(c.id) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='2') as qtd_fem_total,

          (SELECT SUM(c.valor) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='2') as valor_fem_total,

          (SELECT COUNT(c.id) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='3') as qtd_ambos_total,

          (SELECT SUM(c.valor) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND d.tipo='3') as valor_ambos_total,

          (SELECT COUNT(c.id) FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
          INNER JOIN `app_anuncios_ing_types` as d ON c.app_anuncios_ing_types_id = d.id
          WHERE a.app_anuncios_id='$id_anuncio' AND b.status IN('CONFIRMED', 'RECEIVED') AND c.lido='1') as qtd_validados



      ");

      $sql->execute();
      $sql->bind_result(
        $qtd_total,
        $valor_total,
        $qtd_masc_total,
        $valor_masc_total,
        $qtd_fem_total,
        $valor_fem_total,
        $qtd_ambos_total,
        $valor_ambos_total,
        $qtd_validados
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $usuarios = [];

      if ($rows == 0) {
          $Param['rows'] = $rows;
          array_push($usuarios, $Param);
      } else {
          while ($sql->fetch()) {

              $Param['qtd_total'] = $qtd_total;
              $Param['valor_total'] = moneyView($valor_total);
              $Param['qtd_masc_total'] = $qtd_masc_total;
              $Param['valor_masc_total'] = moneyView($valor_masc_total);
              $Param['qtd_fem_total'] = $qtd_fem_total;
              $Param['valor_fem_total'] = moneyView($valor_fem_total);
              $Param['qtd_ambos_total'] = $qtd_ambos_total;
              $Param['valor_ambos_total'] = moneyView($valor_ambos_total);
              $Param['qtd_validados'] = $qtd_validados;

              array_push($usuarios, $Param);
          }
      }

      return $usuarios;
}

}
