<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/Moip/order.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';
require_once MODELS . '/Horarios/Horarios.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';
require_once HELPERS . '/HorariosHelper.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';


class UsuariosController
{

    public function __construct()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 20;
    }

    public function verificatoken()
    {

        $usuariosOBJ =  new Usuarios();
        $usuariosOBJ->verificatoken($this->input->token_senha);
    }
    public function gerarEndereco()
    {
        $novo_endereco=geraLatLong($this->input->endereco, $this->input->numero, $this->input->cidade);
        $Param['latitude'] = number_format($novo_endereco[0],5);
        $Param['longitude'] =  number_format($novo_endereco[1],5);
        jsonReturn(array($Param));
    }

    public function updateMenusCheck()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

            $menuscheck = $usuarios->updateMenusCheck($this->input->id_grupo, $this->input->id_menu);

        jsonReturn($menuscheck);
    }

    public function exportarCsv() {
        // Crie o arquivo CSV
        $usuarios = new Usuarios();
        $usuarios->gerarCSV();


        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }

    public function saveMenuCheck()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

            $menuscheck = $usuarios->saveMenuCheck($this->input->id_grupo, $this->input->id_menu);

        jsonReturn($menuscheck);
    }

    public function doisFatores()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();


        $login = $helper->validateDoisFatores(cryptitem($this->input->email), $this->input->password, $this->input->latitude, $this->input->longitude);
        // $login['status'] = '01';

        jsonReturn(array($login));
    }
    public function login()
    {
        $this->secure->tokens_secure($this->input->token);

        // $login['status'] = '01';
        // $login['id'] = '01';
        // $login['id_grupo'] = '01';
        // jsonReturn(array($login));

        $helper = new UsuariosHelper();
        $login = $helper->validateLogin(cryptitem($this->input->email), $this->input->password);
        $validacao = $helper->verificaCod($login['id'], $this->input->codigo);
        if ($validacao['status']==02) {
            jsonReturn(array($validacao));
        }

        jsonReturn(array($login));
    }

    public function loginMidias(){

        $this->secure->tokens_secure($_POST['token']);

        $this->nome = $_POST['nome'];
        $this->email = $_POST['email'];
        $this->celular = $_POST['celular'];

        $this->pasta = '../../uploads/avatar';

        $usuarios =  new Usuarios();
        $helper = new UsuariosHelper();

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        $verifica = $helper->loginMidias(cryptitem($this->email));


        if($verifica['rows'] > 0){
           jsonReturn(array($verifica));
        }else{

          if (!empty($this->avatar)) {

              //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
              $this->avatar_final = $this->avatar;

              move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

              $imagem = new TutsupRedimensionaImagem();

              $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
              $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

              $imagem->largura = 600;
              $imagem->altura = 0;
              $imagem->qualidade = 100;

              $nova_imagem = $imagem->executa();

              unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
          }else {
              $this->avatar_final = "avatar.png";
          }

          $result = $usuarios->saveApp(
            $tipo = 1,
            cryptitem($this->nome),
            cryptitem($this->email),
            $this->hash,
            cryptitem($this->celular),
            $avatar = $this->avatar_final,
            $this->data_atual,
            $status = '1',
            $status_aprovado = '1',
            "",
            ""
        );

          jsonReturn(array($result));

        }




    }

    public function loginapp()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->loginApp(cryptitem($this->input->email), $this->input->password);

        jsonReturn(array($login));
    }

    // public function listMenusPermitidos()
    // {

    //     $helper = new UsuariosHelper();
    //     // print_r($this->input->id_grupo);exit;
    //     $login = $helper->listMenusPermitidos($this->input->id_grupo);


    //     $this->secure->tokens_secure($this->input->token);
    //     $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

    //     jsonReturn(array($login));
    // }

    public function listid()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->listId($this->input->id_user);

        jsonReturn(array($login));
    }
    public function listIdPerfil()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->listIdPerfil($this->input->id_usuario);

        jsonReturn(array($login));
    }
    public function listidchecks()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new Usuarios();
        $login = $helper->listidchecks($this->input->id_grupo);

        jsonReturn(array($login));
    }
    public function listAllSetores()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new Usuarios();
        $login = $helper->listAllSetores();

        jsonReturn($login);
    }
    public function deleteSetor()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new Usuarios();
        $login = $helper->deleteSetor($this->input->id);

        jsonReturn($login);
    }
    public function saveSetor()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new Usuarios();
        $login = $helper->saveSetor($this->input->nome);

        jsonReturn($login);
    }
    public function listIdUsuariosAdmin()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->listIdUsuariosAdmin($this->input->id_user);

        jsonReturn(array($login));
    }

    public function listAllMenusAdmin()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->listAllMenusAdmin();

        jsonReturn(array($login));
    }


    public function cadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $helper_enderecos = new EnderecosHelper();
        $usuarios =  new Usuarios();
        $enderecos =  new Enderecos();

        $this->hash = $helper->cryptPassword($this->input->password, $this->input->nome_responsavel, $this->input->email);
        $endereco_final = $helper_enderecos->gerarEndereco($lat = "", $long = "", $this->input->cep, $this->input->estado, $this->input->cidade, $this->input->endereco, $this->input->bairro, $this->input->numero, $this->input->complemento);


        // $cnpjCheck = $helper->validateCNPJ(tiraCarac($this->input->cnpj));

        $emailCheck = $helper->validateEmail(cryptitem($this->input->email));

        // VALIDAÇÕES DE EMAIL
        // if ($cnpjCheck) {
        //     jsonReturn(array($cnpjCheck));
        // }
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $result['usuario'] = $usuarios->save(
            2,
            $this->input->tipo_loja,
            $this->input->razao_social,
            $this->input->nome_fantasia,
            cryptitem($this->input->nome_responsavel),
            cryptitem($this->input->cpf_responsavel),
            cryptitem($this->input->cnpj),
            cryptitem($this->input->email),
            cryptitem($this->input->celular),
            $this->hash,
            $avatar = 'avatar.png',
            $this->data_atual,
            1,
            2
        );

        $cep_final = str_replace('-', '', $endereco_final['cep']);

        $result['endereco'] = $enderecos->save(
            $result['usuario']['id'],
            cryptitem($this->input->cep),
            cryptitem($this->input->estado),
            cryptitem($this->input->cidade),
            cryptitem($this->input->endereco),
            cryptitem($this->input->bairro),
            cryptitem($this->input->numero),
            cryptitem($this->input->complemento),
            cryptitem($endereco_final['latitude']),
            cryptitem($endereco_final['longitude'])
        );
        $cria_horarios = $usuarios->criahorarios($result['usuario']['id']);

        jsonReturn(array($result));
    }
    public function saveLatLong()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->saveLatLong($this->input->id_usuario, $this->input->latitude, $this->input->longitude);

        jsonReturn($login);
    }

    public function saveendereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $helper_enderecos = new EnderecosHelper();
        $usuarios =  new Usuarios();
        $enderecos =  new Enderecos();

        $endereco_final = $helper_enderecos->gerarEndereco($lat = "", $long = "", $this->input->cep, $this->input->uf, $this->input->cidade, $this->input->endereco, $this->input->bairro, $this->input->numero, $this->input->complemento);

        $cep_final = str_replace('-', '', $endereco_final['cep']);

        $result = $enderecos->save(
            $this->input->id_user,
            $cep_final,
            $this->input->uf,
            $this->input->cidade,
            $this->input->endereco,
            $this->input->bairro,
            $this->input->numero,
            $this->input->complemento,
            $endereco_final['latitude'],
            $endereco_final['longitude']
        );

        jsonReturn(array($result));
    }

    public function saveenderecoIOS()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $helper_enderecos = new EnderecosHelper();
        $usuarios =  new Usuarios();
        $enderecos =  new Enderecos();

        $endereco_final = $helper_enderecos->gerarEndereco($this->input->latitude, $this->input->longitude, $cep = "", $uf = "", $cidade = "", $endereco = "", $bairro = "", $numero = "", $complemento = "");

        $cep_final = str_replace('-', '', $endereco_final['cep']);

        $result = $enderecos->save(
            $this->input->id_user,
            $cep_final,
            $endereco_final['uf'],
            $endereco_final['cidade'],
            $endereco_final['endereco'],
            $endereco_final['bairro'],
            $endereco_final['numero'],
            $endereco_final['complemento'],
            $endereco_final['latitude'],
            $endereco_final['longitude']
        );

        jsonReturn(array($result));
    }


    public function cadastroapp()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();
        $this->hash = $helper->cryptPassword2($this->input->password);

        $emailCheck = $helper->validateEmail(cryptitem($this->input->email));

        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $result['usuario'] = $usuarios->saveApp(
            $tipo = 1,
            cryptitem($this->input->nome),
            cryptitem($this->input->email),
            $this->hash,
            cryptitem($this->input->celular),
            $avatar = 'avatar.png',
            $this->data_atual,
            $status = '1',
            $status_aprovado = '1',
            cryptitem($this->input->data_nascimento),
            cryptitem($this->input->cpf)
        );


        jsonReturn(array($result));
    }

    public function updatecadastroapp()
    {

        $this->secure->tokens_secure($this->input->token);



        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        $this->hash = $helper->cryptPassword2($this->input->password);

        $emailCheck = $helper->validateEmailUpdate(cryptitem($this->input->email), $this->input->id_user);

        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $result = $usuarios->updateApp(
            $this->input->id_user,
            cryptitem($this->input->nome),
            cryptitem($this->input->email),
            cryptitem($this->input->celular),
            $this->hash
        );


        jsonReturn(array($result));
    }

    public function perfil()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $perfil = $helper->validatePerfil($this->input->id_user);

        jsonReturn(array($perfil));
    }
    public function perfilApp()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $perfil = $helper->validatePerfilApp($this->input->id_user);

        jsonReturn(array($perfil));
    }

    public function updateperfil()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        $cnpjCheck = $helper->validateCNPJUpdate(cryptitem($this->input->cnpj), $this->input->id);

        $emailCheck = $helper->validateEmailUpdate(cryptitem($this->input->email), $this->input->id);

        // VALIDAÇÕES DE EMAIL
        if ($cnpjCheck) {
            jsonReturn(array($cnpjCheck));
        }
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $result = $usuarios->updatePerfil(
            $this->input->id,
            cryptitem($this->input->nome_responsavel),
            $this->input->nome_fantasia,
            $this->input->razao_social,
            cryptitem($this->input->celular),
            cryptitem($this->input->email),
            cryptitem($this->input->cnpj),
            $this->input->tipo_loja
        );


        jsonReturn(array($result));
    }
    public function updateperfilApp()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        // $cpfCheck = $helper->validateCpfUpdate(tiraCarac($this->input->cpf), $this->input->id);

        $emailCheck = $helper->validateEmailUpdate(cryptitem($this->input->email), $this->input->id);

        // VALIDAÇÕES DE EMAIL
        // if ($cpfCheck) {
        //     jsonReturn(array($cpfCheck));
        // }
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $result = $usuarios->updatePerfilApp(
            $this->input->id,
            cryptitem($this->input->nome),
            cryptitem($this->input->data_nascimento),
            cryptitem($this->input->celular),
            cryptitem($this->input->email),
            cryptitem($this->input->cpf)
        );


        jsonReturn(array($result));
    }

    public function listPermissoes()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->listPermissoes();

        jsonReturn($result);
    }
    public function listAllChamados()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->listAllChamados($this->input->status,$this->input->setor);

        jsonReturn($result);
    }
    public function finalizarChamado()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->finalizarChamado($this->input->id_chamado);

        jsonReturn($result);
    }
    public function reabrirChamado()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->reabrirChamado($this->input->id_chamado);

        jsonReturn($result);
    }
    public function deleteChamado()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->deleteChamado($this->input->id_chamado);

        jsonReturn($result);
    }
    public function updateInfo()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->updateInfo($this->input->id_info, $this->input->instagram, $this->input->facebook, $this->input->twitter, $this->input->site, $this->input->link);

        jsonReturn(array($result));
    }

    public function saveUsersInfo()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->saveUsersInfo($this->input->id_user, $this->input->instagram, $this->input->facebook, $this->input->twitter, $this->input->site, $this->input->link);

        jsonReturn(array($result));
    }


    public function meuplano()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $plano = $helper->verificaPlano($this->input->id);

        jsonReturn(array($plano));
    }

    public function aprovarUsuario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $aprovar = $usuarios->aprovarUsuario($this->input->id_usuario,$this->input->numero_paciente,$this->input->numero_estudo,$this->input->nome_visita);

        //manda notificação para usuario
        $notificacao = new Notificacoes();
        $notificacao->aprovouCadastro("aprovou-cadastro", $this->input->id_usuario);

      //manda notificação para usuario FIM

        jsonReturn(array($aprovar));
    }


    public function savefcm()
    {

        $usuariosOBJ =  new Usuarios();

        $verifica = $usuariosOBJ->verificaFcmUser($this->input->id_user);

        if($verifica == 0){
          $result = $usuariosOBJ->saveFcmUser($this->input->id_user, $this->input->type, $this->input->registration_id);
        }else{
          $result = $usuariosOBJ->updateFcmUser($this->input->id_user, $this->input->type, $this->input->registration_id);
        }


        jsonReturn(array($result));
    }


    public function updateavatar()
    {

        $this->app_users_id = $_POST['id_user'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../../uploads/avatar';

        $usuarios =  new Usuarios();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);
        } else {
            $this->avatar_final = "avatar.png";
        }

        $result = $usuarios->updateAvatar($this->app_users_id, $this->avatar_final);

        jsonReturn(array($result));
    }


    public function saveVitrine()
    {

        $this->app_users_id = $_POST['id_user'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../uploads/vitrines';

        $usuarios =  new Usuarios();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->vitrine = renameUpload(basename($_FILES['url']['name']));
        $this->vitrine_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->vitrine)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->vitrine_final = $this->vitrine;

            move_uploaded_file($this->vitrine_tmp, $this->pasta . "/temporarias/" . $this->vitrine_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->vitrine_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->vitrine_final;

            $imagem->largura = 1920;
            $imagem->altura = 1080;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->vitrine_final); // remove o arquivo da pasta temporária
        } else {
            $this->vitrine_final = "avatar.png";
        }

        $result = $usuarios->saveVitrine($this->app_users_id, $this->vitrine_final);

        jsonReturn(array($result));
    }
    public function updateVitrine()
    {

        $this->app_users_id = $_POST['id_user'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../uploads/vitrines';

        $usuarios =  new Usuarios();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->vitrineupdate = renameUpload(basename($_FILES['url']['name']));
        $this->vitrineupdate_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->vitrineupdate)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->vitrineupdate_final = $this->vitrineupdate;

            move_uploaded_file($this->vitrineupdate_tmp, $this->pasta . "/temporarias/" . $this->vitrineupdate_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->vitrineupdate_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->vitrineupdate_final;

            $imagem->largura = 1920;
            $imagem->altura = 1080;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->vitrineupdate_final); // remove o arquivo da pasta temporária
        } else {
            $this->vitrineupdate_final = "avatar.png";
        }

        $result = $usuarios->updateVitrine($this->app_users_id, $this->vitrineupdate_final);

        jsonReturn(array($result));
    }


    public function loginpainel()
    {
        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->validateLoginPainel($this->input->email, $this->input->password);

        jsonReturn(array($login));
    }


    public function busca()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->buscaApp($this->input->id_de, $this->input->nome);

        jsonReturn($login);
    }

    public function buscacoord()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        if (isset($this->input->lat_de, $this->input->lon_de)) {
            $login = $usuarios->buscaCoordApp($this->input->lat_de, $this->input->lon_de, $this->input->nome, $this->input->id_de);
        } else {
            $login = $usuarios->buscaCoordAppNome($this->input->nome);
        }
        jsonReturn($login);
    }

    public function avaliar()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->avaliarApp($this->input->id_de, $this->input->id_para, $this->input->estrelas, $this->input->descricao);

        jsonReturn(array($login));
    }

    public function listAvaliacoes()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->listAvaliacoes($this->input->id);

        jsonReturn(array($login));
    }

    public function verificaBtnAvaliar()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->verificaBtnAvaliar($this->input->id_de, $this->input->id_para);

        jsonReturn($login);
    }

    public function listfavoritos()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->listFavoritos($this->input->id_de);

        jsonReturn($login);
    }

    public function dest()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        if (isset($this->input->lat_de, $this->input->lon_de)) {

            $login = $usuarios->destApp($this->input->lat_de, $this->input->lon_de, $this->input->id_de);
        } else {
            $login = $usuarios->destApp2();
        }

        /*
        foreach ($login as $id) {
            $login2[] = $usuarios->buscarDados($this->input->id_de, $id['id']);
        }

        foreach ($login2 as $id2) {
            $login3[] = distLatLong($id2["latDe"], $id2["lonDe"], $id2["latPara"], $id2["lonPara"]);
        }*/

        jsonReturn($login);
    }

    public function listestabcateg()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        if (isset($this->input->id_de)) {
            $login = $usuarios->listEstabCateg($this->input->id_de, $this->input->id_categoria);
        } else {
            $login = $usuarios->listEstabCateg2($this->input->id_categoria);
        }
        jsonReturn($login);
    }

    public function favoritar()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->favoritarApp($this->input->id_de, $this->input->id_para);

        jsonReturn(array($login));
    }

    public function desfavoritar()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->desfavoritarApp($this->input->id_de, $this->input->id_para);

        jsonReturn(array($login));
    }

    public function distancia()
    {
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $login = $usuarios->buscarDados($this->input->id_de, $this->input->id_para);

        $distancia['distancia'] = distLatLongDistancia($login["latDe"], $login["lonDe"], $login["latPara"], $login["lonPara"]);

        $distancia['duracao'] = distLatLongDuracao($login["latDe"], $login["lonDe"], $login["latPara"], $login["lonPara"]);

        jsonReturn(array($distancia));
    }

    public function listenderecos()
    {
        $this->secure->tokens_secure($this->input->token);

        $enderecos = new Enderecos();
        $login = $enderecos->listEnderecos($this->input->id_user);

        jsonReturn($login);
    }


    public function recuperarsenha()
    {

        $usuariosOBJ =  new Usuarios();
        $usuariosOBJ->recuperarsenha(cryptitem($this->input->email));
    }

    public function updatepasswordtoken()
    {

        $usuariosOBJ =  new Usuarios();
        $usuariosOBJ->updatepasswordtoken($this->input->password,$this->input->token);
    }
    public function pesquisaProduto() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $lista = $usuarios->pesquisaProduto($this->input->id_usuario,$this->input->id_estabelecimento,$this->input->nome_produto,$this->input->marca,$this->input->distancia,$this->input->categoria,
        $this->input->subcategoria,$this->input->genero,$this->input->oferta,$this->input->cor,$this->input->latitude,$this->input->longitude);

        jsonReturn($lista);
    }
    public function pesquisarProdutosLoja() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $lista = $usuarios->pesquisarProdutosLoja($this->input->id_usuario,$this->input->id_estabelecimento,$this->input->nome_produto,$this->input->marca,$this->input->distancia,$this->input->categoria,
        $this->input->subcategoria,$this->input->genero,$this->input->oferta,$this->input->cor,$this->input->latitude,$this->input->longitude);

        jsonReturn($lista);
    }
    public function pesquisaEstabelecimento() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $lista = $usuarios->pesquisaEstabelecimento($this->input->nome_fantasia,$this->input->razao_social,$this->input->latitude,$this->input->longitude);

        jsonReturn($lista);
    }

    public function updateendereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper_enderecos = new EnderecosHelper();
        $enderecos =  new Enderecos();

        $endereco_final = $helper_enderecos->gerarEndereco($lat = "", $long = "", $this->input->cep, $this->input->estado, $this->input->cidade, $this->input->endereco, $this->input->bairro, $this->input->numero, $this->input->complemento);

        $cep_final = str_replace('-', '', $endereco_final['cep']);

        $resultado = $enderecos->update(
            $this->input->id_endereco,
            cryptitem($this->input->cep),
            cryptitem($this->input->estado),
            cryptitem($this->input->cidade),
            cryptitem($this->input->endereco),
            cryptitem($this->input->bairro),
            cryptitem($this->input->numero),
            cryptitem($this->input->complemento),
            cryptitem($endereco_final['latitude']),
            cryptitem($endereco_final['longitude'])
        );

        //$endereco_final['id_usuario'] = $enderecos->consultaId($this->input->id_endereco);

        jsonReturn($resultado);
    }

    public function removeendereco()
    {

        $this->secure->tokens_secure($this->input->token);


        $enderecos =  new Enderecos();

        $resultado = $enderecos->removeEndereco($this->input->id_endereco);


        jsonReturn(array($resultado));
    }

    public function updatepassword()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        //$usuarioDados = $usuarios->listid_franqueado($this->input->id);

        $this->hash = $helper->cryptPassword2($this->input->password);

        $result = $usuarios->updatePassword($this->input->id, $this->hash);

        jsonReturn(array($result));
    }



    public function notificacoes(){

        $this->secure->tokens_secure($this->input->token);
        $usuarios = new Usuarios();

        $notificacoes = $usuarios->Notificacoes($this->input->id);

        jsonReturn($notificacoes);
    }

    public function desativarconta() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->desativarConta($this->input->id);

        jsonReturn(array($result));
    }

    public function listAllClientes()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->listAllClientes($this->input->id_estabelecimento,$this->input->nome_cliente,$this->input->email_cliente);

        jsonReturn($lista);
    }

    public function listAllVitrines()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->listAllVitrines();

        jsonReturn($lista);
    }

    public function listAllUsuariosAdmin()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $usuarios = new Usuarios();
        $lista = $usuarios->listAllUsuariosAdmin($this->input->id_user,$this->input->nome_usuario, $this->input->email_usuario);

        jsonReturn($lista);
    }

    public function listClientesId()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->listClientesId($this->input->id_cliente);

        jsonReturn($lista);
    }

    public function saveUsuarioAdmin()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $randomPassword = $this->generateRandomPassword(6);

        $this->hash = $helper->cryptPassword2($randomPassword);
        $emailCheck = $helper->validateEmailCliente(cryptitem($this->input->email));
        $celularCheck = $helper->validateCelularCliente(cryptitem($this->input->celular));
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }
        if ($celularCheck) {
            jsonReturn(array($celularCheck));
        }

        $usuarios = new Usuarios();
        $lista = $usuarios->saveUsuarioAdmin($this->input->id_grupo,cryptitem($this->input->nome),cryptitem($this->input->email),cryptitem($this->input->celular),$this->hash,$randomPassword);

        jsonReturn($lista);
    }

    private function generateRandomPassword($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomPassword = '';
    $maxIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, $maxIndex)];
    }
    // print_r($randomPassword);exit;
    return $randomPassword;
}

    public function updateCliente()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $find_estabelecimento = $helper->find_estabelecimento($this->input->id_cliente);
        // print_r($find_estabelecimento);exit;
        $emailCheck = $helper->validateEmailClienteUpdate($this->input->email,$this->input->id_cliente,$find_estabelecimento);
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $usuarios = new Usuarios();
        $lista = $usuarios->updateCliente($this->input->id_cliente,$this->input->nome,$this->input->email,$this->input->celular,
        dataUS($this->input->data_nascimento),$this->input->cep,$this->input->estado,$this->input->cidade,$this->input->endereco,
        $this->input->bairro,$this->input->numero,$this->input->complemento,$this->input->status);

        jsonReturn($lista);
    }

    public function updateUsuarioAdmin()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();

        // print_r($find_estabelecimento);exit;
        $emailCheck = $helper->validateEmailClienteUpdate(cryptitem($this->input->email),$this->input->id_user);
        $celularCheck = $helper->validateCelularClienteUpdate(cryptitem($this->input->celular),$this->input->id_user);
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }
        if ($celularCheck) {
            jsonReturn(array($celularCheck));
        }

        $usuarios = new Usuarios();
        $lista = $usuarios->updateUsuarioAdmin($this->input->id_user,$this->input->id_grupo,cryptitem($this->input->nome),cryptitem($this->input->email),cryptitem($this->input->celular),$this->input->status);

        jsonReturn($lista);
    }

    public function deleteCliente()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->deleteCliente($this->input->id_cliente);

        jsonReturn($lista);
    }
    public function deleteVitrine()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->deleteVitrine($this->input->id_cliente);

        jsonReturn($lista);
    }
    public function deleteUsuario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->deleteUsuario($this->input->id_user);

        jsonReturn($lista);
    }

    public function listLog()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->listLog($this->input->id_estabelecimento,dataUS($this->input->data_in),dataUS($this->input->data_out));

        jsonReturn($lista);
    }

    public function lista()
    {

        $this->secure->tokens_secure($this->input->token);

        // $login['status'] = '01';
        // $login['id'] = '01';
        // $login['id_grupo'] = '01';
        // jsonReturn(array($login));

        $helper = new UsuariosHelper();
        $login = $helper->lista();

        jsonReturn(array($login));
    }
}
