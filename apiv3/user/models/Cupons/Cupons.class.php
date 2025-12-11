<?php

require_once MODELS . '/Conexao/Conexao.class.php';

class Cupons extends Conexao
{

    public function __construct()
    {
        $this->Conecta();
        $this->tabela = "app_cupons";
        $this->tabela_uso = "app_cupons_uso";
        $this->data_atual = date('Y-m-d H:i:s');
        $this->data = date('Y-m-d');
    }

    /**
     * Criar novo cupom
     */
    public function criar($id_user, $id_anuncio, $codigo, $descricao, $tipo_desconto, $valor_desconto, $valor_minimo, $uso_maximo, $uso_por_usuario, $data_inicio, $data_fim, $categorias)
    {
        // Verifica se o código já existe
        if ($this->codigoExiste($codigo)) {
            return [
                "status" => "02",
                "msg" => "Este código de cupom já está em uso."
            ];
        }

        $codigo = strtoupper(trim($codigo));
        $categorias_str = is_array($categorias) ? implode(',', $categorias) : $categorias;

        $sql = $this->mysqli->prepare(
            "INSERT INTO {$this->tabela} 
            (app_users_id, app_anuncios_id, codigo, descricao, tipo_desconto, valor_desconto, valor_minimo, uso_maximo, uso_por_usuario, data_inicio, data_fim, categorias, data_cadastro)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $sql->bind_param(
            "iissiiddissss",
            $id_user,
            $id_anuncio,
            $codigo,
            $descricao,
            $tipo_desconto,
            $valor_desconto,
            $valor_minimo,
            $uso_maximo,
            $uso_por_usuario,
            $data_inicio,
            $data_fim,
            $categorias_str,
            $this->data_atual
        );

        $sql->execute();

        if ($sql->affected_rows > 0) {
            return [
                "status" => "01",
                "id" => $sql->insert_id,
                "msg" => "Cupom criado com sucesso."
            ];
        }

        return [
            "status" => "02",
            "msg" => "Erro ao criar cupom."
        ];
    }

    /**
     * Atualizar cupom
     */
    public function atualizar($id, $id_user, $codigo, $descricao, $tipo_desconto, $valor_desconto, $valor_minimo, $uso_maximo, $uso_por_usuario, $data_inicio, $data_fim, $categorias, $ativo)
    {
        // Verifica se o cupom pertence ao usuário
        if (!$this->pertenceAoUsuario($id, $id_user)) {
            return [
                "status" => "02",
                "msg" => "Cupom não encontrado ou sem permissão."
            ];
        }

        // Verifica se o código já existe em outro cupom
        $cupom_existente = $this->buscarPorCodigo($codigo);
        if ($cupom_existente && $cupom_existente['id'] != $id) {
            return [
                "status" => "02",
                "msg" => "Este código de cupom já está em uso."
            ];
        }

        $codigo = strtoupper(trim($codigo));
        $categorias_str = is_array($categorias) ? implode(',', $categorias) : $categorias;

        $sql = $this->mysqli->prepare(
            "UPDATE {$this->tabela} SET 
            codigo = ?, 
            descricao = ?, 
            tipo_desconto = ?, 
            valor_desconto = ?, 
            valor_minimo = ?, 
            uso_maximo = ?, 
            uso_por_usuario = ?, 
            data_inicio = ?, 
            data_fim = ?, 
            categorias = ?,
            ativo = ?
            WHERE id = ? AND app_users_id = ?"
        );

        $sql->bind_param(
            "ssiiddiissiii",
            $codigo,
            $descricao,
            $tipo_desconto,
            $valor_desconto,
            $valor_minimo,
            $uso_maximo,
            $uso_por_usuario,
            $data_inicio,
            $data_fim,
            $categorias_str,
            $ativo,
            $id,
            $id_user
        );

        $sql->execute();

        return [
            "status" => "01",
            "msg" => "Cupom atualizado com sucesso."
        ];
    }

    /**
     * Excluir cupom (soft delete - apenas desativa)
     */
    public function excluir($id, $id_user)
    {
        if (!$this->pertenceAoUsuario($id, $id_user)) {
            return [
                "status" => "02",
                "msg" => "Cupom não encontrado ou sem permissão."
            ];
        }

        $sql = $this->mysqli->prepare(
            "UPDATE {$this->tabela} SET ativo = 0 WHERE id = ? AND app_users_id = ?"
        );
        $sql->bind_param("ii", $id, $id_user);
        $sql->execute();

        return [
            "status" => "01",
            "msg" => "Cupom excluído com sucesso."
        ];
    }

    /**
     * Listar cupons do parceiro
     */
    public function listarPorParceiro($id_user, $ativo = null)
    {
        if ($ativo !== null) {
            $sql = $this->mysqli->prepare(
                "SELECT c.*, 
                (SELECT COUNT(*) FROM {$this->tabela_uso} WHERE app_cupons_id = c.id) as total_usos,
                a.nome as nome_anuncio
                FROM {$this->tabela} c
                LEFT JOIN app_anuncios a ON c.app_anuncios_id = a.id
                WHERE c.app_users_id = ? AND c.ativo = ?
                ORDER BY c.data_cadastro DESC"
            );
            $sql->bind_param("ii", $id_user, $ativo);
        } else {
            $sql = $this->mysqli->prepare(
                "SELECT c.*, 
                (SELECT COUNT(*) FROM {$this->tabela_uso} WHERE app_cupons_id = c.id) as total_usos,
                a.nome as nome_anuncio
                FROM {$this->tabela} c
                LEFT JOIN app_anuncios a ON c.app_anuncios_id = a.id
                WHERE c.app_users_id = ?
                ORDER BY c.data_cadastro DESC"
            );
            $sql->bind_param("i", $id_user);
        }

        $sql->execute();
        $result = $sql->get_result();

        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $row['tipo_desconto_label'] = $row['tipo_desconto'] == 1 ? 'percentual' : 'valor_fixo';
            $row['valido'] = $this->cupomValido($row);
            $row['categorias_array'] = $row['categorias'] ? explode(',', $row['categorias']) : [];
            $lista[] = $row;
        }

        return $lista;
    }

    /**
     * Listar cupons por anúncio
     */
    public function listarPorAnuncio($id_anuncio)
    {
        $sql = $this->mysqli->prepare(
            "SELECT * FROM {$this->tabela} 
            WHERE (app_anuncios_id = ? OR app_anuncios_id IS NULL)
            AND ativo = 1
            AND data_inicio <= ?
            AND data_fim >= ?
            ORDER BY valor_desconto DESC"
        );

        $sql->bind_param("iss", $id_anuncio, $this->data, $this->data);
        $sql->execute();
        $result = $sql->get_result();

        $lista = [];
        while ($row = $result->fetch_assoc()) {
            if ($this->cupomValido($row)) {
                $lista[] = $row;
            }
        }

        return $lista;
    }

    /**
     * Buscar cupom por ID
     */
    public function buscarPorId($id)
    {
        $sql = $this->mysqli->prepare(
            "SELECT * FROM {$this->tabela} WHERE id = ?"
        );
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Buscar cupom por código
     */
    public function buscarPorCodigo($codigo)
    {
        $codigo = strtoupper(trim($codigo));

        $sql = $this->mysqli->prepare(
            "SELECT c.*, u.nome as nome_parceiro, a.nome as nome_anuncio
            FROM {$this->tabela} c
            LEFT JOIN app_users u ON c.app_users_id = u.id
            LEFT JOIN app_anuncios a ON c.app_anuncios_id = a.id
            WHERE c.codigo = ?"
        );
        $sql->bind_param("s", $codigo);
        $sql->execute();
        $result = $sql->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Validar cupom para uso
     */
    public function validarCupom($codigo, $id_user, $id_anuncio, $id_categoria, $valor_reserva)
    {
        $cupom = $this->buscarPorCodigo($codigo);

        if (!$cupom) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Cupom não encontrado."
            ];
        }

        // Verifica se está ativo
        if ($cupom['ativo'] != 1) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom está inativo."
            ];
        }

        // Verifica datas
        if ($this->data < $cupom['data_inicio']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom ainda não está válido. Válido a partir de " . date('d/m/Y', strtotime($cupom['data_inicio']))
            ];
        }

        if ($this->data > $cupom['data_fim']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom expirou em " . date('d/m/Y', strtotime($cupom['data_fim']))
            ];
        }

        // Verifica se é para um anúncio específico
        if ($cupom['app_anuncios_id'] && $cupom['app_anuncios_id'] != $id_anuncio) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom não é válido para este anúncio."
            ];
        }

        // IMPORTANTE: Verifica se o anúncio pertence ao dono do cupom
        // Cupom só pode ser usado em anúncios do mesmo parceiro que o criou
        $sql_anuncio = $this->mysqli->prepare(
            "SELECT app_users_id FROM app_anuncios WHERE id = ?"
        );
        $sql_anuncio->bind_param("i", $id_anuncio);
        $sql_anuncio->execute();
        $result_anuncio = $sql_anuncio->get_result();
        $anuncio = $result_anuncio->fetch_assoc();

        if (!$anuncio) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Anúncio não encontrado."
            ];
        }

        if ($anuncio['app_users_id'] != $cupom['app_users_id']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom não é válido para este anúncio."
            ];
        }

        // Verifica categoria
        if ($cupom['categorias']) {
            $categorias_permitidas = explode(',', $cupom['categorias']);
            if (!in_array($id_categoria, $categorias_permitidas)) {
                $cat_nomes = ['1' => 'hospedagens', '2' => 'experiências', '3' => 'eventos'];
                return [
                    "status" => "02",
                    "valido" => false,
                    "msg" => "Este cupom é válido apenas para: " . implode(', ', array_map(function($c) use ($cat_nomes) {
                        return $cat_nomes[$c] ?? $c;
                    }, $categorias_permitidas))
                ];
            }
        }

        // Verifica valor mínimo
        if ($cupom['valor_minimo'] > 0 && $valor_reserva < $cupom['valor_minimo']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Valor mínimo para usar este cupom é R$ " . number_format($cupom['valor_minimo'], 2, ',', '.')
            ];
        }

        // Verifica uso máximo total
        if ($cupom['uso_maximo'] && $cupom['usos_realizados'] >= $cupom['uso_maximo']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Este cupom atingiu o limite de usos."
            ];
        }

        // Verifica uso por usuário
        $usos_usuario = $this->contarUsosPorUsuario($cupom['id'], $id_user);
        if ($cupom['uso_por_usuario'] && $usos_usuario >= $cupom['uso_por_usuario']) {
            return [
                "status" => "02",
                "valido" => false,
                "msg" => "Você já utilizou este cupom o número máximo de vezes permitido."
            ];
        }

        // Calcula o desconto
        $valor_desconto = $this->calcularDesconto($cupom, $valor_reserva);
        $valor_final = $valor_reserva - $valor_desconto;

        if ($valor_final < 0) {
            $valor_final = 0;
            $valor_desconto = $valor_reserva;
        }

        return [
            "status" => "01",
            "valido" => true,
            "msg" => "Cupom válido!",
            "cupom" => [
                "id" => $cupom['id'],
                "codigo" => $cupom['codigo'],
                "descricao" => $cupom['descricao'],
                "tipo_desconto" => $cupom['tipo_desconto'],
                "tipo_desconto_label" => $cupom['tipo_desconto'] == 1 ? 'percentual' : 'valor_fixo',
                "valor_desconto_config" => $cupom['valor_desconto']
            ],
            "valores" => [
                "valor_original" => number_format($valor_reserva, 2, '.', ''),
                "valor_desconto" => number_format($valor_desconto, 2, '.', ''),
                "valor_final" => number_format($valor_final, 2, '.', '')
            ]
        ];
    }

    /**
     * Aplicar cupom na reserva (registra o uso)
     */
    public function aplicarCupom($id_cupom, $id_user, $id_reserva, $valor_original, $valor_desconto, $valor_final)
    {
        // Registra o uso
        $sql = $this->mysqli->prepare(
            "INSERT INTO {$this->tabela_uso} 
            (app_cupons_id, app_users_id, app_reservas_id, valor_original, valor_desconto, valor_final, data_uso)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $sql->bind_param(
            "iiiddds",
            $id_cupom,
            $id_user,
            $id_reserva,
            $valor_original,
            $valor_desconto,
            $valor_final,
            $this->data_atual
        );

        $sql->execute();

        // Incrementa o contador de usos
        $sql_update = $this->mysqli->prepare(
            "UPDATE {$this->tabela} SET usos_realizados = usos_realizados + 1 WHERE id = ?"
        );
        $sql_update->bind_param("i", $id_cupom);
        $sql_update->execute();

        return [
            "status" => "01",
            "msg" => "Cupom aplicado com sucesso."
        ];
    }

    /**
     * Histórico de uso de cupons do parceiro
     */
    public function historicoUsoParceiro($id_user)
    {
        $sql = $this->mysqli->prepare(
            "SELECT u.*, c.codigo, c.descricao as cupom_descricao, 
            usr.nome as nome_cliente, usr.email as email_cliente,
            a.nome as nome_anuncio
            FROM {$this->tabela_uso} u
            INNER JOIN {$this->tabela} c ON u.app_cupons_id = c.id
            INNER JOIN app_users usr ON u.app_users_id = usr.id
            LEFT JOIN app_reservas r ON u.app_reservas_id = r.id
            LEFT JOIN app_anuncios a ON r.app_anuncios_id = a.id
            WHERE c.app_users_id = ?
            ORDER BY u.data_uso DESC"
        );

        $sql->bind_param("i", $id_user);
        $sql->execute();
        $result = $sql->get_result();

        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $row['data_uso_formatada'] = date('d/m/Y H:i', strtotime($row['data_uso']));
            $lista[] = $row;
        }

        return $lista;
    }

    /**
     * Histórico de cupons usados pelo cliente
     */
    public function historicoUsoCliente($id_user)
    {
        $sql = $this->mysqli->prepare(
            "SELECT u.*, c.codigo, c.descricao as cupom_descricao,
            a.nome as nome_anuncio
            FROM {$this->tabela_uso} u
            INNER JOIN {$this->tabela} c ON u.app_cupons_id = c.id
            LEFT JOIN app_reservas r ON u.app_reservas_id = r.id
            LEFT JOIN app_anuncios a ON r.app_anuncios_id = a.id
            WHERE u.app_users_id = ?
            ORDER BY u.data_uso DESC"
        );

        $sql->bind_param("i", $id_user);
        $sql->execute();
        $result = $sql->get_result();

        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $row['data_uso_formatada'] = date('d/m/Y H:i', strtotime($row['data_uso']));
            $lista[] = $row;
        }

        return $lista;
    }

    // ============ MÉTODOS AUXILIARES ============

    private function codigoExiste($codigo)
    {
        $codigo = strtoupper(trim($codigo));
        $sql = $this->mysqli->prepare(
            "SELECT id FROM {$this->tabela} WHERE codigo = ?"
        );
        $sql->bind_param("s", $codigo);
        $sql->execute();
        $sql->store_result();

        return $sql->num_rows > 0;
    }

    private function pertenceAoUsuario($id, $id_user)
    {
        $sql = $this->mysqli->prepare(
            "SELECT id FROM {$this->tabela} WHERE id = ? AND app_users_id = ?"
        );
        $sql->bind_param("ii", $id, $id_user);
        $sql->execute();
        $sql->store_result();

        return $sql->num_rows > 0;
    }

    private function cupomValido($cupom)
    {
        if ($cupom['ativo'] != 1) return false;
        if ($this->data < $cupom['data_inicio']) return false;
        if ($this->data > $cupom['data_fim']) return false;
        if ($cupom['uso_maximo'] && $cupom['usos_realizados'] >= $cupom['uso_maximo']) return false;

        return true;
    }

    private function contarUsosPorUsuario($id_cupom, $id_user)
    {
        $sql = $this->mysqli->prepare(
            "SELECT COUNT(*) as total FROM {$this->tabela_uso} WHERE app_cupons_id = ? AND app_users_id = ?"
        );
        $sql->bind_param("ii", $id_cupom, $id_user);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row['total'] ?? 0;
    }

    private function calcularDesconto($cupom, $valor_reserva)
    {
        if ($cupom['tipo_desconto'] == 1) {
            // Percentual
            return $valor_reserva * ($cupom['valor_desconto'] / 100);
        } else {
            // Valor fixo
            return $cupom['valor_desconto'];
        }
    }
}
