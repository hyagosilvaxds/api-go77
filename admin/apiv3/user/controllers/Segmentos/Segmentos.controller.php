<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Segmentos/Segmentos.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';

class SegmentosController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 16;
    }
    

    public function listAllSegmentos()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);
        $segmentos =  new Segmentos();
        $consultaprofissionais = $segmentos->listAllSegmentos($this->input->id_segmento);

        jsonReturn($consultaprofissionais);
    }

    public function exportarCsv() {
        // Crie o arquivo CSV
        $segmentos =  new Segmentos();
        $segmentos->gerarCSV();
    
        
        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }
    
    public function saveSegmento()
    {
        
        $this->descricao = $_POST['descricao'];
        $this->nome = $_POST['nome'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../../uploads/categorias';

        $segmentos =  new Segmentos();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->vitrine = renameUpload(basename($_FILES['url']['name']));
        $this->vitrine_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->vitrine)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->vitrine_final = $this->vitrine;

            move_uploaded_file($this->vitrine_tmp, $this->pasta . "/" . $this->vitrine_final);


        } else {
            $this->vitrine_final = "avatar.png";
        }

        $result = $segmentos->saveSegmento($this->nome,$this->vitrine_final,$this->descricao);

        jsonReturn(array($result));
    }

    public function updateSegmento()
    {
        
        $this->id_segmento = $_POST['id_segmento'];
        $this->status = $_POST['status'];
        $this->descricao = $_POST['descricao'];
        $this->nome = $_POST['nome'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../../uploads/categorias';

        $segmentos =  new Segmentos();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->vitrine = renameUpload(basename($_FILES['url']['name']));
        $this->vitrine_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->vitrine)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->vitrine_final = $this->vitrine;

            move_uploaded_file($this->vitrine_tmp, $this->pasta . "/" . $this->vitrine_final);


        } else {
            $this->vitrine_final = null;
        }

        $result = $segmentos->updateSegmento($this->id_segmento,$this->nome,$this->vitrine_final,$this->descricao,$this->status);

        jsonReturn(array($result));
    }
    

   
 
   
    public function deleteSegmento()
    {

        $this->secure->tokens_secure($this->input->token);

        $segmentos = new Segmentos();

        $consultaprofissionais = $segmentos->deleteSegmento($this->input->id_segmento);

        jsonReturn($consultaprofissionais);
    }

   

}

