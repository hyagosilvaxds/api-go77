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

function sortByProp($array, $propName, $reverse = false)
{
    $sorted = [];

    foreach ($array as $item)
    {
        $sorted[$item->$propName][] = $item;
    }

    if ($reverse) krsort($sorted); else ksort($sorted);
    $result = [];

    foreach ($sorted as $subArray) foreach ($subArray as $item)
    {
        $result[] = $item;
    }

    return $result;
}

function listCnpj($cnpj)
{
    $pegaCnpj = file_get_contents('https://publica.cnpj.ws/cnpj/' . $cnpj);

    $dados = json_decode($pegaCnpj);
    return $dados;
}

function gerarCPF() {
    // Gera os nove primeiros dígitos do CPF com números aleatórios
    $noveDigitos = '';
    for ($i = 0; $i < 9; $i++) {
        $noveDigitos .= mt_rand(0, 9);
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $noveDigitos[$i] * (10 - $i);
    }
    $primeiroDigito = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);

    // Adiciona o primeiro dígito verificador aos nove primeiros dígitos
    $cpf = $noveDigitos . $primeiroDigito;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $segundoDigito = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);

    // Adiciona o segundo dígito verificador ao CPF completo
    $cpf .= $segundoDigito;

    return $cpf;
}
function extrairDDDENumero($numeroTelefone) {
    // Remover caracteres não numéricos
    $numeroLimpo = preg_replace('/\D/', '', $numeroTelefone);

    // Extrair DDD (os 2 primeiros dígitos)
    $ddd = substr($numeroLimpo, 0, 2);

    // Extrair o número (os 9 últimos dígitos)
    $numero = substr($numeroLimpo, -9);

    // Retornar o DDD e o número em um array
    return array(
        'ddd' => $ddd,
        'numero' => $numero
    );
}
function gerarLog($inputs) {
    $inputs= json_encode($inputs);
    $logFile = 'log/log.txt';
    // Adicione a data e hora à mensagem
    $logMessage = date('Y-m-d H:i:s') . " - Log armazenado:\n$inputs\n";
    // Escreva a mensagem no arquivo de log (anexando ao conteúdo existente)
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
function gerarLogUserEntrada($inputs, $user_id,$nome) {
    $inputs = json_encode($inputs);
    // Diretório base para os logs de usuários
    $baseDir = 'log/';

    // Verifica se o diretório do usuário existe
    $userDir = $baseDir . $user_id;
    if (!is_dir($userDir)) {
        // Se o diretório do usuário não existir, cria o diretório
        mkdir($userDir, 0755, true); // Permissões 0755 são comuns, ajuste conforme necessário
    }

    // Caminho completo do arquivo de log para o usuário
    $logFile = $userDir . '/log.txt';

    // Adicione a data e hora à mensagem
    $logMessage = date('Y-m-d H:i:s') . " - Log $nome:\n$inputs\n";

    // Escreva a mensagem no arquivo de log (anexando ao conteúdo existente)
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
function gerarLogUserSaida($inputs, $user_id,$nome) {
    $inputs = json_encode($inputs);
    // Diretório base para os logs de usuários
    $baseDir = 'log/';

    // Verifica se o diretório do usuário existe
    $userDir = $baseDir . $user_id;
    if (!is_dir($userDir)) {
        // Se o diretório do usuário não existir, cria o diretório
        mkdir($userDir, 0755, true); // Permissões 0755 são comuns, ajuste conforme necessário
    }

    // Caminho completo do arquivo de log para o usuário
    $logFile = $userDir . '/logSaida.txt';

    // Adicione a data e hora à mensagem
    $logMessage = date('Y-m-d H:i:s') . " - Log $nome:\n$inputs\n";

    // Escreva a mensagem no arquivo de log (anexando ao conteúdo existente)
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}


function statusOrcamentos($status)
{

    switch ($status) {
        case '1':
            $v = "aguardando orçamento";
            break;
        case '2':
            $v = "em aberto";
            break;
        case '3':
            $v = "cancelado";
            break;
        case '4':
            $v = "orçamento recebido";
        break;

        break;
    }

    return $v;
}

function tipoCancelamento($tipo)
{

    switch ($tipo) {
        case '1':
            $v = "cancelado pelo cliente";
            break;
        case '2':
            $v = "cancelado pelo anunciante";
            break;

        break;
    }

    return $v;
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

function statusCancelamento($status)
{

    switch ($status) {
        case '1':
            $v = "solicitação de cancelamento iniciada.";
            break;
        case '2':
            $v = "o seu pagamento foi estornado com sucesso.";
            break;
        case '3':
            $v = "o seu pagamento não foi estornado, fale com o administrador";
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
function autoCompleteEndereco($end_busca,$lat,$long)
{
    $country_code = 'BR'; // Código de país para o Brasil

    $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=" . urlencode($end_busca) . "&location=" . $lat . "," . $long . "&components=country:" . $country_code ."&radius=500". "&key=" . KEY_API;

    $response = file_get_contents($url);

    $data = json_decode($response, true);

    return $data;
}

function createRota($end_inicio, $end_fim, $parada_1, $parada_2)
{
    $origin = urlencode($end_inicio);
    $destination = urlencode($end_fim);

    // Montar a lista de waypoints (paradas intermediárias)
    $waypoints = array();

    if (!empty($parada_1)) {
        $waypoints[] = urlencode($parada_1);
    }

    if (!empty($parada_2)) {
        $waypoints[] = urlencode($parada_2);
    }

    $waypointsStr = implode('|', $waypoints);

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&waypoints=$waypointsStr&key=".KEY_API;

    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data;
}

function createRotaLatLong($originLat, $originLong, $destLat, $destLong, $waypoints = [],$horario_saida)
{
    $origin = "$originLat,$originLong";
    $destination = "$destLat,$destLong";

    // Montar a lista de waypoints
    $waypointsStr = "";
    foreach ($waypoints as $waypoint) {
        $waypointsStr .= "|" . $waypoint['latitude'] . "," . $waypoint['longitude'];
    }

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&waypoints=$waypointsStr&departure_time={$horario_saida}&key=".KEY_API;

    $response = file_get_contents($url);
    $data = json_decode($response, true);
    // print_r($response);
    return $data;
}
function getCityStateFromLatLong($latitude, $longitude) {
    $latLong = "$latitude,$longitude";
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latLong&key=" . KEY_API;

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (isset($data['results'][0])) {
        $components = $data['results'][0]['address_components'];
        $city = '';
        $state = '';
        $street = ''; // Rua
        $neighborhood = ''; // Bairro

        // Percorrer os componentes do endereço para encontrar cidade, estado, rua e bairro
        foreach ($components as $component) {
            if (in_array('administrative_area_level_2', $component['types'])) {
                $city = $component['long_name']; // Cidade
            }
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name']; // Estado (abreviação)
            }
            if (in_array('route', $component['types'])) {
                $street = $component['long_name']; // Rua
            }
            if (in_array('sublocality', $component['types']) || in_array('sublocality_level_1', $component['types'])) {
                $neighborhood = $component['long_name']; // Bairro
            }
        }

        return [
            'cidade' => $city,
            'estado' => $state,
            'rua' => $street,
            'bairro' => $neighborhood
        ];
    }

    return null; // Retorna null se não encontrar os dados
}





function unique_multidimensional_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    $array_final = [];

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;

            array_push($array_final, $val);

        }
        $i++;
    }

    //print_r($array_final);
    //exit;

    return $array_final;
}

function dataBR($campo)
{

    if (substr($campo, 2, 1) == '/') {
        $campo = substr($campo, 6, 4) . '-' . substr($campo, 3, 2) . '-' . substr($campo, 0, 2); //2012-10-10
    } else {
        $campo = substr($campo, 8, 2) . '/' . substr($campo, 5, 2) . '/' . substr($campo, 0, 4); //10/10/2012
    }

    return ($campo);
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
function obterUltimos4Numeros($numeroCartao) {
    // Remove espaços em branco e caracteres não numéricos
    $numeroCartaoLimpo = preg_replace('/[^0-9]/', '', $numeroCartao);

    // Obtém os últimos 4 caracteres do número do cartão
    $ultimos4Numeros = substr($numeroCartaoLimpo, -4);

    return $ultimos4Numeros;
}
function identificarBandeiraCartao($numeroCartao) {
    // Remove espaços em branco e caracteres não numéricos
    $numeroCartaoLimpo = preg_replace('/[^0-9]/', '', $numeroCartao);

    // Array associativo com padrões de identificação de bandeira
    $bandeiras = array(
        'VISA' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
        'MASTERCARD' => '/^5[1-5][0-9]{14}$/',
        'AMEX' => '/^3[47][0-9]{13}$/',
        'DISCOVER' => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
        'DINERS' => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
        'JCB' => '/^(?:2131|1800|35\d{3})\d{11}$/',
        'MAESTRO' => '/^(5[06-8]|6\d)\d{10,17}$/',
        'ELO' => '/^((50670[7-8])|(50900[0-9])|(506715)|(506717)|(506718)|(506719)|(50672[2-9])|(50673[0-9])|(50674[0-9])|(50675[0-9])|(50676[0-9])|(50677[0-9])|(50678[0-9])|(50679[0-9])|(506799]))\d{10,13}$/',
    );

    // Itera sobre as bandeiras para identificar a correspondência
    foreach ($bandeiras as $bandeira => $padrao) {
        if (preg_match($padrao, $numeroCartaoLimpo)) {
            return $bandeira;
        }
    }

    // Retorna null se a bandeira não for identificada
    return null;
}

function criaStringMapas($todosEnderecos) {
    // Inicializa os arrays de latitudes e longitudes
    $latitudes = [];
    $longitudes = [];

    // Percorre o array de endereços e extrai as latitudes e longitudes
    foreach ($todosEnderecos as $endereco) {
        $latitudes[] = $endereco['latitude'];
        $longitudes[] = $endereco['longitude'];
    }

    // Verifica se os arrays de latitudes e longitudes têm o mesmo tamanho
    if (count($latitudes) !== count($longitudes)) {
        return "Erro: O número de latitudes e longitudes não corresponde.";
    }

    // Inicializa as variáveis de waypoints como strings vazias
    $google_maps_waypoints = "";
    $apple_maps_waypoints = "";

    // O primeiro item do array é a origem
    $origem_lat = $latitudes[0];
    $origem_long = $longitudes[0];

    // O último item do array é o destino
    $destino_lat = end($latitudes);
    $destino_long = end($longitudes);

    // Adiciona origem e destino às strings de cada serviço de mapas
    $google_maps_origem_destino = "&origin={$origem_lat}%2C{$origem_long}&destination={$destino_lat}%2C{$destino_long}";
    $apple_maps_origem_destino = "saddr={$origem_lat},{$origem_long}&daddr={$destino_lat},{$destino_long}";

    // O destino do Waze será o último ponto (destino final)
    $destinoWaze_lat = $destino_lat;
    $destinoWaze_long = $destino_long;

    // Verifica se há paradas intermediárias (todos os itens entre origem e destino)
    if (count($latitudes) > 2) {
        // Itera pelos itens intermediários (excluindo o primeiro e o último)
        $intermediate_latitudes = array_slice($latitudes, 1, -1);
        $intermediate_longitudes = array_slice($longitudes, 1, -1);

        foreach ($intermediate_latitudes as $index => $lat) {
            $long = $intermediate_longitudes[$index];
            // Adiciona as paradas para Google Maps e Apple Maps
            $google_maps_waypoints .= ($google_maps_waypoints === "")
                ? "&waypoints={$lat}%2C{$long}"
                : "%7C{$lat}%2C{$long}";

            $apple_maps_waypoints .= "&via={$lat},{$long}";
        }

        // O Waze não suporta múltiplas paradas, então usamos o último ponto intermediário como o destino do Waze
        $destinoWaze_lat = end($intermediate_latitudes);
        $destinoWaze_long = end($intermediate_longitudes);
    }

    // Retorna os URLs formatados
    return [
        'google_maps' => "https://www.google.com/maps/dir/?api=1{$google_maps_origem_destino}{$google_maps_waypoints}",
        'apple_maps' => "http://maps.apple.com/?{$apple_maps_origem_destino}{$apple_maps_waypoints}",
        'waze' => "waze://?ll={$destinoWaze_lat},{$destinoWaze_long}&navigate=yes",
    ];
}



// function criaStringMapas($origem_lat, $origem_long, $destino_lat, $destino_long, $parada1_lat = "", $parada1_long = "", $parada2_lat = "", $parada2_long = ""){
//     // Inicializa as variáveis de waypoints como strings vazias
//     $google_maps_waypoints = "";
//     $apple_maps_waypoints = "";

//     // Adiciona origem e destino às strings de cada serviço de mapas
//     $google_maps_origem_destino = "&origin={$origem_lat}%2C{$origem_long}&destination={$destino_lat}%2C{$destino_long}";
//     $apple_maps_origem_destino = "saddr={$origem_lat},{$origem_long}&daddr={$destino_lat},{$destino_long}";
//     $destinoWaze_lat = $destino_lat ;
//     $destinoWaze_long = $destino_long;

//     // Adiciona paradas apenas se necessário
//     if ($parada1_lat !== "" && $parada1_long !== "") {
//         // Adiciona a primeira parada
//         $google_maps_waypoints .= "&waypoints={$parada1_lat}%2C{$parada1_long}";
//         $apple_maps_waypoints .= "&via={$parada1_lat},{$parada1_long}";
//         $destinoWaze_lat = $parada1_lat;
//         $destinoWaze_long = $parada1_long;

//         if ($parada2_lat !== "" && $parada2_long !== "") {
//             // Adiciona a segunda parada
//             $google_maps_waypoints .= "%7C{$parada2_lat}%2C{$parada2_long}";
//             $apple_maps_waypoints .= "&via={$parada2_lat},{$parada2_long}";
//         }
//     }

//     // Retorna os URLs formatados
//     return [
//         'google_maps' => "https://www.google.com/maps/dir/?api=1{$google_maps_origem_destino}{$google_maps_waypoints}",
//         'apple_maps' => "http://maps.apple.com/?{$apple_maps_origem_destino}{$apple_maps_waypoints}",
//         'waze' => "waze://?ll={$destinoWaze_lat},{$destinoWaze_long}&navigate=yes",
//     ];
// }

function cryptitem($item) {
    $encryptedValue = openssl_encrypt($item, 'aes-256-cbc', KEY_CRYPT, 0, KEY_CRYPT);
    // print_r(KEY_CRYPT);exit;
    return $encryptedValue;
}

function decryptitem($criptografia) {
    $decryptedValue = openssl_decrypt($criptografia, 'aes-256-cbc', KEY_CRYPT, 0, KEY_CRYPT);

    return ($decryptedValue !== false) ? $decryptedValue : null;
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
function dataHoraBR($date)
{
    $isBRFormat = strpos($date, '/') !== false;
    $format = $isBRFormat ? 'd/m/Y H:i:s' : 'Y-m-d H:i:s';
    $datetime = DateTime::createFromFormat($format, $date);
    return $datetime->format($isBRFormat ? 'Y-m-d H:i:s' : 'd/m/Y H:i:s');
}
function dataHoraBR2($date)
{
    $isBRFormat = strpos($date, '/') !== false;
    $format = $isBRFormat ? 'd/m/Y H:i:s' : 'Y-m-d H:i:s';
    $datetime = DateTime::createFromFormat($format, $date);

    // Mapear os nomes dos meses em inglês para português
    $months = [
        'January'   => 'Janeiro',
        'February'  => 'Fevereiro',
        'March'     => 'Março',
        'April'     => 'Abril',
        'May'       => 'Maio',
        'June'      => 'Junho',
        'July'      => 'Julho',
        'August'    => 'Agosto',
        'September' => 'Setembro',
        'October'   => 'Outubro',
        'November'  => 'Novembro',
        'December'  => 'Dezembro'
    ];

    $formattedDate = $datetime->format($isBRFormat ? 'd/m/Y H:i:s' : 'd/M/Y');

    // Substituir os nomes dos meses em inglês pelos equivalentes em português
    foreach ($months as $englishMonth => $portugueseMonth) {
        $formattedDate = str_replace($englishMonth, $portugueseMonth, $formattedDate);
    }

    return $formattedDate;
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
    $data = implode("/", array_reverse(explode("-", $data)));
    return $data;
}


function data($data)
{
    $data = date("d-m-Y", strtotime($data));
    $data = str_replace('-', '/', $data);
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
function dataHoraUS($dataString)
{
    // Converter a string em um objeto DateTime
    $data = DateTime::createFromFormat('d/m/Y H:i', $dataString);

    $dataFormatada = $data->format('Y-m-d H:i:s');
    return $dataFormatada;

}

function horarioBR($campo)
{

    $campo = explode(" ", $campo);
    $campo = $campo[1];
    return $campo;
}

function calculaDifDatas($diaX,$diaY){

  $data1 = new DateTime($diaX); //Dia X é a data atul
  $data2 = new DateTime($diaY); //Dia Y é o dia da publicação ou notícia

  $intervalo = $data1->diff($data2);

  $Param = [
      "dias" => $intervalo->d,
      "minutos" => $intervalo->i
  ];

  return $Param;


}



function calculaDias($diaX,$diaY){
		$data1 = new DateTime($diaX); //Dia X é a data atul
		$data2 = new DateTime($diaY); //Dia Y é o dia da publicação ou notícia

		//Calcula a diferença entre duas datas com a função diff
		$intervalo = $data1->diff($data2); //A variável intervalo vai receber a diferença entre a data1 e a data2

		//Lembrando sempre que:
		//y = Ano
		//m = Mês
		//d = Dia
		//h = Hora
		//i = Minuto
		//s = Segundo

		if($intervalo->y > 1){ // se o ano for maior que 1 ele recebe x anos
		  return $intervalo->y." Anos atrás";
		}elseif($intervalo->y == 1){ // se o ano for igual a 1 ele recebe 1 ano
		  return $intervalo->y." Ano atrás";
		}elseif($intervalo->m > 1){ // E a lógica segue a mesma para todo elseif
		  return $intervalo->m." Meses atrás";
		}elseif($intervalo->m == 1){
		  return $intervalo->m." Mês atrás";
		}elseif($intervalo->d > 1){
		  return $intervalo->d." Dias atrás";
		}elseif($intervalo->d > 0){
		  return $intervalo->d." Dia atrás";
		}elseif($intervalo->h > 0){
		  return $intervalo->h." Horas atrás";
		}elseif($intervalo->i > 1 && $intervalo->i < 59){
		  return $intervalo->i." Minutos atrás";
		}elseif($intervalo->i == 1){
		  return $intervalo->i." Minuto atrás";
		}elseif($intervalo->s < 60 && $intervalo->i <= 0){
		  return $intervalo->s." Segundo atrás";
		}
	}



  function calculaDiasX($diaX,$diaY){
  		$data1 = new DateTime($diaX); //Dia X é a data atul
  		$data2 = new DateTime($diaY); //Dia Y é o dia da publicação ou notícia

  		//Calcula a diferença entre duas datas com a função diff
  		$intervalo = $data1->diff($data2); //A variável intervalo vai receber a diferença entre a data1 e a data2

  		return $intervalo->d;
	}

function hora($data)
{

    $data = date("H:i:s", strtotime($data));

    return $data;
}

function data30()
{

    $data = new DateTime('-30 day');
    $data2 = $data->format('Y-m-d');

    return $data2;
}

function data30m($data)
{

    $data = date('H:i:s', strtotime("+30 minutes", strtotime($data)));
    //$data2 = $data->format('Y-m-d H:i:s');

    return $data;
}

function textToDecimal($texto) {
    preg_match('/\d+(\.\d+)?/', $texto, $matches);
    if (!empty($matches)) {
        return $matches[0];
    } else {
        return null; // Retorna null se nenhum número com decimal for encontrado.
    }
}

function moneySQL($money)
{

    if (strpos($money, 'R$') !== false) {

        $source = array('.', ',');
        $replace = array('', '.');

        $money = str_replace('R$', '', $money);

        $money = str_replace($source, $replace, $money);

    }

    $money = str_replace("\xc2\xa0", "", $money);
    return $money;
}

function moneyView($money)
{
    $money = ' R$ ' . number_format($money, 2, ',', '.');
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

function moneyReplace($string){

  $string = str_replace(' ', '', $string);
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

function geocodeAddress($endereco)
{
    $address = urlencode($endereco);

    // Constrói a URL da API de Geocodificação
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=".KEY_API;

    // Faz a solicitação para a API
    $response = file_get_contents($url);
    $data = json_decode($response);

    // Verifica se a solicitação foi bem-sucedida
    if ($data->status === 'OK' && isset($data->results[0]->geometry->location)) {
        // Obtém as coordenadas de latitude e longitude do resultado
        $latitude = $data->results[0]->geometry->location->lat;
        $longitude = $data->results[0]->geometry->location->lng;

        // Retorna as coordenadas
        return array('lat' => $latitude, 'long' => $longitude);
    } else {
        // Em caso de erro, retorna false ou trata o erro conforme necessário
        return false;
    }
}
function geraEnd($lat, $long)
{

    $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=" . KEY_API;
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


    //print_r(array($estado, $cidade, $bairro, $endereco, $cep)); exit;


    return array($estado, $cidade, $bairro, $endereco, $cep);   // pegar bairro desta variável quebrando ela com 'str'


}
function removerAcentos($string) {
    // Substituir caracteres acentuados por caracteres não acentuados
    $string = preg_replace('/[áàâã]/u', 'a', $string);
    $string = preg_replace('/[éèê]/u', 'e', $string);
    $string = preg_replace('/[íì]/u', 'i', $string);
    $string = preg_replace('/[óòôõ]/u', 'o', $string);
    $string = preg_replace('/[úù]/u', 'u', $string);
    $string = preg_replace('/[ç]/u', 'c', $string);
    $string = preg_replace('/[ÁÀÂÃ]/u', 'A', $string);
    $string = preg_replace('/[ÉÈÊ]/u', 'E', $string);
    $string = preg_replace('/[ÍÌ]/u', 'I', $string);
    $string = preg_replace('/[ÓÒÔÕ]/u', 'O', $string);
    $string = preg_replace('/[ÚÙ]/u', 'U', $string);
    $string = preg_replace('/[Ç]/u', 'C', $string);

    return $string;
}

function distLatLongDistancia($latDe, $lonDe, $latPara, $lonPara)
{


    //$latDe = "-29.9999068";
    //$lonDe = "-51.0784875";
    //$latPara = "-30.0314144";
    //$lonPara = "-51.1353901";

    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $latDe . ',' . $lonDe . '&destinations=' . $latPara . ',' . $lonPara . '&key=' . KEY_API . '&language=PT');

    $output = json_decode($geocode);

    //$distancia = $output->rows[0]->elements[0]->distance->text;

    if ($output->rows[0]->elements[0]->status == 'OK') {
        $distancia = $output->rows[0]->elements[0]->distance->text;
    } else {
        $distancia = 0;
    }

    $letra = substr($distancia, -2);

    $remover = [" m", " km", "."];

    $distancia = str_replace($remover, "", $distancia);

    if ($letra == " m") {
        $distancia = $distancia / 1000;
        $distancia = number_format($distancia, 1, ",", ".");
    }


    return $distancia;
}


function distLatLongDistancia2($latDe, $lonDe, $latPara, $lonPara)
{

    //$latDe = "-29.9999068";
    //$lonDe = "-51.0784875";
    //$latPara = "-30.0314144";
    //$lonPara = "-51.1353901";

    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $latDe . ',' . $lonDe . '&destinations=' . $latPara . ',' . $lonPara . '&key=' . KEY_API . '&language=PT');

    $output = json_decode($geocode);


    //$distancia = $output->rows[0]->elements[0]->distance->text;

    if ($output->rows[0]->elements[0]->status == 'OK') {
        $distancia = $output->rows[0]->elements[0]->distance->text;
    } else {
        $distancia = 0;
    }

    $letra = substr($distancia, -2);

    $remover = [" m", " km", "."];

    $distancia = str_replace($remover, "", $distancia);

    if ($letra == " m") {
        $distancia = $distancia / 1000;
        $distancia = number_format($distancia, 1, ",", ".");
    }

    return $distancia;
}

function distLatLongDuracao($latDe, $lonDe, $latPara, $lonPara)
{

    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $latDe . ',' . $lonDe . '&destinations=' . $latPara . ',' . $lonPara . '&key=' . KEY_API . '&language=PT');

    https: //maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=-30.0369047,-51.2087032&destinations=-30.0369047,-51.2087032&key=AIzaSyBVSc-jJHChbe_htlgUx5i7tFubsPF7-E4&language=PT


    $output = json_decode($geocode);


    //$duracao = $output->rows[0]->elements[0]->duration->text;

    if ($output->rows[0]->elements[0]->status == 'OK') {
        $duracao = $output->rows[0]->elements[0]->duration->text;
    } else {
        $duracao = 0;
    }

    return $duracao;
}
function distancia($lat1, $lon1, $lat2, $lon2) {
    // Verificar se todos os valores são válidos
    if($lat1 === null || $lon1 === null || $lat2 === null || $lon2 === null ||
       $lat1 === '' || $lon1 === '' || $lat2 === '' || $lon2 === '') {
        return 0;
    }
    
    $lat1 = deg2rad(floatval($lat1));
    $lat2 = deg2rad(floatval($lat2));
    $lon1 = deg2rad(floatval($lon1));
    $lon2 = deg2rad(floatval($lon2));

    $latD = $lat2 - $lat1;
    $lonD = $lon2 - $lon1;

    $dist = 2 * asin(sqrt(pow(sin($latD / 2), 2) +
    cos($lat1) * cos($lat2) * pow(sin($lonD / 2), 2)));
    $dist = $dist * 6371;

    return number_format($dist, 3, '.', '');
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

function signo($data)
{
    $m = date("m", strtotime($data));
    $d = date("d", strtotime($data));

    if ($m == "03"  and $d >= "20") {
        $signo = "Áries";
    }   //Áries       20/03 a 20/04
    elseif ($m == "04"  and $d <= "20") {
        $signo = "Áries";
    }   //Áries       20/03 a 20/04
    elseif ($m == "04"  and $d >= "21") {
        $signo = "Touro";
    }   //Touro       21/04 a 20/05
    elseif ($m == "05"  and $d <= "20") {
        $signo = "Touro";
    }   //Touro       21/04 a 20/05
    elseif ($m == "05"  and $d >= "21") {
        $signo = "Gêmeos";
    }   //Gêmeos      21/05 a 20/06
    elseif ($m == "06"  and $d <= "20") {
        $signo = "Gêmeos";
    }   //Gêmeos      21/05 a 20/06
    elseif ($m == "06"  and $d >= "21") {
        $signo = "Câncer";
    }   //Câncer      21/06 a 21/07
    elseif ($m == "07"  and $d <= "21") {
        $signo = "Câncer";
    }   //Câncer      21/06 a 21/07
    elseif ($m == "07"  and $d >= "22") {
        $signo = "Leão";
    }   //Leão        22/07 a 22/08
    elseif ($m == "08"  and $d <= "22") {
        $signo = "Leão";
    }   //Leão        22/07 a 22/08
    elseif ($m == "08"  and $d >= "23") {
        $signo = "Virgem";
    }   //Virgem      23/08 a 22/09
    elseif ($m == "09"  and $d <= "22") {
        $signo = "Virgem";
    }   //Virgem      23/08 a 22/09
    elseif ($m == "09"  and $d >= "23") {
        $signo = "Libra";
    }   //Libra       23/09 a 22/10
    elseif ($m == "10" and $d <= "22") {
        $signo = "Libra";
    }   //Libra       23/09 a 22/10
    elseif ($m == "10" and $d >= "23") {
        $signo = "Escorpião";
    }   //Escorpião   23/10 a 21/11
    elseif ($m == "11" and $d <= "21") {
        $signo = "Escorpião";
    }   //Escorpião   23/10 a 21/11
    elseif ($m == "11" and $d >= "22") {
        $signo = "Sagitário";
    }   //Sagitário   22/11 a 21/12
    elseif ($m == "12" and $d <= "21") {
        $signo = "Sagitário";
    }   //Sagitário   22/11 a 21/12
    elseif ($m == "12" and $d >= "22") {
        $signo = "Capricórnio";
    }   //Capricórnio 22/12 a 21/01
    elseif ($m == "1"  and $d <= "21") {
        $signo = "Capricórnio";
    }   //Capricórnio 22/12 a 21/01
    elseif ($m == "1"  and $d >= "21") {
        $signo = "Aquário";
    }   //Aquário     21/01 a 18/02
    elseif ($m == "2"  and $d <= "18") {
        $signo = "Aquário";
    }   //Aquário     21/01 a 18/02
    elseif ($m == "2"  and $d >= "19") {
        $signo = "Peixes";
    }   //Peixes      19/02 a 19/03
    elseif ($m == "3"  and $d <= "19") {
        $signo = "Peixes";
    }   //Peixes      19/02 a 19/03
    else {
        $signo = "Não Reconhecido";
    }
    return $signo;
}
