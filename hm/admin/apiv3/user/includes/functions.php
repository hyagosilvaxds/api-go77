<?php

//SESSION START
ob_start();
session_start();

//DESLOGAR
if (isset($_GET['acao']) && $_GET['acao'] == 'sair') :
    unset($_SESSION['id']);
    session_destroy();
    header('Location:' . HOME_URI . '/cadastros/index-web');
endif;

function dataBR($campo)
{

    if (substr($campo, 2, 1) == '/') {
        $campo = substr($campo, 6, 4) . '-' . substr($campo, 3, 2) . '-' . substr($campo, 0, 2); //2012-10-10
    } else {
        $campo = substr($campo, 8, 2) . '/' . substr($campo, 5, 2) . '/' . substr($campo, 0, 4); //10/10/2012
    }

    return ($campo);
}

function tipoIngressos($tipo)
{

    switch ($tipo) {
        case '1':
            $v = "Masculino";
            break;
        case '2':
            $v = "Feminino";
            break;
        case '3':
            $v = "Ambos";
            break;

        break;
    }

    return $v;
}

function statusComissao($status)
{

    switch ($status) {
        case '1':
            $v = "Pago";
            break;
        case '2':
            $v = "Pendente";
            break;


        break;
    }

    return $v;
}

function calculaDiasX($diaX,$diaY){
    $data1 = new DateTime($diaX); //Dia X é a data atul
    $data2 = new DateTime($diaY); //Dia Y é o dia da publicação ou notícia

    //Calcula a diferença entre duas datas com a função diff
    $intervalo = $data1->diff($data2); //A variável intervalo vai receber a diferença entre a data1 e a data2

    return $intervalo->d;
}

function statusReserva($status)
{

    switch ($status) {
        case '1':
            $v = "confirmada";
            break;
        case '2':
            $v = "pendente";
            break;
        case '3':
            $v = "cancelada";
            break;

        break;
    }

    return $v;
}

function tipoPagamento($tipo)
{

    switch ($tipo) {
        case '1':
            $v = "Cartão";
            break;
        case '3':
            $v = "Pix";
            break;

        break;
    }

    return $v;
}

function tipoPessoa($tipo)
{

    switch ($tipo) {
        case '1':
            $v = "Física";
            break;
        case '2':
            $v = "Jurídica";
            break;

        break;
    }

    return $v;
}

function statusCotacoes($status)
{

    switch ($status) {
        case '1':
            $v = "Solicitação enviada";
            break;
        case '2':
            $v = "Em análise";
            break;
        case '3':
            $v = "Orçamento enviado";
            break;
        case '4':
            $v = "Aguardando aprovação";
            break;
        case '5':
        $v = "Finalizado";
        break;
        case '6':
            $v = "Cancelado";
        break;
    }

    return $v;
}

function jsonReturn($val)
{
    echo json_encode($val, JSON_UNESCAPED_UNICODE);
    exit;
}

function getNomeTipo($tipo)
{

    switch ($tipo) {
        case 1:
            return 'USUÁRIO';
        case 2:
            return 'FRANQUEADO';
        case 3:
            return 'BARBEIRO';
    }
}

function cryptitem($item) {
    $encryptedValue = openssl_encrypt($item, 'aes-256-cbc', KEY_CRYPT, 0, KEY_CRYPT);
    // print_r(KEY_CRYPT);exit;
    return $encryptedValue;
}

function decryptitem($criptografia) {
    $decryptedValue = openssl_decrypt($criptografia, 'aes-256-cbc', KEY_CRYPT, 0, KEY_CRYPT);

    return ($decryptedValue !== false) ? $decryptedValue : null;
}
function statusPayment($status)
{

    switch ($status) {
        case 'CONFIRMED':
            $v = "Pago";
            break;
        case 'RECEIVED':
            $v = "Pago";
            break;
        case 'AWAITING_RISK_ANALYSIS':
            $v = "Em análise";
            break;
        case 'REPROVED_BY_RISK_ANALYSIS':
            $v = "Rejeitado";
            break;
        case 'CREDIT_CARD_CAPTURE_REFUSED':
            $v = "Rejeitado";
            break;
        case 'REFUNDED':
        $v = "Rejeitado";
            break;
        case 'REFUND_IN_PROGRESS':
        $v = "Reembolso pendente";
            break;
        case 'CHARGEBACK_REQUESTED':
        $v = "Estornado";
            break;
        case 'CHARGEBACK_DISPUTE':
        $v = "Estorno em disputa";
            break;
        case 'AWAITING_CHARGEBACK_REVERSAL':
        $v = "Estorno pendente";
            break;

        break;
    }

    return $v;
}

function nomeChave($status)
{

    switch ($status) {
        case '1':
            $v = "Documento";
            break;
        case '2':
            $v = "Celular";
            break;
        case '3':
            $v = "Email";
            break;
        case '4':
            $v = "Aleatória";
            break;
    }

    return ($v);
}

function statusEntrega($status)
{

    switch ($status) {
        case '1':
            $v = "Recebido";
            break;
        case '2':
            $v = "Em Separação";
            break;
        case '3':
            $v = "Faturado";
            break;
        case '4':
            $v = "Enviado";
            break;
        case '5':
            $v = "Entregue";
            break;
        case '6':
            $v = "Cancelado";
            break;
    }

    return ($v);
}

function nomePagamento($status)
{

    switch ($status) {
        case '1':
            $v = "Cartão";
            break;
        case '2':
            $v = "Boleto";
            break;
        case '3':
            $v = "Pix";
            break;
        case '4':
            $v = "Apple Pay";
            break;
        case '5':
            $v = "Google Pay";
            break;

    }

    return ($v);
}
function MoipBR($status)
{

    if ($status == null) {
        $status = "- - -";
    }

    if ($status == "IN_ANALYSIS") {
        $status = "EM ANÁLISE";
        $classe = "emanalise";
    }
    if ($status == "CREATED") {
        $status = "CRIADO";
        $classe = "criado";
    }
    if ($status == "WAITING") {
        $status = "AGUARDANDO";
        $classe = "aguardando";
    }

    if ($status == "PRE-AUTHORIZED") {
        $status = "PRÉ AUTORIZADO";
        $classe = "preautorizado";
    }
    if ($status == "AUTHORIZED") {
        $status = "AUTORIZADO";
        $classe = "autorizado";
    }
    if ($status == "CANCELLED") {
        $status = "CANCELADO";
        $classe = "cancelado";
    }
    if ($status == "SETTLED") {
        $status = "CONCLUÍDO";
        $classe = "concluido";
    }

    return $status;
}

function horaMin($hora)
{

    $ah = explode(":", $hora);

    return $ah[0] . ":" . $ah[1];
}

function montaInQuery($arrayIn)
{ // retorna o array em (1,2,3,4) para consulta com IN no Mysql

    $string = "(";

    foreach ($arrayIn as $in) {
        $string .= $in . ',';
    }
    $string .= "0)";

    return $string;
}

function categNome($categ)
{

    switch ($categ) {
        case '1':
            return 'Tentante';
            break;
        case '2':
            return 'Gestante';
            break;
        case '3':
            return 'Mãe';
            break;
    }
}

function datissima($data)
{
    $data = date("d-m-y", strtotime($data));
    $data = str_replace('-', '/', $data);
    return $data;
}

function datissima2($data)
{
    $data = date("Y-m-d", strtotime($data));
    return $data;
}

function dataBR2($data)
{
    $data = implode("/", array_reverse(explode("-", $data)));
    return $data;
}

function dataUS($data)
{
    $data = implode("-", array_reverse(explode("/", $data)));
    return $data;
}

function horarioBR($campo)
{

    $campo = explode(" ", $campo);
    $campo = $campo[1];
    return $campo;
}

function moneySQL($money)
{
    $source = array('.', ',');
    $replace = array('', '.');
    $money = str_replace('R$', '', $money);
    $money = str_replace($source, $replace, $money);
    return $money;
}

function moneyView($money)
{
    $money = 'R$ ' . number_format($money, 2, ',', '.');
    return $money;
}

function moedaAdd($get_valor)
{
    $get_valor = $get_valor . ".00";
    return $get_valor; //retorna o valor formatado para gravar no banco
}

function md5_hash($string)
{
    $string = md5($string);
    return $string;
}

function limitarTexto($texto, $limite = 100)
{
    $contador = mb_strlen($texto);
    if ($contador >= $limite) {
        $texto = mb_substr($texto, 0, mb_strrpos(mb_substr($texto, 0, $limite), ' '), 'UTF-8') . '...';
        return $texto;
    } else {
        return $texto;
    }
}

function load_view($controller, $action, $mensagem, $view, $view2, $view3, $view4, $view5)
{

    require_once VIEWS . '/' . $controller . "/" . $controller . '-' . $action . '.php';
}


/*
function secure($string)
{
    $_GET = array_map('trim', $_GET);
    $_POST = array_map('trim', $_POST);
    $_COOKIE = array_map('trim', $_COOKIE);
    $_REQUEST = array_map('trim', $_REQUEST);
    if (get_magic_quotes_gpc()) {
        $_GET = array_map('stripslashes', $_GET);
        $_POST = array_map('stripslashes', $_POST);
        $_COOKIE = array_map('stripslashes', $_COOKIE);
        $_REQUEST = array_map('stripslashes', $_REQUEST);
    }
    $_GET = array_map('mysql_real_escape_string', $_GET);
    $_POST = array_map('mysql_real_escape_string', $_POST);
    $_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);
    $_REQUEST = array_map('mysql_real_escape_string', $_REQUEST);

    return $string;
}*/



function redimensionarImagem($imagem, $largura, $altura)
{
    // Verifica extens�o do arquivo
    $extensao = strrchr($imagem, '.');
    switch ($extensao) {
        case '.png':
            $funcao_cria_imagem = 'imagecreatefrompng';
            $funcao_salva_imagem = 'imagepng';

            break;
        case '.gif':
            $funcao_cria_imagem = 'imagecreatefromgif';
            $funcao_salva_imagem = 'imagegif';

            break;
        case '.jpg':
            $funcao_cria_imagem = 'imagecreatefromjpeg';
            $funcao_salva_imagem = 'imagejpeg';

            break;
    }

    // Cria um identificador para nova imagem
    $imagem_original = $funcao_cria_imagem($imagem);

    // Salva o tamanho antigo da imagem
    list($largura_antiga, $altura_antiga) = getimagesize($imagem);

    // Cria uma nova imagem com o tamanho indicado
    // Esta imagem servir� de base para a imagem a ser reduzida
    $imagem_tmp = imagecreatetruecolor($largura, $altura);

    // Faz a interpola��o da imagem base com a imagem original
    imagecopyresampled($imagem_tmp, $imagem_original, 0, 0, 0, 0, $largura, $altura, $largura_antiga, $altura_antiga);

    // Salva a nova imagem
    $resultado = $funcao_salva_imagem($imagem_tmp, "../views/_depoimentos/" . $imagem . $extensao);

    // Libera memoria
    imagedestroy($imagem_original);
    imagedestroy($imagem_tmp);

    return $resultado;
}

function url_amigavel($texto)
{

    $url = $texto;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
    return $url;
}

function geraSalt($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas)
        $caracteres .= $lmai;
    if ($numeros)
        $caracteres .= $num;
    if ($simbolos)
        $caracteres .= $simb;
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}

function Mask($mask, $str)
{

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}

function calcPercent($valor, $porcentagem)
{

    $resultado = $valor * ($porcentagem / 100);
    return $resultado;
}

function renameUpload($file)
{

    if (!empty($file)) {

        $extensao = strrchr($file, '.');
        $extensao = strtolower($extensao);
        $extensao = str_replace('.', '', $extensao);

        $file = md5(uniqid(time())) . ".";
        $file_final = $file . $extensao;

        return $file_final;
        exit;
    }

    if (empty($file)) {
        $file_final = '';
        return $file_final;
        exit;
    }
}

function geraToken($nome, $email)
{
    $token = md5($nome . $email);
    return $token;
}

function Date30days($data)
{
    $date = date('Y-m-d', strtotime("+30 days", strtotime($data)));
    $date = $date . " " . date('H:i:s');
    return $date;
}

function dateBR($data)
{
    $date = date('d-m-Y', strtotime($data));
    return $date;
}

function horaBR($data)
{
    $date = date('H:i', strtotime($data));
    return $date;
}

function horaBR2($data)
{
    $date = date('H:i', strtotime("-1 Hour", strtotime($data)));
    return $date;
}

function horaBR3($data)
{
    $date = date('H:i', strtotime("+1 Hour", strtotime($data)));
    return $date;
}
function removerAcentos($string) {
    return str_replace(
        ['á', 'à', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ü', 'ç', 'Á', 'À', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ü', 'Ç'],
        ['a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'c', 'A', 'A', 'A', 'A', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'C'],
        $string
    );
}
function horaBR4($data)
{
    $date = date('H:i:s', strtotime($data));
    return $date;
}

function geraLatLong($endereco, $numero,$bairro, $nome_cidade)
{

    $address = $endereco .",". $numero . ",". $bairro . "," . $nome_cidade . "," . "Brazil";
    // print_r($address);exit;
    $prepAddr = str_replace(' ', '+', $address);

    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=' . KEY_API . '&address=' . $prepAddr . '&sensor=false');

    // print_r('https://maps.google.com/maps/api/geocode/json?key=' . KEY_API . '&address=' . $prepAddr . '&sensor=false');exit;
    $output = json_decode($geocode);

    $lat = $output->results[0]->geometry->location->lat;
    $long = $output->results[0]->geometry->location->lng;

    // print_r(array($lat, $long));exit;
    return array($lat, $long);
}
function distLatLongDistancia($lat1, $lon1, $lat2, $lon2) {

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $lon1 = deg2rad($lon1);
    $lon2 = deg2rad($lon2);

    $latD = $lat2 - $lat1;
    $lonD = $lon2 - $lon1;

    $dist = 2 * asin(sqrt(pow(sin($latD / 2), 2) +
    cos($lat1) * cos($lat2) * pow(sin($lonD / 2), 2)));
    $dist = $dist * 6371;
    return number_format($dist, 1, '.', '');
  }

// function distLatLongDistancia($latDe, $lonDe, $latPara, $lonPara)
// {

//     // $latDe = "-29.9999068";
//     // $lonDe = "-51.0784875";
//     // $latPara = "-30.0314144";
//     // $lonPara = "-51.1353901";

//     $geocode = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $latDe . ',' . $lonDe . '&destinations=' . $latPara . ',' . $lonPara . '&key=' . KEY_API . '&language=PT');


//     $output = json_decode($geocode);


//     $distancia = $output->rows[0]->elements[0]->distance->text;

//     if ($output->rows[0]->elements[0]->status == 'OK') {
//         $distancia = $output->rows[0]->elements[0]->distance->text;
//     } else {
//         $distancia = 0;
//     }

//     // echo $distancia;exit;

//     $letra = substr($distancia, -2);

//     $remover = [" m", " km", "."];

//     $distancia = str_replace($remover, "", $distancia);

//     if ($letra == " m") {
//         $distancia = $distancia / 1000;
//         $distancia = number_format($distancia, 1, ",", ".");
//     }

//     return $distancia;
// }


// function distLatLongDuracao($latDe, $lonDe, $latPara, $lonPara)
// {

//     $geocode = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $latDe . ',' . $lonDe . '&destinations=' . $latPara . ',' . $lonPara . '&key=' . KEY_API . '&language=PT');

//     https: //maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=-30.0369047,-51.2087032&destinations=-30.0369047,-51.2087032&key=AIzaSyBVSc-jJHChbe_htlgUx5i7tFubsPF7-E4&language=PT


//     $output = json_decode($geocode);


//     //$duracao = $output->rows[0]->elements[0]->duration->text;

//     if ($output->rows[0]->elements[0]->status == 'OK') {
//         $duracao = $output->rows[0]->elements[0]->duration->text;
//     } else {
//         $duracao = 0;
//     }

//     return $duracao;
// }

function geraEnd($lat, $long)
{

    $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyAQUpPqQ7UDU__BucfNDzOo1CxNWBR3yC8";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geocode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response);

    $dataarray = get_object_vars($output);

    if ($dataarray['status'] == 'OK' && $dataarray['status'] != 'INVALID_REQUEST') {

        if (isset($dataarray['results'][0]->formatted_address)) {

            $estado = $output->results[0]->address_components[3]->short_name;
            $cidade = $output->results[0]->address_components[4]->short_name;
        } else {
            $estado = null;
            $cidade = null;
        }
    } else {
        $estado = null;
        $cidade = null;
    }

    return array($cidade, $estado);
}

function generateRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



// GERA ENDEREÇO COMPLETO
function geraEndCompleto($lat, $lon)
{

    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&key=" . KEY_API;

    $data = file_get_contents($url);
    $jsondata = json_decode($data, true);

    if (!check_status($jsondata)) return array(); // verifica se encontrou o endereço, por enquanto retorna o array vazio, mas pode servir para alertar o usuário a usar a localização
    $pais  = google_getCountry($jsondata);
    $estado = google_getProvince($jsondata);
    $cidade =  google_getCity($jsondata);
    $endereco = google_getStreet($jsondata);
    $cep = google_getPostalCode($jsondata);
    $sigla_pais = google_getCountryCode($jsondata);
    $formatted_address = google_getAddress($jsondata);

    $arrayLocalizacao = explode(",", $formatted_address); // quebra resultado da localização
    /*[0] => R. Marieta Mena Barreto   [1] => 210 - Alto Petrópolis    [2] => Porto Alegre - RS    [3] => 91260-090    [4] => Brazil   */
    $arrayCid = explode("-", $arrayLocalizacao[2]); // pega cidade/estado
    $arrayBairro = explode("-", $arrayLocalizacao[1]); // pega numero/bairro

    $estado = trim($arrayCid[1]);
    $cidade = trim($arrayCid[0]);
    $bairro = $arrayBairro[1];
    $endereco = $arrayLocalizacao[0];
    $cep = $arrayLocalizacao[3];



    // print_r($arrayBairro);exit;

    return array($estado, $cidade, $bairro, $endereco, $cep);   // pegar bairro desta variável quebrando ela com 'str'


}


function check_status($jsondata)
{
    if ($jsondata["status"] == "OK") {
        return true;
    } else {
        return false;
    }
}


function Find_Long_Name_Given_Type($type, $array, $short_name = false)
{
    foreach ($array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}
function google_getCountry($jsondata)
{
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata)
{
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata)
{
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata)
{
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata)
{
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata)
{
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata)
{
    return $jsondata["results"][0]["formatted_address"];
}



function tiraCarac($valor)
{
    $pontos = array("-", ".", "(", ")", " ", "/");
    $result = str_replace($pontos, "", $valor);

    return $result;
}

function formataCpf($cpf_cnpj)
{

    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $tipo_dado = NULL;
    if (strlen($cpf_cnpj) == 11) {
        $tipo_dado = "cpf";
    }
    if (strlen($cpf_cnpj) == 14) {
        $tipo_dado = "cnpj";
    }
    switch ($tipo_dado) {
        default:
            $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
            break;

        case "cpf":
            $bloco_1 = substr($cpf_cnpj, 0, 3);
            $bloco_2 = substr($cpf_cnpj, 3, 3);
            $bloco_3 = substr($cpf_cnpj, 6, 3);
            $dig_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
            break;

        case "cnpj":
            $bloco_1 = substr($cpf_cnpj, 0, 2);
            $bloco_2 = substr($cpf_cnpj, 2, 3);
            $bloco_3 = substr($cpf_cnpj, 5, 3);
            $bloco_4 = substr($cpf_cnpj, 8, 4);
            $digito_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
            break;
    }
    return $cpf_cnpj_formatado;
}

function formataCep($val)
{

    $mask = '#####-###';

    /*
    echo mask($cnpj, '##.###.###/####-##').'<br>';
    echo mask($cpf, '###.###.###-##').'<br>';
    echo mask($cep, '#####-###').'<br>';
    echo mask($data, '##/##/####').'<br>';
    echo mask($data, '##/##/####').'<br>';
    echo mask($data, '[##][##][####]').'<br>';
    echo mask($data, '(##)(##)(####)').'<br>';
    echo mask($hora, 'Agora são ## horas ## minutos e ## segundos').'<br>';
    echo mask($hora, '##:##:##');
*/
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
        if ($mask[$i] == '#') {
            if (isset($val[$k])) {
                $maskared .= $val[$k++];
            }
        } else {
            if (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
    }

    return $maskared;
}

function idDia()
{
    $data = date('D');
    $semana = array(
        'Sun' => 1,
        'Mon' => 2,
        'Tue' => 3,
        'Wed' => 4,
        'Thu' => 5,
        'Fri' => 6,
        'Sat' => 7
    );

    $fila = $semana["$data"];

    return $fila;
}
