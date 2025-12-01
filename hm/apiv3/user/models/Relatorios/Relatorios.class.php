<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';


class Relatorios extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        // $this->ConectaWordPress();
        $this->data_atual = date('Y-m-d H:i:s');
    }

    public function avaliarCorrida($id_de,$id_para,$id_corrida,$estrelas,$descricao,$latitude,$longitude){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_relatorio`(`tipo`, `id_de`, `id_para`, `id_corrida`,`estrelas`, `descricao`,`latitude`, `longitude`, `data_cadastro`)
             VALUES ('1','$id_de','$id_para','$id_corrida','$estrelas','$descricao','$latitude','$longitude','$this->data_atual')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Avaliação enviada com sucesso."
        ];

        return $Param;
    }

    public function avaliarCorridaIgnorar($id_de,$id_para,$id_corrida,$latitude,$longitude){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_relatorio`(`tipo`, `id_de`, `id_para`, `id_corrida`,`latitude`, `longitude`, `data_cadastro`)
             VALUES ('2','$id_de','$id_para','$id_corrida','$latitude','$longitude','$this->data_atual')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Avaliação enviada com sucesso."
        ];

        return $Param;
    }
    public function relatarProblemas($id_de,$id_para,$id_anuncio,$motivos,$estrelas,$descricao,$latitude,$longitude){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_relatorio`(`tipo`, `id_de`, `id_para`, `id_anuncio`,`id_motivo`,`estrelas`, `descricao`,`latitude`, `longitude`, `data_cadastro`,`status`)
             VALUES ('4','$id_de','$id_para','$id_anuncio','$motivos','$estrelas','$descricao','$latitude','$longitude','$this->data_atual','2')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Avaliação enviada com sucesso."
        ];

        return $Param;
    }

    public function listAvaliacaoPendente($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.app_users_id, a.app_corridas_id, b.id_motorista
            FROM `app_participantes` AS a
            INNER JOIN `app_corridas` AS b ON a.app_corridas_id = b.id
            LEFT JOIN `app_relatorio` AS c ON c.id_de = a.app_users_id AND c.id_corrida = a.app_corridas_id
            WHERE a.app_users_id = '$id_user' AND a.status='4'
            AND c.id_de IS NULL;
            "
        );

        $sql->execute();
        $sql->bind_result($id_passageiro,$id_corrida,$id_motorista);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_corrida'] = $id_corrida;
                $Param['id_passageiro'] = $id_passageiro;
                $Param['id_motorista'] = $id_motorista;

                $Param['rows'] = $rows;

                array_push($lista, $Param);
            }
        }

        // var_dump($lista[0]);
        return $lista;
    }
    public function percCupom($cupom)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT perc_desconto
            FROM `app_cupons`
            WHERE codigo='$cupom'
            "
        );

        $sql->execute();
        $sql->bind_result($perc_desconto);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // print_r($perc_desconto);
        return $perc_desconto;
    }
    public function entrouNoAnuncio($id_de,$id_para,$id_anuncio,$latitude,$longitude){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_relatorio`(`tipo`, `id_de`, `id_para`, `id_anuncio`,`latitude`, `longitude`, `data_cadastro`)
             VALUES ('2','$id_de','$id_para','$id_anuncio','$latitude','$longitude','$this->data_atual')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Entrou."
        ];

        return $Param;
    }
    public function verificaPassageiro($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT tipo
            FROM `app_users` 
            WHERE id='$id_user'      
            "
        );

        $sql->execute();
        $sql->bind_result($tipo);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;
        return $tipo;
    }
    public function listSorteioCorridaPassageiro($id_corrida,$id_user)
    {
        $this->ConectaWordPress();
        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_passageiro,n_rifa_passageiro
            FROM `app_corridas` 
            WHERE id='$id_corrida'      
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio_passageiro,$n_rifa_passageiro);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;




        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT post_title
            FROM `wp_posts`
            WHERE ID='$id_sorteio_passageiro'
        "
        );
        $sql->execute();
        $sql->bind_result($titulo);
        $sql->store_result();
        $sql->fetch();


        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT meta_value
            FROM `wp_postmeta`
            WHERE post_id='$id_sorteio_passageiro' AND meta_key='data_sorteio'
        "
        );
        $sql->execute();
        $sql->bind_result($data);
        $sql->store_result();
        $sql->fetch();

        //Pega foto da rifa
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT b.guid
            FROM `wp_postmeta` AS a
            INNER JOIN `wp_posts` AS b ON b.id=a.meta_value
            WHERE a.post_id='$id_sorteio_passageiro' AND  a.meta_key='_thumbnail_id'
            "
        );
        $sql->execute();
        $sql->bind_result($capa);
        $sql->store_result();
        $sql->fetch();




        if(!empty($data)){
            $data_formatada = date('Y-m-d', strtotime($data));
            $data_formatada =  dataBR($data_formatada);
        }else{
            $data_formatada = "";
        }
        $lista = [];
        $Param['url_rifa'] =$capa;
        $Param['url_rifa'] =$this->pegaImagemSorteio($id_sorteio_passageiro,$capa);
        $Param['nome_rifa'] = $titulo;
        $Param['n_rifa'] = $n_rifa_passageiro;
        $Param['data_final'] = $data_formatada;
        $Param['premio'] = "";

        array_push($lista, $Param);
        return $lista;
    }
    public function listSorteioCorridaMotorista($id_corrida,$id_user)
    {
        $this->ConectaWordPress();
        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_motorista,n_rifa_motorista
            FROM `app_corridas` 
            WHERE id='$id_corrida'      
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio_motorista,$n_rifa_motorista);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;




        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT post_title
            FROM `wp_posts`
            WHERE ID='$id_sorteio_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($titulo);
        $sql->store_result();
        $sql->fetch();


        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT meta_value
            FROM `wp_postmeta`
            WHERE post_id='$id_sorteio_motorista' AND meta_key='data_sorteio'
        "
        );
        $sql->execute();
        $sql->bind_result($data);
        $sql->store_result();
        $sql->fetch();



        if(!empty($data)){
            $data_formatada = date('Y-m-d', strtotime($data));
            $data_formatada =  dataBR($data_formatada);
        }else{
            $data_formatada = "";
        }

        //Pega foto da rifa
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT b.guid
            FROM `wp_postmeta` AS a
            INNER JOIN `wp_posts` AS b ON b.id=a.meta_value
            WHERE a.post_id='$id_sorteio_motorista' AND  a.meta_key='_thumbnail_id'
            "
        );
        $sql->execute();
        $sql->bind_result($capa);
        $sql->store_result();
        $sql->fetch();

        $lista = [];
        $Param['url_rifa'] =$this->pegaImagemSorteio($id_sorteio_motorista,$capa);
        $Param['nome_rifa'] = $titulo;
        $Param['n_rifa'] = $n_rifa_motorista;
        $Param['data_final'] = $data_formatada;
        $Param['premio'] = "";

        array_push($lista, $Param);
        return $lista;
    }

    public function meusNumerosPassageiro($id_user,$status)
    {


        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_passageiro,n_rifa_passageiro
            FROM `app_corridas` 
            WHERE id_usuario='$id_user' AND id_sorteio_passageiro != 'NULL' AND n_rifa_passageiro != 'NULL'
            GROUP BY id_sorteio_passageiro
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio,$n_rifa);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

    //    print_r($rows);exit;
        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
            return $lista;
        } else {
            while ($row = $sql->fetch()) {
                $dados_rifa = $this->pegaDadosRifa($id_sorteio);
                // $Param['url_rifa'] =$dados_rifa['capa'];
                $Param['url_rifa'] =$this->pegaImagemSorteio($id_sorteio,$dados_rifa['capa']);
                $Param['nome_rifa'] = $dados_rifa['nome_rifa'];
                $Param['id_sorteio'] = $id_sorteio;
                $Param['premio'] = "";
                $Param['data_final'] = $dados_rifa['data_final'];
                $Param['status'] = $dados_rifa['status'];
                $Param['n_ganhador'] = $dados_rifa['n_ganhador'];
                $Param['meus_numeros'] = $this->meusNumerosPassageiroDetalhes($id_user,$id_sorteio);
                if($status == 2){
                    $Param['n_ganhador'] = "";
                }
                $Param['rows'] = $rows;
                if($status == $dados_rifa['status']){
                    array_push($lista, $Param);
                }

            }

            if(COUNT($lista) == 0){
                $item['rows'] = 0;
                array_push($lista, $item);
            }else{
                foreach ($lista as &$elemento) {
                    $elemento['rows'] = count($lista);
                }
            }
            return $lista;
        }   

    }
    public function pegaImagemSorteio($id_sorteio,$rifaCapa){
        $arquivo_existe = $this->verificarExistenciaDoArquivo($id_sorteio);
        //se existir
        if($arquivo_existe){
            return HOME_URI_ROOT . "/uploads/sorteios/$arquivo_existe";
        }else{
            $caminhoDaPasta = '../../uploads/sorteios/temporarias/';
            $image_info = @getimagesize($rifaCapa);
            if ($image_info !== false && isset($image_info['mime'])) {
                // Obtém o MIME type da imagem
                $mime_type = $image_info['mime'];
                
                // Mapeia o MIME type para a extensão correspondente
                switch ($mime_type) {
                    case 'image/jpeg':
                        $extensaoDoArquivo = '.jpg';
                        break;
                    case 'image/png':
                        $extensaoDoArquivo = '.png';
                        break;
                    case 'image/gif':
                        $extensaoDoArquivo = '.gif';
                        break;
                    default:
                        // Se o MIME type não corresponder a nenhum dos tipos esperados, usa uma extensão padrão
                        $extensaoDoArquivo = '.jpg';
                }
            } else {
                // Se não for possível determinar o MIME type, atribui uma extensão padrão
                $extensaoDoArquivo = '.jpg';
            }


            $imagemComExtensao =  $id_sorteio . $extensaoDoArquivo;
            $caminhoDoArquivo = $caminhoDaPasta . $imagemComExtensao;
            // Baixa a imagem da URL e salva no arquivo especificado
            if (file_put_contents($caminhoDoArquivo, file_get_contents($rifaCapa)) !== false) {

                $imagem = new TutsupRedimensionaImagem();

                $imagem->imagem = $caminhoDaPasta . $imagemComExtensao;
                $imagem->imagem_destino = "../../uploads/sorteios/".  $imagemComExtensao;
                
                $imagem->largura = 400;
                $imagem->altura = 0;
                $imagem->qualidade = 100;
                
                $nova_imagem = $imagem->executa();

                unlink($caminhoDaPasta . $imagemComExtensao); // remove o arquivo da pasta temporária

                return HOME_URI_ROOT . "/uploads/sorteios/$imagemComExtensao";
            } else {
                return $rifaCapa;
            }
           
        }
    }

    public function verificarExistenciaDoArquivo($id_sorteio) {
        $caminhoDaPasta = '../../uploads/sorteios';
        $nomeDoArquivo = $id_sorteio; // O nome do arquivo é o ID do sorteio
        
        // Verifica se o diretório existe
        if (is_dir($caminhoDaPasta)) {
            // Obtém a lista de arquivos na pasta
            $arquivos = scandir($caminhoDaPasta);
    
            // Procura o índice do arquivo com o ID do sorteio na lista de arquivos
            $indice = array_search($nomeDoArquivo, $arquivos);
            // Verifica se o arquivo com o ID do sorteio foi encontrado
            if ($indice !== false) {
                // Obtém a data de modificação do arquivo
                $dataModificacao = filemtime("$caminhoDaPasta/$arquivos[$indice]");
                // Calcula a diferença de tempo em segundos
                $agora = time();
                $diffEmSegundos = $agora - $dataModificacao;
                
                // Verifica se a diferença de tempo é inferior a 2 horas (7200 segundos)
                if ($diffEmSegundos < 7200) {
                    return $arquivos[$indice]; // Se a data de modificação for inferior a 2 horas, retorna o índice do arquivo
                }else{
                    return false; // Arquivo foi enviado a mais de 2hrs atras.
                }
            } else {
                return false; // Se o arquivo não for encontrado, retorna falso
            }
        } else {
            // Se o diretório não existir, retorna false
            return false;
        }
    }


    public function meusNumerosMotorista($id_user,$status)
    {


        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_motorista,n_rifa_motorista
            FROM `app_corridas` 
            WHERE id_motorista='$id_user' AND id_sorteio_motorista != 'NULL' AND n_rifa_motorista != 'NULL'
            GROUP BY id_sorteio_motorista
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio,$n_rifa);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];
        // print_r($rows);exit;
        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
            return $lista;
        } else {
            while ($row = $sql->fetch()) {
                $dados_rifa = $this->pegaDadosRifa($id_sorteio);

                $Param['url_rifa'] =$this->pegaImagemSorteio($id_sorteio,$dados_rifa['capa']);
                
                $Param['nome_rifa'] = $dados_rifa['nome_rifa'];
                $Param['id_sorteio'] = $id_sorteio;
                $Param['data_final'] = $dados_rifa['data_final'];
                $Param['premio'] = "";
                $Param['status'] = $dados_rifa['status'];
                $Param['n_ganhador'] = $dados_rifa['n_ganhador'];
                $Param['meus_numeros'] = $this->meusNumerosMotoristaDetalhes($id_user,$id_sorteio);
                if($status == 2){
                    $Param['n_ganhador'] = "";
                }
                $Param['rows'] = $rows;

                if($status == $dados_rifa['status']){
                    array_push($lista, $Param);
                }

            }
            if(COUNT($lista) == 0){
                $item['rows'] = 0;
                array_push($lista, $item);
            }else{
                foreach ($lista as &$elemento) {
                    $elemento['rows'] = count($lista);
                }
            }
            return $lista;
        } 

    }


    public function meusNumerosPassageiroDetalhes($id_user,$id_sorteio)
    {


        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_passageiro,n_rifa_passageiro
            FROM `app_corridas` 
            WHERE id_usuario='$id_user' AND id_sorteio_passageiro = '$id_sorteio' AND n_rifa_passageiro != 'NULL'
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio,$n_rifa);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

       //print_r($rows);exit;
        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                // $dados_rifa = $this->pegaDadosRifa($id_sorteio);

                // $Param['nome_rifa'] = $dados_rifa['nome_rifa'];
                // $Param['id_sorteio'] = $id_sorteio;
                $Param['n_rifa'] = $n_rifa;
                // $Param['data_final'] = $dados_rifa['data_final'];
                // $Param['premio'] = "";
                // $Param['status'] = $dados_rifa['status'];
                // $Param['n_ganhador'] = $dados_rifa['n_ganhador'];
                $Param['rows'] = $rows;
                array_push($lista, $Param);

            }
        }
        // var_dump($lista[0]);
        return $lista;

    }
    public function meusNumerosMotoristaDetalhes($id_user,$id_sorteio)
    {


        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_motorista,n_rifa_motorista
            FROM `app_corridas` 
            WHERE id_motorista='$id_user' AND id_sorteio_motorista ='$id_sorteio' AND n_rifa_motorista != 'NULL'
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio,$n_rifa);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                // $dados_rifa = $this->pegaDadosRifa($id_sorteio);

                // $Param['nome_rifa'] = $dados_rifa['nome_rifa'];
                $Param['n_rifa'] = $n_rifa;
                // $Param['data_final'] = $dados_rifa['data_final'];
                // $Param['premio'] = "";
                // $Param['status'] = $dados_rifa['status'];
                // $Param['n_ganhador'] = $dados_rifa['n_ganhador'];

                $Param['rows'] = $rows;
                array_push($lista, $Param);

            }
        }

        // var_dump($lista[0]);
        return $lista;

    }
    public function pegaDadosRifa($id_rifa)
    {
        $this->ConectaWordPress();
        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT meta_value
            FROM `wp_postmeta`
            WHERE post_id='$id_rifa' AND meta_key='data_sorteio'
        "
        );
        $sql->execute();
        $sql->bind_result($data);
        $sql->store_result();
        $sql->fetch();

        if(!empty($data)){
            $data_formatada = date('Y-m-d', strtotime($data));
            $data_formatada =  dataBR($data_formatada);
        }else{
            $data_formatada = "";
        }
        // print_r($data);exit;


        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT post_title
            FROM `wp_posts`
            WHERE ID='$id_rifa'
        "
        );
        $sql->execute();
        $sql->bind_result($titulo);
        $sql->store_result();
        $sql->fetch();

        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT meta_value
            FROM `wp_postmeta`
            WHERE post_id='$id_rifa' AND meta_key='rifa_disponivel'
        "
        );
        $sql->execute();
        $sql->bind_result($status);
        $sql->store_result();
        $sql->fetch();
        
        if($status == "Sim"){
            $status = 2;
        }else{
            $status = 1;
        }

        //Pega foto da rifa
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT b.guid
            FROM `wp_postmeta` AS a
            INNER JOIN `wp_posts` AS b ON b.id=a.meta_value
            WHERE a.post_id='$id_rifa' AND  a.meta_key='_thumbnail_id'
            "
        );
        $sql->execute();
        $sql->bind_result($capa);
        $sql->store_result();
        $sql->fetch();
        

        //Pega dados da rifa no outro banco de dados
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT meta_value
            FROM `wp_postmeta`
            WHERE post_id='$id_rifa' AND meta_key='numeros_vencedores'
        "
        );
        $sql->execute();
        $sql->bind_result($n_ganhador);
        $sql->store_result();
        $sql->fetch();
        




        $lista = [];
        $Param['capa'] = $capa;
        $Param['nome_rifa'] = $titulo;
        $Param['data_final'] = $data_formatada;
        $Param['status'] = $status;
        $Param['n_ganhador'] = $n_ganhador ? $n_ganhador : "";

        array_push($lista, $Param);
        return $lista[0];

    }
}
