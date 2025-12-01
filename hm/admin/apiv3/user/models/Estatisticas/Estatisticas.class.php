<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';

class Estatisticas extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_planos_pagamentos";
    }

    // public function cartoesDash()
    // {
    //     $sql = $this->mysqli->prepare("
    //     SELECT COUNT(id)
    //     FROM app_users WHERE id_grupo='4'");
    //     $sql->execute();
    //     $sql->bind_result($usuarios_qtd);
    //     $sql->fetch();
    //     $sql->close();

    //     $sql = $this->mysqli->prepare("
    //     SELECT COUNT(id)
    //     FROM app_users WHERE id_grupo='5'");
    //     $sql->execute();
    //     $sql->bind_result($fornecedores_qtd);
    //     $sql->fetch();
    //     $sql->close();

    //     $sql = $this->mysqli->prepare("
    //     SELECT COUNT(id)
    //     FROM app_users WHERE id_grupo='6'");
    //     $sql->execute();
    //     $sql->bind_result($franqueados_qtd);
    //     $sql->fetch();
    //     $sql->close();


    //     $sql = $this->mysqli->prepare("
    //     SELECT COUNT(id)
    //     FROM app_cotacao WHERE status IN (1,2,3,4,6)");
    //     $sql->execute();
    //     $sql->bind_result($qtd_pedidos);
    //     $sql->fetch();
    //     $sql->close();

    //     $sql = $this->mysqli->prepare("
    //     SELECT COUNT(id)
    //     FROM app_cotacao WHERE status=5");
    //     $sql->execute();
    //     $sql->bind_result($qtd_compras);
    //     $sql->fetch();
    //     $sql->close();



    //     $sql = $this->mysqli->prepare("
    //     SELECT SUM(valor)
    //     FROM app_orcamentos WHERE status=1");
    //     $sql->execute();
    //     $sql->bind_result($valor_compras);
    //     $sql->fetch();
    //     $sql->close();




    //     $CadastrosModel['usuarios_qtd'] = $usuarios_qtd;
    //     $CadastrosModel['fornecedores_qtd'] = $fornecedores_qtd;
    //     $CadastrosModel['franqueados_qtd'] = $franqueados_qtd;
    //     $CadastrosModel['qtd_pedidos'] = $qtd_pedidos;
    //     $CadastrosModel['qtd_compras'] = $qtd_compras;
    //     $CadastrosModel['valor_compras'] = moneyView($valor_compras);



    //     $lista[] = $CadastrosModel;
    //     // print_r($lista);
    //     return $lista;
    // }
    // public function listAll($data_de,$data_ate)
    // {
    //     $filter1 = "WHERE status='1'";
    //     if(!empty($data_de)){$filter1 .= " AND data_cadastro >= '$data_de'";}
    //     if(!empty($data_ate)){$filter1 .= " AND data_cadastro <= '$data_ate 23:59:59'";}

    //     $filter2 = "WHERE status='2'";
    //     if(!empty($data_de)){$filter2 .= " AND data_cadastro >= '$data_de'";}
    //     if(!empty($data_ate)){$filter2 .= " AND data_cadastro <= '$data_ate 23:59:59'";}

    //     $filter3 = "WHERE id_grupo='4'";
    //     if(!empty($data_de)){$filter3 .= " AND data_cadastro >= '$data_de'";}
    //     if(!empty($data_ate)){$filter3 .= " AND data_cadastro <= '$data_ate 23:59:59'";}

    //     $filter4 = "WHERE status!='3'";
    //     if(!empty($data_de)){$filter4 .= " AND data_in >= '$data_de'";}
    //     if(!empty($data_ate)){$filter4 .= " AND data_in <= '$data_ate 23:59:59'";}

    //     $filter5 = "WHERE id>'1'";
    //     if(!empty($data_de)){$filter5 .= " AND data_vencimento >= '$data_de'";}
    //     if(!empty($data_ate)){$filter5 .= " AND data_vencimento <= '$data_ate 23:59:59'";}

    //     $filter6 = "WHERE status='1'";
    //     if(!empty($data_de)){$filter6 .= " AND data >= '$data_de'";}
    //     if(!empty($data_ate)){$filter6 .= " AND data <= '$data_ate 23:59:59'";}

    //     $filter7 = "WHERE status='2'";
    //     if(!empty($data_de)){$filter7 .= " AND data >= '$data_de'";}
    //     if(!empty($data_ate)){$filter7 .= " AND data <= '$data_ate 23:59:59'";}

    //     $filter8 = "WHERE id>'0'";
    //     if(!empty($data_de)){$filter8 .= " AND data >= '$data_de'";}
    //     if(!empty($data_ate)){$filter8 .= " AND data <= '$data_ate 23:59:59'";}

    //     $filter9 = "WHERE id>'0'";
    //     if(!empty($data_de)){$filter9 .= " AND data >= '$data_de'";}
    //     if(!empty($data_ate)){$filter9 .= " AND data <= '$data_ate 23:59:59'";}

    //     $filter10 = "WHERE tipo='1'";
    //     if(!empty($data_de)){$filter10 .= " AND data_cadastro >= '$data_de'";}
    //     if(!empty($data_ate)){$filter10 .= " AND data_cadastro <= '$data_ate 23:59:59'";}

    //     $filter11 = "WHERE tipo='2'";
    //     if(!empty($data_de)){$filter10 .= " AND data_cadastro >= '$data_de'";}
    //     if(!empty($data_ate)){$filter10 .= " AND data_cadastro <= '$data_ate 23:59:59'";}


    //     $sql = $this->mysqli->prepare("SELECT COUNT(id) as total_ativos,
    //      (SELECT COUNT(id) FROM app_users $filter2) as total_inativos,
    //      (SELECT COUNT(id) FROM app_users $filter3) as total_usuarios,
    //      (SELECT COUNT(id) FROM app_agenda $filter4) as total_agendamentos,
    //      (SELECT COUNT(id) FROM app_mensalista_user $filter5) as total_mensalistas,
    //      (SELECT COUNT(id) FROM app_carrinho $filter6) as carrinhos_abandonados,
    //      (SELECT COUNT(id) FROM app_carrinho $filter7) as carrinhos_finalizados,
    //      (SELECT COUNT(id) FROM `app_segmentos` $filter8) as total_segmentos,
    //      (SELECT COUNT(id) FROM `app_notificacoes` $filter9) as total_notificacoes,
    //      (SELECT COUNT(id) FROM `app_pedidos` $filter10) as total_vendas,
    //      (SELECT COUNT(id) FROM `app_pedidos` $filter11) as total_assinaturas,
    //      (SELECT SUM(valor_total) FROM `app_pedidos` $filter10) as valor_vendas,
    //      (SELECT SUM(valor_total) FROM `app_pedidos` $filter11) as valor_assinaturas
    //         FROM app_users $filter1");

    //     $sql->execute();
    //     $sql->bind_result($total_ativos, $total_inativos, $total_usuarios, $total_agendamentos, $total_mensalistas,
    //     $carrinhos_abandonados, $carrinhos_finalizados, $total_segmentos, $total_notificacoes, $total_vendas, $total_assinaturas, $valor_vendas, $valor_assinaturas);
    //     $sql->store_result();
    //     $rows = $sql->num_rows;

    //     $usuarios = [];

    //     if ($rows == 0) {
    //         $Param['rows'] = $rows;
    //         array_push($usuarios, $Param);
    //     } else {
    //         while ($row = $sql->fetch()) {

    //             $Param['total_ativos'] = $total_ativos;
    //             $Param['total_inativos'] = $total_inativos;
    //             $Param['total_usuarios'] = $total_usuarios;
    //             $Param['total_agendamentos'] = $total_agendamentos;
    //             $Param['total_mensalistas'] = $total_mensalistas;
    //             $Param['carrinhos_abandonados'] = $carrinhos_abandonados;
    //             $Param['carrinhos_finalizados'] = $carrinhos_finalizados;
    //             $Param['total_segmentos'] = $total_segmentos;
    //             $Param['total_notificacoes'] = $total_notificacoes;
    //             $Param['total_vendas'] = $total_vendas;
    //             $Param['total_assinaturas'] = $total_assinaturas;
    //             $Param['valor_vendas'] = moneyView($valor_vendas);
    //             $Param['valor_assinaturas'] = moneyView($valor_assinaturas);
    //             array_push($usuarios, $Param);

    //         }
    //     }
    //     return $usuarios;
    // }
    public function listAll($data_de, $data_ate)
{
    $filter = "";
    if (!empty($data_de)) {
        $filter .= " AND data_cadastro >= '$data_de'";
    }
    if (!empty($data_ate)) {
        $filter .= " AND data_cadastro <= '$data_ate 23:59:59'";
    }

    $filter2 = "";
    if (!empty($data_de)) {
        $filter2 .= " AND data >= '$data_de'";
    }
    if (!empty($data_ate)) {
        $filter2 .= " AND data <= '$data_ate 23:59:59'";
    }

    $sql = $this->mysqli->prepare("
        SELECT
        (SELECT COUNT(id) FROM app_users WHERE id_grupo='4' $filter) as usuarios_qtd,
        (SELECT COUNT(id) FROM app_anuncios WHERE status_aprovado='1' AND finalizado='1' $filter) as anuncios_aprovados_qtd,
        (SELECT COUNT(id) FROM app_anuncios WHERE status_aprovado='2' AND finalizado='1' $filter) as anuncios_pendentes_qtd,
        (SELECT COUNT(id) FROM app_anuncios WHERE app_categorias_id='1' AND status_aprovado='1' AND finalizado='1' $filter) as anuncios_1_qtd,
        (SELECT COUNT(id) FROM app_anuncios WHERE app_categorias_id='2' AND status_aprovado='1' AND finalizado='1' $filter) as anuncios_2_qtd,
        (SELECT COUNT(id) FROM app_reservas WHERE status='1' $filter) as reservas_confirmadas_qtd,
        (SELECT COUNT(id) FROM app_reservas WHERE status='2' $filter) as reservas_pendente_qtd,
        (SELECT COUNT(id) FROM app_reservas WHERE status='3' $filter) as reservas_canceladas_qtd,
        (SELECT SUM(valor_final) FROM app_reservas WHERE status='1' $filter) as reservas_confirmadas_valor,
        (SELECT SUM(valor_final) FROM app_reservas WHERE status='2' $filter) as reservas_pendente_valor,
        (SELECT SUM(valor_final) FROM app_reservas WHERE status='3' $filter) as reservas_canceladas_valor,
        (SELECT COUNT(id) FROM app_chat WHERE id>0  $filter2) as chat_qtd,
        (SELECT COUNT(id) FROM app_avaliacoes_ofc WHERE id>0 $filter) as avaliacoes_qtd,
        (SELECT COUNT(id) FROM app_favoritos) as favoritos_qtd,
        (SELECT COUNT(id) FROM app_notificacoes WHERE id>0 $filter2) as notificacoes_qtd,
        (SELECT COUNT(id) FROM app_fcm WHERE type='1') as android_qtd,
        (SELECT COUNT(id) FROM app_fcm WHERE type='2') as ios_qtd
    ");

    $sql->execute();
    $sql->bind_result(
      $usuarios_qtd,
      $anuncios_aprovados_qtd,
      $anuncios_pendentes_qtd,
      $anuncios_1_qtd,
      $anuncios_2_qtd,
      $reservas_confirmadas_qtd,
      $reservas_pendente_qtd,
      $reservas_canceladas_qtd,
      $reservas_confirmadas_valor,
      $reservas_pendente_valor,
      $reservas_canceladas_valor,
      $chat_qtd,
      $avaliacoes_qtd,
      $favoritos_qtd,
      $notificacoes_qtd,
      $android_qtd,
      $ios_qtd
    );
    $sql->store_result();
    $rows = $sql->num_rows;

    $usuarios = [];

    if ($rows == 0) {
        $Param['rows'] = $rows;
        array_push($usuarios, $Param);
    } else {
        while ($sql->fetch()) {

            $Param['usuarios_qtd'] = $usuarios_qtd;
            $Param['anuncios_aprovados_qtd'] = $anuncios_aprovados_qtd;
            $Param['anuncios_pendentes_qtd'] = $anuncios_pendentes_qtd;
            $Param['anuncios_1_qtd'] = $anuncios_1_qtd;
            $Param['anuncios_2_qtd'] = $anuncios_2_qtd;
            $Param['reservas_confirmadas_qtd'] = $reservas_confirmadas_qtd;
            $Param['reservas_pendente_qtd'] = $reservas_pendente_qtd;
            $Param['reservas_canceladas_qtd'] = $reservas_canceladas_qtd;
            $Param['reservas_confirmadas_valor'] = moneyView($reservas_confirmadas_valor);
            $Param['reservas_pendente_valor'] = moneyView($reservas_pendente_valor);
            $Param['reservas_canceladas_valor'] = moneyView($reservas_canceladas_valor);
            $Param['chat_qtd'] = $chat_qtd;
            $Param['avaliacoes_qtd'] = $avaliacoes_qtd;
            $Param['favoritos_qtd'] = $favoritos_qtd;
            $Param['notificacoes_qtd'] = $notificacoes_qtd;
            $Param['android_qtd'] = $android_qtd;
            $Param['ios_qtd'] = $ios_qtd;

            array_push($usuarios, $Param);
        }
    }

    return $usuarios;
}


}
