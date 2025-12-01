<?php
require_once MODELS . '/Conexao.class.php';

class Paginas extends Conexao {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $assunto;
    public $mensagem;
    public $data;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getAssunto() {
        return $this->assunto;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function setData($data) {
        $this->data = $data;
    }

    public function __construct() {
        $this->Conecta();
    }

    //EXEMPLO DE PÁGINA INTERNA
    public function PaginaInterna($action) {
        
        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tb_paginas` WHERE url_link='$action'");
        $sql->execute();
        $sql->bind_result($this->id, $this->url_link, $this->title, $this->titulo, $this->texto, $this->description, $this->keywords);
        $sql->fetch();

        $lista = array();
       $PaginasModel['id'] = $this->id;
       $PaginasModel['url_link'] = $this->url_link;
       $PaginasModel['title'] = $this->title;
       $PaginasModel['titulo'] = $this->titulo;
       $PaginasModel['texto'] = $this->texto;
       $PaginasModel['description'] = $this->description;
       $PaginasModel['keywords'] = $this->keywords;

        $lista[] = $PaginasModel;

        return $lista;
    }
    
    //EXEMPLO DE GALERIA PÁGINA INTERNA
    public function PaginaInternaGaleria($action) {

        $sql = $this->mysqli->prepare("
            SELECT b.url, b.legenda FROM `$this->tb_paginas` AS a 
            INNER JOIN `$this->tb_paginas_fotos` AS b 
            ON a.id = b.tb_paginas_id 
            WHERE a.url_link='$action'
            ");

        $sql->execute();
        $sql->bind_result($this->url, $this->legenda);

        $lista = array();
        while ($row = $sql->fetch()) {

            $PaginasModel['url'] = $this->url;
            $PaginasModel['legenda'] = $this->legenda;

            $lista[] = $PaginasModel;
        }
        return $lista;
    }

    //LISTA DE NOTÍCIAS
    public function Noticias() {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tb_noticias` WHERE ativo='1' ORDER BY id DESC");
        $sql->execute();
        $sql->bind_result($this->id, $this->categorias_id, $this->url_link, $this->titulo, $this->texto, $this->data, $this->horario, $this->url, $this->dest, $this->ativo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $registros = 10;
        $numPaginas = ceil($rows / $registros);
        $inicio = ($registros * $pagina) - $registros;

        $sql_paginacao = $this->mysqli->prepare("SELECT * FROM `$this->tb_noticias` WHERE ativo='1' ORDER BY id DESC LIMIT $inicio, $registros");
        $sql_paginacao->execute();
        $sql_paginacao->bind_result($this->id, $this->categorias_id, $this->url_link, $this->titulo, $this->texto, $this->data, $this->horario, $this->url, $this->dest, $this->ativo);

        $lista = array();
        while ($row = $sql_paginacao->fetch()) {

            $NoticiasModel['numPaginas'] = $numPaginas;
            $NoticiasModel['registros'] = $registros;
            $NoticiasModel['rows'] = $rows;
            $NoticiasModel['id'] = $this->id;
            $NoticiasModel['url_link'] = $this->url_link;
            $NoticiasModel['titulo'] = $this->titulo;
            $NoticiasModel['texto'] = $this->texto;
            $NoticiasModel['data'] = $this->data;
            $NoticiasModel['horario'] = $this->horario;
            $NoticiasModel['url'] = $this->url;
            $NoticiasModel['dest'] = $this->dest;
            $NoticiasModel['ativo'] = $this->ativo;

            $lista[] = $NoticiasModel;
        }
        return $lista;
    }

    //DETALHES DA NOTÍCIA
    public function NoticiasDetalhes($param) {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tb_noticias` WHERE url_link='$param'");
        $sql->execute();
        $sql->bind_result($this->id, $this->categorias_id, $this->url_link, $this->titulo, $this->texto, $this->data, $this->horario, $this->url, $this->dest, $this->ativo);
        $sql->fetch();

        $lista = array();
        $NoticiasModel['id'] = $this->id;
        $NoticiasModel['url_link'] = $this->url_link;
        $NoticiasModel['titulo'] = $this->titulo;
        $NoticiasModel['texto'] = $this->texto;
        $NoticiasModel['data'] = $this->data;
        $NoticiasModel['horario'] = $this->horario;
        $NoticiasModel['url'] = $this->url;
        $NoticiasModel['ativo'] = $this->ativo;

        $lista[] = $NoticiasModel;

        return $lista;
    }

    //GALERIA DA NOTÍCIA CONFORME PARAM
    public function NoticiasGaleria($param) {

        $sql = $this->mysqli->prepare("
            SELECT a.id, b.url, b.legenda FROM `$this->tb_noticias` AS a INNER JOIN `$this->tb_noticias_fotos` AS b ON a.id = b.tb_noticias_id 
            WHERE a.ativo='1' AND a.url_link='$param'
                ");

        $sql->execute();
        $sql->bind_result($this->id, $this->url, $this->legenda);

        $lista = array();
        while ($row = $sql->fetch()) {

            $NoticiasModel['id'] = $this->id;
            $NoticiasModel['url'] = $this->url;
            $NoticiasModel['legenda'] = $this->legenda;
            $NoticiasModel['url'] = $this->url;

            $lista[] = $NoticiasModel;
        }
        return $lista;
    }

    //LISTA DE DEPOIMENTOS
    public function Depoimentos() {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tb_depoimentos` WHERE ativo='1'");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->texto, $this->data, $this->url, $this->ativo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $registros = 10;
        $numPaginas = ceil($rows / $registros);
        $inicio = ($registros * $pagina) - $registros;

        $sql_paginacao = $this->mysqli->prepare("SELECT * FROM `$this->tb_depoimentos` WHERE ativo='1' LIMIT $inicio, $registros");
        $sql_paginacao->execute();
        $sql_paginacao->bind_result($this->id, $this->nome, $this->texto, $this->data, $this->url, $this->ativo);

        $lista = array();
        while ($row = $sql_paginacao->fetch()) {

            $DepoimentosModel['numPaginas'] = $numPaginas;
            $DepoimentosModel['registros'] = $registros;
            $DepoimentosModel['rows'] = $rows;
            $DepoimentosModel['id'] = $this->id;
            $DepoimentosModel['nome'] = $this->nome;
            $DepoimentosModel['texto'] = $this->texto;
            $DepoimentosModel['data'] = $this->data;
            $DepoimentosModel['url'] = $this->url;
            $DepoimentosModel['ativo'] = $this->ativo;

            $lista[] = $DepoimentosModel;
        }
        return $lista;
    }

    //LISTA DE VÍDEOS
    public function Videos() {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tb_videos` WHERE ativo='1'");
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->titulo, $this->url, $this->ativo);

        $lista = array();
        while ($row = $sql->fetch()) {

            $VideosModel['id'] = $this->id;
            $VideosModel['tipo'] = $this->tipo;
            $VideosModel['titulo'] = $this->titulo;
            $VideosModel['url'] = $this->url;
            $VideosModel['ativo'] = $this->ativo;

            $lista[] = $VideosModel;
        }
        return $lista;
    }

    //LISTA DE GALERIAS
    public function Galerias() {

        $sql = $this->mysqli->prepare("
            SELECT a.id, a.nome, a.ativo, b.url, b.dest FROM `$this->tb_galerias` AS a INNER JOIN `$this->tb_galerias_fotos` AS b ON a.id = b.tb_galerias_id 
            WHERE a.ativo='1' GROUP BY a.nome ORDER BY a.id DESC
                ");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->ativo, $this->url, $this->dest);
        $sql->store_result();
        $rows = $sql->num_rows;

        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $registros = 10;
        $numPaginas = ceil($rows / $registros);
        $inicio = ($registros * $pagina) - $registros;

        $sql_paginacao = $this->mysqli->prepare("
            SELECT a.id, a.nome, a.ativo, b.url, b.dest FROM `$this->tb_galerias` AS a INNER JOIN `$this->tb_galerias_fotos` AS b ON a.id = b.tb_galerias_id
            WHERE a.ativo='1' GROUP BY a.nome ORDER BY a.id DESC LIMIT $inicio, $registros     
                ");
        $sql_paginacao->execute();
        $sql_paginacao->bind_result($this->id, $this->nome, $this->ativo, $this->url, $this->dest);

        $lista = array();
        while ($row = $sql->fetch()) {

            $GalerialModel['numPaginas'] = $numPaginas;
            $GalerialModel['registros'] = $registros;
            $GalerialModel['rows'] = $rows;
            $GalerialModel['id'] = $this->id;
            $GalerialModel['nome'] = $this->nome;
            $GalerialModel['ativo'] = $this->ativo;
            $GalerialModel['url'] = $this->url;
            $GalerialModel['dest'] = $this->dest;

            $lista[] = $GalerialModel;
        }
        return $lista;
    }

    //DETALHES DA GALERIA
    public function GaleriasDetalhes($param) {

        $sql = $this->mysqli->prepare("SELECT id, url, legenda FROM `$this->tb_galerias_fotos` WHERE tb_galerias_id='$param'");
        $sql->execute();
        $sql->bind_result($this->id, $this->url, $this->legenda);

        $lista = array();
        while ($row = $sql->fetch()) {

            $GalerialModel['id'] = $this->id;
            $GalerialModel['url'] = $this->url;
            $GalerialModel['legenda'] = $this->legenda;

            $lista[] = $GalerialModel;
        }
        return $lista;
    }

    //LISTA DE EQUIPES
    public function Equipes() {

        $sql = $this->mysqli->prepare("
            SELECT a.id, a.nome, a.cargo, a.anexo, a.url, a.texto, a.ativo, b.nome FROM `$this->tb_equipes` AS a INNER JOIN `$this->tb_equipes_categoria` AS b ON b.id = a.tb_equipes_categoria_id
            WHERE a.ativo='1' ORDER BY a.id DESC    
            ");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->cargo, $this->anexo, $this->url, $this->texto, $this->ativo, $this->nome_categoria);

        $lista = array();
        while ($row = $sql->fetch()) {

            $EquipeModel['id'] = $this->id;
            $EquipeModel['nome'] = $this->nome;
            $EquipeModel['cargo'] = $this->cargo;
            $EquipeModel['anexo'] = $this->anexo;
            $EquipeModel['url'] = $this->url;
            $EquipeModel['texto'] = $this->texto;
            $EquipeModel['ativo'] = $this->ativo;
            $EquipeModel['nome_categoria'] = $this->nome_categoria;

            $lista[] = $EquipeModel;
        }
        return $lista;
    }

    //LISTA DE GERAL
    public function Gerais() {

        $sql = $this->mysqli->prepare("
            SELECT a.id, a.title, a.url_link, a.nome, a.descricao, a.description, a.keywords, a.dest, a.pos, a.ativo, b.url FROM `$this->tb_geral` AS a INNER JOIN `$this->tb_geral_fotos` AS b ON a.id = b.tb_geral_id
            WHERE a.ativo='1' GROUP BY a.nome ORDER BY a.pos ASC 
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->url_link, $this->nome, $this->descricao, $this->dest, $this->pos, $this->ativo, $this->url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $registros = 10;
        $numPaginas = ceil($rows / $registros);
        $inicio = ($registros * $pagina) - $registros;

        $sql_paginacao = $this->mysqli->prepare("
            SELECT a.id, a.title, a.url_link, a.nome, a.descricao, a.description, a.keywords, a.dest, a.pos, a.ativo, b.url FROM `$this->tb_geral` AS a INNER JOIN `$this->tb_geral_fotos` AS b ON a.id = b.tb_geral_id
            WHERE a.ativo='1' GROUP BY a.nome ORDER BY a.pos ASC LIMIT $inicio, $registros
        ");
        $sql_paginacao->execute();
        $sql_paginacao->bind_result($this->id, $this->url_link, $this->nome, $this->descricao, $this->dest, $this->pos, $this->ativo, $this->url);

        $lista = array();
        while ($row = $sql_paginacao->fetch()) {

            $GeralModel['numPaginas'] = $numPaginas;
            $GeralModel['registros'] = $registros;
            $GeralModel['rows'] = $rows;
            $GeralModel['id'] = $this->id;
            $GeralModel['title'] = $this->title;
            $GeralModel['url_link'] = $this->url_link;
            $GeralModel['url_link'] = $this->url_link;
            $GeralModel['nome'] = $this->nome;
            $GeralModel['descricao'] = $this->descricao;
            $GeralModel['description'] = $this->description;
            $GeralModel['keywords'] = $this->keywords;
            $GeralModel['dest'] = $this->dest;
            $GeralModel['pos'] = $this->pos;
            $GeralModel['ativo'] = $this->ativo;
            $GeralModel['url'] = $this->url;

            $lista[] = $GeralModel;
        }
        return $lista;
    }

    //DETALHES DO GERAL
    public function GeraisDetalhes($param) {

        $sql = $this->mysqli->prepare("SELECT id, title, nome, descricao, description, keywords FROM `$this->tb_geral` WHERE url_link='$param'");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->descricao);
        $sql->fetch();

        $lista = array();
        $GeralModel['id'] = $this->id;
        $GeralModel['title'] = $this->title;
        $GeralModel['nome'] = $this->nome;
        $GeralModel['descricao'] = $this->descricao;
        $GeralModel['description'] = $this->description;
        $GeralModel['keywords'] = $this->keywords;

        $lista[] = $GeralModel;

        return $lista;
    }

    //GALERIA DA GERAL CONFORME PARAM
    public function GeraisGaleria($param) {

        $sql = $this->mysqli->prepare("
            SELECT a.id, b.url, b.legenda, b.dest FROM `$this->tb_geral` AS a INNER JOIN `$this->tb_geral_fotos` AS b ON a.id = b.tb_geral_id 
            WHERE a.ativo='1' AND a.url_link='$param'
                ");

        $sql->execute();
        $sql->bind_result($this->id, $this->url, $this->legenda, $this->dest);

        $lista = array();
        while ($row = $sql->fetch()) {

            $GeralModel['id'] = $this->id;
            $GeralModel['url'] = $this->url;
            $GeralModel['legenda'] = $this->legenda;
            $GeralModel['dest'] = $this->dest;

            $lista[] = $GeralModel;
        }
        return $lista;
    }

    //ENVIO FORMULÁRIO DE CONTATO
    public function Contato() {

        $this->dateUs = date('Y-m-d');
        $this->dateBr = date('d/m/Y');

        $contato = $this->mysqli->prepare("INSERT INTO `$this->tb_contatos`
            (nome, email, telefone, assunto, mensagem, data) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $contato->bind_param('ssssss', $this->nome, $this->email, $this->telefone, $this->assunto, $this->mensagem, $this->dateUs);
        $contato->execute();

        $sql = $this->mysqli->prepare("SELECT email FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->email_destinatario);
        $sql->fetch();

        require_once MODELS . '/phpMailer/class.phpmailer.php';

        $mail = new PHPMailer();
        $mail->IsMail(true);
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
        $this->email_remetente = EMAIL_REMETENTE;
        $mail->From = $this->email_remetente; // Seu e-mail
        $mail->FromName = "Solicitação de Contato"; // Seu nome
        $mail->AddAddress($this->email_destinatario); //E-mail Destinatario

        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML

        $mail->Subject = "Formulário de Contato"; // Assunto da mensagem
        $mail->Body .= "Nome: <strong>$this->nome</strong> <br />";
        $mail->Body .= "E-mail: <strong>$this->email</strong> <br />";
        $mail->Body .= "Telefone: <strong>$this->telefone</strong> <br />";
        $mail->Body .= "Assunto: <strong>$this->assunto</strong> <br />";
        $mail->Body .= "Mensagem: <strong>$this->assunto</strong> <br />";
        $mail->Body .= "Data do Envio: <strong>$this->dateBr</strong> <br />";

        //envia e-mail
        $mail->Send();

        echo ("<script language='JavaScript'>
            window.alert('Contato enviado com sucesso, em breve entraremos em contato!')
            window.location.href = 'contato';
        </script>");
    }

    //TELEFONE
    public function Telefone() {

        $sql = $this->mysqli->prepare("SELECT telefone FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->telefone);
        
        $lista = array();
        while ($row = $sql->fetch()) {

            $contato['tel'] = $this->telefone;

            $lista[] = $contato;
        }
        return $lista;
        
    }

    //ENDEREÇO
    public function Endereco() {

        $sql = $this->mysqli->prepare("SELECT estado, cidade, bairro, endereco, numero FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->estado, $this->cidade, $this->bairro, $this->endereco, $this->numero);
        
        $lista = array();
        while ($row = $sql->fetch()) {

            $endereco['estado'] = $this->estado;
            $endereco['cidade'] = $this->cidade;
            $endereco['bairro'] = $this->bairro;
            $endereco['endereco'] = $this->endereco;
            $endereco['numero'] = $this->numero;

            $lista[] = $endereco;
        }
        return $lista;
    }

    //E-mail
    public function Email() {

        $sql = $this->mysqli->prepare("SELECT email FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->email);
        
        $lista = array();
        while ($row = $sql->fetch()) {

            $mail['email'] = $this->email;

            $lista[] = $mail;
        }
        return $lista;
    }

    //GOOGLEMAPS
    public function GoogleMaps() {

        $sql = $this->mysqli->prepare("SELECT estado, cidade, bairro, endereco, numero FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->estado, $this->cidade, $this->bairro, $this->endereco, $this->numero);
        $sql->fetch();

        echo "<iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.8502905236455!2d-51.154027499999955!3d-30.04115259999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951977c3903b2df5%3A0x9899f2766ba7bb08!2s$this->endereco $this->numero+-+$this->bairro%2C+$this->cidade+-+$this->estado!5e0!3m2!1spt-BR!2sbr!4v1408036216469' width='100%' height='450' frameborder='0' style='border:0'></iframe>";
    }

    //FACEBOOK
    public function Facebook() {

        $sql = $this->mysqli->prepare("SELECT facebook FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->facebook);
        $sql->fetch();

        echo $this->facebook;
    }

    //TWIITER
    public function Twitter() {

        $sql = $this->mysqli->prepare("SELECT twitter FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->twitter);
        $sql->fetch();

        echo $this->twitter;
    }

    //INSTAGRAM
    public function Instagram() {

        $sql = $this->mysqli->prepare("SELECT instagram FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->instagram);
        $sql->fetch();

        echo $this->instagram;
    }

    //GOOGLE +
    public function Google() {

        $sql = $this->mysqli->prepare("SELECT google FROM `$this->tb_config`");
        $sql->execute();
        $sql->bind_result($this->google);
        $sql->fetch();

        echo $this->google;
    }

    ### ---------- LOGIN ---------- ###
    public function save() {

        $sql = $this->mysqli->prepare("INSERT INTO `$this->tb_cadastros`
            (nome, email, password, telefone, celular, estado, cep, cidade, bairro, endereco, numero, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param('sssssssssssi', $this->nome, $this->email, $this->password, $this->telefone, $this->celular, $this->estado, $this->cep, $this->cidade, $this->bairro, $this->endereco, $this->numero, $this->status
        );
        $sql->execute();
    }

    public function autenticar() {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tb_cadastros` WHERE email='$this->email' AND password='$this->password'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();

        if ($rows == 0) {
            header('Location:' . HOME_URI);
        }
        if ($rows > 0) {
            $_SESSION['id'] = $this->id;
            header('Location:' . HOME_URI_RESTRITA . '/paginas/index/');
        }
    }
    ### ---------- END LOGIN ---------- ###
}
