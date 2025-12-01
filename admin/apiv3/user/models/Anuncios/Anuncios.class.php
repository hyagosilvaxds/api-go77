<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Reservas/Reservas.class.php';
require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Anuncios extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        // $this->ConectaWordPress();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_pedidos";
        $this->tabela_users = "app_users";
        $this->tabela_status = "app_pedidos_status";


    }

    public function adicionar($id_user, $id_categoria, $id_subcategoria, $nome, $descricao, $checkin, $checkout){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios`(`app_users_id`, `app_categorias_id`, `app_subcategorias_id`,`nome`, `descricao`, `checkin`, `checkout`, `data_cadastro`, `status`, `status_aprovado`, `finalizado`)
             VALUES ('$id_user', '$id_categoria', '$id_subcategoria', '$nome', '$descricao', '$checkin', '$checkout', '$this->data_atual', 1, 1, 2)"
        );
        $sql->execute();
        $id_cadastro = $sql->insert_id;



        $Param = [
            "status" => "01",
            "id" => $id_cadastro,
            "msg" => "Anúncio iniciado com sucesso."
        ];

        return $Param;
    }

    public function adicionarType($id, $nome, $descricao){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios_types`(`app_anuncios_id`, `nome`, `descricao`,`status`)
             VALUES ('$id', '$nome', '$descricao', 1)"
        );
        $sql->execute();
        $id_cadastro = $sql->insert_id;

        $Param = [
            "status" => "01",
            "id" => $id_cadastro,
            "msg" => "Tipo adicionado com sucesso."
        ];

        return $Param;
    }

    public function adicionarTypeInfo($id_type, $adultos, $criancas, $quartos, $banheiros, $pets){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios_info`(`app_anuncios_types_id`, `adultos`, `criancas`, `quartos`, `banheiros`, `pets`)
             VALUES ('$id_type', '$adultos', '$criancas', '$quartos', '$banheiros', '$pets')"
        );
        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Info adicionada com sucesso."
        ];

        return $Param;
    }

    public function adicionarTypeCamas($id_type, $id_cama, $qtd){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios_camas`(`app_anuncios_types_id`, `app_camas_id`, `qtd`)
             VALUES ('$id_type', '$id_cama', '$qtd')"
        );
        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Camas adicionadas com sucesso."
        ];

        return $Param;
    }

    public function adicionarTypePeriodos($id_type, $nome, $data_de, $data_ate, $valor, $taxa_limpeza, $qtd){


        $sql =$this->mysqli->prepare(
            "INSERT INTO `app_anuncios_valor`(`app_anuncios_types_id`, `nome`, `data_de`, `data_ate`, `valor`, `desc_min_diarias`, `taxa_limpeza`, `qtd`)
             VALUES ('$id_type', '$nome', '$data_de', '$data_ate', '$valor', '0', '$taxa_limpeza', '$qtd')"
        );

        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Períodos adicionados com sucesso."
        ];

        return $Param;
    }

    public function adicionarcarac($id, $carac){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios_carac`(`app_anuncios_id`, `app_caracteristicas_id`)
             VALUES ('$id', '$carac')"
        );
        $sql->execute();


        $Param = [
            "status" => "01",
            "msg" => "Caracteristicas adicionadas com sucesso."
        ];

        return $Param;
    }

    public function adicionarImagens($id, $url)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_anuncios_fotos` (`app_anuncios_id`, `capa`, `url`)
        VALUES ('$id', '2', '$url')");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Imagens enviadas com sucesso."
        ];

        return $Param;

    }

    public function excluir($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Anúncio excluído com sucesso."
      ];

      return $Param;

    }

    public function excluirSubcategoria($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_subcategorias` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Subcategoria excluída com sucesso."
      ];

      return $Param;

    }

    public function excluirCaracteristica($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_caracteristicas` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Característica excluída com sucesso."
      ];

      return $Param;

    }

    public function excluirCama($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_camas` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Cama excluída com sucesso."
      ];

      return $Param;

    }

    public function excluirType($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_types` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Tipo de quarto excluído com sucesso."
      ];

      return $Param;

    }

    public function excluirFavorito($id_anuncio, $id_user)
    {

      $sql = $this->mysqli->prepare("DELETE FROM `app_favoritos` WHERE app_users_id='$id_user' AND app_anuncios_id='$id_anuncio'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Favorito excluído com sucesso."
      ];

      return $Param;

    }

    public function excluirimagens($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_fotos` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem excluída com sucesso."
      ];

      return $Param;

    }

    public function excluircarac($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_carac` WHERE app_anuncios_id='$id'");
      $sql->execute();


    }

    public function update($id, $id_categoria, $id_subcategoria, $nome, $descricao, $checkin, $checkout, $status){


      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios` SET app_categorias_id='$id_categoria', app_subcategorias_id='$id_subcategoria', nome='$nome', descricao='$descricao',
      checkin='$checkin', checkout='$checkout', status='$status'
      WHERE id='$id'"
      );

      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Anúncio atualizado com sucesso."
      ];

      return $Param;

    }

    public function updateSubcategoria($id, $id_categoria, $nome, $status)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_subcategorias` SET app_categorias_id='$id_categoria', nome='$nome', status='$status'
        WHERE id='$id'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Subcategoria atualizada com sucesso."
        ];

        return $Param;

    }

    public function updateCaracteristica($id, $id_categoria, $nome, $status)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_caracteristicas` SET app_categorias_id='$id_categoria', nome='$nome', status='$status'
        WHERE id='$id'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Característica atualizada com sucesso."
        ];

        return $Param;

    }

    public function updateCama($id,$nome, $status)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_camas` SET nome='$nome', status='$status'
        WHERE id='$id'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cama atualizada com sucesso."
        ];

        return $Param;

    }

    public function updateMotivo($id,$tipo,$nome,$taxado,$taxa_perc,$status)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_cancelamentos` SET tipo='$tipo', nome='$nome', taxado='$taxado', taxa_perc='$taxa_perc', status='$status'
        WHERE id='$id'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Motivo atualizado com sucesso."
        ];

        return $Param;

    }

    public function aprovar($id, $status_aprovado){


      $sql = $this->mysqli->prepare("UPDATE `app_anuncios` SET status_aprovado='$status_aprovado' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Anúncio atualizado com sucesso."
      ];

      return $Param;

    }


    public function updateType($id, $nome, $descricao, $status){


      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios_types` SET nome='$nome', descricao='$descricao', status='$status'
      WHERE id='$id'"
      );

      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Tipo de quarto atualizado com sucesso."
      ];

      return $Param;

    }

    public function updateTypeInfo($id, $adultos, $criancas, $quartos, $banheiros, $pets){


      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios_info` SET adultos='$adultos', criancas='$criancas', quartos='$quartos', banheiros='$banheiros', pets='$pets'
      WHERE app_anuncios_types_id='$id'"
      );

      $sql->execute();


    }


    public function updateImagemSubcategoria($id, $url){

      $sql = $this->mysqli->prepare("UPDATE `app_subcategorias` SET url='$url' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem atualizada com sucesso."
      ];

      return $Param;

    }

    public function updateImagemCaracteristica($id, $url){

      $sql = $this->mysqli->prepare("UPDATE `app_caracteristicas` SET url='$url' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem atualizada com sucesso."
      ];

      return $Param;

    }

    public function updateImagemCama($id, $url){

      $sql = $this->mysqli->prepare("UPDATE `app_camas` SET url='$url' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem atualizada com sucesso."
      ];

      return $Param;

    }

    public function updateCapa($id){

      $sql = $this->mysqli->prepare("UPDATE `app_anuncios_fotos` SET capa='1' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Capa atualizada com sucesso."
      ];

      return $Param;

    }

    public function updateEndereco($id, $endereco, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia, $latitude, $longitude){


      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios_location` SET end='$endereco', rua='$rua', bairro='$bairro', cidade='$cidade', estado='$estado',
      numero='$numero', complemento='$complemento', referencia='$referencia', latitude='$latitude', longitude='$longitude'
      WHERE app_anuncios_id='$id'"
      );

      $sql->execute();

    }



    public function adicionarSubcategoria($id_categoria, $nome, $url)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_subcategorias` (`app_categorias_id`, `nome`, `url`, `status`)
        VALUES ('$id_categoria', '$nome', '$url', '1')");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Subcategoria cadastrada com sucesso."
        ];

        return $Param;

    }

    public function adicionarCaracteristica($id_categoria, $nome, $url)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_caracteristicas` (`app_categorias_id`, `nome`, `url`, `status`)
        VALUES ('$id_categoria', '$nome', '$url', '1')");


        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Característica cadastrada com sucesso."
        ];

        return $Param;

    }

    public function adicionarCama($nome, $url)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_camas` (`nome`, `url`, `status`)
        VALUES ('$nome', '$url', '1')");


        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cama cadastrada com sucesso."
        ];

        return $Param;

    }

    public function adicionarMotivo($tipo, $nome, $taxado, $taxa_perc)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_cancelamentos` (`tipo`, `nome`, `taxado`, `taxa_perc`, `status`)
        VALUES ('$tipo', '$nome', '$taxado', '$taxa_perc', '1')");


        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Motivo cadastrado com sucesso."
        ];

        return $Param;

    }

    public function excluirImagensType($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_types_fotos` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem excluída com sucesso."
      ];

      return $Param;

    }

    public function updateCamas($id, $qtd){


      $sql = $this->mysqli->prepare("UPDATE `app_anuncios_camas` SET qtd='$qtd' WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Tipo de cama atualizada com sucesso."
      ];

      return $Param;

    }

    public function excluirCamas($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_camas` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Cama excluída com sucesso."
      ];

      return $Param;

    }

    public function excluirMotivo($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_cancelamentos` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Motivo excluído com sucesso."
      ];

      return $Param;

    }

    public function updatePeriodos($id, $nome, $data_de, $data_ate, $valor, $taxa_limpeza, $qtd){


      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios_valor` SET nome='$nome', data_de='$data_de', data_ate='$data_ate', valor='$valor', taxa_limpeza='$taxa_limpeza', qtd='$qtd'
      WHERE id='$id'"
      );

      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Período de quarto atualizado com sucesso."
      ];

      return $Param;

    }

    public function excluirPeriodos($id)
    {


      $sql = $this->mysqli->prepare("DELETE FROM `app_anuncios_valor` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Período excluído com sucesso."
      ];

      return $Param;

    }

    //daqui pra baixo outro projeto

    public function adicionarEndereco($id, $endereco, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia, $latitude, $longitude){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_anuncios_location`(`app_anuncios_id`, `latitude`,`longitude`, `end`,`rua`,`bairro`,`cidade`, `estado`, `numero`, `complemento`, `referencia`)
             VALUES ('$id', '$latitude','$longitude', '$endereco','$rua','$bairro','$cidade','$estado', '$numero', '$complemento', '$referencia')"
        );
        $sql_cadastro->execute();

    }


    public function finalizar($id)
    {

      $sql = $this->mysqli->prepare("
      UPDATE `app_anuncios` SET finalizado='1'
      WHERE id='$id'"
      );

      $sql->execute();


    }


    public function saveFavorito($id_anuncio, $id_user){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_favoritos`(`app_users_id`, `app_anuncios_id`)
             VALUES ('$id_user','$id_anuncio')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Favorito adicionado com sucesso."
        ];

        return $Param;

    }

    public function saveAvaliacao($id_reserva, $id_anuncio, $id_user, $descricao, $estrelas, $avaliou){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_avaliacoes_ofc`(`app_reservas_id`, `app_anuncios_id`, `app_users_id`, `descricao`, `estrelas`, `data_cadastro`, `avaliou`)
             VALUES ('$id_reserva','$id_anuncio','$id_user','$descricao','$estrelas','$this->data_atual', '$avaliou')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Avaliação enviada com sucesso."
        ];

        return $Param;

    }

    public function ambientes_add($id_orcamento, $nome){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_ambientes`(`app_orcamentos_id`, `nome`)
             VALUES ('$id_orcamento', '$nome')"
        );
        $sql->execute();
        $id_cadastro = $sql->insert_id;



        $Param = [
            "status" => "01",
            "id" => $id_cadastro,
            "msg" => "Ambiente cadastrado com sucesso."
        ];

        return $Param;
    }

    public function ambientes_editar($id_ambiente, $nome)
    {


        $sql = $this->mysqli->prepare("
        UPDATE `app_ambientes` SET nome='$nome'
        WHERE id='$id_ambiente'"
        );

        $sql->execute();

        $Param = [
            "status" => "01",
            "id" => $id_ambiente,
            "msg" => "Ambiente atualizado com sucesso."
        ];

        return $Param;
    }

    public function ambientes_excluir($id_ambiente)
    {


      $sql = $this->mysqli->prepare(
          "DELETE FROM `app_ambientes` WHERE id='$id_ambiente'"
      );

      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Ambiente excluído com sucesso."
      ];

      return $Param;

    }


    public function itens_add($id_ambiente, $nome){

        $sql = $this->mysqli->prepare(
            "INSERT INTO `app_ambientes_itens`(`app_ambientes_id`, `nome`)
             VALUES ('$id_ambiente', '$nome')"
        );
        $sql->execute();
        $id_cadastro = $sql->insert_id;


        $Param = [
            "status" => "01",
            "id" => $id_cadastro,
            "msg" => "Item cadastrado com sucesso."
        ];

        return $Param;
    }

    public function itens_editar($id_item, $tipo, $m2, $obs)
    {

        $filter = " SET id='$id_item'";
        if(!empty($tipo)){
            $filter .= ", tipo='$tipo'";
        }
        if(!empty($m2)){
            $filter .= ", m2='$m2'";
        }
        if(!empty($obs)){
            $filter .= ", obs='$obs'";
        }

        $sql = $this->mysqli->prepare("
          UPDATE `app_ambientes_itens`
          $filter
          WHERE id='$id_item'"
        );

        $sql->execute();

        $Param = [
            "status" => "01",
            "id" => $id_item,
            "msg" => "Item atualizado com sucesso."
        ];

        return $Param;

    }

    public function itens_excluir($id_item)
    {


      $sql = $this->mysqli->prepare(
          "DELETE FROM `app_ambientes_itens` WHERE id='$id_item'"
      );

      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Item excluído com sucesso."
      ];

      return $Param;

    }

    public function itens_imagens_adicionar($id_item,$url)
    {


        $sql_cadastro = $this->mysqli->prepare("
        INSERT INTO `app_ambientes_itens_img` (`app_ambientes_itens_id`, `url`, `data`)
        VALUES ('$id_item', '$url', '$this->data_atual')");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Imagem enviada com sucesso."
        ];

        return $Param;

    }

    public function itens_imagens_excluir($id){

      $sql = $this->mysqli->prepare("DELETE FROM `app_ambientes_itens_img` WHERE id='$id'");
      $sql->execute();

      $Param = [
          "status" => "01",
          "msg" => "Imagem excluída com sucesso."
      ];

      return $Param;

    }

    public function listbrifiengserv()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, titulo
            FROM `app_servicos`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$titulo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['titulo'] = $titulo;
                $Param['respostas'] = $this->listbrifiengservresp($id);

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listbrifiengservresp($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, titulo, valor
            FROM `app_servicos_respostas`
            WHERE app_servicos_id='$id' AND status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$titulo,$valor);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['titulo'] = $titulo;
                $Param['valor'] = $valor;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function brifiengserv_editar($id_item, $lista)
    {

      $sql_limpa = $this->mysqli->prepare(
          "DELETE FROM `app_ambientes_itens_serv` WHERE app_ambientes_itens_id='$id_item'"
      );

      $sql_limpa->execute();

      foreach ($lista as $param) {

          $sql_cadastro = $this->mysqli->prepare(
              "INSERT INTO `app_ambientes_itens_serv`(`app_ambientes_itens_id`, `app_servicos_respostas_id`)
              VALUES ('$id_item', '$param')"
          );

          $sql_cadastro->execute();
      }

      $Param = [
          "status" => "01",
          "msg" => "Brifieng atualizado com sucesso."
      ];

      return $Param;

    }

    public function listbrifiengprod()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, titulo
            FROM `app_produtos`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$titulo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['titulo'] = $titulo;
                $Param['respostas'] = $this->listbrifiengprodresp($id);

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listbrifiengprodresp($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, titulo, valor
            FROM `app_produtos_respostas`
            WHERE app_produtos_id='$id' AND status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$titulo,$valor);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['titulo'] = $titulo;
                $Param['valor'] = $valor;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function brifiengprod_editar($id_item, $lista)
    {

      $sql_limpa = $this->mysqli->prepare(
          "DELETE FROM `app_ambientes_itens_prod` WHERE app_ambientes_itens_id='$id_item'"
      );

      $sql_limpa->execute();

      foreach ($lista as $param) {

          $sql_cadastro = $this->mysqli->prepare(
              "INSERT INTO `app_ambientes_itens_prod`(`app_ambientes_itens_id`, `app_produtos_respostas_id`)
              VALUES ('$id_item', '$param')"
          );

          $sql_cadastro->execute();
      }

      $Param = [
          "status" => "01",
          "msg" => "Brifieng atualizado com sucesso."
      ];

      return $Param;

    }

    public function listTodosPagantes($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,app_users_id,tipo_pagamento,valor_corrida,token
            FROM `app_Orcamentos_pagamentos`
            WHERE token <> '' AND app_Orcamentos_id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($id_pagamento,$id_user,$tipo_pagamento,$valor_corrida,$token);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];



        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id_pagamento'] = $id_pagamento;
                $Param['id_user'] = $id_user;
                $Param['tipo_pagamento'] = $tipo_pagamento;
                $Param['valor_corrida'] = $valor_corrida;
                $Param['token'] = $token;
                    array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }
    public function verificaMotorista($id_user,$id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_Orcamentos`
            WHERE id_motorista='$id_user' AND id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // print_r($perc_desconto);
        return $rows;
    }
    public function minhasViagens($id_user)
    {

        // Monta a query SQL
        $sql = "
            SELECT DISTINCT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km ,
            a.status , e.status ,
            f.id, f.hora_partida,g.id,g.hora_partida,
            h.valor_corrida,h.tipo_pagamento,h.id
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            INNER JOIN `app_participantes` AS e ON a.id=e.app_Orcamentos_id
            INNER JOIN `app_Orcamentos_end` AS f ON e.endereco_partida=f.id
            INNER JOIN `app_Orcamentos_end` AS g ON e.endereco_chegada=g.id
            INNER JOIN `app_Orcamentos_pagamentos` AS h ON h.app_Orcamentos_id=a.id
            WHERE e.app_users_id='$id_user' AND h.app_users_id='$id_user' AND e.status<>5
             AND DATE_ADD(a.data_agendada, INTERVAL a.duracao_min + 120 MINUTE) >= NOW()
            GROUP BY e.id
            ORDER BY a.data_agendada DESC
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km,
        $status_corrida,$status_participante,
        $id_partida,$hora_partida,$id_chegada,$hora_chegada,
        $valor_corrida,$tipo_pagamento,$id_pagamento);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $todos_enderecos=$this->buscaEnderecosMinhaCorrida($id,$id_partida,$id_chegada);

                $Param['id_corrida'] = $id;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);

                $Param['enderecos'] = $todos_enderecos;

                $Param['valor_total'] = moneyView($valor_corrida);
                $Param['tipo_pagamento'] = $tipo_pagamento;
                $Param['id_pagamento'] = $id_pagamento;

                $info_vagas = $this->infoVagas($id,$vagas_id,$vagas_qtd);

                $Param['vagas'] = $info_vagas;

                $Param['obs'] = $obs;

                $Param['status_corrida'] = $status_corrida;

                switch ($status_corrida) {
                    case '1':
                        $Param['status_corrida_msg'] = "Aberta";
                        break;
                    case '2':
                        $Param['status_corrida_msg'] = "Fechada";
                        break;
                    case '3':
                        $Param['status_corrida_msg'] = "Em curso";
                        break;
                    case '4':
                        $Param['status_corrida_msg'] = "Cancelada";
                        break;
                }
                $Param['status_participante'] = $status_participante;
                switch ($status_participante) {
                    case '1':
                        $Param['status_participante_msg'] = "Aceito";
                        break;
                    case '2':
                        $Param['status_participante_msg'] = "Pendente";
                        break;
                    case '3':
                        $Param['status_participante_msg'] = "Recusado";
                        break;
                }

                array_push($lista, $Param);
            }

            if(count($lista) == 0){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }else{
                foreach ($lista as &$item) {
                    $item['rows'] = count($lista);
                }
            }

        }

        // print_r($lista);
        return $lista;
    }
    public function minhasViagensOferecidas($id_user)
    {

        // Monta a query SQL
        $sql = "
            SELECT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km , a.status
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            WHERE a.id_motorista='$id_user' AND DATE_ADD(a.data_agendada, INTERVAL a.duracao_min + 120 MINUTE) >= NOW()
            GROUP BY a.id
            ORDER BY a.id DESC
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km,$status_corrida);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $todos_enderecos=$this->buscaEnderecosMinhaCorrida($id,$id_partida,$id_chegada);

                $Param['id_corrida'] = $id;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);

                $Param['enderecos'] = $todos_enderecos;


                $info_vagas = $this->infoVagas($id,$vagas_id,$vagas_qtd);

                $Param['vagas'] = $info_vagas;

                $Param['obs'] = $obs;

                $Param['status_corrida'] = $status_corrida;
                switch ($status_corrida) {
                    case '1':
                        $Param['status_corrida_msg'] = "Aberta";
                        break;
                    case '2':
                        $Param['status_corrida_msg'] = "Fechada";
                        break;
                    case '3':
                        $Param['status_corrida_msg'] = "Em curso";
                        break;
                    case '4':
                        $Param['status_corrida_msg'] = "Cancelada";
                        break;
                }

                array_push($lista, $Param);
            }

            if(count($lista) == 0){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }else{
                foreach ($lista as &$item) {
                    $item['rows'] = count($lista);
                }
            }

        }

        // print_r($lista);
        return $lista;
    }
    public function updateVagasDisponiveis($id_corrida,$id_endereco_partida,$id_endereco_final,$vagas_id,$vagas_qtd,$id_pagamento)
    {

        for ($i=0; $i < COUNT($vagas_id) ; $i++) {
            $vaga_usada = $vagas_id[$i];
            $qtd_usada = $vagas_qtd[$i];

            $sql_cadastro = $this->mysqli->prepare("
            UPDATE `app_Orcamentos_vagas` SET qtd_disponivel=qtd_disponivel-$qtd_usada
            WHERE app_Orcamentos_id='$id_corrida' AND app_vagas_id='$vaga_usada' AND id_corrida_end >= $id_endereco_partida AND id_corrida_end < $id_endereco_final
            "
            );
            $sql_cadastro->execute();
            $sql_cadastro->close();


            $sql = $this->mysqli->prepare(
                "
                SELECT id
                FROM `app_Orcamentos_vagas`
                WHERE app_Orcamentos_id='$id_corrida' AND app_vagas_id='$vaga_usada' AND id_corrida_end >= $id_endereco_partida AND id_corrida_end < $id_endereco_final
                "
            );
            $sql->execute();
            $sql->bind_result($id_vaga_corrida);
            $sql->store_result();
            $sql->fetch();
            $sql->close();

            $sql_cadastro = $this->mysqli->prepare(
                "INSERT INTO `app_pagamentos_vagas`(`app_pagamentos_id`, `app_vagas_id`,`qtd`)
                    VALUES ('$id_pagamento','$id_vaga_corrida','$qtd_usada')"
            );
            $sql_cadastro->execute();
            $sql_cadastro->close();

        }


    }
    public function updateVagasDisponiveisPix($id_corrida,$id_endereco_partida,$id_endereco_final,$vagas_id,$vagas_qtd,$id_pagamento)
    {

        //diferente do 'updateVagasDisponiveis' , esse nao atualiza a qtd de vagas ainda, pois nao é garantido q o pix vai ser pago!
        for ($i=0; $i < COUNT($vagas_id) ; $i++) {
            $vaga_usada = $vagas_id[$i];
            $qtd_usada = $vagas_qtd[$i];

            $sql = $this->mysqli->prepare(
                "
                SELECT id
                FROM `app_Orcamentos_vagas`
                WHERE app_Orcamentos_id='$id_corrida' AND app_vagas_id='$vaga_usada' AND id_corrida_end >= $id_endereco_partida AND id_corrida_end < $id_endereco_final
                "
            );
            $sql->execute();
            $sql->bind_result($id_vaga_corrida);
            $sql->store_result();
            $sql->fetch();

            $sql_cadastro = $this->mysqli->prepare(
                "INSERT INTO `app_pagamentos_vagas`(`app_pagamentos_id`, `app_vagas_id`,`qtd`)
                    VALUES ('$id_pagamento','$id_vaga_corrida','$qtd_usada')"
            );
            $sql_cadastro->execute();

        }


    }
    public function dadosCorrida($latitude,$longitude,$data_agendada)
    {
        // Definir origem e destino
        $originLat = $latitude[0];
        $originLong = $longitude[0];
        $destLat = end($latitude);
        $destLong = end($longitude);

        // Preparar waypoints (do segundo ao penúltimo)
        $waypoints = [];
        $numWaypoints = count($latitude) - 2; // Exclui o primeiro e o último

        for ($i = 1; $i <= $numWaypoints; $i++) {
            $waypoints[] = [
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i]
            ];
        }

        // Chamar a função com origem, destino e waypoints
        $timestamp = strtotime($data_agendada);
        $retorno = createRotaLatLong($originLat, $originLong, $destLat, $destLong, $waypoints, $timestamp);
        $rota = $retorno['routes'][0];
        $distanciaTotal=0;
        $duracaoTotal=0;
        $polyline=$rota['overview_polyline']['points'];
        // print_r($retorno);exit;

        // Iterar sobre cada leg para somar a distância, duração total e calcular durações individuais
        foreach ($rota['legs'] as $index => $leg) {
            $distanciaTotal += $leg['distance']['value'];
            $duracaoTotal += $leg['duration']['value'];

            // Armazenar a duração de cada parada
            $duracoesParadas[] = [
                'parada' => $index + 1, // Identifica a parada pela ordem (1, 2, 3, etc.)
                'duracao' => number_format($leg['duration']['value'] / 60, 1) // Converte para minutos
            ];
        }
        $item = [
            'distancia' => number_format(($distanciaTotal / 1000), 1), // Converte para km
            'duracao' => number_format($duracaoTotal / 60, 1), // Converte para minutos
            'duracoes_paradas' => $duracoesParadas, // Durações de cada parada
            'polyline' => $polyline,
        ];
        return $item;
    }
    public function oferecer($id_motorista,$data_agendada,$obs){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos`(`id_motorista`, `data_agendada`,`data_cadastro`,`obs`,`status`)
             VALUES ('$id_motorista','$data_agendada','$this->data_atual','$obs','1')"
        );
        $sql_cadastro->execute();

        $id_corrida = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "id_corrida" => $id_corrida,
            "msg" => "Carona oferecida com sucesso."
        ];

        return $Param;
    }

    public function saveCaracteristicasCorrida($id_corrida,$caracteristica){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_caracteristicas`(`app_Orcamentos_id`, `app_caracteristicas_id`)
             VALUES ('$id_corrida','$caracteristica')"
        );
        $sql_cadastro->execute();
    }

    public function saveVagasCorrida($id_corrida,$vagas_id,$id_endereco,$vagas_qtd,$vagas_valor,$valor_motorista,$valor_admin){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_vagas`(`app_Orcamentos_id`, `app_vagas_id`,`id_corrida_end`,`qtd`,`qtd_disponivel`,`valor`, `status`, `valor_motorista`, `valor_admin`)
             VALUES ('$id_corrida','$vagas_id','$id_endereco','$vagas_qtd','$vagas_qtd','$vagas_valor','1','$valor_motorista','$valor_admin')"
        );
        $sql_cadastro->execute();
    }

    public function saveEnderecoCorrida($id_corrida,$ordem,$endereco,$rua,$bairro,$cidade,$estado,$latitude,$longitude,$hora_partida){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_end`(`app_Orcamentos_id`, `ordem`,`endereco`,`rua`,`bairro`,`cidade`,`estado`,`latitude`,`longitude`,`hora_partida`)
             VALUES ('$id_corrida','$ordem','$endereco','$rua','$bairro','$cidade','$estado','$latitude','$longitude','$hora_partida')"
        );
        $sql_cadastro->execute();

        $id_cadastro = $sql_cadastro->insert_id;
        return $id_cadastro;
    }
    public function listVagaId($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,url,qtd_max,perc_admin
            FROM `app_vagas`
            WHERE id='$id'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$icone,$qtd_max,$perc_admin);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['icone'] = $icone;
                $Param['qtd_max'] = $qtd_max;
                $Param['perc_admin'] = $perc_admin;
                    array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista[0];
    }
    public function list()
    {
            $lista = [];

            $Param['camas'] = $this->listcamas();
            $Param['categorias'] = $this->listcategorias();
            $Param['subcategorias_all'] = $this->listsubcategoriasAll();
            $Param['config'] = $this->listconfig();

            array_push($lista, $Param);

        return $lista;
    }

    public function listcaracteristicas($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url
            FROM `app_caracteristicas`
            WHERE app_categorias_id='$id' AND status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id, $nome, $url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listcamas()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url
            FROM `app_camas`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id, $nome, $url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listcategorias()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url
            FROM `app_categorias`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id, $nome, $url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['subcategorias'] = $this->listsubcategorias($id);
                $Param['caracteristicas'] = $this->listcaracteristicas($id);

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listsubcategorias($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url
            FROM `app_subcategorias`
            WHERE app_categorias_id='$id' AND status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id, $nome, $url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listsubcategoriasAll()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url
            FROM `app_subcategorias`
            WHERE status='1'
            ORDER BY id ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id, $nome, $url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }


    public function listconfig()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT whatsapp, instagram, manutencao, credito, dinheiro, pix
            FROM `app_config`
            "
        );

        $sql->execute();
        $sql->bind_result($whatsapp, $instagram, $manutencao, $credito, $dinheiro, $pix);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['whatsapp'] = $whatsapp;
                $Param['instagram'] = $instagram;
                $Param['manutencao'] = $manutencao;
                $Param['credito'] = $credito;
                $Param['dinheiro'] = $dinheiro;
                $Param['pix'] = $pix;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listaProximos($id_user, $lat, $long){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.*, b.*, c.nome, d.nome, e.nome
          FROM `app_anuncios` as a
          INNER JOIN `app_anuncios_location` as b ON a.id = b.app_anuncios_id
          INNER JOIN `app_categorias` as c ON a.app_categorias_id = c.id
          INNER JOIN `app_subcategorias` as d ON a.app_subcategorias_id = d.id
          INNER JOIN `app_users` as e ON a.app_users_id = e.id
          WHERE a.app_users_id !='$id_user' AND a.status=1 AND a.status_aprovado=1 AND a.finalizado=1
          "
      );

      $sql->execute();
      $sql->bind_result(
        $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $status, $status_aprovado, $finalizado,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria, $nome_user
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_config = New Configuracoes();

              $dados_config = $model_config->listConfig();

              $distancia = distancia($lat, $long, $latitude, $longitude);

              if ($distancia <= $dados_config['raio_km']) {

                $Param['id'] = $id;
                $Param['id_user'] = $app_users_id;
                $Param['nome_user'] = decryptitem($nome_user);
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;
                $Param['id_subcategoria'] = $id_subcategoria;
                $Param['nome_subcategoria'] = $nome_subcategoria;
                $Param['nome'] = $nome;
                $Param['descricao'] = $descricao;
                $Param['checkin'] = dataBR($checkin);
                $Param['checkout'] = dataBR($checkout);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['finalizado'] = $finalizado;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['end'] = $end;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['numero'] = $numero;
                $Param['complemento'] = $complemento;
                $Param['referencia'] = $referencia;
                $Param['distancia'] = $distancia . " km";
                $Param['media'] = $this->avaliacoesMedia($id);
                $Param['favorito'] = $this->verificaFavorito($id, $id_user);
                $Param['data'] = dataBR($data_cadastro);
                $Param['imagens'] = $this->listimagens($id);
                if(!empty($data_de) AND !empty($data_ate)){
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de, $data_ate);
                }else{
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de = null, $data_ate = null);
                }
                $Param['caracteristicas'] = $this->listcaracteristicasID($id);
                $Param['imagens'] = $this->listimagens($id);
                $Param['tipos'] = $this->listtiposValor($id, $data_de = null, $data_ate = null);
                $Param['avaliacoes'] = $this->avaliacoes($id);
                //$Param['reservas'] = $this->avaliacoes($id);

                array_push($lista, $Param);

            }
          }
      }

      return $lista;

    }

    public function listaCategorias()
    {

        $sql = $this->mysqli->prepare("SELECT id, nome FROM `app_categorias` ORDER BY id ASC");

        $sql->execute();
        $sql->bind_result($id,$nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listasubCategorias($id_categoria, $id)
    {

        $filter = " WHERE a.status IN (1,2) ";


        if(!empty($id_categoria)){
            $filter .= " AND b.app_categorias_id ='$id_categoria'";
        }
        if(!empty($id)){
            $filter .= " AND b.id ='$id'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.nome, b.id, b.nome, b.url, b.status
            FROM `app_categorias` as a
            INNER JOIN `app_subcategorias` as b ON a.id = b.app_categorias_id
            $filter
            ORDER BY a.id ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id_categoria,$nome_categoria,$id,$nome,$url,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['status'] = $status;


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listaCaracteristicas($id)
    {

        $filter = " WHERE a.status IN (1,2) ";

        if(!empty($id)){
            $filter .= " AND a.id ='$id'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.nome, a.url, a.status, b.id, b.nome
            FROM `app_caracteristicas` as a
            INNER JOIN `app_categorias` as b ON a.app_categorias_id = b.id
            $filter
            ORDER BY a.app_categorias_id ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$url,$status,$id_categoria,$nome_categoria);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['status'] = $status;
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listaCamas($id)
    {

        $filter = " WHERE status IN (1,2) ";

        if(!empty($id)){
            $filter .= " AND id ='$id'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT id, nome, url, status
            FROM `app_camas`
            $filter
            ORDER BY id ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$url,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['status'] = $status;


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function listaMotivos($id)
    {

        $filter = " WHERE status IN (1,2) ";

        if(!empty($id)){
            $filter .= " AND id ='$id'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT id, tipo, nome, taxado, taxa_perc, status
            FROM `app_cancelamentos`
            $filter
            ORDER BY id ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id,$tipo,$nome,$taxado,$taxa_perc,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['tipo'] = $tipo;
                $Param['nome'] = $nome;
                $Param['taxado'] = $taxado;
                $Param['taxa_perc'] = $taxa_perc;
                $Param['status'] = $status;


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function lista($id,$id_categoria,$data_de,$data_ate,$limite){

        $filter = " WHERE a.status_aprovado='1' ";

        if(!empty($id)){
            $filter .= " AND a.id ='$id'";
        }
        if(!empty($id_categoria)){
            $filter .= " AND a.app_categorias_id ='$id_categoria'";
        }
        if(!empty($data_de) AND !empty($data_ate)){
            $filter .= " AND a.data_de <='$data_de' AND a.data_ate >='$data_ate'";
        }

      $sql = $this->mysqli->prepare(
          "
          SELECT a.*, b.nome, c.*, d.nome, e.nome
          FROM `app_anuncios` as a
          INNER JOIN `app_users` as b ON a.app_users_id = b.id
          INNER JOIN `app_anuncios_location` as c ON a.id = c.app_anuncios_id
          INNER JOIN `app_categorias` as d ON a.app_categorias_id = d.id
          INNER JOIN `app_subcategorias` as e ON a.app_subcategorias_id = e.id
          LEFT JOIN `app_anuncios_types` as f ON a.id = f.app_anuncios_id
          LEFT JOIN `app_anuncios_info` as g ON f.id = g.app_anuncios_types_id
          LEFT JOIN `app_anuncios_carac` as h ON a.id = h.app_anuncios_id
          $filter
          GROUP BY a.id
          ORDER BY a.id DESC
          LIMIT $limite
          ");


      $sql->execute();
      $sql->bind_result(
        $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $data_in, $data_out, $status, $status_aprovado, $finalizado, $nome_user,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['id_user'] = $app_users_id;
                $Param['nome_user'] = decryptitem($nome_user);
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;
                $Param['id_subcategoria'] = $id_subcategoria;
                $Param['nome_subcategoria'] = $nome_subcategoria;
                $Param['nome'] = $nome;
                $Param['descricao'] = $descricao;
                $Param['checkin'] = dataBR($checkin);
                $Param['checkout'] = dataBR($checkout);
                $Param['data_in'] = dataBR($data_in);
                $Param['data_out'] = dataBR($data_out);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['finalizado'] = $finalizado;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['end'] = $end;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['numero'] = $numero;
                $Param['complemento'] = $complemento;
                $Param['referencia'] = $referencia;
                $Param['distancia'] = "0 km";
                $Param['media'] = $this->avaliacoesMedia($id);
                $Param['favorito'] = $this->verificaFavorito($id, $app_users_id);
                $Param['data'] = dataBR($data_cadastro);
                $Param['imagens'] = $this->listimagens($id);
                if(!empty($data_de) AND !empty($data_ate)){
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de, $data_ate);
                }else{
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de = null, $data_ate = null);
                }

                $Param['caracteristicas'] = $this->listcaracteristicasID($id);
                $Param['imagens'] = $this->listimagens($id);
                $Param['tipos'] = $this->listtiposValor($id, $data_de, $data_ate);
                $Param['avaliacoes'] = $this->avaliacoes($id);

                array_push($lista, $Param);


          }
      }

      return $lista;

    }

    public function listaPendentes($limite){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.*, b.nome, c.*, d.nome, e.nome
          FROM `app_anuncios` as a
          INNER JOIN `app_users` as b ON a.app_users_id = b.id
          INNER JOIN `app_anuncios_location` as c ON a.id = c.app_anuncios_id
          INNER JOIN `app_categorias` as d ON a.app_categorias_id = d.id
          INNER JOIN `app_subcategorias` as e ON a.app_subcategorias_id = e.id
          LEFT JOIN `app_anuncios_types` as f ON a.id = f.app_anuncios_id
          LEFT JOIN `app_anuncios_info` as g ON f.id = g.app_anuncios_types_id
          LEFT JOIN `app_anuncios_carac` as h ON a.id = h.app_anuncios_id
          WHERE a.status_aprovado='2'
          GROUP BY a.id
          ORDER BY a.id DESC
          LIMIT $limite
          ");


      $sql->execute();
      $sql->bind_result(
        $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $data_in, $data_out, $status, $status_aprovado, $finalizado, $nome_user,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['id_user'] = $app_users_id;
                $Param['nome_user'] = decryptitem($nome_user);
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;
                $Param['id_subcategoria'] = $id_subcategoria;
                $Param['nome_subcategoria'] = $nome_subcategoria;
                $Param['nome'] = $nome;
                $Param['descricao'] = $descricao;
                $Param['checkin'] = dataBR($checkin);
                $Param['checkout'] = dataBR($checkout);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['finalizado'] = $finalizado;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['end'] = $end;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['numero'] = $numero;
                $Param['complemento'] = $complemento;
                $Param['referencia'] = $referencia;
                $Param['distancia'] = $distancia . " km";
                $Param['media'] = $this->avaliacoesMedia($id);
                $Param['favorito'] = $this->verificaFavorito($id, $id_user);
                $Param['data'] = dataBR($data_cadastro);
                $Param['imagens'] = $this->listimagens($id);
                if(!empty($data_de) AND !empty($data_ate)){
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de, $data_ate);
                }else{
                  $Param['valor'] = $this->listAnunciosValor($id, $data_de = null, $data_ate = null);
                }

                $Param['caracteristicas'] = $this->listcaracteristicasID($id);
                $Param['imagens'] = $this->listimagens($id);
                $Param['tipos'] = $this->listtiposValor($id, $data_de, $data_ate);
                $Param['avaliacoes'] = $this->avaliacoes($id);

                array_push($lista, $Param);


          }
      }

      return $lista;

    }

    public function listaFavoritos($id_user){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, b.*, c.*, d.nome, e.nome, f.nome
          FROM `app_favoritos` as a
          INNER JOIN `app_anuncios` as b ON a.app_anuncios_id = b.id
          INNER JOIN `app_anuncios_location` as c ON b.id = c.app_anuncios_id
          INNER JOIN `app_categorias` as d ON b.app_categorias_id = d.id
          INNER JOIN `app_subcategorias` as e ON b.app_subcategorias_id = e.id
          INNER JOIN `app_users` as f ON b.app_users_id = f.id
          WHERE a.app_users_id ='$id_user' AND b.status=1 AND b.status_aprovado=1 AND b.finalizado=1
          "
      );

      $sql->execute();
      $sql->bind_result(
        $id_favorito, $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $checkin, $checkout, $data_cadastro, $status, $status_aprovado, $finalizado,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria, $nome_user
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_config = New Configuracoes();

              $dados_config = $model_config->listConfig();

              $distancia = distancia($lat, $long, $latitude, $longitude);

                $Param['id_favorito'] = $id_favorito;
                $Param['id'] = $id;
                $Param['id_user'] = $app_users_id;
                $Param['nome_user'] = decryptitem($nome_user);
                $Param['id_categoria'] = $id_categoria;
                $Param['nome_categoria'] = $nome_categoria;
                $Param['id_subcategoria'] = $id_subcategoria;
                $Param['nome_subcategoria'] = $nome_subcategoria;
                $Param['nome'] = $nome;
                $Param['descricao'] = $descricao;
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['finalizado'] = $finalizado;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['end'] = $end;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['numero'] = $numero;
                $Param['complemento'] = $complemento;
                $Param['referencia'] = $referencia;
                $Param['distancia'] = $distancia . " km";
                $Param['media'] = $this->avaliacoesMedia($id);
                $Param['favorito'] = $this->verificaFavorito($id, $id_user);
                $Param['data'] = dataBR($data_cadastro);
                $Param['imagens'] = $this->listimagens($id);
                $Param['valor'] = $this->listAnunciosValor($id, $data_de = null, $data_ate = null);
                $Param['caracteristicas'] = $this->listcaracteristicasID($id);
                $Param['imagens'] = $this->listimagens($id);
                $Param['tipos'] = $this->listtipos($id);
                $Param['avaliacoes'] = $this->avaliacoes($id);

                array_push($lista, $Param);


          }
      }

      return $lista;

    }

    public function mylistID($id_user){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.*, b.*, c.nome, d.nome
          FROM `app_anuncios` as a
          INNER JOIN `app_anuncios_location` as b
          ON a.id = b.app_anuncios_id
          INNER JOIN `app_categorias` as c
          ON a.app_categorias_id = c.id
          INNER JOIN `app_subcategorias` as d
          ON a.app_subcategorias_id = d.id
          WHERE a.app_users_id='$id_user'
          "
      );

      $sql->execute();
      $sql->bind_result(
        $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $data_in, $data_out, $status, $status_aprovado, $finalizado,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['id_user'] = $app_users_id;
              $Param['id_categoria'] = $id_categoria;
              $Param['nome_categoria'] = $nome_categoria;
              $Param['id_subcategoria'] = $id_subcategoria;
              $Param['nome_subcategoria'] = $nome_subcategoria;
              $Param['nome'] = $nome;
              $Param['descricao'] = $descricao;
              $Param['checkin'] = $checkin;
              $Param['checkout'] = $checkout;
              $Param['data_in'] = dataBR($data_in);
              $Param['data_out'] = dataBR($data_out);
              $Param['status'] = $status;
              $Param['status_aprovado'] = $status_aprovado;
              $Param['finalizado'] = $finalizado;
              $Param['latitude'] = $latitude;
              $Param['longitude'] = $longitude;
              $Param['end'] = $end;
              $Param['rua'] = $rua;
              $Param['bairro'] = $bairro;
              $Param['cidade'] = $cidade;
              $Param['estado'] = $estado;
              $Param['numero'] = $numero;
              $Param['complemento'] = $complemento;
              $Param['referencia'] = $referencia;
              $Param['data'] = dataBR($data_cadastro);
              $Param['imagens'] = $this->listimagens($id);
              $Param['avaliacoes'] = $this->avaliacoes($id);


              array_push($lista, $Param);
          }
      }

      return $lista;

    }

    public function listID($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.*, b.*, c.nome, d.nome
          FROM `app_anuncios` as a
          INNER JOIN `app_anuncios_location` as b
          ON a.id = b.app_anuncios_id
          INNER JOIN `app_categorias` as c
          ON a.app_categorias_id = c.id
          INNER JOIN `app_subcategorias` as d
          ON a.app_subcategorias_id = d.id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result(
        $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $data_in, $data_out, $status, $status_aprovado, $finalizado,
        $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
        $nome_categoria, $nome_subcategoria
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_reservas = New Reservas();

              $Param['id'] = $id;
              $Param['id_user'] = $app_users_id;
              $Param['id_categoria'] = $id_categoria;
              $Param['nome_categoria'] = $nome_categoria;
              $Param['id_subcategoria'] = $id_subcategoria;
              $Param['nome_subcategoria'] = $nome_subcategoria;
              $Param['nome'] = $nome;
              $Param['descricao'] = $descricao;
              $Param['checkin'] = $checkin;
              $Param['checkout'] = $checkout;
              $Param['data_in'] = dataBR($data_in);
              $Param['data_out'] = dataBR($data_out);
              $Param['status'] = $status;
              $Param['status_aprovado'] = $status_aprovado;
              $Param['finalizado'] = $finalizado;
              $Param['latitude'] = $latitude;
              $Param['longitude'] = $longitude;
              $Param['end'] = $end;
              $Param['rua'] = $rua;
              $Param['bairro'] = $bairro;
              $Param['cidade'] = $cidade;
              $Param['estado'] = $estado;
              $Param['numero'] = $numero;
              $Param['complemento'] = $complemento;
              $Param['referencia'] = $referencia;
              $Param['data'] = dataBR($data_cadastro);
              $Param['media'] = $this->avaliacoesMedia($id);
              $Param['caracteristicas'] = $this->listcaracteristicasID($id);
              $Param['imagens'] = $this->listimagens($id);

              $Param['ingressos'] = $this->listtiposIng($id);
              $Param['tipos'] = $this->listtipos($id);


              $Param['avaliacoes'] = $this->avaliacoes($id);
              $Param['reservas'] = $model_reservas->listReservasAnuncioAll($id);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listAnunciosValor($id_anuncio, $data_de, $data_ate){


      $filter = " WHERE a.app_anuncios_id='$id_anuncio' ";

      if(!empty($data_de) AND !empty($data_ate)){
          $filter .= " AND b.data_de <='$data_de' AND b.data_ate >='$data_ate'";
      }

      $sql = $this->mysqli->prepare(
          "
          SELECT b.valor, b.taxa_limpeza, b.qtd
          FROM `app_anuncios_types` as a
          INNER JOIN `app_anuncios_valor` as b ON a.id = b.app_anuncios_types_id
          $filter
          GROUP BY a.id
          ORDER BY b.valor ASC
          LIMIT 1
          ");


      $sql->execute();
      $sql->bind_result($valor, $taxa_limpeza, $qtd);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $dias = calculaDiasX($data_de, $data_ate);

              $valor_total = $dias * $valor;

              $Param['data_de'] = dataBR($data_de);
              $Param['data_ate'] = dataBR($data_ate);
              $Param['valor_diaria'] = moneyView($valor);
              $Param['valor_total'] = moneyView($valor_total);
              $Param['taxa_limpeza'] = $taxa_limpeza;
              $Param['qtd_disponiveis'] = $qtd;
              //$Param['produtos'] = $this->listitensprod($id);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function avaliacoes($id_anuncio)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.descricao, a.estrelas, a.data_cadastro, b.nome,b.avatar
            FROM `app_avaliacoes_ofc` AS a
            INNER JOIN `app_users` AS b ON a.app_users_id = b.id
            WHERE a.app_anuncios_id='$id_anuncio' AND a.avaliou='1'
            ORDER BY a.data_cadastro DESC
        "
        );
        $sql->execute();
        $sql->bind_result($id,$descricao,$estrelas,$data_cadastro,$nome,$avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {

                $item['id'] =$id;
                $item['nome'] =decryptitem($nome);
                $item['avatar'] =$avatar;
                $item['estrelas'] =$estrelas;
                $item['descricao'] =$descricao;
                $item['data_cadastro'] =dataBR($data_cadastro);
                array_push($usuarios,$item);
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }

    public function avaliacoesMedia($id_anuncio)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT AVG(estrelas)
            FROM `app_avaliacoes_ofc`
            WHERE app_anuncios_id='$id_anuncio' AND avaliou='1'
        "
        );
        $sql->execute();
        $sql->bind_result($media);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
        }
        !$media ? $media = 5 : $media;
        // print_r($usuarios);exit;
        return number_format($media,2);
    }

    public function verificaFavorito($id_anuncio, $id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT *
            FROM `app_favoritos`
            WHERE app_users_id='$id_usuario' AND app_anuncios_id='$id_anuncio'
        "
        );
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;


        if($rows == 0){return 2;}else{return 1;}

    }

    public function verificaAvaliou($id_reserva, $id_anuncio, $data_ate, $checkout, $id_usuario)
    {

        $date = $data_ate . " " . $checkout;
        $date_teste = "2025-02-21 13:05:00";

        $sql = $this->mysqli->prepare(
            "
            SELECT *
            FROM `app_avaliacoes_ofc`
            WHERE app_reservas_id='$id_reserva' AND app_users_id='$id_usuario' AND app_anuncios_id='$id_anuncio'
        "
        );
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;

        if (($this->data_atual > $date) && ($rows == 0)) {

          $Param = [
            "status" => 02,
            "anuncio" => $this->listID($id_anuncio)
          ];

        }else{

          $Param = [
            "status" => 01,
            "msg" => "Aguarde o checkout para avaliar essa reserva"
          ];

        }

        return $Param;

    }

    public function listtipos($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.nome, a.descricao, a.status, b.adultos, b.criancas, b.quartos, b.banheiros, pets
          FROM `app_anuncios_types` as a
          INNER JOIN `app_anuncios_info` as b
          ON a.id = b.app_anuncios_types_id
          WHERE a.app_anuncios_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id_type, $nome, $descricao, $status, $adultos, $criancas, $quartos, $banheiros, $pets);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_reservas = New Reservas();

              $Param['id'] = $id_type;
              $Param['nome'] = $nome;
              $Param['descricao'] = $descricao;
              $Param['status'] = $status;
              $Param['adultos'] = $adultos;
              $Param['criancas'] = $criancas;
              $Param['quartos'] = $quartos;
              $Param['banheiros'] = $banheiros;
              $Param['pets'] = $pets;
              $Param['imagens'] = $this->listTypeimagens($id_type);
              $Param['camas'] = $this->listcamasID($id_type);
              $Param['periodos'] = $this->listperiodosID($id_type);
              $Param['reservas'] = $model_reservas->listReservasAnuncio($id, $id_type);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listtiposIng($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT id, tipo, nome, valor, qtd
          FROM `app_anuncios_ing_types`
          WHERE app_anuncios_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id_type, $tipo, $nome, $valor, $qtd);
      $sql->store_result();
      $rows = $sql->num_rows;


      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_reservas = New Reservas();

              $qtd_comprados = $model_reservas->listIngressosComprados($id_type);
              $qtd_disponivel = $qtd - $qtd_comprados;

              $Param['id'] = $id_type;
              $Param['tipo'] = tipoIngressos($tipo);
              $Param['nome'] = $nome;
              $Param['valor'] = moneyView($valor);
              $Param['qtd_total'] = $qtd;
              $Param['qtd_comprados'] = $qtd_comprados;
              $Param['qtd_disponivel'] = $qtd_disponivel;



              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listtiposID($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.nome, a.descricao, a.status, b.adultos, b.criancas, b.quartos, b.banheiros, pets
          FROM `app_anuncios_types` as a
          INNER JOIN `app_anuncios_info` as b
          ON a.id = b.app_anuncios_types_id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id_type, $nome, $descricao, $status, $adultos, $criancas, $quartos, $banheiros, $pets);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $model_reservas = New Reservas();

              $Param['id'] = $id_type;
              $Param['nome'] = $nome;
              $Param['descricao'] = $descricao;
              $Param['status'] = $status;
              $Param['adultos'] = $adultos;
              $Param['criancas'] = $criancas;
              $Param['quartos'] = $quartos;
              $Param['banheiros'] = $banheiros;
              $Param['pets'] = $pets;
              $Param['imagens'] = $this->listTypeimagens($id_type);
              $Param['camas'] = $this->listcamasID($id_type);
              $Param['periodos'] = $this->listperiodosID($id_type);
              $Param['reservas'] = $model_reservas->listReservasAnuncioTipo($id, $id_type);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listtiposValor($id, $data_de, $data_ate){

      $filter = " WHERE a.app_anuncios_id='$id'";

      if(!empty($data_de) AND !empty($data_ate)){
          $filter .= " AND c.data_de <='$data_de' AND c.data_ate >='$data_ate'";
      }

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.nome, a.descricao, a.status, b.adultos, b.criancas, b.quartos, b.banheiros, b.pets, c.valor, c.desc_min_diarias, c.taxa_limpeza, c.qtd
          FROM `app_anuncios_types` as a
          INNER JOIN `app_anuncios_info` as b ON a.id = b.app_anuncios_types_id
          INNER JOIN `app_anuncios_valor` as c ON a.id = c.app_anuncios_types_id
          $filter
          "
      );

      //echo $sql;exit;

      $sql->execute();
      $sql->bind_result($id_type, $nome, $descricao, $status, $adultos, $criancas, $quartos, $banheiros, $pets, $valor, $desc_min_diarias, $taxa_limpeza, $qtd);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $dias = calculaDiasX($data_de, $data_ate);

              $valor_total = $dias * $valor;

              $model_reservas = New Reservas();

              $Param['id'] = $id_type;
              $Param['nome'] = $nome;
              $Param['descricao'] = $descricao;
              $Param['status'] = $status;
              $Param['adultos'] = $adultos;
              $Param['criancas'] = $criancas;
              $Param['quartos'] = $quartos;
              $Param['banheiros'] = $banheiros;
              $Param['pets'] = $pets;
              $Param['valor_diaria'] = moneyView($valor);
              $Param['valor_total'] = moneyView($valor_total);
              $Param['taxa_limpeza'] = moneyView($taxa_limpeza);
              $Param['qtd_disponiveis'] = $qtd;
              $Param['imagens'] = $this->listTypeimagens($id_type);
              $Param['camas'] = $this->listcamasID($id_type);
              $Param['reservas'] = $model_reservas->listReservasAnuncio($id, $id_type);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listimagens($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT id, url, capa
          FROM `app_anuncios_fotos`
          WHERE app_anuncios_id='$id'
          ORDER BY capa ASC
          LIMIT 1
          "
      );

      $sql->execute();
      $sql->bind_result($id, $url, $capa);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {


              $Param['id'] = $id;
              $Param['url'] = $url;
              $Param['capa'] = $capa;
              //$Param['produtos'] = $this->listitensprod($id);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }


    public function listTypeimagens($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT id, url, capa
          FROM `app_anuncios_types_fotos`
          WHERE app_anuncios_types_id='$id'
          ORDER BY capa ASC
          "
      );

      $sql->execute();
      $sql->bind_result($id, $url, $capa);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {


              $Param['id'] = $id;
              $Param['url'] = $url;
              $Param['capa'] = $capa;
              //$Param['produtos'] = $this->listitensprod($id);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listcaracteristicasID($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, b.nome, b.url
          FROM `app_anuncios_carac` as a
          INNER JOIN `app_caracteristicas` as b
          ON a.app_caracteristicas_id = b.id
          WHERE a.app_anuncios_id='$id' AND b.status=1
          "
      );

      $sql->execute();
      $sql->bind_result($id, $nome, $url);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['nome'] = $nome;
              $Param['url'] = $url;

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listcamasID($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.qtd, b.nome, b.url
          FROM `app_anuncios_camas` as a
          INNER JOIN `app_camas` as b
          ON a.app_camas_id = b.id
          WHERE a.app_anuncios_types_id='$id' AND b.status=1
          "
      );

      $sql->execute();
      $sql->bind_result($id, $qtd, $nome, $url);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['nome'] = $nome;
              $Param['url'] = $url;
              $Param['qtd'] = $qtd;

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listperiodosID($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT *
          FROM `app_anuncios_valor`
          WHERE app_anuncios_types_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id, $id_type, $nome, $data_de, $data_ate, $valor, $desc_min_diarias, $taxa_limpeza, $qtd);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['nome'] = $nome;
              $Param['data_de'] = dataBR($data_de);
              $Param['data_ate'] = dataBR($data_ate);
              $Param['valor'] = moneyView($valor);
              $Param['taxa_limpeza'] = moneyView($taxa_limpeza);
              $Param['qtd'] = $qtd;

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listitensserv($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, b.titulo, b.valor
          FROM `app_ambientes_itens_serv` as a
          INNER JOIN `app_servicos_respostas` as b
          ON a.app_servicos_respostas_id = b.id
          WHERE a.app_ambientes_itens_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id, $titulo, $valor);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['titulo'] = $titulo;
              $Param['valor'] = moneyView($valor);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listservSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(d.valor) as soma
          FROM `app_ambientes` as a
          INNER JOIN `app_ambientes_itens` as b
          ON a.id = b.app_ambientes_id
          INNER JOIN `app_ambientes_itens_serv` as c
          ON b.id = c.app_ambientes_itens_id
          INNER JOIN `app_servicos_respostas` as d
          ON c.app_servicos_respostas_id = d.id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma;

    }

    public function listitensservSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(b.valor) as soma
          FROM `app_ambientes_itens_serv` as a
          INNER JOIN `app_servicos_respostas` as b
          ON a.app_servicos_respostas_id = b.id
          WHERE a.app_ambientes_itens_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma;

    }

    public function listitensprod($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, b.titulo, b.valor
          FROM `app_ambientes_itens_prod` as a
          INNER JOIN `app_produtos_respostas` as b
          ON a.app_produtos_respostas_id = b.id
          WHERE a.app_ambientes_itens_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id, $titulo, $valor);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {
          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['titulo'] = $titulo;
              $Param['valor'] = moneyView($valor);

              array_push($lista, $Param);
          }
      }


      return $lista;

    }

    public function listprodSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(d.valor) as soma
          FROM `app_ambientes` as a
          INNER JOIN `app_ambientes_itens` as b
          ON a.id = b.app_ambientes_id
          INNER JOIN `app_ambientes_itens_prod` as c
          ON b.id = c.app_ambientes_itens_id
          INNER JOIN `app_produtos_respostas` as d
          ON c.app_produtos_respostas_id = d.id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma;

    }

    public function listitensprodSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(b.valor) as soma
          FROM `app_ambientes_itens_prod` as a
          INNER JOIN `app_produtos_respostas` as b
          ON a.app_produtos_respostas_id = b.id
          WHERE a.app_ambientes_itens_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($id, $titulo, $valor);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma;

    }

    public function listperc($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(b.perc) as soma_perc
          FROM `app_ambientes` as a
          INNER JOIN `app_ambientes_itens` as b
          ON a.id = b.app_ambientes_id
          WHERE a.app_orcamentos_id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma_perc);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma_perc;

    }

    public function listpercamb($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(b.perc) as soma_perc
          FROM `app_ambientes` as a
          INNER JOIN `app_ambientes_itens` as b
          ON a.id = b.app_ambientes_id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma_perc);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma_perc;

    }

    public function listm2amb($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT SUM(b.m2) as soma_m2
          FROM `app_ambientes` as a
          INNER JOIN `app_ambientes_itens` as b
          ON a.id = b.app_ambientes_id
          WHERE a.id='$id'
          "
      );

      $sql->execute();
      $sql->bind_result($soma_m2);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      return $soma_m2;

    }

    public function verifica($id){

      $sql = $this->mysqli->prepare(
          "
            SELECT id, app_categorias_id
            FROM `app_anuncios`
            WHERE app_users_id='$id' AND finalizado='2'
          "
      );

      $sql->execute();
      $sql->bind_result($id, $id_categoria);
      $sql->store_result();
      $sql->fetch();
      $rows = $sql->num_rows;

      $sql->fetch();

      $Param = [
        "id" => $id,
        "id_categoria" => $id_categoria,
        "rows" => $rows
      ];


      return $Param;

    }

    public function verificaTypeDatas($id_type, $id, $data_de, $data_ate){

      $sql = $this->mysqli->prepare(
          "
            SELECT *
            FROM `app_anuncios_valor`
            WHERE id != '$id' AND app_anuncios_types_id='$id_type' AND data_de <='$data_de' AND data_ate >='$data_ate'
          "
      );

      $sql->execute();
      $sql->store_result();
      $rows = $sql->num_rows;

      if($rows > 0){

        $Param = [
            "status" => "02",
            "msg" => "Já possui intervalo de datas para esse tipo de quarto."
        ];

        return $Param;
      }


    }

    public function verificaTypeCama($id_user, $id_type, $id){

      $sql = $this->mysqli->prepare(
          "
            SELECT *
            FROM `app_anuncios_camas` as a
            INNER JOIN `app_anuncios_types` as b ON a.app_anuncios_types_id = b.id
            INNER JOIN `app_anuncios` as c ON b.app_anuncios_id = c.id
            WHERE a.app_anuncios_types_id='$id_type' AND a.app_camas_id='$id' AND c.app_users_id='$id_user'
          "
      );

      $sql->execute();
      $sql->store_result();
      $rows = $sql->num_rows;

      if($rows > 0){

        $Param = [
            "status" => "02",
            "msg" => "Já possui esse tipo de cama, tente outros dados."
        ];

        return $Param;
      }


    }


    public function listOrcSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT count(*), sum(valor_final) as soma
          FROM `app_orcamentos`
          WHERE app_users_id='$id' AND tipo='1'
          "
      );

      $sql->execute();
      $sql->bind_result( $count, $soma);
      $sql->store_result();
      $sql->fetch();

      $Param = [
          "rows" => $count,
          "soma" => moneyView($soma)
      ];

      return $Param;

    }

    public function listObraSUM($id){

      $sql = $this->mysqli->prepare(
          "
          SELECT count(*), sum(valor_final) as soma
          FROM `app_orcamentos`
          WHERE app_users_id='$id' AND tipo='2'
          "
      );

      $sql->execute();
      $sql->bind_result( $count, $soma);
      $sql->store_result();
      $sql->fetch();

      $Param = [
          "rows" => $count,
          "soma" => moneyView($soma)
      ];

      return $Param;

    }


    public function caracteristicasViagem()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,icone
            FROM `app_caracteristicas`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$icone);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['icone'] = $icone;
                    array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }
    public function updateOferecer($id_corrida, $distancia,$duracao,$polyline)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos` SET distancia_km='$distancia', duracao_min='$duracao',polyline='$polyline'
        WHERE id='$id_corrida'"
        );

        $sql_cadastro->execute();
    }
    public function buscaEnderecosMinhaCorrida($id_corrida,$id_partida,$id_chegada)
    {
        $filter = " WHERE app_Orcamentos_id='$id_corrida' ";
        if(!empty($id_partida) AND !empty($id_chegada)){
            $filter .= " AND id >='$id_partida' AND id <='$id_chegada'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT id,rua,bairro,cidade,estado,endereco,latitude,longitude,ordem,hora_partida
            FROM `app_Orcamentos_end`
            $filter
            ORDER BY ordem ASC
            "
        );
        $sql->execute();
        $sql->bind_result($id,$rua,$bairro,$cidade,$estado,$endereco,$latitude,$longitude,$ordem,$hora_partida);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['ordem'] = $ordem;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['endereco'] = $rua . ", " . $bairro . " - " . $cidade . ", " . $estado;
                $Param['endereco_nome'] = $endereco;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['longitude'] = $longitude;
                $Param['hora_partida'] = horaBR($hora_partida);

                $Param['minha_partida'] = $id == $id_partida ? 1 : 2;
                $Param['minha_chegada'] = $id == $id_chegada ? 1 : 2;
                // $Param['id_partida'] = $id_partida;
                // $Param['id_chegada'] = $id_chegada;

                array_push($lista, $Param);
            }
            //caso seja motorista
            if(($id_partida == null) OR ($id_chegada == null)){
                // Encontrar o menor valor de id
                $endereco_origem = min(array_column($lista, 'id'));
                // Encontrar o maior valor de id
                $endereco_fim = max(array_column($lista, 'id'));

                // Atualizar os valores de minha_partida e minha_chegada
                foreach ($lista as &$endereco) {
                    if ($endereco['id'] == $endereco_origem) {
                        $endereco['minha_partida'] = 1; // Menor distância da partida
                    }
                    if ($endereco['id'] == $endereco_fim) {
                        $endereco['minha_chegada'] = 1; // Menor distância da chegada
                    }
                }

            }
        }

        return $lista;
    }






    public function buscaEnderecoCorrida($id_corrida,$latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,rua,bairro,cidade,estado,endereco,latitude,longitude,ordem,hora_partida
            FROM `app_Orcamentos_end`
            WHERE app_Orcamentos_id='$id_corrida'
            ORDER BY ordem ASC
            "
        );

        $sql->execute();
        $sql->bind_result($id,$rua,$bairro,$cidade,$estado,$endereco,$latitude,$longitude,$ordem,$hora_partida);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $distancia_partida = distancia($latitude,$longitude,$latitude_inicio,$longitude_inicio);
                $distancia_chegada = distancia($latitude,$longitude,$latitude_fim,$longitude_fim);

                $Param['id'] = $id;
                $Param['ordem'] = $ordem;
                $Param['rua'] = $rua;
                $Param['bairro'] = $bairro;
                $Param['cidade'] = $cidade;
                $Param['estado'] = $estado;
                $Param['endereco'] = $rua . ", " . $bairro . " - " . $cidade . ", " . $estado;
                $Param['endereco_nome'] = $endereco;
                $Param['latitude'] = $latitude;
                $Param['longitude'] = $longitude;
                $Param['longitude'] = $longitude;
                $Param['hora_partida'] = horaBR($hora_partida);

                $Param['distancia_partida'] = $distancia_partida;
                $Param['distancia_chegada'] = $distancia_chegada;

                $Param['minha_partida'] = 2;
                $Param['minha_chegada'] = 2;

                array_push($lista, $Param);
            }

            // Encontrar o menor valor de distancia_partida
            $menor_partida = min(array_column($lista, 'distancia_partida'));
            // Encontrar o menor valor de distancia_chegada
            $menor_chegada = min(array_column($lista, 'distancia_chegada'));

            // Atualizar os valores de minha_partida e minha_chegada
            foreach ($lista as &$endereco) {
                if ($endereco['distancia_partida'] == $menor_partida) {
                    $endereco['minha_partida'] = 1; // Menor distância da partida
                }
                if ($endereco['distancia_chegada'] == $menor_chegada) {
                    $endereco['minha_chegada'] = 1; // Menor distância da chegada
                }
            }
        }

        return $lista;
    }
    public function pegaMotivo($id_motivo)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT taxado,taxa_perc
            FROM `app_cancelamentos`
            WHERE id='$id_motivo'
            "
        );

        $sql->execute();
        $sql->bind_result($taxado,$taxa_perc);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;


        return $taxa_perc;


    }
    public function buscaEnderecoInicio($id_corrida,$completo)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT cidade,estado,endereco
            FROM `app_Orcamentos_end`
            WHERE ordem='0' AND app_Orcamentos_id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($cidade,$estado,$endereco);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;


        if($completo == 1){
            return $endereco;
        }else{
            return $cidade . "/" . $estado;
        }
    }
    public function buscaEnderecoFim($id_corrida,$completo)
    {

        $sql = $this->mysqli->prepare(
            "SELECT cidade,estado ,endereco
                FROM `app_Orcamentos_end`
                WHERE ordem = (
                    SELECT MAX(ordem)
                    FROM `app_Orcamentos_end`
                    WHERE app_Orcamentos_id = '$id_corrida'
                )
                AND app_Orcamentos_id = '$id_corrida'
                LIMIT 1;
            "
        );

        $sql->execute();
        $sql->bind_result($cidade,$estado,$endereco);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        if($completo == 1){
            return $endereco;
        }else{
            return $cidade . "/" . $estado;
        }
    }
    public function infoCaracteristicas($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome,b.icone
            FROM `app_Orcamentos_caracteristicas` AS a
            INNER JOIN `app_caracteristicas` AS b ON a.app_caracteristicas_id=b.id
            WHERE a.app_Orcamentos_id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$icone);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['nome'] = $nome;
            $Param['icone'] = $icone;



            array_push($lista, $Param);
        }


        // print_r($lista);
        return $lista;
    }
    public function vaga_invalida($id_corrida,$vagas_id,$vagas_qtd,$endereco_inicio,$endereco_fim)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome,a.qtd,a.qtd_disponivel,a.id_corrida_end
            FROM `app_Orcamentos_vagas` AS a
            INNER JOIN `app_vagas` AS b ON a.app_vagas_id=b.id
            WHERE a.status='1' AND app_Orcamentos_id='$id_corrida'
            "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$qtd,$qtd_disponivel,$id_corrida_end);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $indice = array_search($id, $vagas_id);
            //para cada vaga q eu busquei
            if ($indice !== false) {
                //para o endereco q eu vou usar dessa vaga
                if(($id_corrida_end >= $endereco_inicio) AND ($id_corrida_end < $endereco_fim)){
                    // para a qtd q eu preciso
                    if($qtd_disponivel < $vagas_qtd[$indice]){
                        return true;
                    }
                }
            }
        }


        // print_r($lista);exit;
        return false;
    }
    public function listSolicitacoes($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT DISTINCT a.id,a.app_users_id,a.endereco_partida,a.endereco_chegada,a.status,b.nome,b.avatar,c.tipo_pagamento,c.valor_corrida,c.id
            FROM `app_participantes` AS a
            INNER JOIN `app_users` AS b ON b.id=a.app_users_id
            INNER JOIN `app_Orcamentos_pagamentos` AS c ON c.id=a.app_pagamentos_id
            WHERE c.app_Orcamentos_id='$id_corrida' AND a.app_Orcamentos_id='$id_corrida' AND a.status=2
            GROUP BY a.id
            "
        );
        $sql->execute();
        $sql->bind_result($id_solicitacao,$id_passageiro,$endereco_partida,$endereco_chegada,$status,$nome,$avatar,$tipo_pagamento,$valor_corrida,$id_pagamento);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id_solicitacao'] = $id_solicitacao;
            $Param['id_passageiro'] = $id_passageiro;
            $Param['endereco_partida'] = $endereco_partida;
            $Param['endereco_chegada'] = $endereco_chegada;
            $Param['status'] = $status;
            $Param['nome'] = decryptitem($nome);
            $Param['avatar'] = $avatar;
            $Param['tipo_pagamento'] = $tipo_pagamento;
            $Param['valor_corrida'] = moneyView($valor_corrida);
            $Param['vagas_utilizadas'] =  $this->infoVagasUtilizadas($id_pagamento);

            array_push($lista, $Param);
        }


        // print_r($lista);exit;
        return $lista;
    }
    public function contaVagasUtilizadas($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT c.id,c.nome,SUM(a.qtd)
            FROM `app_pagamentos_vagas` AS a
            INNER JOIN `app_Orcamentos_vagas` AS b ON b.id=a.app_vagas_id
            INNER JOIN `app_vagas` AS c ON c.id=b.app_vagas_id
            INNER JOIN `app_participantes` AS d ON b.app_Orcamentos_id=d.app_Orcamentos_id
            WHERE b.app_Orcamentos_id='$id_corrida' AND d.status=1
            GROUP BY c.id
            "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$qtd);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['nome'] = $nome;
            $Param['qtd'] = intval($qtd);

            array_push($lista, $Param);
        }


        // print_r($lista);exit;
        return $lista;
    }
    public function infoVagasPreenchidasMotorista($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT f.id,f.nome,f.avatar,a.tipo_pagamento, a.valor_corrida,e.endereco_partida,e.endereco_chegada,a.id,e.status
            FROM `app_Orcamentos_pagamentos` AS a
            INNER JOIN `app_pagamentos_vagas` AS b ON a.id=b.app_pagamentos_id
            INNER JOIN `app_participantes` AS e ON e.app_users_id=a.app_users_id
            INNER JOIN `app_users` AS f ON f.id=a.app_users_id
            WHERE a.app_Orcamentos_id='$id_corrida' AND e.status IN(1,4) AND e.app_Orcamentos_id='$id_corrida'
            GROUP BY a.app_users_id
            "
        );
        $sql->execute();
        $sql->bind_result($id_passageiro,$nome_passageiro,$avatar_passageiro,$metodo_pagamento,$valor,$endereco_partida,$endereco_chegada,$id_pagamento,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id_passageiro'] = $id_passageiro;
            $Param['nome_passageiro'] = decryptitem($nome_passageiro);
            $Param['avatar_passageiro'] = $avatar_passageiro;
            $Param['metodo_pagamento'] = $metodo_pagamento;
            $Param['endereco_partida'] = $endereco_partida;
            $Param['endereco_chegada'] = $endereco_chegada;
            $Param['vagas_utilizadas'] =  $this->infoVagasUtilizadas($id_pagamento);
            $Param['status'] = $status;

            $Param['valor'] = moneyView($valor);




            array_push($lista, $Param);
        }


        // print_r($lista);exit;
        return $lista;
    }

    public function infoVagasUtilizadas($id_pagamento)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT c.id,c.nome,a.qtd
            FROM `app_pagamentos_vagas` AS a
            INNER JOIN `app_Orcamentos_vagas` AS b ON a.app_vagas_id=b.id
            INNER JOIN `app_vagas` AS c ON c.id=b.app_vagas_id
            WHERE a.app_pagamentos_id='$id_pagamento'
            "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$qtd);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['nome'] = $nome;
            $Param['qtd'] = $qtd;

            array_push($lista, $Param);
        }


        // print_r($lista);exit;
        return $lista;
    }
    public function infoVagas($id_corrida,$vagas_id,$vagas_qtd)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome,a.qtd,a.qtd_disponivel,a.valor,a.valor_motorista,a.valor_admin
            FROM `app_Orcamentos_vagas` AS a
            INNER JOIN `app_vagas` AS b ON a.app_vagas_id=b.id
            WHERE a.status='1' AND app_Orcamentos_id='$id_corrida'
            GROUP BY a.app_vagas_id
            "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$qtd,$qtd_disponivel,$valor_un,$valor_motorista,$valor_admin);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['nome'] = $nome;
            $Param['qtd'] = $qtd;
            $Param['qtd_disponivel'] = $qtd_disponivel;
            $Param['valor_un'] = $valor_un;


            $indice = array_search($id, $vagas_id);
            if ($indice !== false) {
                $Param['valor'] = $valor_un * $vagas_qtd[$indice];
                $Param['valor_motorista'] = $valor_motorista * $vagas_qtd[$indice];
                $Param['valor_admin'] = $valor_admin * $vagas_qtd[$indice];
            } else {
                $Param['valor'] =0;
                $Param['valor_motorista'] =0;
                $Param['valor_admin'] =0;
            }


            array_push($lista, $Param);
        }


        // print_r($lista);exit;
        return $lista;
    }
    public function validaCarona($todos_enderecos,$raio_km,$id_corrida,$vagas_id,$vagas_qtd)
    {
        $carona_invalida = false;
        // verifica se a proximidade do endereco de partida e chegada condiz com o filtro de raio_km
        foreach ($todos_enderecos as $endereco) {
            // print_r("end partida:" .$endereco['minha_partida'] . " - distancia_partida:" . $endereco['distancia_partida'] . " ------- ");
            // print_r("end chegada:" .$endereco['minha_chegada'] . " - distancia_chegada:" . $endereco['distancia_chegada']. " ------- ");
            if(($endereco['minha_partida'] == 1) AND ($endereco['distancia_partida'] > $raio_km)){
                $carona_invalida = true;
                continue;
            }
            if(($endereco['minha_chegada'] == 1) AND ($endereco['distancia_chegada'] > $raio_km)){
                $carona_invalida = true;
                continue;
            }

            if($endereco['minha_partida'] == 1){
                $id_partida = $endereco['id'];
                $ordem_partida = $endereco['ordem'];
            }
            if($endereco['minha_chegada'] == 1){
                $id_chegada = $endereco['id'];
                $ordem_chegada = $endereco['ordem'];
            }

            //validacao caso o mesmo endereco de partida seja o de chegada.
            if($id_partida AND $id_chegada){
                if($id_partida == $id_chegada){
                    $carona_invalida = true;
                }
            }
            if($ordem_partida > $ordem_chegada){
                $carona_invalida = true;
            }

            $vaga_invalida=$this->vaga_invalida($id_corrida,$vagas_id,$vagas_qtd,$id_partida,$id_chegada);
            if($vaga_invalida) {
                $carona_invalida = true;
            }
        }

        return $carona_invalida;
    }
    public function buscarCarona($id_user,$latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim,$data,$hora,$raio_km,$vagas_id,$vagas_qtd,$caracteristicas)
    {
        if(empty($raio_km)){$raio_km = RAIO_KM ;}

        $filter1 = "";
        $filter2 = "";

        if(!empty($hora)){$filter1 .= " AND TIME(a.data_agendada) <= '$hora' " ;}

        $conditions = [];

        // Construindo as condições para as vagas e quantidades requisitadas
        foreach ($vagas_id as $index => $vaga_id) {
            $qtd_requisitada = $vagas_qtd[$index];
            $conditions[] = "SUM(c.app_vagas_id = $vaga_id AND c.qtd_disponivel >= $qtd_requisitada) > 0 ";
        }

        if (!empty($caracteristicas)) {
            foreach ($caracteristicas as $item) {
                $conditions2[] = "SUM(d.app_caracteristicas_id = $item) > 0 ";
            }
        }
        // Junta as condições das vagas com "OR"
        $vagas_condition = implode(' AND ', $conditions);

        // Junta as condições das características com "AND", se existirem
        $caracteristicas_condition = !empty($conditions2) ? implode(' AND ', $conditions2) : '1=1'; // Se estiver vazio, coloca uma condição sempre verdadeira

        // Monta a query SQL
        $sql = "
            SELECT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            INNER JOIN `app_Orcamentos_vagas` AS c ON a.id = c.app_Orcamentos_id
            LEFT JOIN `app_Orcamentos_caracteristicas` AS d ON a.id = d.app_Orcamentos_id
            WHERE a.status = '1'
              AND a.data_agendada > NOW()
              AND DATE(a.data_agendada) = '$data'
            $filter1
            GROUP BY a.id
            HAVING ($caracteristicas_condition) AND ($vagas_condition)
            ORDER BY data_agendada DESC
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $todos_enderecos=$this->buscaEnderecoCorrida($id,$latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim);

                $carona_invalida=$this->validaCarona($todos_enderecos,$raio_km,$id,$vagas_id,$vagas_qtd);
                if($carona_invalida){ continue;}//skipa o while e deixa de dar push no array


                $Param['id_corrida'] = $id;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);
                $Param['horario_partida'] = horaBR($data_agendada);

                // Calcular horário de chegada (hora de partida + duração)
                $datetime_partida = new DateTime($data_agendada);
                $duracao_min = intval($duracao_min);
                $datetime_partida->add(new DateInterval('PT' . $duracao_min . 'M')); // Adiciona os minutos da duração
                $horario_chegada = $datetime_partida->format('H:i'); // Formata para exibir horas e minutos

                $Param['horario_chegada'] = $horario_chegada; // Usa o horário calculado


                $Param['enderecos'] = $todos_enderecos;

                $info_vagas = $this->infoVagas($id,$vagas_id,$vagas_qtd);

                $Param['vagas'] = $info_vagas;
                $valor_total = 0;
                foreach ($info_vagas as $item) {
                    $valor_total = $valor_total + $item['valor'];
                }
                $Param['valor_total'] = moneyView($valor_total);

                $Param['duracao_min'] = $duracao_min;
                $Param['distancia_km'] = $distancia_km;

                $Param['obs'] = $obs;

                array_push($lista, $Param);
            }

            if(count($lista) == 0){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }else{
                foreach ($lista as &$item) {
                    $item['rows'] = count($lista);
                }
            }

        }

        // print_r($lista);
        return $lista;
    }
    public function detalhesCorrida($id_corrida,$vagas_id,$vagas_qtd,$latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim)
    {


        // Monta a query SQL
        $sql = "
            SELECT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            WHERE a.id = '$id_corrida'
            GROUP BY a.id
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $todos_enderecos=$this->buscaEnderecoCorrida($id,$latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim);


                $Param['id_corrida'] = $id;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['qtd_caronas'] = $this->qtdCaronas($id_motorista);
                $Param['veiculo_info'] = $this->veiculoInfo($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);
                $Param['horario_partida'] = horaBR($data_agendada);

                // Calcular horário de chegada (hora de partida + duração)
                $datetime_partida = new DateTime($data_agendada);
                $duracao_min = intval($duracao_min);
                $datetime_partida->add(new DateInterval('PT' . $duracao_min . 'M')); // Adiciona os minutos da duração
                $horario_chegada = $datetime_partida->format('H:i'); // Formata para exibir horas e minutos

                $Param['horario_chegada'] = $horario_chegada; // Usa o horário calculado


                $Param['enderecos'] = $todos_enderecos;



                $info_vagas = $this->infoVagas($id,$vagas_id,$vagas_qtd);
                $Param['vagas'] = $info_vagas;

                $valor_total = 0;
                foreach ($info_vagas as $item) {
                    $valor_total = $valor_total + $item['valor'];
                }
                $Param['valor_total'] = moneyView($valor_total);

                $Param['caracteristicas'] = $this->infoCaracteristicas($id);


                $Param['duracao_min'] = $duracao_min;
                $Param['distancia_km'] = $distancia_km;

                $Param['obs'] = $obs;

                $maps = criaStringMapas($todos_enderecos);

                $Param['google_maps'] = $maps['google_maps'];
                $Param['apple_maps'] = $maps['apple_maps'];
                $Param['waze'] = $maps['waze'];


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function detalhesMinhasViagens($id_user,$id_corrida)
    {


        // Monta a query SQL
        $sql = "
            SELECT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km ,
            c.endereco_partida,c.endereco_chegada,d.id,d.tipo_pagamento,d.valor_corrida,a.status,c.status
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            INNER JOIN `app_participantes` AS c ON c.app_Orcamentos_id=a.id
            INNER JOIN `app_Orcamentos_pagamentos` AS d ON a.id=d.app_Orcamentos_id
            WHERE a.id = '$id_corrida' AND c.app_users_id='$id_user' AND d.app_users_id='$id_user'
            ORDER BY (c.status >= 5),d.id DESC
            LIMIT 1
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km,
        $id_partida,$id_chegada,$id_pagamento,$tipo_pagamento,$valor_corrida,$status_corrida,$status_participante);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $todos_enderecos=$this->buscaEnderecosMinhaCorrida($id,$id_partida,$id_chegada);


                $Param['id_corrida'] = $id;
                $Param['id_pagamento'] = $id_pagamento;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['qtd_caronas'] = $this->qtdCaronas($id_motorista);
                $Param['veiculo_info'] = $this->veiculoInfo($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);
                $Param['horario_partida'] = horaBR($data_agendada);

                $Param['enderecos'] = $todos_enderecos;


                // $info_vagas = $this->infoVagas($id,$vagas_id,$vagas_qtd);

                // $Param['vagas'] = $info_vagas;

                $Param['vagas_utilizadas'] =  $this->infoVagasUtilizadas($id_pagamento);

                $Param['valor_total'] = moneyView($valor_corrida);
                $Param['tipo_pagamento'] = $tipo_pagamento;

                $Param['caracteristicas'] = $this->infoCaracteristicas($id);

                $Param['obs'] = $obs;
                $Param['status_corrida'] = $status_corrida;


                switch ($status_corrida) {
                    case '1':
                        $Param['status_corrida_msg'] = "Aberta";
                        break;
                    case '2':
                        $Param['status_corrida_msg'] = "Fechada";
                        break;
                    case '3':
                        $Param['status_corrida_msg'] = "Em curso";
                        break;
                    case '4':
                        $Param['status_corrida_msg'] = "Cancelada";
                        break;
                }
                $Param['status_participante'] = $status_participante;
                switch ($status_participante) {
                    case '1':
                        $Param['status_participante_msg'] = "Aceito";
                        break;
                    case '2':
                        $Param['status_participante_msg'] = "Pendente";
                        break;
                    case '3':
                        $Param['status_participante_msg'] = "Recusado";
                        break;
                }

                $maps = criaStringMapas($todos_enderecos);

                $Param['google_maps'] = $maps['google_maps'];
                $Param['apple_maps'] = $maps['apple_maps'];
                $Param['waze'] = $maps['waze'];


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }

    public function detalhesMinhasViagensMotorista($id_user,$id_corrida)
    {


        // Monta a query SQL
        $sql = "
            SELECT a.id, a.id_motorista, b.avatar, b.nome, a.obs, a.data_agendada, a.duracao_min, a.distancia_km,a.status
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_users` AS b ON a.id_motorista = b.id
            WHERE a.id = '$id_corrida' AND a.id_motorista='$id_user'
            GROUP BY a.id
        ";
        // print_r($sql);exit;

        $sql = $this->mysqli->prepare($sql);
        $sql->execute();
        $sql->bind_result($id,$id_motorista,$avatar_motorista,$nome_motorista,$obs,$data_agendada,$duracao_min,$distancia_km,$status_corrida);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $todos_enderecos=$this->buscaEnderecosMinhaCorrida($id,$id_partida,$id_chegada);


                $Param['id_corrida'] = $id;
                $Param['id_motorista'] = $id_motorista;
                $Param['avatar_motorista'] = $avatar_motorista;
                $Param['nome_motorista'] = decryptitem($nome_motorista);
                $Param['avaliacao_motorista'] = $this->avaliacaoUser($id_motorista);

                $Param['qtd_caronas'] = $this->qtdCaronas($id_motorista);
                $Param['veiculo_info'] = $this->veiculoInfo($id_motorista);

                $Param['data_partida'] = dataBR($data_agendada);
                $Param['horario_partida'] = horaBR($data_agendada);

                $Param['enderecos'] = $todos_enderecos;
                $Param['solicitacoes'] = $this->listSolicitacoes($id_corrida);

                $usuarios_aceitos = $this->infoVagasPreenchidasMotorista($id_corrida);
                $Param['usuarios_aceitos'] =  $usuarios_aceitos;
                $valor_total = 0;
                foreach ($usuarios_aceitos as $item) {
                    $valor_total = $valor_total + moneySQL($item['valor']);
                }
                $Param['valor_total'] = moneyView($valor_total);


                // $Param['vagas_utilizadas'] = $this->contaVagasUtilizadas($id_corrida);
                $Param['vagas_utilizadas'] = $this->vagasUtilizadasMotorista($usuarios_aceitos);


                $Param['caracteristicas'] = $this->infoCaracteristicas($id);

                $Param['obs'] = $obs;
                $Param['status_corrida'] = $status_corrida;

                switch ($status_corrida) {
                    case '1':
                        $Param['status_corrida_msg'] = "Aberta";
                        break;
                    case '2':
                        $Param['status_corrida_msg'] = "Fechada";
                        break;
                    case '3':
                        $Param['status_corrida_msg'] = "Em curso";
                        break;
                    case '4':
                        $Param['status_corrida_msg'] = "Cancelada";
                        break;
                }

                $maps = criaStringMapas($todos_enderecos);

                $Param['google_maps'] = $maps['google_maps'];
                $Param['apple_maps'] = $maps['apple_maps'];
                $Param['waze'] = $maps['waze'];


                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }


    public function vagasUtilizadasMotorista($usuarios_aceitos)
    {
        $lista = [];

        foreach ($usuarios_aceitos as $usuario) {
            foreach ($usuario['vagas_utilizadas'] as $vaga) {
                $id_vaga = $vaga['id'];

                // Verifica se a vaga já existe na lista
                $encontrado = false;
                foreach ($lista as &$item) {
                    if ($item['id'] === $id_vaga) {
                        // Se já existe, soma a quantidade
                        $item['qtd'] += $vaga['qtd'];
                        $encontrado = true;
                        break;
                    }
                }

                // Se não encontrou a vaga, adiciona um novo item na lista
                if (!$encontrado) {
                    $Param['id'] = $vaga['id'];
                    $Param['nome'] = $vaga['nome'];
                    $Param['qtd'] = $vaga['qtd'];
                    $lista[] = $Param;
                }
            }
        }

        return $lista;
    }


















    public function trocaStatusSolicitacao($id_user,$id_motivo, $id_corrida, $status)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_participantes` SET status='$status',id_motivo='$id_motivo'
        WHERE app_users_id='$id_user' AND app_Orcamentos_id='$id_corrida' AND status<>5"
        );

        $sql_cadastro->execute();


        if($status == 1){
            $msg = "Solicitação aprovada";
        }
        if($status == 3){
            $msg = "Solicitação recusada";
        }
        if($status == 4){
            $msg = "Passageiro entregue";
        }
        if($status == 5){
            $msg = "Passageiro cancelado";
        }
        $Param = [
            "status" => "01",
            "msg" => $msg
        ];

        return $Param;
    }
    public function aceitarCorrida($id_corrida, $id_motorista)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos` SET status='2', id_motorista='$id_motorista'
        WHERE id='$id_corrida'"
        );

        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_disparos` SET status='1'
        WHERE app_Orcamentos_id='$id_corrida' AND id_motorista='$id_motorista'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Corrida Aceita"
        ];

        return $Param;
    }

    public function cancelarCorridaPassageiro($id_corrida,$mensagem)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos` SET status='4',passageiro_cancelou='1'
        WHERE id='$id_corrida'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => $mensagem
        ];


        return $Param;
    }
    public function trocaStatusCorrida($id_corrida,$id_motivo,$status)
    {


        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos` SET status='$status',id_motivo='$id_motivo'
        WHERE id='$id_corrida'"
        );

        $sql_cadastro->execute();

        if($status == 1){
            $mensagem="aberta";
        }
        if($status == 2){
            $mensagem="finalizada";
        }
        if($status == 3){
            $mensagem="em curso";
        }
        if($status == 4){
            $mensagem="cancelada";
        }


        $Param = [
            "status" => "01",
            "msg" => "Corrida $mensagem"
        ];

        return $Param;
    }
    public function recusarCorrida($id_corrida, $id_motorista)
    {


        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_disparos` SET status='2'
        WHERE app_Orcamentos_id='$id_corrida' AND id_motorista='$id_motorista'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Corrida Recusada"
        ];

        return $Param;
    }

    public function estornarTudoToken($id_corrida,$id_passageiro,$token) {



        $url = ASAAS_URL."v3/payments/".$token."/refund";

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY));
        curl_setopt($ch, CURLOPT_HTTPGET, true);


        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $sql = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_pagamentos` SET status='REFOUNDED'
        WHERE app_Orcamentos_id='$id_corrida' AND app_users_id='$id_passageiro'"
        );
        $sql->execute();


        if ($httpCode != 200) {
            return $json_data['errors'][0]['description'];
        }else{
            return $json_data;
        }

        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function estornarTaxandoToken($id_corrida,$id_user,$valor,$tipo_pagamento,$token) {

        if($tipo_pagamento == 1){
            $this->confirmaPagamentoAsaas($token);
        }

        $url = ASAAS_URL."v3/payments/".$token."/refund";

        // Dados da requisição
        $data = array(
            'value' => $valor
        );
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);

        // print_r($json_data);
        // Verifica se houve algum erro na requisição

        $sql = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_pagamentos` SET status='REFOUNDED'
        WHERE app_Orcamentos_id='$id_corrida' AND app_users_id='$id_user'"
        );
        $sql->execute();


        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function estornarTudo($id_corrida,$id_passageiro) {

        $sql= $this->mysqli->prepare("SELECT `token` FROM `app_Orcamentos_pagamentos` WHERE app_Orcamentos_id ='$id_corrida' AND app_users_id='$id_passageiro' ORDER BY id DESC LIMIT 1");
        $sql->execute();
        $sql->bind_result($token);
        $sql->store_result();
        $sql->fetch();
        $sql->close();


        $url = ASAAS_URL."v3/payments/".$token."/refund";

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY));
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $sql = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_pagamentos` SET status='REFOUNDED'
        WHERE app_Orcamentos_id='$id_corrida' AND app_users_id='$id_passageiro'"
        );
        $sql->execute();


        if ($httpCode != 200) {
            return $json_data['errors'][0]['description'];
        }

        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function estornarTaxando($id_corrida,$id_user,$valor,$tipo_pagamento) {

        $sql = $this->mysqli->prepare("SELECT token FROM `app_Orcamentos_pagamentos` WHERE app_Orcamentos_id = $id_corrida AND app_users_id='$id_user'");
        $sql->execute();
        $sql->bind_result($token);
        $sql->store_result();
        $sql->fetch();
        $sql->close();

        // $token="pay_v6xdjimuct47ig57";
        if($tipo_pagamento == 1){
            $this->confirmaPagamentoAsaas($token);
        }

        $url = ASAAS_URL."v3/payments/".$token."/refund";

        // Dados da requisição
        $data = array(
            'value' => $valor
        );
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);

        // print_r($json_data);
        // Verifica se houve algum erro na requisição

        $sql = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_pagamentos` SET status='REFOUNDED'
        WHERE app_Orcamentos_id='$id_corrida' AND app_users_id='$id_user'"
        );
        $sql->execute();


        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function cobrarCartao($valor,$customer,$token,$card_number,$month,$year,$cvv,$nome,$cpf,$cep,$numero,$email,$celular)
    {

        // URL da API
        $url = ASAAS_URL.'v3/payments';

        if(!empty($token)){
            // Dados da requisição
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'value' => $valor,
                'dueDate' => $this->data_atual,
                'creditCardToken' => $token,
                'authorizeOnly' => true
            );
        }else{
            // Dados da requisição
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'value' => $valor,
                'dueDate' => $this->data_atual,
                'authorizeOnly' => true,
                'creditCardHolderInfo' => array(
                    'name' => $nome,
                    'email' => $email,
                    'cpfCnpj' => $cpf,
                    'postalCode' => $cep,
                    'addressNumber' => $numero,
                    'phone' => $celular
                ),
                'creditCard' => array(
                    'holderName' => $nome,
                    'number' => $card_number,
                    'expiryMonth' => $month,
                    'expiryYear' => $year,
                    'ccv' => $cvv
                )
            );

        }



        // print_r($data);exit;
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);

        // echo $response;
        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) OR ($httpCode != 200) ) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description']
            ];

            return $lista;
        }


        // Fecha a sessão cURL
        curl_close($ch);

        $lista = [
            "status" => '01',
            "payment_id" => $json_data['id']
        ];

        return $lista;
    }
    public function cobrarCartaoComToken($valor, $customer, $token, $nome, $cpf, $cep, $numero, $email, $celular)
{
    // URL da API
    $url = ASAAS_URL . 'v3/payments';

    // Dados da requisição usando o token do cartão
    $data = array(
        'billingType' => 'CREDIT_CARD',
        'customer' => $customer,
        'value' => $valor,
        'dueDate' => $this->data_atual,
        'creditCardToken' => $token,
        'authorizeOnly' => true,
        'creditCardHolderInfo' => array(
            'name' => $nome,
            'email' => $email,
            'cpfCnpj' => $cpf,
            'postalCode' => $cep,
            'addressNumber' => $numero,
            'phone' => $celular
        )
    );

    // Inicializa a sessão cURL
    $ch = curl_init($url);

    // Configura as opções da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY,
        'content-type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $json_data = json_decode($response, true);

    // Verifica se houve algum erro na requisição
    if (curl_errno($ch) || ($httpCode != 200)) {
        $lista = [
            "status" => '02',
            "msg" => $json_data['errors'][0]['description'] ?? 'Erro desconhecido.'
        ];

        curl_close($ch);
        return $lista;
    }

    // Fecha a sessão cURL
    curl_close($ch);

    $lista = [
        "status" => '01',
        "payment_id" => $json_data['id']
    ];

    return $lista;
}


    public function gerarCobrancaPix($valor)
    {

        // URL da API
        $url = ASAAS_URL.'v3/payments';

        // Dados da requisição
        $data = array(
            'billingType' => 'PIX',
            'customer' => ASAAS_CUSTOMER_PIX,
            'value' => $valor,
            'dueDate' => $this->data_atual
        );

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);


        // Verifica se houve algum erro na requisição
        if (curl_errno($ch)) {
            echo 'Erro na requisição cURL: ' . curl_error($ch);
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($response,true);
        // print_r($json_data);exit;
        return $json_data;
    }

    public function verificarClientePorEmail($email)
    {
        // URL da API para listar clientes
        $url = ASAAS_URL . 'v3/customers?email=' . urlencode($email);

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:' . ASAAS_KEY,
            'content-type: application/json',

        ));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response, true);

        // Fecha a sessão cURL
        curl_close($ch);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) || ($httpCode != 200)) {
            return [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description'] ?? 'Erro desconhecido.'
            ];
        }

        // Verifica se o cliente foi encontrado
        if (!empty($json_data['data'])) {
            // Retorna o customer_id do primeiro cliente encontrado
            return [
                "status" => '01',
                "customer_id" => $json_data['data'][0]['id']
            ];
        } else {
            return [
                "status" => '00',
                "msg" => "Cliente não encontrado."
            ];
        }
    }

    public function criar_cliente($nome,$cpf)
    {
        $url = ASAAS_URL."v3/customers";

        $headers = array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        );

        $data = array(
            "name" => $nome,
            "cpfCnpj" => "$cpf"
        );

        // print_r($data);exit;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response, true);
        if ($response === false) {
            $Param = [
                "status" => "02",
                "msg" => "Erro ao criar o cliente.",
            ];

            return $Param;
        } else {
            // Verifique o código de resposta
            if ($httpCode === 200) {
                return $json_data['id'];
                // echo 'Solicitação bem-sucedida: ' . $response;
            } else {
                return null;
            }
        }

        curl_close($ch);

    }
    public function gerarQrCode($valor)
    {
        $dados_cobranca = $this->gerarCobrancaPix($valor);
        // print_r($dados_cobranca['id']);exit;
        $payment_id =$dados_cobranca['id'];
        // URL da API
        $url = ASAAS_URL.'v3/payments/'.$payment_id.'/pixQrCode';

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token:'.ASAAS_KEY,
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        ));
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch)) {
            echo 'Erro na requisição cURL: ' . curl_error($ch);
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($response,true);
        // print_r($response);exit;
        $lista = [
            "payment_id" => $payment_id,
            "payload" => $json_data['payload'],
            "qrCode64" => $json_data['encodedImage']
        ];

        return $lista;

    }
    public function confirmaPagamentoAsaas($payment_id)
    {

        // URL da API
        $url = ASAAS_URL.'v3/payments/'.$payment_id.'/captureAuthorized';
        // Dados da requisição
        $data = array();



        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);
        // echo $response;
        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) OR ($httpCode != 200) ) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description']
            ];

            return $lista;
        }


        // Fecha a sessão cURL
        curl_close($ch);

        $lista = [
            "status" => '01',
            "payment_id" => $json_data['id']
        ];

        return $lista;
    }

    public function verificaCartao($id_cartao,$id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,customer,token,card_number,month,year,cvv,nome,cpf,cep,numero,bandeira
            FROM `app_cartoes`
            WHERE id = '$id_cartao' AND app_users_id='$id_user'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$customer,$token,$card_number,$month,$year,$cvv,$nome,$cpf,$cep,$numero,$bandeira);
        $sql->store_result();
        $rows = $sql->num_rows;


        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['customer'] = $customer;
            $Param['token'] = $token;
            $Param['bandeira'] = $bandeira;
            $Param['card_number'] = $card_number;
            $Param['month'] = $month;
            $Param['year'] = $year;
            $Param['cvv'] = $cvv;
            $Param['nome'] = $nome;
            $Param['cpf'] = $cpf;
            $Param['cep'] = $cep;
            $Param['numero'] = $numero;

            array_push($lista, $Param);
        }
        return $lista[0];
    }
    public function corridaEmAberto($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,status
            FROM `app_Orcamentos`
            WHERE id_usuario = '$id_user' AND (status !='1' AND status !='4')
            ORDER BY id DESC
            LIMIT 1
            "
        );

        $sql->execute();
        $sql->bind_result($corrida,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if($rows == 0){
            $Param['status'] = '02';
            $Param['msg'] = 'Nenhuma corrida em aberto foi encontrada';

            array_push($lista, $Param);
        }else{
            while ($row = $sql->fetch()) {
                $Param['status'] = '01';
                $Param['id_corrida'] = $corrida;
                $Param['status_corrida'] = $status;

                array_push($lista, $Param);
            }
        }
        return $lista;
    }
    public function verificaCupom($id_user,$cupom)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT perc_desconto
            FROM `app_cupons`
            WHERE (app_users_id = '0' OR app_users_id = '$id_user')
                AND status='1'
                AND (NOW() >= data_in AND NOW() <= data_out)
                AND codigo='$cupom'
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
    public function verificaCupomUsado($id_user,$cupom)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT cupom
            FROM `app_Orcamentos`
            WHERE id_usuario='$id_user' AND cupom='$cupom'
            "
        );

        $sql->execute();
        $sql->bind_result($cupom);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // print_r($perc_desconto);
        return $rows;
    }
    public function verificaCorridaPendente($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_Orcamentos`
            WHERE id = '$id_corrida' AND (status='2' OR status='3') AND id_motorista IS NULL
            "
        );

        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // var_dump($lista[0]);
        return $rows;
    }
    public function pega_tipo_pagamento($id_corrida,$id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.tipo_pagamento,a.token,a.valor_motorista,a.valor_admin,b.id_motorista,a.valor_corrida
            FROM `app_Orcamentos_pagamentos` AS a
            INNER JOIN `app_Orcamentos` AS b ON b.id=a.app_Orcamentos_id
            INNER JOIN `app_users` AS c ON c.id=b.id_motorista
            WHERE a.app_Orcamentos_id = '$id_corrida' AND a.app_users_id='$id_user'
            ORDER BY a.id DESC
            "
        );

        $sql->execute();
        $sql->bind_result($id_pagamento,$tipo_pagamento,$token,$valor_motorista,$valor_admin,$id_motorista,$valor_corrida);
        $sql->store_result();
        $rows = $sql->num_rows;
        $lista = [];

        $valor_reajuste = 0;
        while ($row = $sql->fetch()) {

            $Param['id_pagamento'] = $id_pagamento;
            $Param['id_motorista'] = $id_motorista;
            $Param['token'] = $token;
            $Param['tipo_pagamento'] = $tipo_pagamento;
            $Param['valor_motorista'] = $valor_motorista;
            $Param['valor_admin'] = $valor_admin;



            array_push($lista, $Param);
        }

        // print_r($lista);exit;
        return $lista[0];
    }
    public function pegaValorReceber($id_motorista)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT saldo
            FROM `app_users_saldo`
            WHERE app_users_id='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($saldo);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        // print_r($usuarios);exit;
        return $saldo;
    }
    public function pegarChargeId($id_pedido)
    {
        $body = array();


        // URL da API e chave de API
        $url = PAGARME_URL."/orders/$id_pedido";
        $apiKey = PAGARME_KEY;

        // Configurar a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'User-Agent: PostmanRuntime/7.28.0',
            'Content-Type: application/json'
        ));

        // Executar a requisição e capturar a resposta
        $response = curl_exec($ch);

        // Verificar por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechar a conexão
        curl_close($ch);
        $response = json_decode($response,true);
        // Exibir a resposta

        return $response['charges'][0]['id'];


    }
    public function capturarValorParaEstorno($chargeId)
    {
        $url = PAGARME_URL."/charges/$chargeId/capture";
        // URL da API

        // Dados da solicitação
        $data = array(
        );

        // Converter os dados para o formato JSON
        $data_string = json_encode($data);
        $apiKey = PAGARME_KEY;
        // Configurar as opções da solicitação cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'User-Agent: PostmanRuntime/7.28.0',
            'content-type: application/json',
            'content-length: ' . strlen($data_string))
        );

        // Executar a solicitação cURL e obter a resposta
        $result = curl_exec($ch);

        // Verificar por erros
        if (curl_errno($ch)) {
            echo 'Erro ao enviar a solicitação: ' . curl_error($ch);
        }

        // Fechar a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($result,true);
        if (curl_errno($ch)) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['message']
            ];

            return $lista;
        }
        $lista = [
            "status" => '01',
            "payment_id" => $json_data['id']
        ];

        return $lista;
    }
    public function confirmaPagamentoPagarme($chargeId,$split,$valor_motorista,$valor_admin)
    {
        $valor_motorista = $valor_motorista * 100;
        $valor_admin = $valor_admin * 100;
        $amount=$valor_motorista + $valor_admin;

        $url = PAGARME_URL."/charges/$chargeId/capture";
        // URL da API

        // Dados da solicitação
        $data = array(
            'amount'=>intval($amount),
            'split' => array(
                array(
                    'options' => array(
                        'charge_processing_fee' => false,
                        'charge_remainder_fee' => false,
                        'liable' => false
                    ),
                    'amount' => intval($valor_motorista),
                    'recipient_id' => $split,
                    'type' => 'flat'
                ),
                array(
                    'options' => array(
                        'liable' => true,
                        'charge_remainder_fee' => true,
                        'charge_processing_fee' => true
                    ),
                    'amount' => intval($valor_admin),
                    'recipient_id' => PAGARME_SPLIT,
                    'type' => 'flat'
                )
            )
        );



        // Converter os dados para o formato JSON
        $data_string = json_encode($data);
        // print_r($data_string);exit;
        $apiKey = PAGARME_KEY;
        // Configurar as opções da solicitação cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'User-Agent: PostmanRuntime/7.28.0',
            'content-type: application/json',
            'content-length: ' . strlen($data_string))
        );

        // Executar a solicitação cURL e obter a resposta
        $result = curl_exec($ch);

        // Verificar por erros
        if (curl_errno($ch)) {
            echo 'Erro ao enviar a solicitação: ' . curl_error($ch);
        }

        // Fechar a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($result,true);
        // print_r($json_data);
        if (curl_errno($ch)) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['message']
            ];

            return $lista;
        }
        $lista = [
            "status" => '01',
            "payment_id" => $json_data['id']
        ];
        return $lista;
    }

    public function verificaSolicitacoes($id_user,$id_corrida,$id_endereco_partida,$id_endereco_final)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.hora_partida,c.hora_partida,d.hora_partida
            FROM `app_participantes` AS a
            LEFT JOIN `app_Orcamentos_end` AS b ON a.endereco_partida=b.id
            LEFT JOIN `app_Orcamentos_end` AS c ON a.endereco_chegada=c.id
            LEFT JOIN `app_Orcamentos_end` AS d ON $id_endereco_partida=d.id
            LEFT JOIN `app_Orcamentos_end` AS e ON $id_endereco_final=e.id
            WHERE a.app_users_id = '$id_user' AND a.status IN (1,2,3,4) AND
            (
                (d.hora_partida BETWEEN b.hora_partida AND c.hora_partida)
                OR
                (e.hora_partida BETWEEN b.hora_partida AND c.hora_partida)
            )
            "
        );

        $sql->execute();
        $sql->bind_result($hora_partida,$hora_chegada,$hora_atual);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // var_dump($lista[0]);
        return $rows;
    }

    // public function verificaSolicitacoes($id_user,$id_corrida)
    // {

    //     $sql = $this->mysqli->prepare(
    //         "
    //         SELECT id
    //         FROM `app_participantes`
    //         WHERE app_users_id = '$id_user' AND app_Orcamentos_id='$id_corrida'
    //         "
    //     );

    //     $sql->execute();
    //     $sql->bind_result($id);
    //     $sql->store_result();
    //     $sql->fetch();
    //     $rows = $sql->num_rows;

    //     $lista = [];

    //     // var_dump($lista[0]);
    //     return $rows;
    // }
    public function verificaDono($id_user,$id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id_motorista
            FROM `app_Orcamentos`
            WHERE id_motorista = '$id_user' AND id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // var_dump($lista[0]);
        return $rows;
    }
    public function getCondutor($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id_motorista
            FROM `app_Orcamentos`
            WHERE id='$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($id_motorista);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // var_dump($lista[0]);
        return $id_motorista;
    }
    public function verificaCorridaAtual($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.status,b.tipo_pagamento,b.status,c.origem_lat,c.origem_long,a.valor_total,a.subcategoria,a.passageiro_cancelou,a.id_usuario,a.id_motorista
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_Orcamentos_pagamentos` AS b ON a.id=b.app_Orcamentos_id
            INNER JOIN `app_Orcamentos_end` AS c ON a.id=c.app_Orcamentos_id
            WHERE a.id = '$id_corrida'
            "
        );

        $sql->execute();
        $sql->bind_result($status,$tipo_pagamento,$status_pagamento,$origem_lat,$origem_long,$valor_total,$subcategoria,$passageiro_cancelou,$id_usuario,$id_motorista);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['status'] = $status;
            $Param['tipo_pagamento'] = $tipo_pagamento;
            $Param['status_pagamento'] = $status_pagamento;
            $Param['origem_lat'] = $origem_lat;
            $Param['origem_long'] = $origem_long;
            $Param['valor_total'] = $valor_total;
            $Param['subcategoria'] = $subcategoria;
            $Param['id_usuario'] = $id_usuario;
            $Param['id_motorista'] = $id_motorista;

            array_push($lista, $Param);
        }
        return $lista[0];
    }
    public function solicitarCarona($id_user, $id_corrida,$id_pagamento, $id_endereco_partida, $id_endereco_final) {

        // Preparar a query com placeholders para evitar injeção de SQL
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_participantes`(`app_users_id`, `app_Orcamentos_id`, `app_pagamentos_id`, `endereco_partida`, `endereco_chegada`, `data_cadastro`, `id_motivo`, `status`)
             VALUES (?, ?, ?, ?, ?, ?, '0', '2')"
        );

        // Verificar se a preparação da query falhou
        if (!$sql_cadastro) {
            return [
                "status" => "02",
                "msg" => "Erro na preparação da query: " . $this->mysqli->error
            ];
        }

        // Bind dos parâmetros, todos como strings (s), exceto a data
        $data_atual = $this->data_atual;
        $sql_cadastro->bind_param("iiisss", $id_user, $id_corrida,  $id_pagamento,$id_endereco_partida, $id_endereco_final, $data_atual);

        // Executar a query
        if (!$sql_cadastro->execute()) {
            // Retornar mensagem de erro se a execução falhar
            return [
                "status" => "02",
                "msg" => "Erro ao executar a query: " . $sql_cadastro->error
            ];
        }

        // Capturar o ID gerado
        $id_participante = $sql_cadastro->insert_id;

        // Fechar a query
        $sql_cadastro->close();

        // Verificar se o ID foi gerado corretamente
        if ($id_participante > 0) {
            $Param = [
                "status" => "01",
                "id" => $id_participante,
                "msg" => "Solicitada com sucesso."
            ];
        } else {
            $Param = [
                "status" => "02",
                "msg" => "Erro ao inserir o participante: Nenhum ID gerado."
            ];
        }

        return $Param;
    }

    public function solicitarCaronaPix($id_user,$id_corrida,$id_pagamento,$id_endereco_partida,$id_endereco_final){

        gerarLog("id:pagamento".$id_pagamento);

        //solicita igual, só q sem status, pois ele ainda nao solicitou de VERDADE, afinal nao pagou ainda!
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_participantes`(`app_users_id`, `app_Orcamentos_id`,`app_pagamentos_id`, `endereco_partida`, `endereco_chegada`,`data_cadastro`,`id_motivo`, `status`)
             VALUES ('$id_user','$id_corrida','$id_pagamento','$id_endereco_partida','$id_endereco_final','$this->data_atual','0','0')"
        );
        $sql_cadastro->execute();


        $Param = [
            "status" => "01",
            "msg" => "Solicitada com sucesso."
        ];

        return $Param;
    }
    public function solicitarCorrida($id_corrida,$id_motorista,$prioridade_delay){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_disparos`(`app_Orcamentos_id`, `id_motorista`, `prioridade_delay`, `data`,`status`)
             VALUES ('$id_corrida','$id_motorista','$prioridade_delay','$this->data_atual','3')"
        );
        $sql_cadastro->execute();


        $Param = [
            "status" => "01",
            "id_corrida" => $id_corrida,
            "msg" => "Solicitada com sucesso."
        ];

        return $Param;
    }
    public function calculaValorMotorista($valor_corrida,$subcategoria,$cupom){
        $sql = $this->mysqli->prepare(
            "
            SELECT b.valor_min,a.perc_motorista
            FROM `app_config` AS a
            JOIN `app_subcategorias` AS b
            WHERE a.id = '1' AND b.id='$subcategoria'
            "
        );

        $sql->execute();
        $sql->bind_result($valor_min,$perc_motorista);
        $sql->store_result();
        $sql->fetch();

        if(!empty($cupom)){
            //reestabeleço o valor original da corrida antes do desconto do cupom
            $percCupom = $this->percCupom($cupom);
            $valor_original = $valor_corrida / (1 - ($percCupom / 100));
            $valor_corrida = $valor_original;
        }

        $valor_calculado = $valor_corrida * ($perc_motorista/100);
        if($valor_min > $valor_calculado){
            $valor_calculado = $valor_min;
        }
        return $valor_calculado;
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

    public function createCorrida($id_user,$valor,$duracao_min,$distancia_km,$bagagens_status,$obs,$cupom,$subcategoria){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos`(`id_usuario`, `valor_total`, `duracao_min`, `distancia_km`,`bagagem_status`,`data`, `status`, `obs`, `cupom`, `subcategoria`)
             VALUES ('$id_user','$valor','$duracao_min','$distancia_km','$bagagens_status','$this->data_atual','3','$obs','$cupom','$subcategoria')"
        );
        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;
        $Param = [
            "status" => "01",
            "id" => $this->id_cadastro,
            "msg" => "Solicitada com sucesso."
        ];

        return $Param;
    }

    public function createCorridaPagamentos($id_user,$corrida_id,$tipo_pagamento,$valor,$valor_motorista,$valor_admin,$cartao_id,$qr_code,$data_atual,$token,$status_pagamento){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_pagamentos`(`app_users_id`, `app_Orcamentos_id`, `tipo_pagamento`, `valor_corrida`, `valor_motorista`, `valor_admin` ,`cartao_id`,`qr_code`, `data`,`token`,
             `status`)
             VALUES ('$id_user','$corrida_id','$tipo_pagamento','$valor','$valor_motorista','$valor_admin','$cartao_id','$qr_code','$data_atual','$token','$status_pagamento')"
        );
        $sql_cadastro->execute();
        $id_pagamento= $sql_cadastro->insert_id;
        $sql_cadastro->close();
        $Param = [
            "id" => $id_pagamento,
            "status" => "01",
            "msg" => "Solicidata com sucesso."
        ];

        return $Param;
    }

    public function createCorridaEnd($id_corrida,$origem,$latitude_inicio,$longitude_inicio,
    $parada1,$latitude_parada_1,$longitude_parada_1,
    $parada2,$latitude_parada_2,$longitude_parada_2,
    $destino,$latitude_fim,$longitude_fim,
    $polyline){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_Orcamentos_end`(`app_Orcamentos_id`, `origem`, `origem_lat`, `origem_long`, `parada1` ,`parada1_lat`,`parada1_long`, `parada2`,`parada2_lat`,
             `parada2_long`,`destino`,`destino_lat`, `destino_long`, `polyline`)
             VALUES ('$id_corrida','$origem','$latitude_inicio','$longitude_inicio','$parada1','$latitude_parada_1','$longitude_parada_1','$parada2','$latitude_parada_2','$longitude_parada_2',
             '$destino','$latitude_fim','$longitude_fim','$polyline')"
        );
        $sql_cadastro->execute();
        $Param = [
            "status" => "01",
            "msg" => "Solicidata com sucesso."
        ];

        return $Param;
    }
    public function buscaTaxa()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT taxa_cancelar
            FROM `app_config`
            WHERE id = '1'
            "
        );

        $sql->execute();
        $sql->bind_result($taxa);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $taxa;
    }
    public function rifaInfo()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id_sorteio_passageiro,id_sorteio_motorista
            FROM `app_config`
            WHERE id = '1'
            "
        );

        $sql->execute();
        $sql->bind_result($id_sorteio_passageiro,$id_sorteio_motorista);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id_sorteio_passageiro'] = $id_sorteio_passageiro;
            $Param['id_sorteio_motorista'] = $id_sorteio_motorista;

            array_push($lista, $Param);
        }
        return $lista[0];
    }
    public function buscaAlcance()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT raio_km
            FROM `app_config`
            WHERE id = '1'
            "
        );

        $sql->execute();
        $sql->bind_result($raio_km);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // var_dump($lista[0]);
        return $raio_km;
    }

    public function motoristasProximos($latitude,$longitude)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,b.latitude, b.longitude
            FROM `app_users` AS a
            INNER JOIN `app_users_location` AS b ON a.id = b.app_users_id
            WHERE a.online = '1' AND a.tipo = '2'
            "
        );

        $sql->execute();
        $sql->bind_result($id_motorista,$lat,$long);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            // $alcance = $this->buscaAlcance();
            while ($row = $sql->fetch()) {
                $distancia = distancia($latitude,$longitude,$lat,$long);
                $contagem = 0;
                if($distancia <= $alcance ){
                    // $Param['alcance'] = $alcance;
                    $Param['id_motorista'] = $id_motorista;
                    $Param['distancia'] = $distancia;
                    $Param['latitude'] = $lat;
                    $Param['longitude'] = $long;
                    array_push($lista, $Param);
                }
            }
            foreach ($lista as &$item) {
                $item['rows'] = count($lista);
                $this->deslogaMotoristaPorTempo($id_motorista);
            }
            if(count($lista) == 0){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }
    public function verificaSubcategoriasMotorista($id_motorista,$subcategoria)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_users_subcategorias`
            WHERE app_users_id='$id_motorista' AND app_subcategorias_id='$subcategoria'
        "
        );
        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $rows;
    }
    public function updateRotaMotorista($id_corrida,$lat_moto,$long_moto,$lat_corrida,$long_corrida)
    {


        $retorno = createRotaLatLong($lat_moto, $long_moto, $lat_corrida, $long_corrida, "");
        $rota = $retorno['routes'][0];
        $polyline=$rota['overview_polyline']['points'];
        $polyline=addslashes($polyline);

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_end` SET polyline_motorista='$polyline'
        WHERE app_Orcamentos_id='$id_corrida'"
        );

        $sql_cadastro->execute();
    }
    public function deslogaMotoristaPorTempo($id_user)
    {
        //verifica se o mototorista continua online
        $sql = $this->mysqli->prepare("SELECT `data` FROM app_users_location WHERE app_users_id='$id_user'");
        $sql->execute();
        $sql->bind_result($ultimaResposta);
        $sql->store_result();
        $sql->fetch();
        // Converte as datas para objetos DateTime
        $data1_obj = new DateTime($this->data_atual);
        $data2_obj = new DateTime($ultimaResposta);

        // Calcula a diferença em segundos entre as datas
        $diferenca_em_segundos = $data1_obj->getTimestamp() - $data2_obj->getTimestamp();
        // Define o limite em segundos
        $limite_em_segundos = 60;

        if ($diferenca_em_segundos > $limite_em_segundos) {
            $sql_cadastro = $this->mysqli->prepare("
            UPDATE `app_users` SET online='2'
            WHERE id='$id_user'"
            );
            $sql_cadastro->execute();
        }
    }
    public function criarRota($end_inicio,$end_fim, $parada_1,$parada_2)
    {

        $retorno = createRota($end_inicio, $end_fim, $parada_1, $parada_2);

        $usuarios=[];

        if ($retorno['status'] == 'OK') {
            $rota = $retorno['routes'][0];
            $distanciaTotal=0;
            $duracaoTotal=0;
            $polyline=$rota['overview_polyline']['points'];

            foreach ($rota['legs'] as $leg) {
                $distanciaTotal= $distanciaTotal + $leg['distance']['value'];
                $duracaoTotal = $duracaoTotal + $leg['duration']['value'];
            }


            $corrida=$this->calculaPreco($distanciaTotal);

            $item = [
                'distancia' => number_format(($distanciaTotal/1000),1).' Km',
                'duracao' => number_format($duracaoTotal/60,1).' minutos',
                'origem' => $rota['legs'][0]['start_address'],
                'destino' => end($rota['legs'])['end_address'],//pega o ultimo do array legs
                'polyline' => $polyline,
                'valor_corrida' => $corrida,
                'status' => 1
            ];
            array_push($usuarios, $item);
        } else {
            $item = ['status' => 2,'msg' => 'Ocorreu um erro ao montar a rota.'];
            array_push($usuarios, $item);
        }

        return $usuarios;
    }
    public function criaListaParadas( $latitude_parada_1,$longitude_parada_1,$latitude_parada_2,$longitude_parada_2)
    {
        $contador_paradas=0;
        $paradas =[];
        if(!empty($latitude_parada_1) && !empty($latitude_parada_2)){
            $contador_paradas=2;
            $parada1 = ['lat' => $latitude_parada_1,'long' => $longitude_parada_1];
            $parada2 = ['lat' => $latitude_parada_2,'long' => $longitude_parada_2];
            $paradas = [
                'parada1' => $parada1,
                'parada2' => $parada2,
                'rows' => $contador_paradas
            ];
        }elseif(!empty($latitude_parada_1)){
            $parada1 = ['lat' => $latitude_parada_1,'long' => $longitude_parada_1];
            $contador_paradas=1;
            $paradas = [
                'parada1' => $parada1,
                'parada2' => [],
                'rows' => $contador_paradas
            ];
        }else{
            $paradas = [
                'parada1' => [],
                'parada2' => [],
                'rows' => $contador_paradas
            ];
        }
        return $paradas;
    }


    public function criarRotaLatLong($latitude_inicio,$longitude_inicio,$latitude_fim,$longitude_fim,
        $latitude_parada_1,$longitude_parada_1,$latitude_parada_2,$longitude_parada_2)
    {

        if(!empty($latitude_parada_1) && !empty($latitude_parada_2)){
            $paradas_intermediarias = array(
                array('latitude' => $latitude_parada_1, 'longitude' => $longitude_parada_1), // Parada 1
                array('latitude' => $latitude_parada_2, 'longitude' => $longitude_parada_2)  // Parada 2
            );
            $parada1 = ['lat' => $latitude_parada_1,'long' => $longitude_parada_1];
            $parada2 = ['lat' => $latitude_parada_2,'long' => $longitude_parada_2];
            $contaParadas=2;
        }elseif(!empty($latitude_parada_1)){
            $paradas_intermediarias = array(
                array('latitude' => $latitude_parada_1, 'longitude' => $longitude_parada_1) // Parada 1
            );
            $parada1 = ['lat' => $latitude_parada_1,'long' => $longitude_parada_1];
            $contaParadas=1;
        }else{
            $paradas_intermediarias = array();
            $contaParadas=0;
        }

        $criaListaParadas = $this->criaListaParadas($latitude_parada_1,$longitude_parada_1,$latitude_parada_2,$longitude_parada_2);

        $retorno = createRotaLatLong($latitude_inicio, $longitude_inicio, $latitude_fim, $longitude_fim, $paradas_intermediarias);

        $usuarios=[];

        if ($retorno['status'] == 'OK') {
            $rota = $retorno['routes'][0];
            $distanciaTotal=0;
            $duracaoTotal=0;
            $polyline=$rota['overview_polyline']['points'];

            foreach ($rota['legs'] as $leg) {
                $distanciaTotal= $distanciaTotal + $leg['distance']['value'];
                $duracaoTotal = $duracaoTotal + $leg['duration']['value'];
            }

            $corrida=$this->calculaPreco($distanciaTotal,$latitude_inicio,$longitude_inicio);

            $item = [
                'distancia' => number_format(($distanciaTotal/1000),1).' Km',
                'duracao' => number_format($duracaoTotal/60,1).' minutos',
                'origem' => $rota['legs'][0]['start_address'],
                'destino' => end($rota['legs'])['end_address'],//pega o ultimo do array legs
                'polyline' => $polyline,
                'valor_corrida' => $corrida,
                'parada1' => $parada1,
                'parada2' => $parada2,
                'paradas_qtd' => $contaParadas,
                'status' => 1
            ];
            array_push($usuarios, $item);
        } else {
            $item = ['status' => 2,'msg' => 'Ocorreu um erro ao montar a rota.'];
            array_push($usuarios, $item);
        }

        return $usuarios;
    }

    public function calculaPreco($distancia,$lat,$long)
    {
        // passa para km:
        $distancia = $distancia /1000;

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome, url ,valor_min,valor_km,descricao
            FROM `app_subcategorias`
            WHERE status = 1
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$url,$valor_min , $valor_km, $descricao);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            $valor_dinamico=$this->valorDinamico($lat,$long);
            while ($row = $sql->fetch()) {
                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['descricao'] = $descricao;

                // $Param['valor_min'] = $valor_min;
                // $Param['valor_km'] = $valor_km;


                if($valor_dinamico > 0){
                    $valor_corrida = ($valor_km+$valor_dinamico) * $distancia;
                }else{
                    $valor_corrida = $valor_km * $distancia;
                }


                if($valor_corrida < $valor_min){
                    $valor_corrida = $valor_min;
                }
                $Param['valor_corrida'] = "R$ ".number_format($valor_corrida,2,",",".");
                $Param['rows'] = $rows;

                array_push($lista, $Param);
            }
        }
        return $lista;
    }

    // public function valorDinamico1($lat,$long)
    // {

    //     print_r($lat);exit;
    //     $diaSemanaHoje = date('N');
    //     $horaAtual = date('H:i:s');
    //     $sql = $this->mysqli->prepare(
    //         "
    //         SELECT valor
    //         FROM `app_dinamico`
    //         WHERE status=1 AND dia='$diaSemanaHoje' AND hora_in <= '$horaAtual' AND hora_out >= '$horaAtual'
    //         ORDER BY valor DESC
    //         LIMIT 1
    //         "
    //     );

    //     $sql->execute();
    //     $sql->bind_result($valor);
    //     $sql->store_result();
    //     $sql->fetch();
    //     $rows = $sql->num_rows;

    //     $lista = [];

    //     if($valor){
    //         return $valor;
    //     }else{
    //         return 0;
    //     }

    // }
    public function valorDinamico($lat,$long)
    {


        $diaSemanaHoje = date('N');
        $horaAtual = date('H:i:s');
        $sql = $this->mysqli->prepare(
            "
            SELECT a.valor,b.raio_metros,b.latitude,b.longitude
            FROM `app_dinamico` AS a
            JOIN `app_dinamico_locais` AS b
            WHERE a.status=1 AND a.dia='$diaSemanaHoje' AND a.hora_in <= '$horaAtual' AND a.hora_out >= '$horaAtual'
            ORDER BY a.valor DESC
            "
        );

        $sql->execute();
        $sql->bind_result($valor,$raio_metros,$latitute,$longitude);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        while ($row = $sql->fetch()) {
            $distancia = distancia($lat,$long,$latitute,$longitude);
            $distancia_metros = $distancia*1000;
            $Param['distancia'] = $distancia_metros;
            $Param['valor'] = $valor;
            $Param['raio_metros'] = $raio_metros;
            $Param['latitute'] = $latitute;
            $Param['longitude'] = $longitude;

            if($distancia_metros <= $raio_metros){
                return $valor;
            }
            array_push($lista, $Param);
        }
        return 0;
    }
    public function verificaChegou($id_motorista,$origem_lat,$origem_long)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT latitude,longitude
            FROM `app_users_location`
            WHERE app_users_id='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($motorista_lat,$motorista_long);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $motorista = [];

        if ($rows == 0) {
            return "2";
        } else {
            $distancia = distancia($motorista_lat,$motorista_long,$origem_lat,$origem_long);
            $distancia_metros = $distancia*1000;

            // echo $distancia_metros;
            if($distancia_metros <= RAIO_PARADA){
                return 1 ;
            }else{
                return 2 ;
            }
        }
        // print_r($usuarios);exit;

    }
    public function listOrcamentos($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.id_usuario,a.id_motorista,a.valor_total,a.duracao_min,a.distancia_km,a.bagagem_status,a.obs,a.data,a.status,
            b.origem,b.origem_lat,b.origem_long,b.parada1,b.parada1_lat,b.parada1_long,b.parada2,b.parada2_lat,b.parada2_long,b.destino,b.destino_lat,b.destino_long,b.polyline,
            c.tipo_pagamento,c.valor_motorista,c.cartao_id
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_Orcamentos_end` AS b ON a.id=b.app_Orcamentos_id
            LEFT JOIN `app_Orcamentos_pagamentos` AS c ON a.id=c.app_Orcamentos_id
            WHERE (a.id_usuario = '$id_user' OR a.id_motorista = '$id_user') AND a.status='1'
            ORDER BY a.data DESC;
        "
        );
        $sql->execute();
        $sql->bind_result($id_corrida,$id_usuario,$id_motorista,$valor_total,$duracao_min,$distancia_km,$bagagem_status,$obs,$data,$status,
        $origem,$origem_lat,$origem_long,$parada_end_1,$parada1_lat,$parada1_long,$parada_end_2,$parada2_lat,$parada2_long,$destino,$destino_lat,$destino_long,$polyline,
        $tipo_pagamento,$valor_motorista,$cartao_id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if($rows == 0){
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        }else{
            while ($row = $sql->fetch()) {
                $item['id_corrida'] =$id_corrida;
                if ($status == 1 || $status == 5) {
                    //se corrida completa ou iniciou nao preciso verificar se chegou , pois ele ja chegou anteriormente.
                    $item['status_chegou'] = 2;
                }else{
                    $item['status_chegou'] =$this->verificaChegou($id_motorista,$origem_lat,$origem_long);
                }
                if(!empty($parada1_lat)){
                    //verifica se o motorista esta a X metros da parada 1 ou 2.
                    $parada1=$this->verificaChegou($id_motorista,$parada1_lat,$parada1_long);
                    $parada2 = 2;
                    if(!empty($parada2_lat)){
                        $parada2=$this->verificaChegou($id_motorista,$parada2_lat,$parada2_long);
                    }
                    if(($parada1 == 1) || ($parada2 == 1)){
                        //se ja estou parado, status 3 para indicar q estou aguardando
                        if($status == 6){
                            $status_parada = 3;
                        }else{
                            $status_parada = 1;
                        }
                    }else{
                        $status_parada = 2;
                    }


                    $item['status_parada'] =$status == 6 ? 3 : $parada1;
                }else{
                    $item['status_parada'] =2;
                }
                $item['passageiro'] =$this->userInfo($id_usuario);
                $item['motorista'] =$this->userInfo($id_motorista);
                $veiculo = $this->veiculoInfo($id_motorista);
                $item['placa_moto'] =$veiculo['placa'];
                $item['modelo_moto'] =$veiculo['modelo'];
                $item['cor_moto'] =$veiculo['cor'];
                $item['valor_total'] =$valor_total;
                $item['duracao_min'] =$duracao_min;
                $item['distancia_km'] =$distancia_km;
                $item['bagagem_status'] =$bagagem_status;

                $item['tipo_pagamento'] =$tipo_pagamento;
                $item['bandeira_cartao'] =$this->pegaBandeira($cartao_id);
                $item['valor_motorista'] =$valor_motorista;

                $item['obs'] =$obs;
                $item['data'] =$data;
                $item['status'] =$status;
                switch ($status) {
                    case '1':
                        $item['status_text'] ='Completa';
                        $item['status_text_passageiro'] ='Completa';
                      break;
                    case '2':
                        $item['status_text'] ='Trajeto';
                        $item['status_text_passageiro'] ='Trajeto';
                      break;
                    case '3':
                        $item['status_text'] ='Solicitando';
                        $item['status_text_passageiro'] ='Solicitando';
                      break;
                    case '4':
                        $item['status_text'] ='Cancelada';
                        $item['status_text_passageiro'] ='Cancelada';
                      break;
                      case '5':
                        $item['status_text'] ='Iniciada';
                        $item['status_text_passageiro'] ='Iniciada';
                      break;
                      case '6':
                        $item['status_text'] ='Aguardando o passageiro';
                        $item['status_text_passageiro'] ='Motorista chegou';
                      break;
                  }

                $item['origem'] =$origem;
                $item['origem_lat'] =$origem_lat;
                $item['origem_long'] =$origem_long;

                $item['parada1'] =$parada_end_1;
                $item['parada1_lat'] =$parada1_lat;
                $item['parada1_long'] =$parada1_long;

                $item['parada2'] =$parada_end_2;
                $item['parada2_lat'] =$parada2_lat;
                $item['parada2_long'] =$parada2_long;

                $item['destino'] =$destino;
                $item['destino_lat'] =$destino_lat;
                $item['destino_long'] =$destino_long;

                $item['polyline'] =$polyline;

                $item['rows'] = $rows;
                array_push($usuarios,$item);
            }
        }



        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listOrcamentosId($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.id_usuario,a.id_motorista,a.valor_total,a.duracao_min,a.distancia_km,a.bagagem_status,a.obs,a.data,a.status,
            b.origem,b.origem_lat,b.origem_long,b.parada1,b.parada1_lat,b.parada1_long,b.parada2,b.parada2_lat,b.parada2_long,b.destino,b.destino_lat,b.destino_long,b.polyline,
            c.tipo_pagamento,c.valor_motorista,c.cartao_id
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_Orcamentos_end` AS b ON a.id=b.app_Orcamentos_id
            LEFT JOIN `app_Orcamentos_pagamentos` AS c ON a.id=c.app_Orcamentos_id
            WHERE a.id = '$id_corrida'
            ORDER BY a.data DESC;
        "
        );
        $sql->execute();
        $sql->bind_result($id_corrida,$id_usuario,$id_motorista,$valor_total,$duracao_min,$distancia_km,$bagagem_status,$obs,$data,$status,
        $origem,$origem_lat,$origem_long,$parada1,$parada1_lat,$parada1_long,$parada2,$parada2_lat,$parada2_long,$destino,$destino_lat,$destino_long,$polyline,
        $tipo_pagamento,$valor_motorista,$cartao_id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if($rows == 0){
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        }else{
            while ($row = $sql->fetch()) {
                $item['id_corrida'] =$id_corrida;
                if ($status == 1 || $status == 5) {
                    //se corrida completa ou iniciou nao preciso verificar se chegou , pois ele ja chegou anteriormente.
                    $item['status_chegou'] = 2;
                }else{
                    $item['status_chegou'] =$this->verificaChegou($id_motorista,$origem_lat,$origem_long);
                }
                if(!empty($parada1_lat)){
                    //verifica se o motorista esta a X metros da parada 1 ou 2.
                    $parada1=$this->verificaChegou($id_motorista,$parada1_lat,$parada1_long);
                    $parada2 = 2;
                    if(!empty($parada2_lat)){
                        $parada2=$this->verificaChegou($id_motorista,$parada2_lat,$parada2_long);
                    }
                    if(($parada1 == 1) || ($parada2 == 1)){
                        //se ja estou parado, status 3 para indicar q estou aguardando
                        if($status == 6){
                            $status_parada = 3;
                        }else{
                            $status_parada = 1;
                        }
                    }else{
                        $status_parada = 2;
                    }


                    $item['status_parada'] =$status == 6 ? 3 : $parada1;
                }else{
                    $item['status_parada'] =2;
                }
                $item['passageiro'] =$this->userInfo($id_usuario);
                $item['motorista'] =$this->userInfo($id_motorista);
                $veiculo = $this->veiculoInfo($id_motorista);
                $item['placa_moto'] =$veiculo['placa'];
                $item['modelo_moto'] =$veiculo['modelo'];
                $item['cor_moto'] =$veiculo['cor'];
                $item['valor_total'] =$valor_total;
                $item['duracao_min'] =$duracao_min;
                $item['distancia_km'] =$distancia_km;
                $item['bagagem_status'] =$bagagem_status;
                $nota_passageiro = $this->pegaNotaCorrida($id_usuario,$id_corrida);
                $nota_motorista = $this->pegaNotaCorrida($id_motorista,$id_corrida);
                $item['nota_passageiro'] =$nota_passageiro['estrelas'];
                $item['nota_motorista'] =$nota_motorista['estrelas'];
                $item['comentario_passageiro'] =$nota_passageiro['descricao'];
                $item['comentario_motorista'] =$nota_motorista['descricao'];
                $item['tipo_pagamento'] =$tipo_pagamento;
                $item['bandeira_cartao'] =$this->pegaBandeira($cartao_id);
                $item['valor_motorista'] =$valor_motorista;

                $item['obs'] =$obs;
                $item['data'] =$data;
                $item['status'] =$status;
                switch ($status) {
                    case '1':
                        $item['status_text'] ='Completa';
                        $item['status_text_passageiro'] ='Completa';
                      break;
                    case '2':
                        $item['status_text'] ='Trajeto';
                        $item['status_text_passageiro'] ='Trajeto';
                      break;
                    case '3':
                        $item['status_text'] ='Solicitando';
                        $item['status_text_passageiro'] ='Solicitando';
                      break;
                    case '4':
                        $item['status_text'] ='Cancelada';
                        $item['status_text_passageiro'] ='Cancelada';
                      break;
                      case '5':
                        $item['status_text'] ='Iniciada';
                        $item['status_text_passageiro'] ='Iniciada';
                      break;
                      case '6':
                        $item['status_text'] ='Aguardando o passageiro';
                        $item['status_text_passageiro'] ='Motorista chegou';
                      break;
                  }

                $item['origem'] =$origem;
                $item['origem_lat'] =$origem_lat;
                $item['origem_long'] =$origem_long;

                $item['parada1'] =$parada1;
                $item['parada1_lat'] =$parada1_lat;
                $item['parada1_long'] =$parada1_long;

                $item['parada2'] =$parada2;
                $item['parada2_lat'] =$parada2_lat;
                $item['parada2_long'] =$parada2_long;

                $item['destino'] =$destino;
                $item['destino_lat'] =$destino_lat;
                $item['destino_long'] =$destino_long;

                $item['polyline'] =$polyline;

                $item['rows'] = $rows;
                array_push($usuarios,$item);
            }
        }



        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function qtdCaronas($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT COUNT(*)
            FROM `app_Orcamentos`
            WHERE id_motorista='$id_usuario' AND status='2'
        "
        );
        $sql->execute();
        $sql->bind_result($media);
        $sql->store_result();
        $rows = $sql->num_rows;

        return $rows;
    }
    public function avaliacaoUser($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT AVG(estrelas)
            FROM `app_relatorio`
            WHERE id_para='$id_usuario' AND (tipo='1' OR tipo='4')
        "
        );
        $sql->execute();
        $sql->bind_result($media);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
        }
        !$media ? $media = 5 : $media;
        // print_r($usuarios);exit;
        return number_format($media,2);
    }
    public function userInfo($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,apelido,avatar,tipo
            FROM `app_users`
            WHERE id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$apelido,$avatar,$tipo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
                while ($row = $sql->fetch()) {
                    $item['id'] =$id;
                    $item['nome'] =decryptitem($nome);
                    $item['apelido'] =decryptitem($apelido);
                    $item['avatar'] =$avatar;
                    $item['avaliacao'] =$this->avaliacaoUser($id_usuario);
                    if($tipo == 2){
                        $latLong = $this->listLocation($id_usuario);
                        $item['lat'] =$latLong['lat'];
                        $item['long'] =$latLong['long'];
                    }
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function pegaNotaCorrida($id_user,$id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT estrelas,descricao
            FROM `app_relatorio`
            WHERE id_para='$id_user' AND id_corrida='$id_corrida' AND tipo='1'
        "
        );
        $sql->execute();
        $sql->bind_result($estrelas,$descricao);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $Param['estrelas'] = $estrelas;
        $Param['descricao'] = $descricao;

        return $Param;
    }
    public function pegaBandeira($id_cartao)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT bandeira
            FROM `app_cartoes`
            WHERE id='$id_cartao'
        "
        );
        $sql->execute();
        $sql->bind_result($bandeira);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $bandeira;
    }
    public function novoMotoristaProximo($latitude,$longitude,$corrida_id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,b.latitude, b.longitude
            FROM `app_users` AS a
            INNER JOIN `app_users_location` AS b ON a.id = b.app_users_id
            WHERE a.online = '1' AND a.tipo = '2'
            AND NOT EXISTS (
                SELECT 1
                FROM `app_Orcamentos_disparos`
                WHERE app_Orcamentos_id = $corrida_id
                  AND id_motorista = a.id
              )
            "
        );

        $sql->execute();
        $sql->bind_result($id_motorista,$lat,$long);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
        } else {
            $alcance = $this->buscaAlcance();
            while ($row = $sql->fetch()) {
                $distancia = distancia($latitude,$longitude,$lat,$long);
                $contagem = 0;
                if($distancia <= $alcance ){
                    // $Param['alcance'] = $alcance;
                    $Param['id_motorista'] = $id_motorista;
                    $Param['distancia'] = $distancia;
                    $Param['latitude'] = $lat;
                    $Param['longitude'] = $long;
                    array_push($lista, $Param);
                }
            }
        }

        // print_r($lista);exit;
        return $lista;
    }
    public function corridaEmAbertoMotorista($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,status
            FROM `app_Orcamentos`
            WHERE id_motorista = '$id_user' AND (`status` !='1' AND `status` !='4' AND `status` !='3')
            ORDER BY id DESC
            LIMIT 1
            "
        );

        $sql->execute();
        $sql->bind_result($corrida,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if($rows == 0){
            $Param['status'] = '02';
            $Param['msg'] = 'Nenhuma corrida em aberto foi encontrada';

            array_push($lista, $Param);
        }else{
            while ($row = $sql->fetch()) {
                $Param['status'] = '01';
                $Param['id_corrida'] = $corrida;
                $Param['status_corrida'] = $status;

                array_push($lista, $Param);
            }
        }
        return $lista;
    }
    public function listLocation($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT latitude,longitude
            FROM `app_users_location`
            WHERE app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($lat,$long);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
                while ($row = $sql->fetch()) {
                    $item['lat'] =$lat;
                    $item['long'] = $long;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function veiculoInfo($id_motorista)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.cor,a.modelo,a.placa,a.tipo,b.url
            FROM `app_veiculos` AS a
            LEFT JOIN `app_tipos_carros` AS b ON a.tipo=b.nome
            WHERE a.app_users_id='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($cor,$modelo,$placa,$tipo,$url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        $model = new Usuarios();
        $cores = $model->listCores();


        while ($row = $sql->fetch()) {

            foreach ($cores as $item) {
                if ($item['hex'] === $cor) {
                    $nomeCor = $item['nome']; // Armazena o nome da cor correspondente
                    break; // Para o loop após encontrar o valor
                }
            }
            $param['cor'] =$nomeCor;
            $param['cor_hex'] =$cor;
            $param['modelo'] = $modelo;
            $param['placa'] = $placa;
            $param['url'] = $url;
            $param['tipo'] = $tipo;
            array_push($usuarios,$param);
        }



        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function updateReajuste($id_motorista,$valor)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users_saldo` SET  saldo= saldo + '$valor' ,data='$this->data_atual'
        WHERE app_users_id='$id_motorista'"
        );
        $sql_cadastro->execute();
    }
    public function pagamentoMotorista($token)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id_motorista,b.tipo_pagamento,b.valor_motorista,b.status,b.valor_admin
            FROM `app_Orcamentos` AS a
            INNER JOIN `app_Orcamentos_pagamentos` AS b ON a.id = b.app_Orcamentos_id
            WHERE b.token = '$token'
            "
        );

        $sql->execute();
        $sql->bind_result($id_motorista,$tipo_pagamento,$valor,$status,$valor_admin);
        $sql->store_result();
        $sql->fetch();
        $sql->close();

        //pagamento em dinheiro deixa saldo devedor
        if($tipo_pagamento == 2){
            $valor = 0;
        }


        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users_saldo` SET  saldo= saldo + $valor ,data='$this->data_atual'
        WHERE app_users_id='$id_motorista'"
        );
        $sql_cadastro->execute();
        $sql_cadastro->close();


        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos_pagamentos` SET  status='RECEIVED'
        WHERE token='$token'"
        );
        $sql_cadastro->execute();
        $sql_cadastro->close();





    }

    public function corridaRifa($id_corrida,$id_sorteio_passageiro,$id_sorteio_motorista,$rifa_passageiro,$rifa_motorista)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_Orcamentos` SET  id_sorteio_passageiro='$id_sorteio_passageiro' ,id_sorteio_motorista='$id_sorteio_motorista',n_rifa_passageiro='$rifa_passageiro',n_rifa_motorista='$rifa_motorista'
        WHERE id='$id_corrida'"
        );
        $sql_cadastro->execute();

    }
    public function criaUsuarioRifa($nome,$email)
    {
        $this->ConectaWordPress();
        //verifica se usuario existe
        $sql = $this->mysqliWordPress->prepare(
            "
            SELECT customer_id
            FROM `wp_wc_customer_lookup`
            WHERE email='$email'
        "
        );
        $sql->execute();
        $sql->bind_result($customer_id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        //se nao existe um customer_id eu crio, se existe eu pego o id
        if ($rows == 0) {
            $sql_cadastro = $this->mysqliWordPress->prepare(
                "INSERT INTO `wp_wc_customer_lookup`(`first_name`, `email`, `date_last_active`)
                 VALUES ('$nome','$email','$this->data_atual')"
            );
            $sql_cadastro->execute();
            $customer_id= $sql_cadastro->insert_id;
            return $customer_id;

        } else {
            while ($row = $sql->fetch()) {
                return $customer_id;
            }
        }

    }
    public function pegaNumeroDisponivel($id_rifa)
    {
        $url = 'https://jgventerprise.com.br/wp-json/pluginrifa/v2/infos/?rifa='.$id_rifa;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($response,true);

        $livres = $json_data['livres'];
        $tentativas = 0;
        // Loop para selecionar um número disponível
        do {
            if($tentativas == 10){
                return 0;
            }
            // Sorteia uma chave aleatória do array
            $chave_sorteada = array_rand($livres);

            $item_sorteado = $livres[$chave_sorteada];

            // Verifica se o número já foi sorteado
            $verificaRedundancia = $this->verificaRifaBancoProprio($id_rifa, $item_sorteado);
            $tentativas = $tentativas + 1;
        } while ($verificaRedundancia != 0);

        // Retorna o número selecionado
        return $item_sorteado;
    }

    public function verificaRifaBancoProprio($id_rifa,$item_sorteado)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_Orcamentos`
            WHERE (id_sorteio_passageiro='$id_rifa' OR id_sorteio_motorista='$id_rifa') AND ( n_rifa_passageiro='$item_sorteado' OR n_rifa_motorista='$item_sorteado')
        "
        );
        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;
        //se for ZERO , significa q o numero esta disponivel
        return $rows;
    }

    public function geraRifa($nome,$email,$id_rifa,$celular)
    {
        $cotaEscolhida = $this->pegaNumeroDisponivel($id_rifa);
        // print("etapa1:$cotaEscolhida");
        $customer_id = $this->criaUsuarioRifa($nome,$email);
        // print("etapa2:$customer_id");
        $wp_post_id = $this->insert_wp_post();
        // print("etapa3:$wp_post_id");
        $this->insert_wp_postmeta($wp_post_id,$cotaEscolhida,$nome,$email,$celular);
        // print("etapa4");
        $order_id = $this->wp_wc_order_stats($customer_id);
        // print("etapa5:$order_id");
        $order_item_id = $this->wp_wc_order_product_lookup($customer_id,$id_rifa,$order_id);
        // print("etapa6:$order_item_id");
        $this->wp_woocommerce_order_items($order_item_id,$order_id);
        // print("etapa7");
        $this->wp_woocommerce_order_itemmeta($order_item_id,$id_rifa,$cotaEscolhida);
        // print("etapa8");
        $this->update_wp_post($id_rifa);
        // print("etapa9");
        return $cotaEscolhida;
    }
    public function update_wp_post($id_rifa)
    {
        $this->ConectaWordPress();

        $sql_cadastro = $this->mysqliWordPress->prepare("
        UPDATE `wp_postmeta` SET  meta_value= meta_value-1
        WHERE post_id='$id_rifa' AND meta_key='_stock' "
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare("
        UPDATE `wp_postmeta` SET  meta_value= meta_value+1
        WHERE post_id='$id_rifa' AND meta_key='total_sales' "
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare("
        UPDATE `wp_wc_product_meta_lookup` SET  stock_quantity= stock_quantity-1, total_sales=total_sales+1
        WHERE product_id='$id_rifa'"
        );
        $sql_cadastro->execute();
    }

    public function wp_woocommerce_order_itemmeta($order_item_id,$id_rifa,$cotaEscolhida)
    {
        $this->ConectaWordPress();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_product_id','$id_rifa')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','billing_cotasescolhidas','$cotaEscolhida')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_variation_id','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_qty','1')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_tax_class','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_line_subtotal','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_line_subtotal_tax','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_line_total','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_line_tax','0')"
        );
        $sql_cadastro->execute();

        // $meta_value = 'a:2:{s:5:"total";a:0:{}s:8:"subtotal";a:0:{}}';
        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_itemmeta`(`order_item_id`, `meta_key`, `meta_value`)
                VALUES ('$order_item_id','_line_tax_data','')"
        );
        $sql_cadastro->execute();
    }


    public function wp_woocommerce_order_items($order_item_id,$order_id)
    {
        $this->ConectaWordPress();
        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_woocommerce_order_items`(`order_item_id`, `order_item_name`, `order_item_type`, `order_id`)
                VALUES ('$order_item_id','POP TRIP','line_item','$order_id')"
        );
        $sql_cadastro->execute();
    }
    public function wp_wc_order_product_lookup($customer_id,$id_rifa,$order_id)
    {
        $this->ConectaWordPress();
        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_wc_order_product_lookup`(`order_id`, `product_id`, `variation_id`, `customer_id`, `date_created`,`product_qty`)
                VALUES ('$order_id','$id_rifa','0','$customer_id','$this->data_atual','1')"
        );
        $sql_cadastro->execute();
        $id= $sql_cadastro->insert_id;
        return $id;
    }
    public function wp_wc_order_stats($customer_id)
    {
        $this->ConectaWordPress();
        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_wc_order_stats`(`date_created`, `date_created_gmt`, `date_paid`, `num_items_sold`, `returning_customer`,`status`,`customer_id`)
                VALUES ('$this->data_atual','$this->data_atual','$this->data_atual','1','0','wc-processing','$customer_id')"
        );
        $sql_cadastro->execute();
        $id= $sql_cadastro->insert_id;
        return $id;
    }

    public function insert_wp_post()
    {
        $this->ConectaWordPress();
        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_posts`(`post_author`, `post_date`, `post_date_gmt`,`post_content`, `post_title`,`post_excerpt`, `post_status`, `comment_status`,`ping_status`,`post_password`,
            `post_name`,`to_ping`,`pinged`,`post_modified`,`post_modified_gmt`,`post_content_filtered`,`post_parent`,`guid`,`menu_order`,`post_type`,`post_mime_type`,`comment_count`)
                VALUES ('1','$this->data_atual','$this->data_atual','','Order &ndash; TOPCAR','','wc-processing','open','closed','',
                'pedido-jan-01-1970-1200-am','','','$this->data_atual','$this->data_atual','','0','','0','shop_order','','0')"
        );
        $sql_cadastro->execute();


        // $sql_cadastro = $this->mysqliWordPress->prepare(
        //     "INSERT INTO `wp_posts`(`post_author`, `post_date`, `post_date_gmt`, `post_title`, `post_status`, `comment_status`,`ping_status`,
        //     `post_name`,`post_modified`,`post_modified_gmt`,`post_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        // );
        // $sql_cadastro->bind_param('issssssssss', '1', $this->data_atual, $this->data_atual,'Order &ndash; TOPCAR','wc-processing','open','closed',
        // 'pedido-jan-01-1970-1200-am',$this->data_atual,$this->data_atual,'shop_order');
        // $sql_cadastro->execute();

        $id_post= $sql_cadastro->insert_id;
        return $id_post;
    }

    public function insert_wp_postmeta($wp_post_id,$cotaEscolhida,$nome,$email,$celular)
    {
        $this->ConectaWordPress();
        $timestamp = time();


        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_customer_user','0')"
        );
        $sql_cadastro->execute();


        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_date_paid','$timestamp')"
        );
        $sql_cadastro->execute();


        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_download_permissions_granted','no')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_recorded_sales','no')"
        );
        $sql_cadastro->execute();


        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_recorded_coupon_usage_counts','no')"
        );
        $sql_cadastro->execute();


        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_new_order_email_sent','false')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_stock_reduced','no')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_currency','BRL')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_shipping_tax','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_tax','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_total','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_order_version','7.9.0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_prices_include_tax','no')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_address_index','')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_shipping_address_index','')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_paid_date','$this->data_atual')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_cart_discount','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_cart_discount_tax','0')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','billing_cotasescolhidas','$cotaEscolhida')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_first_name','$nome')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_last_name','')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_email','$email')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_phone','$celular')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_cellphone','$celular')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_billing_billing_cotasescolhidas','$cotaEscolhida')"
        );
        $sql_cadastro->execute();

        $sql_cadastro = $this->mysqliWordPress->prepare(
            "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`)
                VALUES ('$wp_post_id','_edit_lock','$timestamp:1')"
        );
        $sql_cadastro->execute();

    }

    public function verificaPixPago($paymentid)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT status
            FROM `app_Orcamentos_pagamentos`
            WHERE token='$paymentid'
        "
        );
        $sql->execute();
        $sql->bind_result($status);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;
        $lista = [];
        if($status == 'RECEIVED'){
            $Param['status'] = '01';
            $Param['msg'] = 'O pagamento foi identificado!';
            array_push($lista, $Param);
        }else{
            $Param['status'] = '02';
            $Param['msg'] = 'O pagamento  não foi identificado!';
            array_push($lista, $Param);

        }

        // print_r($usuarios);exit;
        return $lista;
    }

    public function verificaBloqueio($id_motorista,$id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_bloqueados`
            WHERE id_passageiro='$id_user' AND id_motorista='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($motorista_lat,$motorista_long);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $motorista = [];

        return $rows;

        // print_r($usuarios);exit;

    }

    /**
     * Busca reservas de um anúncio específico (para iCal)
     */
    public function getReservasAnuncio($id_anuncio)
    {
        $sql = $this->mysqli->prepare(
            "SELECT r.id, r.data_in, r.data_out, r.data_cadastro, u.nome as nome_hospede
             FROM app_reservas r
             LEFT JOIN app_users u ON r.app_users_id = u.id
             WHERE r.app_anuncios_id = ? AND r.status = 1
             ORDER BY r.data_in ASC"
        );
        $sql->bind_param("i", $id_anuncio);
        $sql->execute();
        $result = $sql->get_result();
        
        $reservas = [];
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
        
        return $reservas;
    }

    // ==================== ICAL EXTERNO (IMPORTAÇÃO) ====================

    /**
     * Adiciona um link iCal externo (Airbnb, Booking, etc)
     * 
     * @param int $id_anuncio ID do anúncio
     * @param int $id_type ID do quarto/tipo (0 = anúncio inteiro)
     * @param string $nome Nome da plataforma
     * @param string $url URL do calendário iCal
     */
    public function adicionarIcalExterno($id_anuncio, $id_type, $nome, $url)
    {
        // Se id_type for 0 ou vazio, salva como NULL (anúncio inteiro)
        $id_type_value = ($id_type > 0) ? $id_type : null;
        
        $stmt = $this->mysqli->prepare(
            "INSERT INTO `app_ical_links` (`app_anuncios_id`, `app_anuncios_types_id`, `nome`, `url`, `data_cadastro`) 
             VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param("iiss", $id_anuncio, $id_type_value, $nome, $url);
        $stmt->execute();
        $id = $stmt->insert_id;
        
        return [
            "status" => "01",
            "id" => $id,
            "id_type" => $id_type_value,
            "msg" => "Link iCal adicionado com sucesso."
        ];
    }

    /**
     * Remove um link iCal externo
     */
    public function removerIcalExterno($id_link, $id_anuncio)
    {
        // Primeiro remove os bloqueios associados
        $stmt = $this->mysqli->prepare(
            "DELETE FROM `app_ical_bloqueios` WHERE `app_ical_links_id` = ?"
        );
        $stmt->bind_param("i", $id_link);
        $stmt->execute();
        
        // Depois remove o link
        $stmt = $this->mysqli->prepare(
            "DELETE FROM `app_ical_links` WHERE `id` = ? AND `app_anuncios_id` = ?"
        );
        $stmt->bind_param("ii", $id_link, $id_anuncio);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return [
                "status" => "01",
                "msg" => "Link iCal removido com sucesso."
            ];
        }
        
        return [
            "status" => "02",
            "msg" => "Link não encontrado."
        ];
    }

    /**
     * Lista links iCal externos de um anúncio
     * 
     * @param int $id_anuncio ID do anúncio
     * @param int|null $id_type ID do quarto/tipo (null = todos)
     */
    public function listarIcalExterno($id_anuncio, $id_type = null)
    {
        $sql = "SELECT l.id, l.app_anuncios_types_id as id_type, l.nome, l.url, 
                       l.ultima_sincronizacao, l.status, l.erros, l.ultimo_erro, l.data_cadastro,
                       t.titulo as nome_type
                FROM `app_ical_links` l
                LEFT JOIN `app_anuncios_types` t ON l.app_anuncios_types_id = t.id
                WHERE l.`app_anuncios_id` = ?";
        
        if ($id_type !== null) {
            if ($id_type == 0) {
                $sql .= " AND l.app_anuncios_types_id IS NULL";
            } else {
                $sql .= " AND l.app_anuncios_types_id = ?";
            }
        }
        
        $sql .= " ORDER BY l.data_cadastro DESC";
        
        $stmt = $this->mysqli->prepare($sql);
        
        if ($id_type !== null && $id_type > 0) {
            $stmt->bind_param("ii", $id_anuncio, $id_type);
        } else {
            $stmt->bind_param("i", $id_anuncio);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $links = [];
        while ($row = $result->fetch_assoc()) {
            $links[] = $row;
        }
        
        return $links;
    }

    /**
     * Busca bloqueios importados de um anúncio
     * 
    /**
     * Retorna bloqueios importados via iCal (todos os quartos ou um específico)
     * @param int $id_anuncio ID do anúncio
     * @param int|null $id_type ID do quarto/tipo (null = todos)
     */
    public function getBloqueiosIcal($id_anuncio, $id_type = null)
    {
        $sql = "SELECT b.*, l.nome as plataforma, l.app_anuncios_types_id as id_type,
                       t.titulo as nome_type
                FROM `app_ical_bloqueios` b
                INNER JOIN `app_ical_links` l ON b.app_ical_links_id = l.id
                LEFT JOIN `app_anuncios_types` t ON l.app_anuncios_types_id = t.id
                WHERE b.app_anuncios_id = ? AND b.data_fim >= CURDATE()";
        
        if ($id_type !== null) {
            if ($id_type == 0) {
                $sql .= " AND b.app_anuncios_types_id IS NULL";
            } else {
                $sql .= " AND b.app_anuncios_types_id = ?";
            }
        }
        
        $sql .= " ORDER BY b.data_inicio ASC";
        
        $stmt = $this->mysqli->prepare($sql);
        
        if ($id_type !== null && $id_type > 0) {
            $stmt->bind_param("ii", $id_anuncio, $id_type);
        } else {
            $stmt->bind_param("i", $id_anuncio);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $bloqueios = [];
        while ($row = $result->fetch_assoc()) {
            $bloqueios[] = $row;
        }
        
        return $bloqueios;
    }

    /**
     * Conta quantos types/quartos um anúncio possui
     */
    public function countTypesAnuncio($id_anuncio)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT COUNT(*) as total FROM `app_anuncios_types` WHERE `app_anuncios_id` = ?"
        );
        $stmt->bind_param("i", $id_anuncio);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return intval($row['total']);
    }

    /**
     * Verifica se um type/quarto pertence a um anúncio
     */
    public function verificarTypePertenceAnuncio($id_type, $id_anuncio)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT COUNT(*) as total FROM `app_anuncios_types` WHERE `id` = ? AND `app_anuncios_id` = ?"
        );
        $stmt->bind_param("ii", $id_type, $id_anuncio);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] > 0;
    }

    // ==================== UNIDADES DE TIPOS/QUARTOS ====================

    /**
     * Obtém a quantidade de unidades de um tipo (da tabela app_anuncios_valor)
     */
    public function getQtdUnidadesTipo($id_type)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT COALESCE(MAX(qtd), 1) as qtd FROM `app_anuncios_valor` WHERE `app_anuncios_types_id` = ?"
        );
        $stmt->bind_param("i", $id_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return intval($row['qtd']) ?: 1;
    }

    /**
     * Garante que as unidades existam para um tipo
     */
    public function garantirUnidadesTipo($id_type)
    {
        $qtd = $this->getQtdUnidadesTipo($id_type);
        
        $stmt = $this->mysqli->prepare(
            "SELECT COUNT(*) as total FROM `app_anuncios_types_unidades` WHERE `app_anuncios_types_id` = ?"
        );
        $stmt->bind_param("i", $id_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $existentes = intval($row['total']);
        
        if ($existentes < $qtd) {
            for ($i = $existentes + 1; $i <= $qtd; $i++) {
                $stmt = $this->mysqli->prepare(
                    "INSERT INTO `app_anuncios_types_unidades` (`app_anuncios_types_id`, `numero`, `nome`, `status`) 
                     VALUES (?, ?, ?, 1)"
                );
                $nome = "Unidade " . $i;
                $stmt->bind_param("iis", $id_type, $i, $nome);
                $stmt->execute();
            }
        }
        
        return $qtd;
    }

    /**
     * Lista todas as unidades de um tipo de quarto
     */
    public function listarUnidadesTipo($id_type)
    {
        $this->garantirUnidadesTipo($id_type);
        
        $stmt = $this->mysqli->prepare(
            "SELECT u.*, 
                    (SELECT COUNT(*) FROM `app_ical_links` WHERE `app_anuncios_types_unidades_id` = u.id AND `status` = 1) as links_ical
             FROM `app_anuncios_types_unidades` u
             WHERE u.`app_anuncios_types_id` = ? AND u.`status` = 1
             ORDER BY u.`numero` ASC"
        );
        $stmt->bind_param("i", $id_type);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $unidades = [];
        while ($row = $result->fetch_assoc()) {
            $unidades[] = $row;
        }
        
        return $unidades;
    }

    /**
     * Lista todos os tipos de um anúncio com suas unidades
     */
    public function listarTypesComUnidades($id_anuncio)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT t.id, t.nome as nome_type, t.descricao,
                    COALESCE(MAX(v.qtd), 1) as qtd_unidades
             FROM `app_anuncios_types` t
             LEFT JOIN `app_anuncios_valor` v ON t.id = v.app_anuncios_types_id
             WHERE t.`app_anuncios_id` = ? AND t.`status` = 1
             GROUP BY t.id
             ORDER BY t.id ASC"
        );
        $stmt->bind_param("i", $id_anuncio);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $types = [];
        while ($row = $result->fetch_assoc()) {
            $row['unidades'] = $this->listarUnidadesTipo($row['id']);
            $types[] = $row;
        }
        
        return $types;
    }

    /**
     * Verifica se uma unidade pertence a um tipo
     */
    public function verificarUnidadePertenceTipo($id_unidade, $id_type)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT COUNT(*) as total FROM `app_anuncios_types_unidades` 
             WHERE `id` = ? AND `app_anuncios_types_id` = ? AND `status` = 1"
        );
        $stmt->bind_param("ii", $id_unidade, $id_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] > 0;
    }

    /**
     * Adiciona link iCal externo vinculado a uma unidade específica
     */
    public function adicionarIcalExternoUnidade($id_anuncio, $id_type, $id_unidade, $nome, $url)
    {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO `app_ical_links` 
             (`app_anuncios_id`, `app_anuncios_types_id`, `app_anuncios_types_unidades_id`, `nome`, `url`, `status`, `erros`, `data_cadastro`) 
             VALUES (?, ?, ?, ?, ?, 1, 0, NOW())"
        );
        $stmt->bind_param("iiiss", $id_anuncio, $id_type, $id_unidade, $nome, $url);
        
        if ($stmt->execute()) {
            return [
                'status' => '01',
                'id' => $stmt->insert_id,
                'id_type' => $id_type,
                'id_unidade' => $id_unidade,
                'msg' => 'Link iCal adicionado com sucesso para a unidade.'
            ];
        }
        
        return ['status' => '00', 'msg' => 'Erro ao adicionar link iCal: ' . $stmt->error];
    }
}
