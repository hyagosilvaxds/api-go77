<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';
//require_once MODELS . '/Mp/order.php';


class UsuariosController
{

    public function __construct()
    {
        // print_r("teste");exit;
        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
    }


    public function doisFatores()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $login = $helper->validateDoisFatores(cryptitem($this->input->email), $this->input->password, $this->input->latitude, $this->input->longitude);

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
          $result = $usuarios->cadastroApp(
            cryptitem($this->nome),
            cryptitem($this->email),
            $this->hash,
            cryptitem($this->celular)
            );
            $usuarios->criaAvaliacao($result['id']);

            $usuarios->savePlanoGratis($result['id']);

            $usuarios->criaSaldo($perfil['id']);

            $usuarios->saveLocation($result['id'],$this->input->latitude, $this->input->longitude);

            $email->novoCadastro($this->input->nome,$this->input->email);

          jsonReturn(array($result));

        }




    }

    public function tiposCarros()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        $result = $usuarios->tiposCarros();

        jsonReturn($result);


    }
    public function savePix()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->savePix($this->input->id_user,$this->input->tipo_chave,$this->input->chave);

        jsonReturn($lista);
    }
    public function login()
    {
        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();

        $login = $helper->validateLogin(cryptitem($this->input->email), $this->input->password, $this->input->tipo);

        if($this->input->email=='motorista@teste.com' && $this->input->codigo==1234){
            jsonReturn(array($login));
        }
        if($this->input->email=='passageiro@teste.com' && $this->input->codigo==1234){
            jsonReturn(array($login));
        }
        if($this->input->email=='victorsilva428@gmail.com' && $this->input->codigo==1234){
            jsonReturn(array($login));
        }

        $validacao = $helper->verificaCod($login['id'], $this->input->codigo);
        if ($validacao['status']==2) {
            jsonReturn(array($validacao));
        }

        jsonReturn(array($login));
    }

    public function cadastroapp()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios = new Usuarios();
        $enderecos = new Enderecos();
        $enderecosHelper = new EnderecosHelper();
        $email = new EnviarEmail();


        $emailCheck = $helper->validateEmail(cryptitem($this->input->email));
        // $celularCheck = $helper->validateCelular(cryptitem($this->input->celular));


        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }
        if ($celularCheck) {
            jsonReturn(array($celularCheck));
        }

        $this->hash = $helper->cryptPassword2($this->input->password);
        $usuarios = new Usuarios();


        $perfil = $usuarios->cadastroApp(cryptitem($this->input->nome), cryptitem($this->input->email), $this->hash, cryptitem($this->input->celular));

        $usuarios->saveLocation($perfil['id'],$this->input->latitude, $this->input->longitude);
        $usuarios->criaSaldo($perfil['id']);

        $email->novoCadastro($this->input->nome,$this->input->email);

        jsonReturn(array($perfil));
    }
    public function updateLocation()
    {

        $this->secure->tokens_secure($this->input->token);

        // gerarLogUserEntrada($this->input,$this->input->id_usuario,"updateLocation");

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateLocation($this->input->id_usuario,$this->input->latitude, $this->input->longitude);
        $perfil['corrida'] = null;
        // $verificaOnline = $usuarios->verificaOnline($this->input->id_usuario);

        // if($verificaOnline > 0){
        //     $perfil['corrida'] = $usuarios->listCorrida($this->input->id_usuario);
        // }

        // gerarLogUserSaida($result,$this->input->id_usuario,"updateLocation");

        jsonReturn($perfil);
    }
    public function verificaSplit()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->perfil($this->input->id_usuario);
        $lista = $usuarios->verificaSplit($perfil['split']);

        jsonReturn($lista);
    }

    public function saveSplit()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        $perfil = $usuarios->perfil($this->input->id_usuario);

        $verifica = $usuarios->verificaSplit($perfil['split']);
        if($verifica['status'] == 1){
            //editar informações existentes
            $lista = $usuarios->updateSplit($this->input->id_usuario,tiraCarac($this->input->cpf),$this->input->nome_conta,$this->input->codigo_banco,$this->input->numero_agencia,$this->input->digito_agencia
            ,$this->input->numero_conta,$this->input->digito_conta,$this->input->tipo_conta,$perfil['email'],$perfil['split']);
        }else{
            $lista = $usuarios->saveSplit($this->input->id_usuario,tiraCarac($this->input->cpf),$this->input->nome_conta,$this->input->codigo_banco,$this->input->numero_agencia,$this->input->digito_agencia
            ,$this->input->numero_conta,$this->input->digito_conta,$this->input->tipo_conta,$perfil['email']);
        }

        jsonReturn($lista);
    }

    public function procuraSolicitacao()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil['corrida'] = null;
        $verificaOnline = $usuarios->verificaOnline($this->input->id_usuario);

        if($verificaOnline > 0){
            $perfil['corrida'] = $usuarios->listCorrida($this->input->id_usuario);
        }


        jsonReturn($perfil);
    }
    public function saveEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $lista = new Usuarios();
        $lat_long = geraLatLong($this->input->endereco,$this->input->numero,$this->input->bairro, $this->input->cidade);
        $resultado = $lista->saveEndereco($this->input->id_user,cryptitem($this->input->cep),cryptitem($this->input->estado),
        cryptitem($this->input->cidade),cryptitem($this->input->endereco),cryptitem($this->input->bairro),cryptitem($this->input->numero),cryptitem($this->input->complemento),cryptitem($lat_long[0]),cryptitem($lat_long[1]));

        jsonReturn($resultado);
    }

    public function meusEnderecos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->meusEnderecos($this->input->id_user);

        jsonReturn($perfil);
    }

    public function buscaEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        gerarLog($this->input);
        $perfil = $usuarios->buscaEndereco($this->input->end_busca,$this->input->id_user,$this->input->latitude,$this->input->longitude);

        jsonReturn($perfil);
    }
    public function ativarUsuarioDev()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->ativarUsuarioDev($this->input->id_user);

        jsonReturn($perfil);
    }
    public function suporte()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->suporte();

        jsonReturn($perfil);
    }
    public function listComissoes()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listComissoes($this->input->id_user,dataUS($this->input->data_de),dataUS($this->input->data_ate));

        jsonReturn($perfil);
    }

    public function listComissoesSUM()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listComissoesSUM($this->input->id_user,dataUS($this->input->data_de),dataUS($this->input->data_ate));

        jsonReturn(array($perfil));
    }

    public function cancelamentos()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->cancelamentos($this->input->tipo,$this->input->cancelar_corrida);

        jsonReturn($perfil);
    }


    public function meusEnderecosSave()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->meusEnderecosSave($this->input->id_user,cryptitem($this->input->nome),cryptitem($this->input->end_completo),cryptitem($this->input->latitude),cryptitem($this->input->longitude));

        jsonReturn(array($perfil));
    }
    public function meusEnderecosDelete()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->meusEnderecosDelete($this->input->id_endereco);

        jsonReturn(array($perfil));
    }



    public function listCategorias()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listCategorias();

        jsonReturn($perfil);
    }
    public function listaFuncionariosId()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listaFuncionariosId($this->input->id_empresa,$this->input->id_funcionario);

        jsonReturn($perfil);
    }
    public function updateStatusFuncionario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateStatusFuncionario($this->input->id_empresa,$this->input->id_funcionario);

        jsonReturn($perfil);
    }
    public function verificatokencadastro()
    {

        $usuarios =  new Usuarios();
        $usuarios->verificatokenCadastro($this->input->token_cadastro);
    }

    public function verificatoken()
    {

        $usuarios =  new Usuarios();
        $usuarios->verificatoken($this->input->token_senha);
    }

    public function atualizarlocalizacao()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        $perfil = $usuarios->updateLocation($this->input->id, $this->input->latitude, $this->input->longitude);

        jsonReturn(array($perfil));
    }

    public function verificaEmail()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $validate = $helper->validateEmailEtapa1($this->input->email);

        jsonReturn(array($validate));
    }


    public function verificaPlano()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();


        $result=$usuarios->verificaplano($this->input->id_user);
        jsonReturn(array($result));
    }
    public function planoUser()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->planoUser($this->input->id_user);
        jsonReturn($result);
    }
    public function listPlanos()
    {

        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->listPlanos();
        jsonReturn($result);
    }
    public function listConfig()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->listConfig();
        jsonReturn($result);
    }
    public function listBanners()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->listBanners();
        jsonReturn($result);
    }
    public function valorTurbinar()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->valorTurbinar();
        jsonReturn($result);
    }
    public function planosHistorico()
    {
        $this->secure->tokens_secure($this->input->token);
        $usuarios =  new Usuarios();

        $result=$usuarios->planosHistorico($this->input->id_user);
        jsonReturn($result);
    }


    public function recuperarsenha()
    {

        $usuarios =  new Usuarios();
        // gerarLog($this->input);
        $result=$usuarios->recuperarSenha(cryptitem($this->input->email));
        jsonReturn($result);


    }

    public function confirmar()
    {

        $usuarios =  new Usuarios();
        $usuarios->confirmartoken($this->input->token);
    }



    public function updatepassword()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();


        $this->hash = $helper->cryptPassword2($this->input->password);
        $result = $usuarios->updatePassword($this->input->id, $this->hash);

        jsonReturn(array($result));
    }

    public function updatepasswordtoken()
    {
        // $this->secure->tokens_secure($this->input->token);

        $usuariosOBJ =  new Usuarios();
        $usuariosOBJ->updatepasswordtoken($this->input->password,$this->input->token_senha);
    }


    public function updateavatar()
    {

        $this->app_users_id = $_POST['id_user'];

        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/avatar';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

            // print_r($imagem->imagem_destino);exit;

            $imagem->largura = 250;
            $imagem->altura = 0;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
        } else {
            $this->avatar_final = "avatar.png";
        }

        $result = $usuarios->updateAvatar($this->app_users_id, $this->avatar_final);

        jsonReturn($result);
    }
    public function updateDoc()
    {

        $this->app_users_id = $_POST['id_user'];

        $this->tipo = $_POST['tipo'];

        $this->lado = $_POST['lado'];

        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/documento';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

            // print_r($imagem->imagem_destino);exit;

            $imagem->largura = 800;
            $imagem->altura = 0;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
        } else {
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro ao enviar a imagem"
            ];
            jsonReturn(array($Param));
        }


        $result = $usuarios->updateDoc($this->app_users_id, $this->avatar_final,$this->lado,$this->tipo);

        jsonReturn($result);
    }


    public function perfil()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->Perfil($this->input->id_user);

        jsonReturn($perfil);
    }
    public function listObras()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $listObras = $usuarios->listObras($this->input->id_user);

        jsonReturn($listObras);
    }
    public function listServicos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $listServicos = $usuarios->listServicos($this->input->id_obra);

        jsonReturn($listServicos);
    }
    public function listBriefing()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $listBriefing = $usuarios->listBriefing($this->input->id_tarefa,$this->input->id_obra);

        jsonReturn($listBriefing);
    }
    public function updateBriefing()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();

        //pega id do serviço recebendo o (briefing/pergunta/campo)
        $pegaServico = $usuarios->servicoPelaPergunta($this->input->id_briefing);
        // verifica se o serviço pode ou nao ultrapassar a qtd maxima
        $verificaStatusUltrapassar = $usuarios->verificaServicoUltrapassar($pegaServico['id_servico']);

        //se o serviço puder ultrapassar, ele é "= 1" , se nao puder ultrapassar faz a logica para validar a quantidade que vai ser inserida
        if($verificaStatusUltrapassar['qtd_ultrapassar'] == 1){
            $updateBriefing = $usuarios->updateBriefing($this->input->id_obra,$this->input->id_briefing,$this->input->qtd_respondida);
        }else{

            //verifica a qtd disponivel para no serviço
            $verificaDisponivel = $usuarios->ultrapassarRestante($pegaServico['id_servico'],$this->input->id_obra);

            //verifica se ja existem lançamentos feitos num array briefings (caso possa ter mais de 1 pergunta por tarefa)
            $verificaLancamentos = $usuarios->verificaLancamentos($this->input->id_briefing,$this->input->id_obra);

            //verifica o resultado do valor que esta sendo inserido (com o calculo da formula)
            $verificaAtual = $usuarios->calculaValorAtual($this->input->id_briefing,$this->input->qtd_respondida);

            //verifica o resultado do valor de todos os valores previamente lançados e somados
            $verificaAnterior = $usuarios->calculaValorAtual($verificaLancamentos['briefings'],$verificaLancamentos['qtd']);

            //se o valor que foi inserido + valor que ja existia cadastrado - o valor que ja foi inserido referente a esse briefing for >= a quantidade maxima permidada
            if(($verificaAtual + $verificaDisponivel['valor_consumido'] - $verificaAnterior)>= $verificaDisponivel['maximo_ultrapassar']){
                // $mensagem = " valor atual : " .$verificaAtual. " --valor anterior : " .  $verificaDisponivel[0]['valor_consumido']. " -- valor disponivel: ". $verificaDisponivel[0]['maximo_ultrapassar'] ;
                $mensagem = " Quantidade máxima do serviço foi excedida" ;

            }else{
                $updateBriefing = $usuarios->updateBriefing($this->input->id_obra,$this->input->id_briefing,$this->input->qtd_respondida);
                // $updateBriefing =[
                //     "status" => "02",
                //     "msg" => $mensagem,
                //     "verificaDisponivel" => $verificaDisponivel,
                //     "verificaLancamentos" => $verificaLancamentos,
                //     "verificaAnterior" => $verificaAnterior,
                //     "verificaAtual" => $verificaAtual
                // ];
            }
        }
        if($updateBriefing == null){
            $updateBriefing =[
                "status" => "02",
                "msg" => $mensagem,
                // "verificaDisponivel" => $verificaDisponivel,
                // "verificaLancamentos" => $verificaLancamentos,
                // "verificaAnterior" => $verificaAnterior,
                // "verificaAtual" => $verificaAtual
            ];
        }
        jsonReturn($updateBriefing);

    }
    public function listFotos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $listFotos = $usuarios->listFotos($this->input->id_obra);

        jsonReturn($listFotos);
    }
    public function deleteFotos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $deleteFotos = $usuarios->deleteFotos($this->input->id_foto);

        jsonReturn($deleteFotos);
    }


    public function listEquipe()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $listEquipe = $usuarios->listEquipe($this->input->id_obra);

        jsonReturn($listEquipe);
    }
    public function updateEquipe()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $updateEquipe = $usuarios->updateEquipe($this->input->id_obra,$this->input->id_funcionario,$this->input->tipo_equipe,hora($this->input->date_in),hora($this->input->date_out));

        jsonReturn($updateEquipe);
    }

    public function saveFotos()
    {

        $this->id_obra = $_POST['id_obra'];

        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/obras';

        $usuarios =  new Usuarios();


        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;

            move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

            $imagem->largura = 800;
            $imagem->altura = 0;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária

            $result = $usuarios->saveFotos($this->id_obra, $this->avatar_final);
            jsonReturn(array($result));
        } else {
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro ao salvar a imagem"
            ];
            jsonReturn(array($Param));
        }


    }
    public function updateUserEnd()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();
        $result = $usuarios->updateEmpresaEnd(
                $this->input->id,
                tiraCarac($this->input->cep),
                $this->input->estado,
                $this->input->cidade,
                $this->input->bairro,
                $this->input->endereco,
                $this->input->numero,
                $this->input->complemento
            );



        jsonReturn(array($result));
    }

    public function updateUser()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        $result = $usuarios->update(
            $this->input->id,
            $this->input->tipo_pessoa,
            cryptitem($this->input->nome),
            cryptitem($this->input->celular),
            cryptitem(dataUS($this->input->data_nascimento)),
            cryptitem($this->input->cpf),
            cryptitem($this->input->cnpj),
            cryptitem($this->input->razao_social),
            cryptitem($this->input->nome_fantasia),
            cryptitem($this->input->ie)
        );
        jsonReturn(array($result));
    }
    public function updateInteresses()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $usuarios =  new Usuarios();

        $result=$usuarios->saveInteresse($this->input->id_user,$this->input->interesses);

        jsonReturn(array($result));
    }

    public function listDocs()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result=$usuarios->listDocs($this->input->id_user);

        jsonReturn($result);
    }

    public function listVeiculo()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result=$usuarios->listVeiculo($this->input->id_user);

        jsonReturn($result);
    }
    public function updateVeiculo()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result=$usuarios->updateVeiculo($this->input->id_user,$this->input->modelo,$this->input->marca,$this->input->ano,$this->input->cor,$this->input->placa,$this->input->pais,$this->input->tipo);

        jsonReturn($result);
    }
    public function listMarcas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuariosOBJ =  new Usuarios();

        $result = $usuariosOBJ->listMarcas();

        jsonReturn($result);
    }


    public function Notificacoes()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuariosOBJ =  new Usuarios();

        $result = $usuariosOBJ->Notificacoes($this->input->id);

        jsonReturn($result);
    }

    public function listUsuarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listUsuarios($this->input->type, $this->input->param, $this->input->id);

        jsonReturn($perfil);
    }

    public function saveMarcas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveMarcas($this->input->id_user,$this->input->nome,$this->input->status);

        jsonReturn($perfil);
    }
    public function updateMarcas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateMarcas($this->input->id_marca,$this->input->nome,$this->input->status);

        jsonReturn($perfil);
    }
    public function excluirMarcas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirMarcas($this->input->id_marca);

        jsonReturn($excluir);
    }

    public function listEquipamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listEquipamentos($this->input->id_user);

        jsonReturn($perfil);
    }
    public function saveEquipamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveEquipamentos($this->input->id_marca,$this->input->id_modelo,$this->input->nome,$this->input->ano,
        $this->input->serie,$this->input->horimetro,$this->input->proprietario,tiraCarac($this->input->placa),$this->input->status);

        jsonReturn($perfil);
    }
    public function updateEquipamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateEquipamentos($this->input->id_equipamento,$this->input->id_marca,$this->input->id_modelo,$this->input->nome,$this->input->ano,
        $this->input->serie,$this->input->horimetro,$this->input->proprietario,tiraCarac($this->input->placa),$this->input->status);

        jsonReturn($perfil);
    }
    public function excluirEquipamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirEquipamentos($this->input->id_equipamento);

        jsonReturn($excluir);
    }


    public function listTarefas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefas($this->input->frota_id);

        jsonReturn($perfil);
    }
    public function listTarefasId()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasId($this->input->tarefa_id);

        jsonReturn($perfil);
    }
    public function saveTarefas()
    {

        $this->secure->tokens_secure($this->input->token);
        $usuarios = new Usuarios();

        $equipamento=$usuarios->listEquipamentosId($this->input->id_equipamento);
        $nome= $equipamento['nome'] . " | " . $equipamento['modelo_nome'];
        $descricao=$usuarios->criaDescricao($equipamento);
        // print_r($descricao);exit;
        $perfil = $usuarios->saveTarefas($this->input->id_frota,$this->input->id_equipamento,$nome,$descricao);

        jsonReturn($perfil);
    }
    public function updateTarefas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateTarefas($this->input->id_tarefa,$this->input->id_frota,$this->input->id_equipamento,$this->input->nome,
        $this->input->descricao,$this->input->checklist,$this->input->status,dataHoraUS($this->input->data_in),dataHoraUS($this->input->data_out));

        jsonReturn($perfil);
    }
    public function excluirTarefas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirTarefas($this->input->id_tarefa);

        jsonReturn($excluir);
    }

    public function listTarefasFuncionarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasFuncionarios($this->input->id_tarefa);

        jsonReturn($perfil);
    }
    public function listTarefasFuncionariosAll()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasFuncionariosAll($this->input->id_tarefa,$this->input->id_empresa);

        jsonReturn($perfil);
    }
    public function saveTarefasFuncionarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveTarefasFuncionarios($this->input->id_tarefa,$this->input->id_funcionario);

        jsonReturn($perfil);
    }
    public function excluirTarefasFuncionarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirTarefasFuncionarios($this->input->id_tarefa,$this->input->id_funcionario);

        jsonReturn($excluir);
    }

    public function listTarefasChecklists()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasChecklists($this->input->id_tarefa);

        jsonReturn($perfil);
    }
    public function listTarefasChecklistsItens()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasChecklistsItens($this->input->id_checklist);

        jsonReturn($perfil);
    }
    public function updateTarefasChecklists()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateTarefasChecklists($this->input->id_checklist,$this->input->nome);

        jsonReturn($perfil);
    }
    public function updateTarefasCheckItens()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateTarefasCheckItens($this->input->id_check_item,$this->input->nome,dataHoraUS($this->input->previsao));

        jsonReturn($perfil);
    }
    public function checkItem()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->checkItem($this->input->id_checklist_item);

        jsonReturn($perfil);
    }
    public function saveTarefasChecklists()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveTarefasChecklists($this->input->id_tarefa,$this->input->nome);

        jsonReturn($perfil);
    }
    public function saveTarefasChecklistsItens()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveTarefasChecklistsItens($this->input->id_checklist,$this->input->nome,dataHoraUS($this->input->previsao));

        jsonReturn($perfil);
    }
    public function excluirTarefasChecklists()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirTarefasChecklists($this->input->id_checklist);

        jsonReturn($excluir);
    }
    public function excluirTarefasChecklistsItens()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirTarefasChecklistsItens($this->input->id_checklist_item);

        jsonReturn($excluir);
    }

    public function listModelos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listModelos($this->input->id_marca);

        jsonReturn($perfil);
    }
    public function listCores()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listCores();

        jsonReturn($perfil);
    }
    public function saveModelos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveModelos($this->input->id_marca,$this->input->nome,$this->input->status);

        jsonReturn($perfil);
    }
    public function updateModelos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateModelos($this->input->id_modelo,$this->input->nome,$this->input->status);

        jsonReturn($perfil);
    }
    public function excluirModelos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirModelos($this->input->id_modelo);

        jsonReturn($excluir);
    }





    public function listFrotas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listFrotas($this->input->id_user);

        jsonReturn($perfil);
    }
    public function excluirFrotas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirFrotas($this->input->id_frota);

        jsonReturn($excluir);
    }
    public function updateOrdemTarefa()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $ordem_atual = $usuarios->findOrdemTarefa($this->input->id_tarefa);

        $perfil = $usuarios->updateOrdemTarefa($this->input->id_tarefa,$this->input->tipo,$ordem_atual,$this->input->id_frota);

        jsonReturn($perfil);
    }

    public function updateOrdem()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $ordem_atual = $usuarios->findOrdem($this->input->id_frota);

        $perfil = $usuarios->updateOrdem($this->input->id_frota,$this->input->tipo,$ordem_atual,$this->input->id_user);

        jsonReturn($perfil);
    }
    public function saveFrotas()
    {
        $this->id_user = $_POST['app_users_id'];

        $this->secure->tokens_secure($_POST['token']);

        $this->nome = $_POST['nome'];

        $this->obs = $_POST['obs'];

        $this->pasta = '../../uploads/frotas';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

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
            $this->avatar_final = "frota.png";
        }

        $result = $usuarios->saveFrotas($this->id_user, $this->avatar_final, $this->nome,$this->obs);

        jsonReturn(array($result));
    }
    public function updateFrotas()
    {
        $this->id_frota = $_POST['id_frota'];
        $this->secure->tokens_secure($_POST['token']);
        $this->nome = $_POST['nome'];
        $this->obs = $_POST['obs'];
        $this->status = $_POST['status'];

        $this->pasta = '../../uploads/frotas';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

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
            $fotoFrota = $usuarios->findFotoFrota($this->id_frota);
            $this->avatar_final = $fotoFrota;
            // print_r($this->avatar_final);exit;
        }

        $result = $usuarios->updateFrotas($this->id_frota, $this->avatar_final, $this->nome,$this->obs,$this->status);

        jsonReturn(array($result));
    }

    public function savefcm()
    {

        $usuariosOBJ =  new Usuarios();
        $notificacoes =  new Notificacoes();

        $verifica = $usuariosOBJ->verificaFcmUser($this->input->id_user);

        if($verifica == 0){
          $result = $usuariosOBJ->saveFcmUser($this->input->id_user, $this->input->type, $this->input->registration_id);
        //   $type="cadastro-realizado";
        //   $notificacoes->save($type, $this->input->id_user, "","");

        }else{
          $result = $usuariosOBJ->updateFcmUser($this->input->id_user,$this->input->type, $this->input->registration_id);
        }


        jsonReturn(array($result));
    }
    public function atualizar_senha()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();

        $usuarios =  new Usuarios();

        //pegando os dados do usuário para a criptografia
        $usuarioDados = $usuarios->listId($this->input->id_usuario);

        // var_dump($usuarioDados[0]['nome']);
        // exit;

        $this->hash  = $helper->cryptPassword($this->input->password, $usuarioDados[0]['nome'], $usuarioDados[0]['email']);

        $result = $usuarios->updatePassword($this->input->id_usuario, $this->hash);

        jsonReturn(array($result));
    }
    public function desativarconta() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $result = $usuarios->desativarConta($this->input->id);

        jsonReturn(array($result));
    }
    public function ficarOnline() {

        $this->secure->tokens_secure($this->input->token);

        $usuarios =  new Usuarios();

        $docs=$usuarios->listDocs($this->input->id);
        if(($this->input->status == 1) AND ($docs['status'] == 2)){
            $Param = [
                "status" => "02",
                "msg" => "Deslogue do app, ocorreu um erro."
            ];
            jsonReturn(array($Param));
        }
        $result = $usuarios->ficarOnline($this->input->id,$this->input->status);

        jsonReturn(array($result));
    }


    public function listAllEnderecos()
    {

        $this->secure->tokens_secure($this->input->token);

        $enderecos =  new Enderecos();
        $endereco = $enderecos->listAllID($this->input->id_user);

        jsonReturn($endereco);
    }
    public function findEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $enderecos =  new Enderecos();
        $endereco = $enderecos->find($this->input->id_endereco);

        jsonReturn($endereco);
    }
    public function updateEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $helper_enderecos = new EnderecosHelper();
        $usuarios =  new Usuarios();
        $enderecos =  new Enderecos();

        $endereco_final =  $helper_enderecos->gerarEndereco($lat = "", $long = "", $this->input->cep, $this->input->estado, $this->input->cidade, $this->input->endereco, $this->input->bairro, $this->input->numero, $this->input->complemento);

        $cep_final = str_replace('-', '', $endereco_final['cep']);

        $result = $enderecos->update(
            $this->input->nome,
            $this->input->id_endereco,
            $cep_final,
            $this->input->estado,
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
    public function deleteEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $enderecos =  new Enderecos();
        $del = $enderecos->deleteEndereco($this->input->id_endereco);

        jsonReturn($del);
    }
    public function excluirFuncionario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirFuncionario($this->input->id_empresa,$this->input->id_funcionario);

        jsonReturn($excluir);
    }
    public function editarFuncionario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $helper = new UsuariosHelper();

        $emailCheck = $helper->validateEmailUpdate($this->input->email,$this->input->id_funcionario);
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        if($this->input->status == 2){$status = 2;}else{$status=1;}

        $lista = $usuarios->editarFuncionario($this->input->id_empresa,$this->input->id_funcionario,$this->input->nome,$this->input->email,
        $this->input->celular,tiraCarac($this->input->cpf),dataUS($this->input->data_nascimento),$status);

        jsonReturn($lista);
    }
    public function saveFuncionario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $helper = new UsuariosHelper();

        $emailCheck = $helper->validateEmail($this->input->email);
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $lista = $usuarios->saveFuncionario($this->input->id_empresa,$this->input->nome,$this->input->email,$this->input->celular,tiraCarac($this->input->cpf),dataUS($this->input->data_nascimento));

        jsonReturn($lista);
    }
    public function listaFuncionariosToken()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listaFuncionariosToken($this->input->token_cadastro);

        jsonReturn($perfil);
    }
    public function cadastroFuncionario()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $helper = new UsuariosHelper();
        $this->hash = $helper->cryptPassword2($this->input->password);
        $id_user=$usuarios->findUserIdByToken($this->input->token_cadastro);
        $perfil = $usuarios->cadastroFuncionario($this->input->token_cadastro,$this->hash,$id_user);

        jsonReturn($perfil);
    }
    public function saveAnexo()
    {
        $this->id_user = $_POST['id_usuario'];

        $this->secure->tokens_secure($_POST['token']);

        $this->tarefa_id = $_POST['tarefa_id'];

        $this->tipo = $_POST['tipo'];

        $this->pasta = '../../uploads/anexos';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {
            if($this->tipo == 1){
                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);
                // Verificar se o arquivo é uma imagem
                $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
                $imageInfo = getimagesize($this->pasta . '/temporarias/' . $this->avatar_final);

                if ($imageInfo !== false && in_array($imageInfo['mime'], $permitidos)) {
                    // O arquivo é uma imagem válida
                    $imagem = new TutsupRedimensionaImagem();

                    $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
                    $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

                    $imagem->largura = 600;
                    $imagem->altura = 0;
                    $imagem->qualidade = 100;

                    $nova_imagem = $imagem->executa();

                    unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária

                    $result = $usuarios->saveAnexo($this->tarefa_id, $this->id_user, $this->tipo, $this->avatar_final);
                } else {
                    // O arquivo não é uma imagem válida
                    unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
                    $result = [
                        "status" => "02",
                        "msg" => "O arquivo não é uma imagem válida."
                    ];
                }
            }else{
                //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
                $this->avatar_final = $this->avatar;
                move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);
                // Verificar se o arquivo é uma imagem
                $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
                $imageInfo = getimagesize($this->pasta . '/' . $this->avatar_final);
                if ($imageInfo == false) {
                    // O arquivo é diferente de uma imagem
                    $result = $usuarios->saveAnexo($this->tarefa_id, $this->id_user, $this->tipo, $this->avatar_final);
                }else{
                    unlink($this->pasta . "/" . $this->avatar_final); // remove o arquivo da pasta temporária
                    $result = [
                        "status" => "02",
                        "msg" => "Tipo incorreto, o arquivo é uma imagem."
                    ];
                }
            }
        }
        jsonReturn($result);
    }
    public function listAnexos()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listAnexos($this->input->tarefa_id);

        jsonReturn($perfil);
    }
    public function excluirAnexo()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirAnexo($this->input->id_anexo);

        jsonReturn($excluir);
    }
    public function listTarefasComentarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listTarefasComentarios($this->input->id_tarefa);

        jsonReturn($perfil);
    }
    public function excluirTarefasComentarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $excluir = $usuarios->excluirTarefasComentarios($this->input->id_comentario);

        jsonReturn($excluir);
    }
    public function saveTarefasComentarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->saveTarefasComentarios($this->input->id_tarefa,$this->input->id_usuario,$this->input->descricao);

        jsonReturn($perfil);
    }
    public function updateTarefasComentarios()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->updateTarefasComentarios($this->input->id_comentario,$this->input->id_usuario,$this->input->descricao);

        jsonReturn($perfil);
    }
    public function buscarCidades()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->buscarCidades($this->input->cidade);

        jsonReturn($perfil);
    }

    public function buscarEmpresas()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->buscarEmpresas($this->input->cidade,$this->input->hashtag);

        jsonReturn($perfil);
    }
    public function listParceiroId()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $perfil = $usuarios->listParceiroId($this->input->id_parceiro);

        jsonReturn($perfil);
    }

    public function importarCsv()
    {
        $this->secure->tokens_secure($_POST['token']);
        $usuarios =  new Usuarios();

        // $this->pasta = '../../uploads/planilhas';

        $this->arquivo_tmp = $_FILES['url']['tmp_name'];
        // $this->arquivo_nome = renameUpload(basename($_FILES['url']['name']));

        // move_uploaded_file($this->arquivo_tmp, $this->pasta . "/" . $this->arquivo_nome);


        $result = $usuarios->importarCsv($this->arquivo_tmp);


        jsonReturn(array($result));
    }
    public function enviarLog()
    {
        $this->secure->tokens_secure($_POST['token']);
        $id_user = $_POST['id_user'];
        gerarLogUserEntrada($id_user,$id_user,"enviarLog");
        $this->pasta = "../user/log/$id_user/";

        $usuarios =  new Usuarios();


        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "errorLog.txt");
            $Param = [
                "status" => "01",
                "msg" => "Log enviado"
            ];
            jsonReturn(array($Param));
        } else {
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro ao enviar o log"
            ];
            jsonReturn(array($Param));
        }
    }

    public function listCnpj()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $lista = $usuarios->listCnpj(tiraCarac($this->input->cnpj));

        jsonReturn($lista);
    }

}
