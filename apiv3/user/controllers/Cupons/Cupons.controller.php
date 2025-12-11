<?php

require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Cupons/Cupons.class.php';

class CuponsController
{

    public function __construct()
    {
        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
    }

    /**
     * Criar novo cupom (Parceiro)
     * POST /cupons/criar
     */
    public function criar()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $id_anuncio = $this->input->id_anuncio ?? null;
        $categorias = $this->input->categorias ?? null;
        $uso_maximo = $this->input->uso_maximo ?? null;
        $uso_por_usuario = $this->input->uso_por_usuario ?? 1;
        $valor_minimo = $this->input->valor_minimo ?? 0;

        $result = $model->criar(
            $this->input->id_user,
            $id_anuncio,
            $this->input->codigo,
            $this->input->descricao ?? '',
            $this->input->tipo_desconto,
            $this->input->valor_desconto,
            $valor_minimo,
            $uso_maximo,
            $uso_por_usuario,
            $this->input->data_inicio,
            $this->input->data_fim,
            $categorias
        );

        jsonReturn(array($result));
    }

    /**
     * Atualizar cupom (Parceiro)
     * POST /cupons/atualizar
     */
    public function atualizar()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $categorias = $this->input->categorias ?? null;
        $uso_maximo = $this->input->uso_maximo ?? null;
        $uso_por_usuario = $this->input->uso_por_usuario ?? 1;
        $valor_minimo = $this->input->valor_minimo ?? 0;
        $ativo = $this->input->ativo ?? 1;

        $result = $model->atualizar(
            $this->input->id,
            $this->input->id_user,
            $this->input->codigo,
            $this->input->descricao ?? '',
            $this->input->tipo_desconto,
            $this->input->valor_desconto,
            $valor_minimo,
            $uso_maximo,
            $uso_por_usuario,
            $this->input->data_inicio,
            $this->input->data_fim,
            $categorias,
            $ativo
        );

        jsonReturn(array($result));
    }

    /**
     * Excluir cupom (Parceiro)
     * POST /cupons/excluir
     */
    public function excluir()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $result = $model->excluir(
            $this->input->id,
            $this->input->id_user
        );

        jsonReturn(array($result));
    }

    /**
     * Listar cupons do parceiro
     * POST /cupons/listar
     */
    public function listar()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $ativo = isset($this->input->ativo) ? $this->input->ativo : null;

        $result = $model->listarPorParceiro(
            $this->input->id_user,
            $ativo
        );

        jsonReturn($result);
    }

    /**
     * Listar cupons disponíveis para um anúncio (Cliente)
     * POST /cupons/disponiveis
     */
    public function disponiveis()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $result = $model->listarPorAnuncio($this->input->id_anuncio);

        // Remove informações sensíveis
        $cupons_publicos = array_map(function($cupom) {
            return [
                'codigo' => $cupom['codigo'],
                'descricao' => $cupom['descricao'],
                'tipo_desconto' => $cupom['tipo_desconto'],
                'tipo_desconto_label' => $cupom['tipo_desconto'] == 1 ? 'percentual' : 'valor_fixo',
                'valor_desconto' => $cupom['valor_desconto'],
                'valor_minimo' => $cupom['valor_minimo'],
                'data_fim' => date('d/m/Y', strtotime($cupom['data_fim']))
            ];
        }, $result);

        jsonReturn($cupons_publicos);
    }

    /**
     * Validar cupom (Cliente)
     * POST /cupons/validar
     */
    public function validar()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $result = $model->validarCupom(
            $this->input->codigo,
            $this->input->id_user,
            $this->input->id_anuncio,
            $this->input->id_categoria,
            $this->input->valor
        );

        jsonReturn(array($result));
    }

    /**
     * Buscar detalhes de um cupom (Parceiro)
     * POST /cupons/detalhes
     */
    public function detalhes()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $cupom = $model->buscarPorId($this->input->id);

        if (!$cupom) {
            jsonReturn(array([
                "status" => "02",
                "msg" => "Cupom não encontrado."
            ]));
            return;
        }

        // Verifica se pertence ao usuário
        if ($cupom['app_users_id'] != $this->input->id_user) {
            jsonReturn(array([
                "status" => "02",
                "msg" => "Sem permissão para acessar este cupom."
            ]));
            return;
        }

        $cupom['tipo_desconto_label'] = $cupom['tipo_desconto'] == 1 ? 'percentual' : 'valor_fixo';
        $cupom['data_inicio_formatada'] = date('d/m/Y', strtotime($cupom['data_inicio']));
        $cupom['data_fim_formatada'] = date('d/m/Y', strtotime($cupom['data_fim']));
        $cupom['categorias_array'] = $cupom['categorias'] ? explode(',', $cupom['categorias']) : [];

        jsonReturn(array([
            "status" => "01",
            "cupom" => $cupom
        ]));
    }

    /**
     * Histórico de uso dos cupons do parceiro
     * POST /cupons/historico
     */
    public function historico()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $result = $model->historicoUsoParceiro($this->input->id_user);

        jsonReturn($result);
    }

    /**
     * Histórico de cupons usados pelo cliente
     * POST /cupons/meus-cupons
     */
    public function meusCupons()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $result = $model->historicoUsoCliente($this->input->id_user);

        jsonReturn($result);
    }

    /**
     * Estatísticas de cupons do parceiro
     * POST /cupons/estatisticas
     */
    public function estatisticas()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cupons();

        $cupons = $model->listarPorParceiro($this->input->id_user);
        $historico = $model->historicoUsoParceiro($this->input->id_user);

        $total_cupons = count($cupons);
        $cupons_ativos = count(array_filter($cupons, fn($c) => $c['ativo'] == 1 && $c['valido']));
        $total_usos = count($historico);
        $total_desconto = array_sum(array_column($historico, 'valor_desconto'));

        $result = [
            "status" => "01",
            "estatisticas" => [
                "total_cupons" => $total_cupons,
                "cupons_ativos" => $cupons_ativos,
                "total_usos" => $total_usos,
                "total_desconto_concedido" => number_format($total_desconto, 2, '.', ''),
                "total_desconto_formatado" => "R$ " . number_format($total_desconto, 2, ',', '.')
            ]
        ];

        jsonReturn(array($result));
    }
}
