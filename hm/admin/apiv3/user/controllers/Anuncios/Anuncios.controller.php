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

    public function listaCategorias()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listaCategorias();


        jsonReturn($result);

    }

    public function listasubCategorias()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listasubCategorias($this->input->id_categoria, $this->input->id);


        jsonReturn($result);

    }

    public function listaCaracteristicas()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listaCaracteristicas($this->input->id);


        jsonReturn($result);

    }

    public function listaCamas()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listaCamas($this->input->id);


        jsonReturn($result);

    }

    public function listaMotivos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listaMotivos($this->input->id);


        jsonReturn($result);

    }

    public function lista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->lista($this->input->id,$this->input->id_categoria,$this->input->data_de,$this->input->ate,$this->input->limite);


        jsonReturn($result);

    }

    public function listaPendentes()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listaPendentes($this->input->limite);


        jsonReturn($result);

    }

    public function listID()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listID($this->input->id);


        jsonReturn($result);

    }

    public function listtiposID()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->listtiposID($this->input->id);


        jsonReturn($result);

    }

    public function listaFilter()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        if($this->input->mais_proximos == 1){
          $result = $model->listaProximos($this->input->id_user, $this->input->latitude, $this->input->longitude);
        }else{
          $result = $model->listaFilter(
            $this->input->id_user,
            $this->input->latitude,
            $this->input->longitude,
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
          $this->input->checkout
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
          $this->input->adultos,
          $this->input->criancas,
          $this->input->quartos,
          $this->input->banheiros,
          $this->input->pets
        );

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

        //camas
        foreach ($this->input->camas as $key) {
            $result3 = $model->adicionarTypeCamas($id_type, $key->id, $key->qtd);
        }

        //periodos
        foreach ($this->input->periodos as $key) {
            $result4 = $model->adicionarTypePeriodos(
              $id_type,
              $key->nome,
              dataUS($key->data_de),
              dataUS($key->data_ate),
              moneySQL(trim($key->valor)),
              moneySQL(trim($key->taxa_limpeza)),
              $key->qtd)
              ;
        }

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

    public function aprovar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->aprovar($this->input->id, $this->input->status_aprovado);

        jsonReturn($result);

    }

    public function updateSubcategoria()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->updateSubcategoria($this->input->id, $this->input->id_categoria, $this->input->nome, $this->input->status);

        jsonReturn($result);

    }

    public function updateCaracteristica()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->updateCaracteristica($this->input->id, $this->input->id_categoria, $this->input->nome, $this->input->status);

        jsonReturn($result);

    }

    public function updateCama()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->updateCama($this->input->id, $this->input->nome, $this->input->status);

        jsonReturn($result);

    }

    public function updateMotivo()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->updateMotivo($this->input->id, $this->input->tipo, $this->input->nome, $this->input->taxado, $this->input->taxa_perc, $this->input->status);

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

    public function excluirSubcategoria()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirSubcategoria($this->input->id);

        jsonReturn($result);

    }

    public function excluirCaracteristica()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirCaracteristica($this->input->id);

        jsonReturn($result);

    }

    public function excluirCama()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirCama($this->input->id);

        jsonReturn($result);

    }

    public function excluirMotivo()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirMotivo($this->input->id);

        jsonReturn($result);

    }

    public function updateImagemSubcategoria()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->updateImagemSubcategoria($this->id, $this->avatar_final);

        jsonReturn($result);
    }

    public function updateImagemCaracteristica()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->updateImagemCaracteristica($this->id, $this->avatar_final);

        jsonReturn($result);
    }

    public function updateImagemCama()
    {

        $this->id = $_POST['id'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->updateImagemCama($this->id, $this->avatar_final);

        jsonReturn($result);
    }

    public function excluirType()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirType($this->input->id);

        jsonReturn($result);

    }

    public function excluirimagens()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->excluirimagens($this->input->id);

        jsonReturn($result);

    }


    public function adicionarSubcategoria()
    {

        $this->id_categoria = $_POST['id_categoria'];
        $this->nome = $_POST['nome'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';


        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->adicionarSubcategoria($this->id_categoria, $this->nome, $this->avatar_final);

        jsonReturn($result);
    }


    public function adicionarCaracteristica()
    {

        $this->id_categoria = $_POST['id_categoria'];
        $this->nome = $_POST['nome'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';


        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->adicionarCaracteristica($this->id_categoria, $this->nome, $this->avatar_final);

        jsonReturn($result);
    }

      public function adicionarCama()
    {

        $this->nome = $_POST['nome'];
        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../../uploads/icon';


        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

        }

        $model = new Anuncios();
        $result = $model->adicionarCama($this->nome, $this->avatar_final);

        jsonReturn($result);
    }

    public function adicionarMotivo()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Anuncios();

        $result = $model->adicionarMotivo($this->input->tipo, $this->input->nome, $this->input->taxado, $this->input->taxa_perc);

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


}
