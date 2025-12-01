<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Chat/Chat.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';

class ChatController
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

    public function listchat()
    {

        $this->secure->tokens_secure($this->input->token);

        $chat =  new Chat();
        
        $result = $chat->listChat($this->input->id,$this->input->type,$this->input->nome);

        jsonReturn($result);


    }
    public function listchatID()
    {

        $this->secure->tokens_secure($this->input->token);

        $chat =  new Chat();

        $result = $chat->listChatID($this->input->id_de, $this->input->id_para);

        jsonReturn($result);
    }
    public function updatechat()
    {

        $this->secure->tokens_secure($this->input->token);

        $chat =  new Chat();

        $chat = $chat->updateChat($this->input->id_de,$this->input->id_para);

        jsonReturn($chat);
    }
    public function updatemensagem()
    {

        $this->secure->tokens_secure($this->input->token);
        $chat =  new Chat();
        $chat = $chat->updateMensagem($this->input->id, $this->input->mensagem);

        jsonReturn($chat);
    }
    public function deletechat()
    {

        $this->secure->tokens_secure($this->input->token);

        $chat =  new Chat();
        $chat = $chat->deleteChat($this->input->id);

        jsonReturn($chat);
    }

    public function mensagemNLida()
    {

        $this->secure->tokens_secure($this->input->token);

        $chat =  new Chat();
        
        $result = $chat->mensagemNLida($this->input->id);

        jsonReturn($result);


    }
    public function savechat()
    {

        $this->id_de = $_POST['id_de'];
        $this->id_para = $_POST['id_para'];
        $this->type = $_POST['type'];
        $this->mensagem = $_POST['mensagem'];

        $this->secure->tokens_secure($_POST['token']);

        // $this->pasta_anexos = '../../uploads/chat/anexos';
        // $this->pasta_audios = '../../uploads/chat/audios';
        // $this->pasta_imagens = '../../uploads/chat/imagens';
        // $this->pasta_videos = '../../uploads/chat/videos';

        $chat =  new Chat();


        $this->url = renameUpload(basename($_FILES['url']['name']));
        $this->url_tmp = $_FILES['url']['tmp_name'];
        $this->url_final = $this->url;

        if (!empty($this->url)) {

            switch ($this->type) {

              //imagem
              case '2':

              move_uploaded_file($this->url_tmp, $this->pasta_imagens . "/temporarias/" . $this->url_final);

              $imagem = new TutsupRedimensionaImagem();

              $imagem->imagem = $this->pasta_imagens . '/temporarias/' . $this->url_final;
              $imagem->imagem_destino = $this->pasta_imagens . '/' . $this->url_final;

              $imagem->largura = 800;
              $imagem->altura = 0;
              $imagem->qualidade = 100;

              $nova_imagem = $imagem->executa();

              unlink($this->pasta_imagens . "/temporarias/" . $this->url_final); // remove o arquivo da pasta temporária

              break;

              //audio
              case '3':

              move_uploaded_file($this->url_tmp, $this->pasta_audios . "/" . $this->url_final);

              break;

              //anexo
              case '4':

              move_uploaded_file($this->url_tmp, $this->pasta_anexos . "/" . $this->url_final);

              break;

              //videos
              case '6':

              move_uploaded_file($this->url_tmp, $this->pasta_videos . "/" . $this->url_final);

              break;
            }

        }

        $result = $chat->saveChat($this->id_de, $this->id_para, $this->type, $this->url_final, $this->mensagem);

        // //ENVIAR GCM
        $gcm = new Gcm();
        $gcm->notificacao_android_user("Nova mensagem", $this->mensagem,$this->id_para,$this->id_de);
        $gcm->notificacao_ios_user("Nova mensagem", $this->mensagem,$this->id_para,$this->id_de);


        jsonReturn(array($result));

    }
}
