<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
//require_once MODELS . '/Mp/order.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';

class AnunciosController
{

    public function __construct()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        // gerarLog($this->input);


    }


    public function list()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->list();

        jsonReturn($result);

    }

    public function verifica()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->verifica($this->input->id_user);

        jsonReturn($result);

    }

    public function favoritar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result_favorito = $model->verificaFavorito($this->input->id_anuncio, $this->input->id_user);

        if($result_favorito == 2){
          $result = $model->saveFavorito($this->input->id_anuncio, $this->input->id_user);
        }else{
          $result = $model->excluirFavorito($this->input->id_anuncio, $this->input->id_user);
        }

        jsonReturn($result);

    }

    public function avaliar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->saveAvaliacao($this->input->id_reserva, $this->input->id_anuncio, $this->input->id_user, $this->input->descricao, $this->input->estrelas, $this->input->avaliou);

        jsonReturn($result);

    }

    public function lista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        if(isset($this->input->id_user)){
          $result = $model->mylistID($this->input->id_user);
        }else{
          $result = $model->listID($this->input->id);
        }

        jsonReturn($result);

    }

    public function listaFilter()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Tratar parâmetros opcionais
        $id_user = isset($this->input->id_user) && $this->input->id_user !== '' ? $this->input->id_user : null;
        $latitude = isset($this->input->latitude) && $this->input->latitude !== '' ? floatval($this->input->latitude) : null;
        $longitude = isset($this->input->longitude) && $this->input->longitude !== '' ? floatval($this->input->longitude) : null;
        $id = isset($this->input->id) && $this->input->id !== '' ? $this->input->id : null;

        if($this->input->mais_proximos == 1 && $latitude !== null && $longitude !== null){
          $result = $model->listaProximos($id_user, $latitude, $longitude);
        }elseif($this->input->mais_proximos == 1 && ($latitude === null || $longitude === null)){
          // Sem coordenadas, retornar lista vazia ou lista geral
          $result = array("status" => "01", "anuncios" => array());
        }else{
          $result = $model->listaFilter(
            $id_user,
            $id,
            $latitude,
            $longitude,
            $this->input->id_categoria,
            $this->input->id_subcategoria,
            $this->input->adultos,
            $this->input->criancas,
            $this->input->quartos,
            $this->input->banheiros,
            $this->input->pets,
            $this->input->caracteristicas,
            $this->input->endereco,
            dataUS($this->input->data_de),
            dataUS($this->input->data_ate)
          );
        }

        jsonReturn($result);

    }


    public function adicionar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->adicionar(
          $this->input->id_user,
          $this->input->id_categoria,
          $this->input->id_subcategoria,
          $this->input->nome,
          $this->input->descricao,
          $this->input->checkin,
          $this->input->checkout,
          dataUS($this->input->data_in),
          dataUS($this->input->data_out),
        );


        //caracteristicas
        foreach($this->input->caracteristicas as $carac){
          $result2 = $model->adicionarcarac($result['id'], $carac);
        }

        //endereco
          $cidade_estado = getCityStateFromLatLong($this->input->latitude, $this->input->longitude);

          $id_endereco = $model->adicionarEndereco(
          $result['id'],
          $this->input->endereco,
          $cidade_estado['rua'],
          $cidade_estado['bairro'],
          $cidade_estado['cidade'],
          $cidade_estado['estado'],
          $this->input->numero,
          $this->input->complemento,
          $this->input->referencia,
          $this->input->latitude,
          $this->input->longitude
        );

        jsonReturn($result);

    }

    public function adicionarType()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();


        $result = $model->adicionarType($this->input->id_anuncio, $this->input->nome, $this->input->descricao);
        $id_type = $result['id'];

        //info
        $result2 = $model->adicionarTypeInfo(
          $id_type,
          $this->input->adultos ?? 0,
          $this->input->criancas ?? 0,
          $this->input->quartos ?? 0,
          $this->input->banheiros ?? 0,
          $this->input->pets ?? 0
        );

        //endereco (só adiciona se latitude/longitude foram fornecidos)
        if (!empty($this->input->latitude) && !empty($this->input->longitude)) {
          $cidade_estado = getCityStateFromLatLong($this->input->latitude, $this->input->longitude);

          $id_endereco = $model->adicionarEndereco(
          $result['id'],
          $this->input->endereco ?? '',
          $cidade_estado['rua'] ?? '',
          $cidade_estado['bairro'] ?? '',
          $cidade_estado['cidade'] ?? '',
          $cidade_estado['estado'] ?? '',
          $this->input->numero ?? '',
          $this->input->complemento ?? '',
          $this->input->referencia ?? '',
          $this->input->latitude,
          $this->input->longitude
          );
        }

        //camas (só processa se foi enviado)
        if (!empty($this->input->camas) && is_array($this->input->camas)) {
          foreach ($this->input->camas as $key) {
              $result3 = $model->adicionarTypeCamas($id_type, $key->id, $key->qtd);
          }
        }

        //periodos
        if (!empty($this->input->periodos) && is_array($this->input->periodos)) {
          foreach ($this->input->periodos as $key) {
              $result4 = $model->adicionarTypePeriodos(
                $id_type,
                $key->nome ?? '',
                dataUS($key->data_de ?? ''),
                dataUS($key->data_ate ?? ''),
                moneySQL(trim($key->valor ?? '0')),
                moneySQL(trim($key->taxa_limpeza ?? '0')),
                $key->qtd ?? 0)
                ;
          }
        }

        //update finalizado
        $result5 = $model->finalizar($this->input->id_anuncio);

        jsonReturn($result);

    }

    public function adicionarTypeIng()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->adicionarTypeIng(
          $this->input->id_anuncio,
          $this->input->tipo,
          $this->input->nome,
          moneySQL($this->input->valor),
          $this->input->qtd
        );
        $id_type = $result['id'];

        //update finalizado
        $result5 = $model->finalizar($this->input->id_anuncio);

        jsonReturn($result);

    }

    public function adicionar_imagens()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/anuncios';


        for ($i=0; $i < count($_FILES['url']['tmp_name']); $i++) {

            $this->avatar = renameUpload(basename($_FILES['url']['name'][$i]));
            $this->avatar_tmp = $_FILES['url']['tmp_name'][$i];

            if (!empty($this->avatar)) {

                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

                $imagem = new TutsupRedimensionaImagem();

                $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
                $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

                // print_r($imagem->imagem_destino);exit;

                $imagem->largura = 600;
                $imagem->altura = 0;
                $imagem->qualidade = 100;

                $nova_imagem = $imagem->executa();

                unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
            } else {
                $this->avatar_final = "avatar.png";
            }

            $model = new Anuncios();
            $result = $model->adicionarImagens($this->id, $this->avatar_final);

        }

        jsonReturn($result);
    }

    public function adicionar_imagens_bkp()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/anuncios';


        for ($i=0; $i < count($_FILES['url']['tmp_name']); $i++) {

            $this->avatar = renameUpload(basename($_FILES['url']['name'][$i]));
            $this->avatar_tmp = $_FILES['url']['tmp_name'][$i];

            if (!empty($this->avatar)) {

                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

            }

            $model = new Anuncios();
            $result = $model->adicionarImagens($this->id, $this->avatar_final);

        }

        jsonReturn($result);
    }

    public function update()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->update(
          $this->input->id,
          $this->input->id_categoria,
          $this->input->id_subcategoria,
          $this->input->nome,
          $this->input->descricao,
          $this->input->checkin,
          $this->input->checkout,
          dataUS($this->input->data_in),
          dataUS($this->input->data_out),
          $this->input->status
        );

        //caracteristicas
        $excluir_carac = $model->excluircarac($this->input->id);

        foreach($this->input->caracteristicas as $carac){

          $result2 = $model->adicionarcarac($this->input->id, $carac);

        }

        //endereco
          $cidade_estado = getCityStateFromLatLong($this->input->latitude, $this->input->longitude);

          $id_endereco = $model->updateEndereco(
          $this->input->id,
          $this->input->endereco,
          $cidade_estado['rua'],
          $cidade_estado['bairro'],
          $cidade_estado['cidade'],
          $cidade_estado['estado'],
          $this->input->numero,
          $this->input->complemento,
          $this->input->referencia,
          $this->input->latitude,
          $this->input->longitude
        );

        jsonReturn($result);

    }

    public function updateType()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        //update
        $result = $model->updateType($this->input->id, $this->input->nome, $this->input->descricao, $this->input->status);

        //update info
        $result2 = $model->updateTypeInfo(
          $this->input->id,
          $this->input->adultos,
          $this->input->criancas,
          $this->input->quartos,
          $this->input->banheiros,
          $this->input->pets
        );

        jsonReturn($result);

    }

    public function updateTypeIng()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        //update
        $result = $model->updateTypeIng(
          $this->input->id,
          $this->input->tipo,
          $this->input->nome,
          moneySQL($this->input->valor),
          $this->input->qtd
        );

        jsonReturn($result);

    }

    public function updateCapa()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $excluir_capas = $model->updateCapaAll($this->input->id_anuncio);
        $result = $model->updateCapa($this->input->id);

        jsonReturn($result);

    }


    public function excluir()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluir($this->input->id);

        jsonReturn($result);

    }

    public function excluirType()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirType($this->input->id);

        jsonReturn($result);

    }

    public function excluirTypeIng()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirTypeIng($this->input->id);

        jsonReturn($result);

    }

    public function excluirimagens()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirimagens($this->input->id);

        jsonReturn($result);

    }


    public function adicionar_imagens_type()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/anuncios';


        for ($i=0; $i < count($_FILES['url']['tmp_name']); $i++) {

            $this->avatar = renameUpload(basename($_FILES['url']['name'][$i]));
            $this->avatar_tmp = $_FILES['url']['tmp_name'][$i];

            if (!empty($this->avatar)) {

                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

                $imagem = new TutsupRedimensionaImagem();

                $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
                $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

                // print_r($imagem->imagem_destino);exit;

                $imagem->largura = 600;
                $imagem->altura = 0;
                $imagem->qualidade = 100;

                $nova_imagem = $imagem->executa();

                unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
            } else {
                $this->avatar_final = "avatar.png";
            }

            $model = new Anuncios();
            $result = $model->adicionarImagensType($this->id, $this->avatar_final);

        }

        jsonReturn($result);
    }

    public function excluir_imagens_type()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirImagensType($this->input->id);

        jsonReturn($result);

    }

    public function adicionarCamas()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $verifica_cama = $model->verificaTypeCama($this->input->id_user, $this->input->id_type, $this->input->id);

        if ($verifica_cama) {
            jsonReturn($verifica_cama);
        }

        $result = $model->adicionarTypeCamas(
          $this->input->id_type,
          $this->input->id,
          $this->input->qtd
        );

        jsonReturn($result);

    }

    public function update_camas()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->updateCamas(
          $this->input->id,
          $this->input->qtd
        );


        jsonReturn($result);

    }

    public function excluir_camas()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirCamas($this->input->id);

        jsonReturn($result);

    }

    public function excluir_periodos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirPeriodos($this->input->id);

        jsonReturn($result);

    }

    public function adicionar_periodos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $verifica_datas = $model->verificaTypeDatas($this->input->id_type, $this->input->id, dataUS($this->input->data_de), dataUS($this->input->data_ate));

        if ($verifica_datas) {
            jsonReturn($verifica_datas);
        }

        $result = $model->adicionarTypePeriodos(
          $this->input->id_type,
          $this->input->nome,
          dataUS($this->input->data_de),
          dataUS($this->input->data_ate),
          moneySQL(trim($this->input->valor)),
          moneySQL(trim($this->input->taxa_limpeza)),
          $this->input->qtd
        );


        jsonReturn($result);

    }

    public function update_periodos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $verifica_datas = $model->verificaTypeDatas($this->input->id_type, $this->input->id, dataUS($this->input->data_de), dataUS($this->input->data_ate));

        if ($verifica_datas) {
            jsonReturn(array($verifica_datas));
        }

        $result = $model->updatePeriodos(
          $this->input->id,
          $this->input->nome,
          dataUS($this->input->data_de),
          dataUS($this->input->data_ate),
          moneySQL($this->input->valor),
          moneySQL($this->input->taxa_limpeza),
          $this->input->qtd
        );


        jsonReturn($result);

    }


    //daqui pra baixo outro projeto


    public function cancelar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->cancelar($this->input->id_orcamento);

        jsonReturn($result);

    }

    public function finalizar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->finalizar($this->input->id_orcamento);

        jsonReturn($result);

    }

    //CRUD AMBIENTES
    public function ambientes_add()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->ambientes_add($this->input->id_orcamento, $this->input->nome);

        jsonReturn($result);

    }

    public function ambientes_editar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->ambientes_editar($this->input->id_ambiente, $this->input->nome);

        jsonReturn($result);

    }

    public function ambientes_excluir()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->ambientes_excluir($this->input->id_ambiente);

        jsonReturn($result);

    }

    //CRUD ITENS
    public function itens_add()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->itens_add($this->input->id_ambiente, $this->input->nome);

        jsonReturn($result);

    }

    public function itens_editar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->itens_editar($this->input->id_item, $this->input->tipo, $this->input->m2, $this->input->obs);

        jsonReturn($result);

    }

    public function itens_excluir()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->itens_excluir($this->input->id_item);

        jsonReturn($result);

    }

    //crud brifieng serviços
    public function listbrifiengserv()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listbrifiengserv();

        jsonReturn($result);

    }

    public function brifiengserv_editar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->brifiengserv_editar($this->input->id_item, $this->input->lista);

        jsonReturn($result);

    }

    //crud brifieng produtos
    public function listbrifiengprod()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listbrifiengprod();

        jsonReturn($result);

    }

    public function brifiengprod_editar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->brifiengprod_editar($this->input->id_item, $this->input->lista);

        jsonReturn($result);

    }


    public function itens_imagens_adicionar()
    {

        $this->id_item = $_POST['id_item'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/imagens';


        for ($i=0; $i < count($_FILES['url']['tmp_name']); $i++) {

            $this->avatar = renameUpload(basename($_FILES['url']['name'][$i]));
            $this->avatar_tmp = $_FILES['url']['tmp_name'][$i];

            if (!empty($this->avatar)) {

                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

            }

            $model = new Anuncios();
            $result = $model->itens_imagens_adicionar($this->id_item, $this->avatar_final);

        }

        jsonReturn($result);
    }

    public function itens_imagens_excluir()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->itens_imagens_excluir($this->input->id);

        jsonReturn($result);

    }


    public function minhasViagens()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        //lista oferecidas
        if($this->input->tipo == 1){
            $result = $model->minhasViagensOferecidas($this->input->id_user);
        }else{
            $result = $model->minhasViagens($this->input->id_user);

        }

        jsonReturn($result);
    }

    public function detalhesMinhasViagens()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $verificaMotorista = $model->verificaMotorista($this->input->id_user,$this->input->id_corrida);

        if($verificaMotorista > 0){
            //sou o motorista dessa viagem
            $result = $model->detalhesMinhasViagensMotorista($this->input->id_user,$this->input->id_corrida);
        }else{
            $result = $model->detalhesMinhasViagens($this->input->id_user,$this->input->id_corrida);
        }

        jsonReturn($result);


    }
    public function trocaStatusSolicitacao()
    {


        $this->secure->tokens_secure($this->input->token);

        // gerarLogUserEntrada($this->input,$this->input->id_user,"troca status");
        $model = new Anuncios();
        $notificacao = new Notificacoes();
        $getCondutor = $model->getCondutor($this->input->id_corrida);
        //Entrengando passageiro no destino
        gerarLogUserEntrada($this->input,$this->input->id_user,"troca status");
        if($this->input->status == 4){

            //verifica metodo de pagamento
            $pagamentoInfo = $model->pega_tipo_pagamento($this->input->id_corrida,$this->input->id_user);
            // print_r($pagamentoInfo);exit;

            //CARTAO
            if($pagamentoInfo['tipo_pagamento'] == 1){
                //captura valor
                $pagamentoAsaas = $model->confirmaPagamentoAsaas($pagamentoInfo['token']);
                if($pagamentoAsaas['status'] == 2){
                    jsonReturn($pagamentoAsaas);
                }else{
                    //atualiza saldo do motorista
                    $model->pagamentoMotorista($pagamentoInfo['token']);

                    //atualiza status do passageiro
                    $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
                    jsonReturn($result);
                }
            }
            //DINHEIRO
            if($pagamentoInfo['tipo_pagamento'] == 2){
                //atualiza saldo do motorista
                $model->pagamentoMotorista($pagamentoInfo['token']);

                //atualiza status do passageiro
                $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
                jsonReturn($result);

            }
            //PIX
            if($pagamentoInfo['tipo_pagamento'] == 3){
                //atualiza saldo do motorista
                $model->pagamentoMotorista($pagamentoInfo['token']);

                //atualiza status do passageiro
                $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
                jsonReturn($result);
            }
            $notificacao->save("passageiro-entregue",$this->input->id_user,"");

        }
        elseif($this->input->status == 1){
            $notificacao->save("passageiro-aceito",$this->input->id_user,"");

            $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
            jsonReturn($result);
        }
        elseif($this->input->status == 5){

            $notificacao->save("passageiro-cancelou",$getCondutor,"");

            $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);

            if($this->input->id_motivo == 0){
                //passageiro esta cancelando num momento possivel de receber estorno de 100%
                $model->estornarTudo($this->input->id_corrida,$this->input->id_user);
            }
            //  gerarLogUserSaida($result,$this->input->id_user,"troca status");
            jsonReturn($result);
        }
        elseif($this->input->status == 3){
            $notificacao->save("passageiro-recusado",$this->input->id_user,"");

            $model->estornarTudo($this->input->id_corrida,$this->input->id_user);

            $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
            jsonReturn($result);
        }
        else{
            $result = $model->trocaStatusSolicitacao($this->input->id_user,$this->input->id_motivo,$this->input->id_corrida,$this->input->status);
            jsonReturn($result);
        }




    }
    public function trocaStatusCorrida()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        gerarLog($this->input);

        if($this->input->status == 4){

            $todosPagantes = $model->listTodosPagantes($this->input->id_corrida);

            if($this->input->id_motivo == 0){
                //se nao tem motivo critico de cancelamento, estorna todos passageiros q pagaram algo.
                foreach ($todosPagantes as $pagante) {
                    $model->estornarTudoToken($this->input->id_corrida,$pagante['id_user'],$pagante['token']);
                }
            }else{
                 //com motivo critico de cancelamento, estorna todos passageiros taxando referente ao motivo.
                $pegaMotivo = $model->pegaMotivo($this->input->id_motivo);
                $taxa_perc = $pegaMotivo / 100;
                foreach ($todosPagantes as $pagante) {
                    $valor_taxa =  $pagante['valor_corrida'] * $taxa_perc;
                    $valor_estorno = number_format($pagante['valor_corrida'] - $valor_taxa,2);

                    $model->estornarTaxandoToken($this->input->id_corrida,$pagante['id_user'],$pagante['valor_corrida'],$pagante['tipo_pagamento'],$pagante['token']);
                }
            }

        }




        $result = $model->trocaStatusCorrida($this->input->id_corrida,$this->input->id_motivo,$this->input->status);

        jsonReturn($result);





    }
    public function caracteristicasViagem()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->caracteristicasViagem();

        jsonReturn($result);


    }
    public function oferecer()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        gerarLogUserEntrada($this->input,$this->input->id_user,"oferecer");
        $data_agendada = dataUS($this->input->data) ." ". $this->input->hora;

        $result = $model->oferecer($this->input->id_user,$data_agendada,$this->input->obs);

        if ($result['id_corrida'] > 0) {
            $dados_corrida = $model->dadosCorrida($this->input->latitude,$this->input->longitude,$data_agendada);
            // print_r($dados_corrida);exit;
            $model->updateOferecer($result['id_corrida'],$dados_corrida['distancia'],$dados_corrida['duracao'],addslashes($dados_corrida['polyline']));

        }

        //ENDERECOS
        $horario_saida_end = $data_agendada;
        for ($i=0; $i < COUNT($this->input->latitude); $i++) {
            //pula o endereco inicial
            if($i > 0){
                $index = $i-1;
                // Obtém a duração da parada em minutos
                $duracao_parada = $dados_corrida['duracoes_paradas'][$index]['duracao'] ?? 0;

                // Converte a duração de minutos para segundos
                $duracao_segundos = $duracao_parada * 60;

                // Converte o horário agendado para timestamp
                $hora_partida_timestamp = strtotime($horario_saida_end);

                // Soma os segundos da parada ao timestamp
                $hora_partida_timestamp += $duracao_segundos;

                // Converte o timestamp de volta para o formato de data "ano-mês-dia hora:minuto:segundo"
                $hora_partida_formatada = date('Y-m-d H:i:s', $hora_partida_timestamp);

                $horario_saida_end = $hora_partida_formatada;

            } else {
                // Se for o primeiro endereço, use o horário agendado inicial
                $hora_partida_formatada = $data_agendada; // Use o horário de partida original
            }


            $cidade_estado = getCityStateFromLatLong($this->input->latitude[$i], $this->input->longitude[$i]);
            $id_endereco = $model->saveEnderecoCorrida($result['id_corrida'],$i,$this->input->endereco[$i],$cidade_estado['rua'],$cidade_estado['bairro'],$cidade_estado['cidade'],
            $cidade_estado['estado'],$this->input->latitude[$i],$this->input->longitude[$i],$hora_partida_formatada);

            //VAGAS (Vagas precisam de contagem especifica para cada endereco)
            for ($v=0; $v < COUNT($this->input->vagas_id); $v++) {
                $vaga_info = $model->listVagaId($this->input->vagas_id[$v]);
                $perc_admin = $vaga_info['perc_admin'] / 100;
                $valor_admin = moneySQL($this->input->vagas_valor[$v]) * $perc_admin;
                $valor_motorista = moneySQL($this->input->vagas_valor[$v]) - $valor_admin;

                $model->saveVagasCorrida($result['id_corrida'],$this->input->vagas_id[$v],$id_endereco,$this->input->vagas_qtd[$v],
                moneySQL($this->input->vagas_valor[$v]),$valor_motorista,$valor_admin);
            }

        }

        //CARACTERISTICAS
        for ($i=0; $i < COUNT($this->input->caracteristicas); $i++) {
            $model->saveCaracteristicasCorrida($result['id_corrida'],$this->input->caracteristicas[$i]);
        }






        jsonReturn($result);


    }

    public function buscarCarona()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        gerarLogUserEntrada($this->input,$this->input->id_user,"buscarCarona");
        $result = $model->buscarCarona($this->input->id_user,$this->input->latitude[0],$this->input->longitude[0],$this->input->latitude[1],$this->input->longitude[1],
        dataUS($this->input->data),$this->input->hora,$this->input->raio_km,$this->input->vagas_id,$this->input->vagas_qtd,$this->input->caracteristicas);

        // gerarLogUserSaida($result,$this->input->id_user,"buscarCarona");
        jsonReturn($result);


    }
    public function detalhesCorrida()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->detalhesCorrida($this->input->id_corrida,$this->input->vagas_id,$this->input->vagas_qtd,
        $this->input->latitude[0],$this->input->longitude[0],$this->input->latitude[1],$this->input->longitude[1]);


        jsonReturn($result);


    }




































    public function motoristasProximos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->motoristasProximos($this->input->latitude,$this->input->longitude);

        jsonReturn($result);


    }


    public function criarRota()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        if(!empty($this->input->latitude_inicio) && !empty($this->input->longitude_inicio) && !empty($this->input->latitude_fim) && !empty($this->input->longitude_fim) ){

            $result = $model->criarRotaLatLong($this->input->latitude_inicio,$this->input->longitude_inicio, $this->input->latitude_fim,$this->input->longitude_fim,
            $this->input->latitude_parada_1,$this->input->longitude_parada_1, $this->input->latitude_parada_2,$this->input->longitude_parada_2);
        }else{
            $result = $model->criarRota($this->input->end_inicio,$this->input->end_fim, $this->input->parada_1,$this->input->parada_2);
        }


        jsonReturn($result);


    }
    public function solicitarCorrida()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        gerarLogUserEntrada($this->input,$this->input->id_user,"solicitarCorrida");



        $verificaSolicitacoes = $model->verificaSolicitacoes($this->input->id_user,$this->input->id_corrida,$this->input->id_endereco_partida,$this->input->id_endereco_final);
        $verificaDono = $model->verificaDono($this->input->id_user,$this->input->id_corrida);
        // print_r($verificaDono);exit;
        if($verificaDono > 0){
            $result = [
                "status" => "02",
                "msg" => "Você não pode solicitar a própria corrida.",
            ];
            // gerarLogUserSaida($result,$this->input->id_user,"solicitarCorrida");
            jsonReturn(array($result));
        }

        if($verificaSolicitacoes > 0){
            $result = [
                "status" => "02",
                "msg" => "Já foi solicitada uma carona, pode haver conflito de horário.",
            ];
            // gerarLogUserSaida($result,$this->input->id_user,"solicitarCorrida");
            jsonReturn(array($result));
        }



        //calcula valor a ser divido pro motorista e admin
        $info_vagas = $model->infoVagas($this->input->id_corrida,$this->input->vagas_id,$this->input->vagas_qtd);
        $valor_total = 0; $valor_total_motorista = 0; $valor_total_admin = 0;
        foreach ($info_vagas as $item) {
            $valor_total = $valor_total + $item['valor'];
            $valor_total_motorista = $valor_total_motorista + $item['valor_motorista'];
            $valor_total_admin = $valor_total_admin + $item['valor_admin'];
        }
        // print_r($valor_total_motorista);exit;
        $status_pagamento = "PENDING";














        //inicio correto dos fluxos
        if($this->input->tipo_pagamento == 1){
            $dadosCartao = $model->verificaCartao($this->input->cartao_id,$this->input->id_user);
            // print_r($dadosCartao['customer']);exit;
            if(empty($dadosCartao['id'])){
                $result = [
                    "status" => "02",
                    "msg" => "Cartão não encontrado."
                ];
                gerarLogUserSaida($result,$this->input->id_user,"solicitarCorrida");
                jsonReturn(array($result));
            }
            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);
            // $localizacao = $usuarios->listLocation($this->input->id_user);
            // $endereco_completo = geraEndCompleto($localizacao['lat'],$localizacao['long']);
            $celular= $dados_user['celular'];
            $email =$dados_user['email'];
            // print_r($dadosCartao);exit;
            if(empty($dadosCartao['token'])){
                $preAprovarCartao = $model->cobrarCartao($valor_total,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['card_number']),
                decryptitem($dadosCartao['month']),decryptitem($dadosCartao['year']),decryptitem($dadosCartao['cvv']),decryptitem($dadosCartao['nome']),decryptitem($dadosCartao['cpf']),
                decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular);
            }else{
                $preAprovarCartao = $model->cobrarCartaoComToken($valor_total,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['nome']),
                decryptitem($dadosCartao['cpf']),decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular);
            }

            if($preAprovarCartao['status'] != 1){
                // $notificacao = new Notificacoes();

                // $notificacao->save("pagamento-reprovado",$this->input->id_user,"","");
                gerarLogUserSaida($preAprovarCartao,$this->input->id_user,"solicitarCorrida");
                jsonReturn(array($preAprovarCartao));
            }
            $token = $preAprovarCartao['payment_id'];
        }














        if($this->input->tipo_pagamento == 3){
            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);
            $celular= $dados_user['celular'];
            $email =$dados_user['email'];
            $nome =$dados_user['nome'];

            // $verificaCliente = $model->verificarClientePorEmail($email);
            // if($verificaCliente['status'] == 2){
            //     $verificaCliente = $model->criar_cliente();
            // }

            $cobrançaQrCode = $model->gerarQrCode($valor_total,$nome,$email,$celular);

            $qr_code = $cobrançaQrCode['payload'];
            $token = $cobrançaQrCode['payment_id'];
            $base64QrCode = $cobrançaQrCode['qrCode64'];
        }













        if(($this->input->tipo_pagamento == 2) OR ($this->input->tipo_pagamento == 1)){
            if($this->input->tipo_pagamento == 2){
                //100% entra pro motorista
                $valor_total_motorista = $valor_total;
                $valor_total_admin = 0;
            }
            //cria pagamento
            $pagamento_id = $model->createCorridaPagamentos($this->input->id_user,$this->input->id_corrida,
            $this->input->tipo_pagamento,$valor_total,$valor_total_motorista,$valor_total_admin,$this->input->cartao_id,
            $qr_code,$this->data_atual,$token,$status_pagamento);

            gerarLogUserEntrada($this->input,$this->input->id_user,"solicitarCarona");
            //pedir para participar da carona
            $result = $model->solicitarCarona($this->input->id_user,$this->input->id_corrida,$pagamento_id['id'],$this->input->id_endereco_partida,$this->input->id_endereco_final);


            //updave vagas da corrida em cada endereco e participo da corrida
            $model->updateVagasDisponiveis($this->input->id_corrida,$this->input->id_endereco_partida,$this->input->id_endereco_final,$this->input->vagas_id,$this->input->vagas_qtd,$pagamento_id['id']);

        }
        //se cair aqui é pq a corrida é pix;
        if($this->input->tipo_pagamento == 3){

            //cria pagamento
            $pagamento_id = $model->createCorridaPagamentos($this->input->id_user,$this->input->id_corrida,
            $this->input->tipo_pagamento,$valor_total,$valor_total_motorista,$valor_total_admin,$this->input->cartao_id,
            $qr_code,$this->data_atual,$token,$status_pagamento);

            //pedir para participar da carona
            $result = $model->solicitarCaronaPix($this->input->id_user,$this->input->id_corrida,$pagamento_id['id'],$this->input->id_endereco_partida,$this->input->id_endereco_final);


            //updave vagas da corrida em cada endereco e participo da corrida
            $model->updateVagasDisponiveisPix($this->input->id_corrida,$this->input->id_endereco_partida,$this->input->id_endereco_final,$this->input->vagas_id,$this->input->vagas_qtd,$pagamento_id['id']);

            $result = [
                "status" => "01",
                "id_corrida" => $this->input->id_corrida,
                "payment_id" => $token,
                "msg" => "Aguardando pagamento do QrCode.",
                "qrCode" => $qr_code,
                "qrCode64" => $base64QrCode,
            ];
            gerarLogUserSaida($result,$this->input->id_user,"solicitarCorrida");
            jsonReturn(array($result));
        }

        $getCondutor = $model->getCondutor($this->input->id_corrida);
        // print_r($getCondutor);exit;
        if($getCondutor > 0){
            $notificacao = new Notificacoes();

            $notificacao->save("corrida-solicitada",$getCondutor,"");
        }


        gerarLogUserSaida($result,$this->input->id_user,"solicitarCorrida");
        jsonReturn(array($result));


    }



    public function aceitarCorrida()
    {

        $this->secure->tokens_secure($this->input->token);
        $id_corrida=$this->input->id_corrida;
        $arquivoCache = "log/Orcamentos/cache_$id_corrida.txt";
        if (file_exists($arquivoCache)) {
            $tempoCriacao = filemtime($arquivoCache); // Obtém o tempo de modificação do arquivo
            $tempoAtual = time(); // Obtém o tempo atual em segundos

            // Verifica se o arquivo foi criado há menos de 5 segundos
            if (($tempoAtual - $tempoCriacao) < 5) {
                $Param = [
                    "status" => "02",
                    "msg" => "A corrida não esta mais disponível"
                ];
                jsonReturn($Param);
            } else {
                // Arquivo de cache expirado, você pode deletá-lo se desejar
                unlink($arquivoCache);
            }
        }
        file_put_contents($arquivoCache, '');

        $model = new Anuncios();
        $verificaPendente = $model->verificaCorridaPendente($this->input->id_corrida);
        if($verificaPendente == 0){
            $Param = [
                "status" => "02",
                "msg" => "A corrida não esta mais disponível"
            ];
            jsonReturn($Param);
        }else{
            $usuario = new Usuarios();
            $result = $model->aceitarCorrida($this->input->id_corrida,$this->input->id_motorista);
            $location = $model->listLocation($this->input->id_motorista);
            $corrida_info = $usuario->corridaInfo($this->input->id_corrida);

            $model->updateRotaMotorista($this->input->id_corrida,$location['lat'],$location['long'],$corrida_info['origem_lat'],$corrida_info['origem_long']);
        }
        jsonReturn($result);
    }
    public function verificaPixPago()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        gerarLogUserEntrada($this->input,$this->input->id_user,"verificaPixPago");

        $result = $model->verificaPixPago($this->input->payment_id);

        // gerarLogUserSaida($result,$this->input->id_user,"corridaEmAberto");

        jsonReturn($result);
    }
    public function verificaCupom()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $cupom = $model->verificaCupom($this->input->id_user,$this->input->cupom);
        if($cupom > 0){
            //verifica se ja foi usado
            $usado = $model->verificaCupomUsado($this->input->id_user,$this->input->cupom);
            if($usado == 0){
                $Param = [
                    "status" => "01",
                    "msg" => "O cupom esta disponível",
                    "perc_desconto" =>$cupom,
                ];
                jsonReturn(array($Param));
            }else{
                //ja foi usado
                $Param = [
                    "status" => "02",
                    "msg" => "Cupom já foi usado anteriormente"
                ];
                jsonReturn(array($Param));
            }
        }else{
            //cupom nao existe
            $Param = [
                "status" => "02",
                "msg" => "Cupom inválido"
            ];
            jsonReturn(array($Param));
        }
    }
    public function corridaEmAberto()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        gerarLogUserEntrada($this->input,$this->input->id_user,"corridaEmAberto");

        $result = $model->corridaEmAberto($this->input->id_user);

        gerarLogUserSaida($result,$this->input->id_user,"corridaEmAberto");

        jsonReturn($result);
    }
    public function corridaEmAbertoMotorista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->corridaEmAbertoMotorista($this->input->id_user);

        jsonReturn($result);
    }

    public function recusarCorrida()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        $verificaPendente = $model->verificaCorridaPendente($this->input->id_corrida);
        if($verificaPendente == 0){
            $Param = [
                "status" => "02",
                "msg" => "Corrida recusada."
            ];
            jsonReturn(array($Param));
        }else{
            $result = $model->recusarCorrida($this->input->id_corrida,$this->input->id_motorista);
        }
        jsonReturn($result);
    }

    // public function trocaStatusCorrida()
    // {

    //     $this->secure->tokens_secure($this->input->token);


    //     $model = new Anuncios();


    //     if($this->input->status == 1){
    //         gerarLog($this->input);
    //         $pagamentoInfo = $model->pagamentoInfo($this->input->id_corrida);//dados da corrida
    //         if($pagamentoInfo['tipo_pagamento'] == 1){
    //             $chargeId = $model->pegarChargeId($pagamentoInfo['token']);
    //             $pagamentoPagarme = $model->confirmaPagamentoPagarme($chargeId,$pagamentoInfo['split'],$pagamentoInfo['valor_motorista'],$pagamentoInfo['valor_admin']);
    //             if($pagamentoPagarme['status'] == 2){
    //                 jsonReturn($pagamentoPagarme);
    //             }else{
    //                 $model->updateReajuste($pagamentoInfo['id_motorista'],$pagamentoInfo['reajuste']);
    //                 $result = $model->trocaStatusCorrida($this->input->id_corrida,$this->input->status);
    //                 $model->pagamentoMotorista($this->input->id_corrida);
    //                 $this->fluxoRifa($pagamentoInfo,$this->input->id_corrida);//Gera a rifa para o passageiro e motorista
    //                 jsonReturn($result);
    //             }
    //         }elseif($pagamentoInfo['tipo_pagamento'] == 2){
    //             // motorista fica devendo , sera descontado das proximas Orcamentos em pix ou cartao
    //             $result = $model->trocaStatusCorrida($this->input->id_corrida,$this->input->status);
    //             $model->pagamentoMotorista($this->input->id_corrida);
    //             $this->fluxoRifa($pagamentoInfo,$this->input->id_corrida);//Gera a rifa para o passageiro e motorista
    //             jsonReturn($result);
    //         }
    //         elseif($pagamentoInfo['tipo_pagamento'] == 3){
    //             // Admin fica devendo, motorista recebera bonus nas proximas Orcamentos em cartao ou dinheiro
    //                 $result = $model->trocaStatusCorrida($this->input->id_corrida,$this->input->status);
    //                 $model->pagamentoMotorista($this->input->id_corrida);
    //                 $this->fluxoRifa($pagamentoInfo,$this->input->id_corrida);//Gera a rifa para o passageiro e motorista
    //                 jsonReturn($result);

    //         }
    //     }else{
    //         if($this->input->status == 3){
    //             $corrida = $model->verificaCorridaAtual($this->input->id_corrida);
    //             $gcm = new Gcm();
    //             $gcm->corrida_pagamento_Android($corrida['id_usuario'], "Corrida cancelada", "Parece que o motorista cancelou a corrida, aguarde enquanto procuramos um novo.");
    //             $gcm->corrida_pagamento_IOS($corrida['id_usuario'], "Corrida cancelada","Parece que o motorista cancelou a corrida, aguarde enquanto procuramos um novo.");
    //         }
    //         $result = $model->trocaStatusCorrida($this->input->id_corrida,$this->input->status);
    //         jsonReturn($result);
    //     }

    // }
    public function fluxoRifa($pagamentoInfo,$id_corrida){
        $model = new Anuncios();
        $usuarios = new Usuarios();

        $passageiro_info = $usuarios->perfil($pagamentoInfo['id_passageiro']);//dados do passageiro
        $motorista_info = $usuarios->perfil($pagamentoInfo['id_motorista']);//dados do motorista
        $rifa_info = $model->rifaInfo();//ids da rifa de motorista e passageiro
        gerarLog($rifa_info);
        $geraRifaPassageiro = $model->geraRifa($passageiro_info['nome'],$passageiro_info['email'],$rifa_info['id_sorteio_passageiro'],tiraCarac($passageiro_info['celular']));//gera rifa para o passageiro

        $geraRifaMotorista = $model->geraRifa($motorista_info['nome'],$motorista_info['email'],$rifa_info['id_sorteio_motorista'],tiraCarac($motorista_info['celular']));//gera rifa para o motorista

        $updateInfoRifa = $model->corridaRifa($id_corrida,$rifa_info['id_sorteio_passageiro'],$rifa_info['id_sorteio_motorista'],$geraRifaPassageiro,$geraRifaMotorista);
    }

    public function corridaAtual()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        $usuario = new Usuarios();
        $corrida = $model->verificaCorridaAtual($this->input->id_corrida);
        if(($corrida['status'] == 3) AND ($corrida['tipo_pagamento'] == 3) AND ($corrida['status_pagamento'] == 'RECEIVED')){
            $motoristasProximos = $model->motoristasProximos($corrida['origem_lat'],$corrida['origem_long']);
            $atraso = 0;
            foreach ($motoristasProximos as $motorista) {
                $verificaSubCateg = $model->verificaSubcategoriasMotorista($motorista['id_motorista'],$corrida['subcategoria']);
                $verificaBloqueio = $model->verificaBloqueio($motorista['id_motorista'],$corrida['id_usuario']);
                if(($verificaSubCateg > 0) AND ($verificaBloqueio == 0)){
                    $result = $model->solicitarCorrida($this->input->id_corrida,$motorista['id_motorista'],$atraso);
                    $atraso=$atraso + 5;
                }
            }

        }
        if($corrida['status'] == 2){
            $result = $usuario->corridaInfo($this->input->id_corrida);
            $result['status_solicitacao'] = "01";
            $result['msg'] = "Motorista a caminho.";
            jsonReturn(array($result));
        }
        if($corrida['status'] == 5){
            $result = $usuario->corridaInfo($this->input->id_corrida);
            $result['status_solicitacao'] = "05";
            $result['msg'] = "Corrida iniciada.";
            jsonReturn(array($result));

        }
        if ($corrida['status'] == 3) {

            if(($corrida['tipo_pagamento'] == 3) AND ($corrida['status_pagamento'] == 'PENDING')){
                $Param = [
                    "status_solicitacao" => "04",
                    "msg" => "Aguardando pagamento do pix..."
                ];
            }else{
                $novoMotoristaProximo = $model->novoMotoristaProximo($corrida['origem_lat'],$corrida['origem_long'],$this->input->id_corrida);
                $atraso = 0;
                foreach ($novoMotoristaProximo as $motorista) {
                    $verificaSubCateg = $model->verificaSubcategoriasMotorista($motorista['id_motorista'],$corrida['subcategoria']);
                    $verificaBloqueio = $model->verificaBloqueio($motorista['id_motorista'],$corrida['id_usuario']);
                    if(($verificaSubCateg > 0) AND ($verificaBloqueio == 0)){
                        $result = $model->solicitarCorrida($this->input->id_corrida,$motorista['id_motorista'],$atraso);
                        $atraso=$atraso + 5;
                    }
                }

                $Param = [
                    "status_solicitacao" => "03",
                    "msg" => "Procurando um motorista..."
                ];
            }

            jsonReturn(array($Param));
        }
        if ($corrida['status'] == 4) {

                $Param = [
                    "status_solicitacao" => "02",
                    "msg" => "Esta corrida foi cancelada...",
                    "passageiro_cancelou" => $corrida['passageiro_cancelou']  == 1 ? 1 : 2
                ];

            jsonReturn(array($Param));
        }
        if($corrida['status'] == 6){
            $result = $usuario->corridaInfo($this->input->id_corrida);
            $result['status_solicitacao'] = "06";
            $result['msg'] = "Aguardando o passageiro.";
            jsonReturn(array($result));

        }
        $erro = [
            "status_solicitacao" => "02",
            "msg" => "Ocorreu um erro."
        ];
        jsonReturn(array($erro));

    }


    public function corridaAtualMotorista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        $usuario = new Usuarios();
        $corrida = $model->verificaCorridaAtual($this->input->id_corrida);
        if(($corrida['status'] == 2) OR ($corrida['status'] == 5) OR ($corrida['status'] == 6)){
            $result = $usuario->corridaInfo($this->input->id_corrida);
            jsonReturn(array($result));
        }
        else{
            if($corrida['status'] == 4){
                $Param = [
                    "status_solicitacao" => "02",
                    "status" => "02",
                    "msg" => "Esta corrida foi cancelada...",
                    "passageiro_cancelou" => $corrida['passageiro_cancelou']  == 1 ? 1 : 2
                ];
            }else{
                $Param = [
                    "status_solicitacao" => "02",
                    "status" => "02",
                    "msg" => "Ocorreu um erro."
                ];
            }
            jsonReturn(array($Param));
        }
    }

    public function cancelarCorridaPassageiro()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();
        $corrida = $model->verificaCorridaAtual($this->input->id_corrida);

        if(($corrida['status'] != 2) AND ($corrida['status'] != 3)){
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro ao cancelar essa corrida."
            ];
            jsonReturn(array($Param));
        }else{
            if($corrida['status'] == 2){
                $gcm = new Gcm();
                $gcm->motorista_IOS($corrida['id_motorista'],"Corrida cancelada","Parece que o passageiro cancelou a corrida");
                $gcm->motorista_Android($corrida['id_motorista'],"Corrida cancelada","Parece que o passageiro cancelou a corrida");
            }
            if($corrida['tipo_pagamento'] == 2){
                $mensagem = "Corrida cancelada com sucesso.";
                $result = $model->cancelarCorridaPassageiro($this->input->id_corrida,$mensagem);
                jsonReturn($result);
            }
            else{

                //corrida aguardando pagamento (qualquer corrida q esteja pendente o pagamento pode ser cancelada e 100% estornada)
                if(($corrida['status'] == 3) AND ($corrida['status_pagamento'] != 'RECEIVED')){
                    //estorna tudo q puder
                    $model->estornarTudo($this->input->id_corrida);
                    $mensagem = "Corrida cancelada com sucesso.";
                }
                //corrida solicitada (provavelmente no pix...ai devolvemos pois nenhum motorista ainda tinha aceitado)
                if(($corrida['status'] == 3) AND ($corrida['status_pagamento'] == 'RECEIVED')){
                    //estorna tudo q puder
                    $model->estornarTudo($this->input->id_corrida);
                    $mensagem ="Corrida cancelada,estorno pode levar 24hs para cair.";
                }
                //corrida em trajeto deve pagar multa , pix e cartão caem nesse problema
                if(($corrida['status'] == 2)){
                    //estorna pagando multa
                    $valor_taxa=$model->buscaTaxa();
                    $valor_taxado = $corrida['valor_total']-$valor_taxa;
                    $model->estornarTaxando($this->input->id_corrida,$valor_taxado,$corrida['tipo_pagamento']);
                    $mensagem = "Corrida cancelada,estorno sujeito a taxa de cancelamento.";
                }
                $result = $model->cancelarCorridaPassageiro($this->input->id_corrida,$mensagem);
            }


        }
        jsonReturn($result);
    }
    public function listOrcamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listOrcamentos($this->input->id_user);

        jsonReturn($result);
    }
    public function listOrcamentosId()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listOrcamentosId($this->input->id_corrida);

        jsonReturn($result);
    }

    /**
     * Exporta o calendário iCal de um anúncio
     * Retorna o link para download do arquivo .ics
     */
    public function exportarIcal()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Token fixo baseado no ID do anúncio (não muda nunca)
        $ical_token = $this->gerarTokenIcal($this->input->id_anuncio);
        
        // Retorna o link permanente para o iCal
        $link = HOME_URI_ROOT . '/apiv3/user/anuncios/ical/' . $this->input->id_anuncio . '_' . $ical_token . '/';
        
        jsonReturn([
            'status' => '01',
            'link' => $link,
            'msg' => 'Link do calendário gerado com sucesso'
        ]);
    }

    /**
     * Retorna o link iCal de um anúncio específico
     * Disponível apenas para o dono do anúncio
     * 
     * Payload:
     * - id_user: ID do usuário logado
     * - id_anuncio: ID do anúncio
     * - token: Token de autenticação
     */
    public function getLinkIcal()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio existe
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado']);
            return;
        }

        // Verifica se o usuário é o dono do anúncio
        if ($anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Você não tem permissão para acessar o calendário deste anúncio']);
            return;
        }

        // Token fixo baseado no ID do anúncio (sempre o mesmo)
        $ical_token = $this->gerarTokenIcal($this->input->id_anuncio);
        
        // Link permanente do iCal
        $link = HOME_URI_ROOT . '/apiv3/user/anuncios/ical/' . $this->input->id_anuncio . '_' . $ical_token . '/';
        
        jsonReturn([
            'status' => '01',
            'id_anuncio' => $this->input->id_anuncio,
            'nome' => $anuncio['nome'],
            'link_ical' => $link,
            'instrucoes' => 'Use este link para sincronizar com Airbnb, Booking, Google Calendar, etc. O link é permanente e sempre retorna as reservas atualizadas.'
        ]);
    }

    /**
     * Retorna os links iCal de todos os anúncios do usuário
     * Disponível apenas para o próprio usuário
     * 
     * Payload:
     * - id_user: ID do usuário logado
     * - token: Token de autenticação
     */
    public function getMeusLinksIcal()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Busca todos os anúncios do usuário
        $anuncios = $model->mylistID($this->input->id_user);
        
        $linksIcal = [];
        
        if (!empty($anuncios) && !isset($anuncios[0]['rows'])) {
            foreach ($anuncios as $anuncio) {
                $ical_token = $this->gerarTokenIcal($anuncio['id']);
                $link = HOME_URI_ROOT . '/apiv3/user/anuncios/ical/' . $anuncio['id'] . '_' . $ical_token . '/';
                
                $linksIcal[] = [
                    'id_anuncio' => $anuncio['id'],
                    'nome' => $anuncio['nome'],
                    'status' => $anuncio['status'],
                    'status_aprovado' => $anuncio['status_aprovado'],
                    'link_ical' => $link
                ];
            }
        }
        
        jsonReturn([
            'status' => '01',
            'total' => count($linksIcal),
            'anuncios' => $linksIcal,
            'instrucoes' => 'Use estes links para sincronizar seus anúncios com Airbnb, Booking, Google Calendar, etc.'
        ]);
    }

    /**
     * Gera token fixo para o iCal baseado no ID do anúncio
     * O token é sempre o mesmo para o mesmo anúncio
     */
    private function gerarTokenIcal($id_anuncio)
    {
        // Salt fixo para garantir segurança
        $salt = 'go77ical_permanent_2025';
        return substr(md5($id_anuncio . '_' . $salt), 0, 16);
    }

    /**
     * Gera e retorna o arquivo iCal (.ics) do anúncio
     * Acesso público via link permanente (sem token de API)
     * URL: /anuncios/ical/{id_anuncio}_{ical_token}/
     * 
     * Este endpoint é chamado periodicamente por serviços como Airbnb, Booking, etc.
     * Sempre retorna os dados mais atualizados das reservas.
     */
    public function ical($param = null)
    {
        // Param vem no formato: id_token (ex: 104_0a286c4b1514123f)
        if ($param) {
            $parts = explode('_', $param);
            $id_anuncio = $parts[0] ?? null;
            $ical_token = $parts[1] ?? null;
        } else {
            $id_anuncio = null;
            $ical_token = null;
        }

        if (!$id_anuncio || !$ical_token) {
            header('HTTP/1.1 404 Not Found');
            echo 'Parâmetros inválidos';
            return;
        }

        $model = new Anuncios();
        
        // Busca o anúncio
        $anuncio = $model->getAnuncioById($id_anuncio);
        
        if (!$anuncio) {
            header('HTTP/1.1 404 Not Found');
            echo 'Anúncio não encontrado';
            return;
        }

        // Valida o token fixo
        $expected_token = $this->gerarTokenIcal($id_anuncio);
        if ($ical_token !== $expected_token) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Token inválido';
            return;
        }

        // Busca as reservas ATUALIZADAS do anúncio (sempre em tempo real)
        $reservas = $model->getReservasAnuncio($id_anuncio);

        // Gera o conteúdo iCal com dados atualizados
        $ical = $this->gerarIcal($anuncio, $reservas);

        // Define headers para o arquivo iCal
        // Importante: não usar cache para garantir dados atualizados
        $filename = 'calendario_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anuncio['nome']) . '.ics';
        
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        echo $ical;
        exit;
    }

    /**
     * Gera o conteúdo do arquivo iCal
     */
    private function gerarIcal($anuncio, $reservas)
    {
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//GO77 Destinos//Calendario de Reservas//PT\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        $ical .= "X-WR-CALNAME:" . $this->escapeIcal($anuncio['nome']) . "\r\n";
        $ical .= "X-WR-TIMEZONE:America/Sao_Paulo\r\n";

        // Adiciona timezone
        $ical .= "BEGIN:VTIMEZONE\r\n";
        $ical .= "TZID:America/Sao_Paulo\r\n";
        $ical .= "BEGIN:STANDARD\r\n";
        $ical .= "DTSTART:19700101T000000\r\n";
        $ical .= "TZOFFSETFROM:-0300\r\n";
        $ical .= "TZOFFSETTO:-0300\r\n";
        $ical .= "END:STANDARD\r\n";
        $ical .= "END:VTIMEZONE\r\n";

        // Adiciona cada reserva como um evento
        if (!empty($reservas) && !isset($reservas[0]['rows'])) {
            foreach ($reservas as $reserva) {
                $ical .= $this->gerarEvento($anuncio, $reserva);
            }
        }

        $ical .= "END:VCALENDAR\r\n";

        return $ical;
    }

    /**
     * Gera um evento iCal para uma reserva
     */
    private function gerarEvento($anuncio, $reserva)
    {
        $uid = 'reserva-' . $reserva['id'] . '@go77app.com';
        $dtstamp = gmdate('Ymd\THis\Z');
        
        // Data de início e fim (eventos de dia inteiro)
        $dtstart = date('Ymd', strtotime($reserva['data_de']));
        $dtend = date('Ymd', strtotime($reserva['data_ate'] . ' +1 day'));
        
        $summary = 'Reserva - ' . $anuncio['nome'];
        $description = 'Reserva confirmada\\n';
        $description .= 'Adultos: ' . ($reserva['adultos'] ?? 0) . '\\n';
        $description .= 'Crianças: ' . ($reserva['criancas'] ?? 0) . '\\n';
        $description .= 'Valor: R$ ' . number_format($reserva['valor_final'] ?? 0, 2, ',', '.') . '\\n';
        if (!empty($reserva['obs'])) {
            $description .= 'Obs: ' . $reserva['obs'];
        }

        $evento = "BEGIN:VEVENT\r\n";
        $evento .= "UID:" . $uid . "\r\n";
        $evento .= "DTSTAMP:" . $dtstamp . "\r\n";
        $evento .= "DTSTART;VALUE=DATE:" . $dtstart . "\r\n";
        $evento .= "DTEND;VALUE=DATE:" . $dtend . "\r\n";
        $evento .= "SUMMARY:" . $this->escapeIcal($summary) . "\r\n";
        $evento .= "DESCRIPTION:" . $this->escapeIcal($description) . "\r\n";
        $evento .= "STATUS:CONFIRMED\r\n";
        $evento .= "TRANSP:OPAQUE\r\n";
        $evento .= "END:VEVENT\r\n";

        return $evento;
    }

    /**
     * Escapa caracteres especiais para o formato iCal
     */
    private function escapeIcal($string)
    {
        $string = str_replace('\\', '\\\\', $string);
        $string = str_replace("\n", '\\n', $string);
        $string = str_replace("\r", '', $string);
        $string = str_replace(',', '\\,', $string);
        $string = str_replace(';', '\\;', $string);
        return $string;
    }

    // ==================== ICAL EXPORTAÇÃO POR UNIDADE ====================

    /**
     * Gera token fixo para o iCal de UNIDADE baseado nos IDs
     */
    private function gerarTokenIcalUnidade($id_anuncio, $id_type, $id_unidade)
    {
        $salt = 'go77ical_unidade_2025';
        return substr(md5($id_anuncio . '_' . $id_type . '_' . $id_unidade . '_' . $salt), 0, 16);
    }

    /**
     * Gera e retorna o arquivo iCal (.ics) de uma UNIDADE específica
     * Acesso público via link permanente (sem token de API)
     * URL: /anuncios/icalUnidade/{id_anuncio}_{id_type}_{id_unidade}_{token}/
     * 
     * Inclui:
     * - Reservas feitas na GO77 para esta unidade
     * - Bloqueios importados via iCal externo (Airbnb, Booking, etc)
     */
    public function icalUnidade($param = null)
    {
        // Param vem no formato: id_anuncio_id_type_id_unidade_token
        if ($param) {
            $parts = explode('_', $param);
            $id_anuncio = $parts[0] ?? null;
            $id_type = $parts[1] ?? null;
            $id_unidade = $parts[2] ?? null;
            $ical_token = $parts[3] ?? null;
        } else {
            $id_anuncio = null;
            $id_type = null;
            $id_unidade = null;
            $ical_token = null;
        }

        if (!$id_anuncio || !$id_type || !$id_unidade || !$ical_token) {
            header('HTTP/1.1 404 Not Found');
            echo 'Parâmetros inválidos';
            return;
        }

        $model = new Anuncios();
        
        // Busca o anúncio
        $anuncio = $model->getAnuncioById($id_anuncio);
        
        if (!$anuncio) {
            header('HTTP/1.1 404 Not Found');
            echo 'Anúncio não encontrado';
            return;
        }

        // Valida o token fixo
        $expected_token = $this->gerarTokenIcalUnidade($id_anuncio, $id_type, $id_unidade);
        if ($ical_token !== $expected_token) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Token inválido';
            return;
        }

        // Busca informações do tipo e unidade
        $types = $model->getTypesAnuncio($id_anuncio);
        $type_info = null;
        foreach ($types as $t) {
            if ($t['id'] == $id_type) {
                $type_info = $t;
                break;
            }
        }

        $unidades = $model->listarUnidadesTipo($id_type);
        $unidade_info = null;
        foreach ($unidades as $u) {
            if ($u['id'] == $id_unidade) {
                $unidade_info = $u;
                break;
            }
        }

        if (!$type_info || !$unidade_info) {
            header('HTTP/1.1 404 Not Found');
            echo 'Tipo ou unidade não encontrada';
            return;
        }

        // Busca as reservas da unidade (inclui bloqueios iCal externos)
        $reservas = $model->getReservasAnuncioPorUnidade($id_anuncio, $id_type, $id_unidade);

        // Gera o conteúdo iCal
        $ical = $this->gerarIcalUnidade($anuncio, $type_info, $unidade_info, $reservas);

        // Define headers para o arquivo iCal
        $filename = 'calendario_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anuncio['nome'] . '_' . $unidade_info['nome']) . '.ics';
        
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        echo $ical;
        exit;
    }

    /**
     * Gera o conteúdo do arquivo iCal para uma unidade
     */
    private function gerarIcalUnidade($anuncio, $type, $unidade, $reservas)
    {
        $calName = $anuncio['nome'] . ' - ' . $type['nome'] . ' - ' . $unidade['nome'];
        
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//GO77 Destinos//Calendario por Unidade//PT\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        $ical .= "X-WR-CALNAME:" . $this->escapeIcal($calName) . "\r\n";
        $ical .= "X-WR-TIMEZONE:America/Sao_Paulo\r\n";

        // Adiciona timezone
        $ical .= "BEGIN:VTIMEZONE\r\n";
        $ical .= "TZID:America/Sao_Paulo\r\n";
        $ical .= "BEGIN:STANDARD\r\n";
        $ical .= "DTSTART:19700101T000000\r\n";
        $ical .= "TZOFFSETFROM:-0300\r\n";
        $ical .= "TZOFFSETTO:-0300\r\n";
        $ical .= "END:STANDARD\r\n";
        $ical .= "END:VTIMEZONE\r\n";

        // Adiciona cada reserva como um evento
        foreach ($reservas as $reserva) {
            $ical .= $this->gerarEventoUnidade($anuncio, $type, $unidade, $reserva);
        }

        $ical .= "END:VCALENDAR\r\n";

        return $ical;
    }

    /**
     * Gera um evento iCal para uma reserva de unidade
     */
    private function gerarEventoUnidade($anuncio, $type, $unidade, $reserva)
    {
        // UID diferenciado para reservas GO77 vs bloqueios importados
        if (isset($reserva['origem']) && $reserva['origem'] === 'ical_externo') {
            $uid = 'bloqueio-' . $reserva['id'] . '@go77app.com';
            $summary = $reserva['nome_hospede'] ?: 'Bloqueio';
            $description = 'Importado de: ' . ($reserva['plataforma'] ?? 'iCal externo');
        } else {
            $uid = 'reserva-' . $reserva['id'] . '-u' . $unidade['id'] . '@go77app.com';
            $summary = 'Reserva - ' . $unidade['nome'];
            $description = 'Reserva confirmada\\n';
            $description .= 'Unidade: ' . $unidade['nome'] . '\\n';
            $description .= 'Adultos: ' . ($reserva['adultos'] ?? 0) . '\\n';
            $description .= 'Crianças: ' . ($reserva['criancas'] ?? 0) . '\\n';
            if (!empty($reserva['valor_final'])) {
                $description .= 'Valor: R$ ' . number_format($reserva['valor_final'], 2, ',', '.') . '\\n';
            }
            if (!empty($reserva['obs'])) {
                $description .= 'Obs: ' . $reserva['obs'];
            }
        }

        $dtstamp = gmdate('Ymd\THis\Z');
        
        // Data de início e fim (eventos de dia inteiro)
        $dtstart = date('Ymd', strtotime($reserva['data_de']));
        $dtend = date('Ymd', strtotime($reserva['data_ate'] . ' +1 day'));

        $evento = "BEGIN:VEVENT\r\n";
        $evento .= "UID:" . $uid . "\r\n";
        $evento .= "DTSTAMP:" . $dtstamp . "\r\n";
        $evento .= "DTSTART;VALUE=DATE:" . $dtstart . "\r\n";
        $evento .= "DTEND;VALUE=DATE:" . $dtend . "\r\n";
        $evento .= "SUMMARY:" . $this->escapeIcal($summary) . "\r\n";
        $evento .= "DESCRIPTION:" . $this->escapeIcal($description) . "\r\n";
        $evento .= "STATUS:CONFIRMED\r\n";
        $evento .= "TRANSP:OPAQUE\r\n";
        $evento .= "END:VEVENT\r\n";

        return $evento;
    }

    /**
     * Retorna os links iCal de todas as unidades de um anúncio
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - token: Token de autenticação
     */
    public function listarLinksIcalExportacao()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Verifica se tem quartos
        $totalTypes = $model->countTypesAnuncio($this->input->id_anuncio);

        if ($totalTypes == 0) {
            // Anúncio sem quartos - retorna link único
            jsonReturn([
                'status' => '01',
                'tem_quartos' => false,
                'msg' => 'Este anúncio não possui quartos. Use o link único abaixo.',
                'anuncio' => [
                    'id' => $anuncio['id'],
                    'nome' => $anuncio['nome']
                ],
                'link_unico' => $model->gerarLinkIcal($this->input->id_anuncio),
                'links_por_unidade' => []
            ]);
            return;
        }

        // Anúncio com quartos - gera links por unidade
        $links = $model->gerarLinksIcalUnidades($this->input->id_anuncio);

        jsonReturn([
            'status' => '01',
            'tem_quartos' => true,
            'msg' => 'Use estes links para exportar o calendário de cada unidade para outras plataformas (Airbnb, Booking, etc).',
            'anuncio' => [
                'id' => $anuncio['id'],
                'nome' => $anuncio['nome']
            ],
            'link_unico' => $model->gerarLinkIcal($this->input->id_anuncio),
            'total_unidades' => count($links),
            'links_por_unidade' => $links
        ]);
    }

    // ==================== ICAL EXTERNO (IMPORTAÇÃO) ====================

    /**
     * Lista tipos e unidades disponíveis para configurar iCal
     * Use este endpoint para mostrar ao usuário as opções disponíveis antes de adicionar um link iCal
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - token: Token de autenticação
     */
    public function listarUnidadesParaIcal()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Verifica se anúncio tem types
        $qtdTypes = $model->countTypesAnuncio($this->input->id_anuncio);
        
        if ($qtdTypes == 0) {
            // Anúncio sem quartos - retorna apenas info do anúncio
            jsonReturn([
                'status' => '01',
                'tem_quartos' => false,
                'msg' => 'Este anúncio não possui quartos. O iCal será vinculado ao anúncio inteiro.',
                'anuncio' => [
                    'id' => $anuncio['id'],
                    'nome' => $anuncio['nome']
                ],
                'types' => []
            ]);
            return;
        }

        // Lista todos os tipos com suas unidades
        $types = $model->listarTypesComUnidades($this->input->id_anuncio);
        
        jsonReturn([
            'status' => '01',
            'tem_quartos' => true,
            'total_types' => count($types),
            'msg' => 'Selecione o tipo de quarto e a unidade específica para vincular o iCal.',
            'anuncio' => [
                'id' => $anuncio['id'],
                'nome' => $anuncio['nome']
            ],
            'types' => $types
        ]);
    }

    /**
     * Lista apenas as unidades de um tipo específico
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_type: ID do tipo de quarto
     * - token: Token de autenticação
     */
    public function listarUnidadesTipo()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        $id_type = intval($this->input->id_type ?? 0);
        if (empty($id_type)) {
            jsonReturn(['status' => '00', 'msg' => 'ID do tipo é obrigatório']);
            return;
        }

        // Verifica se o type pertence ao anúncio
        if (!$model->verificarTypePertenceAnuncio($id_type, $this->input->id_anuncio)) {
            jsonReturn(['status' => '00', 'msg' => 'Tipo não encontrado ou não pertence a este anúncio']);
            return;
        }

        $unidades = $model->listarUnidadesTipo($id_type);
        
        jsonReturn([
            'status' => '01',
            'id_type' => $id_type,
            'total' => count($unidades),
            'unidades' => $unidades
        ]);
    }

    /**
     * Atualiza o nome de uma unidade
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_type: ID do tipo
     * - id_unidade: ID da unidade
     * - nome: Novo nome da unidade
     * - token: Token de autenticação
     */
    public function atualizarNomeUnidade()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        $id_type = intval($this->input->id_type ?? 0);
        $id_unidade = intval($this->input->id_unidade ?? 0);
        $nome = trim($this->input->nome ?? '');

        if (empty($id_unidade)) {
            jsonReturn(['status' => '00', 'msg' => 'ID da unidade é obrigatório']);
            return;
        }

        if (empty($nome)) {
            jsonReturn(['status' => '00', 'msg' => 'Nome da unidade é obrigatório']);
            return;
        }

        // Verifica se a unidade pertence ao tipo
        if (!$model->verificarUnidadePertenceTipo($id_unidade, $id_type)) {
            jsonReturn(['status' => '00', 'msg' => 'Unidade não encontrada ou não pertence a este tipo']);
            return;
        }

        if ($model->atualizarNomeUnidade($id_unidade, $nome)) {
            jsonReturn(['status' => '01', 'msg' => 'Nome da unidade atualizado com sucesso']);
        } else {
            jsonReturn(['status' => '00', 'msg' => 'Erro ao atualizar nome da unidade']);
        }
    }

    /**
     * Adiciona um link iCal externo (Airbnb, Booking, etc)
     * Permite sincronizar calendários de outras plataformas
     * 
     * Payload:
     * - id_user: ID do usuário (deve ser dono do anúncio)
     * - id_anuncio: ID do anúncio
     * - id_type: ID do tipo/quarto (obrigatório se anúncio tiver quartos)
     * - id_unidade: ID da unidade específica (obrigatório se tipo tiver mais de 1 unidade)
     * - nome: Nome da plataforma (ex: "Airbnb", "Booking")
     * - url: URL do calendário iCal
     * - token: Token de autenticação
     */
    public function adicionarIcalExterno()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Verifica se o anúncio tem quartos/types
        $qtdTypes = $model->countTypesAnuncio($this->input->id_anuncio);
        $id_type = isset($this->input->id_type) ? intval($this->input->id_type) : 0;
        $id_unidade = isset($this->input->id_unidade) ? intval($this->input->id_unidade) : 0;
        
        if ($qtdTypes > 0) {
            // Anúncio TEM quartos - id_type é obrigatório
            if (empty($id_type)) {
                jsonReturn(['status' => '00', 'msg' => 'Este anúncio possui quartos. Informe o id_type do quarto.']);
                return;
            }
            
            // Verifica se o type pertence ao anúncio
            if (!$model->verificarTypePertenceAnuncio($id_type, $this->input->id_anuncio)) {
                jsonReturn(['status' => '00', 'msg' => 'Quarto não encontrado ou não pertence a este anúncio']);
                return;
            }

            // Verifica quantidade de unidades do tipo
            $unidades = $model->listarUnidadesTipo($id_type);
            $qtdUnidades = count($unidades);

            if ($qtdUnidades > 1) {
                // Tipo tem múltiplas unidades - id_unidade é obrigatório
                if (empty($id_unidade)) {
                    jsonReturn([
                        'status' => '00', 
                        'msg' => 'Este tipo possui ' . $qtdUnidades . ' unidades. Informe o id_unidade.',
                        'unidades_disponiveis' => $unidades
                    ]);
                    return;
                }
                
                // Verifica se a unidade pertence ao tipo
                if (!$model->verificarUnidadePertenceTipo($id_unidade, $id_type)) {
                    jsonReturn(['status' => '00', 'msg' => 'Unidade não encontrada ou não pertence a este tipo']);
                    return;
                }
            } else if ($qtdUnidades == 1) {
                // Apenas 1 unidade - usa automaticamente
                $id_unidade = $unidades[0]['id'];
            }
        } else {
            // Anúncio NÃO tem quartos - id_type e id_unidade devem ser 0
            $id_type = 0;
            $id_unidade = 0;
        }

        // Valida URL
        $url = trim($this->input->url ?? '');
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            jsonReturn(['status' => '00', 'msg' => 'URL inválida']);
            return;
        }

        // Valida nome
        $nome = trim($this->input->nome ?? '');
        if (empty($nome)) {
            jsonReturn(['status' => '00', 'msg' => 'Nome da plataforma é obrigatório']);
            return;
        }

        // Usa o novo método que suporta unidades
        if ($id_unidade > 0) {
            $result = $model->adicionarIcalExternoUnidade($this->input->id_anuncio, $id_type, $id_unidade, $nome, $url);
        } else {
            $result = $model->adicionarIcalExterno($this->input->id_anuncio, $nome, $url, $id_type);
        }
        
        jsonReturn($result);
    }

    /**
     * Remove um link iCal externo
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_link: ID do link iCal a remover
     * - token: Token de autenticação
     */
    public function removerIcalExterno()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        $result = $model->removerIcalExterno($this->input->id_link, $this->input->id_anuncio);
        
        jsonReturn($result);
    }

    /**
     * Lista links iCal externos de um anúncio (todos os quartos/unidades ou filtrado)
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_type: ID do quarto/tipo (opcional - se não informado, lista todos)
     * - id_unidade: ID da unidade (opcional - se não informado, lista todos)
     * - token: Token de autenticação
     */
    public function listarIcalExterno()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        $id_type = isset($this->input->id_type) ? intval($this->input->id_type) : null;
        $id_unidade = isset($this->input->id_unidade) ? intval($this->input->id_unidade) : null;
        
        // Usa o método que retorna informações de unidade
        $links = $model->listarIcalExternoComUnidades($this->input->id_anuncio, $id_type, $id_unidade);
        
        jsonReturn([
            'status' => '01',
            'total' => count($links),
            'id_type' => $id_type,
            'id_unidade' => $id_unidade,
            'links' => $links
        ]);
    }

    /**
     * Lista bloqueios importados via iCal de um anúncio (todos os quartos ou um específico)
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_type: ID do quarto/tipo (opcional - se não informado, lista todos)
     * - token: Token de autenticação
     */
    public function listarBloqueiosIcal()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Filtro por tipo/quarto (opcional)
        $id_type = isset($this->input->id_type) ? intval($this->input->id_type) : null;
        
        $bloqueios = $model->getBloqueiosIcal($this->input->id_anuncio, $id_type);
        
        jsonReturn([
            'status' => '01',
            'id_type' => $id_type,
            'total' => count($bloqueios),
            'bloqueios' => $bloqueios
        ]);
    }

    /**
     * Força sincronização manual de um link iCal específico
     * 
     * Payload:
     * - id_user: ID do usuário
     * - id_anuncio: ID do anúncio
     * - id_type: ID do quarto/tipo (opcional - se informado, sincroniza apenas links deste tipo)
     * - id_link: ID do link iCal (opcional, se não informado sincroniza todos)
     * - token: Token de autenticação
     */
    public function sincronizarIcalExterno()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        // Verifica se o anúncio pertence ao usuário
        $anuncio = $model->getAnuncioById($this->input->id_anuncio);
        
        if (!$anuncio || $anuncio['app_users_id'] != $this->input->id_user) {
            jsonReturn(['status' => '00', 'msg' => 'Anúncio não encontrado ou não pertence ao usuário']);
            return;
        }

        // Filtro por tipo/quarto (opcional)
        $id_type = isset($this->input->id_type) ? intval($this->input->id_type) : null;

        // Busca links do anúncio (com filtro opcional por tipo)
        $links = $model->listarIcalExterno($this->input->id_anuncio, $id_type);
        
        if (empty($links)) {
            jsonReturn(['status' => '00', 'msg' => 'Nenhum link iCal cadastrado para este anúncio/tipo']);
            return;
        }

        $resultados = [];
        
        foreach ($links as $link) {
            // Se id_link específico foi informado, processa apenas ele
            if (!empty($this->input->id_link) && $link['id'] != $this->input->id_link) {
                continue;
            }
            
            $resultados[] = $this->processarLinkIcal($link, $model);
        }

        jsonReturn([
            'status' => '01',
            'msg' => 'Sincronização concluída',
            'id_type' => $id_type,
            'resultados' => $resultados
        ]);
    }

    /**
     * Processa um link iCal e importa os eventos
     */
    private function processarLinkIcal($link, $model)
    {
        $resultado = [
            'id_link' => $link['id'],
            'nome' => $link['nome'],
            'sucesso' => false,
            'eventos_importados' => 0,
            'erro' => null
        ];

        try {
            // Faz download do iCal
            $contexto = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'GO77-iCal-Sync/1.0'
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]);
            
            $conteudo = @file_get_contents($link['url'], false, $contexto);
            
            if ($conteudo === false) {
                throw new Exception('Não foi possível acessar a URL');
            }

            // Limpa bloqueios anteriores deste link
            $model->limparBloqueiosIcal($link['id']);
            
            // Faz parse do iCal
            $eventos = $this->parseIcal($conteudo);
            
            foreach ($eventos as $evento) {
                if (!empty($evento['dtstart']) && !empty($evento['dtend'])) {
                    $model->adicionarBloqueioIcal(
                        $link['app_anuncios_id'],
                        $link['app_anuncios_types_id'] ?? 0,
                        $link['app_anuncios_types_unidades_id'] ?? 0,
                        $link['id'],
                        $evento['uid'] ?? uniqid('evt_'),
                        $evento['dtstart'],
                        $evento['dtend'],
                        $evento['summary'] ?? null
                    );
                    $resultado['eventos_importados']++;
                }
            }
            
            // Atualiza status de sincronização
            $model->atualizarSincronizacaoIcal($link['id'], true);
            $resultado['sucesso'] = true;
            
        } catch (Exception $e) {
            $resultado['erro'] = $e->getMessage();
            $model->atualizarSincronizacaoIcal($link['id'], false, $e->getMessage());
            
            // Desativa link com muitos erros (5+)
            if ($link['erros'] >= 4) {
                $model->desativarIcalComErros($link['id']);
                $resultado['erro'] .= ' (Link desativado após muitos erros)';
            }
        }
        
        return $resultado;
    }

    /**
     * Faz parse de um arquivo iCal e extrai os eventos
     */
    private function parseIcal($conteudo)
    {
        $eventos = [];
        $linhas = preg_split('/\r\n|\r|\n/', $conteudo);
        
        $evento = null;
        $propriedade_atual = '';
        
        foreach ($linhas as $linha) {
            // Continuação de linha (começa com espaço ou tab)
            if (preg_match('/^[ \t]/', $linha)) {
                $linha = substr($linha, 1);
                if ($evento !== null && !empty($propriedade_atual)) {
                    $evento[$propriedade_atual] .= $linha;
                }
                continue;
            }
            
            $linha = trim($linha);
            
            if ($linha === 'BEGIN:VEVENT') {
                $evento = [];
                continue;
            }
            
            if ($linha === 'END:VEVENT' && $evento !== null) {
                $eventos[] = $evento;
                $evento = null;
                continue;
            }
            
            if ($evento !== null) {
                // Parse propriedade
                if (preg_match('/^([A-Z\-]+)[;:](.*)$/i', $linha, $matches)) {
                    $prop = strtolower($matches[1]);
                    $valor = $matches[2];
                    
                    // Remove parâmetros (ex: DTSTART;VALUE=DATE:20251220)
                    if (strpos($valor, ':') !== false) {
                        $valor = substr($valor, strpos($valor, ':') + 1);
                    }
                    
                    $propriedade_atual = $prop;
                    
                    // Converte datas
                    if (in_array($prop, ['dtstart', 'dtend'])) {
                        $valor = $this->parseDataIcal($valor);
                    }
                    
                    $evento[$prop] = $valor;
                }
            }
        }
        
        return $eventos;
    }

    /**
     * Converte data iCal para formato MySQL
     */
    private function parseDataIcal($data)
    {
        // Remove Z se presente
        $data = rtrim($data, 'Z');
        
        // Formato: YYYYMMDD ou YYYYMMDDTHHmmss
        if (strlen($data) === 8) {
            // Apenas data
            return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
        } elseif (strlen($data) >= 15) {
            // Data e hora
            return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
        }
        
        return $data;
    }


}
