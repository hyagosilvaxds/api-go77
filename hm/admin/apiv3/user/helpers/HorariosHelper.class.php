<?php

require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';

/**
 * Helpers são responsáveis por todas validaçoes e regras de negócio que o Modelo pode possuir
 *
 */

class HorariosHelper extends Conexao
{

    public function __construct()
    {
        $this->Conecta();
    }

    public function diaSemana($day)
    {
        $this->dias = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
        return $this->dias[$day];
    }


    public function dias($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, day, status
        FROM app_users_horarios
        WHERE app_users_id='$id'
        GROUP BY day
        ORDER BY day
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->day, $this->status);
        $sql->store_result();

        while ($row = $sql->fetch()) {
            $param['id'] = $this->id;
            $param['day'] = $this->day;
            $param['day_nome'] = $this->diaSemana($this->day - 1);
            $param['status'] = $this->status;
            $lista[] = $param;
        }

        return $lista;
    }

    public function consultaIdFilas($id_filas_c)
    {

        $sql = $this->mysqli->prepare(
            "SELECT f.id_fila, f.id_horario, f.id_de, f.id_para, f.status, g.type
        FROM app_filas_c as f
        LEFT JOIN `app_fcm` as g ON f.id_de = g.app_users_id
        WHERE f.id='$id_filas_c'
        ORDER BY g.id DESC
        LIMIT 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_fila, $this->id_horario, $this->id_de, $this->id_para, $this->status, $this->type);
        $sql->fetch();

        $param['id_fila'] = $this->id_fila;
        $param['id_horario'] = $this->id_horario;
        $param['id_de'] = $this->id_de;
        $param['type'] = $this->type;
        $param['id_para'] = $this->id_para;
        $param['status'] = $this->status;

        $lista = $param;

        return $lista;
    }

    public function consultaIdReserva($id)
    {
        $sql = $this->mysqli->prepare(
        "SELECT f.data, f.horario, f.id_de, g.type
        FROM `app_reservas` as f
        LEFT JOIN `app_fcm` as g
        ON f.id_de = g.app_users_id
        WHERE f.id='$id'"
        );
        $sql->execute();
        $sql->bind_result($this->data, $this->horario, $this->id_de, $this->type);
        $sql->fetch();

        $param['data'] = dataBR($this->data);
        $param['horario'] = $this->horario;
        $param['id_de'] = $this->id_de;
        $param['type'] = $this->type;

        $lista = $param;

        return $lista;
    }

    public function consultaUsuariosFilas($id_filas_c, $id_fila, $id_horario, $id_para, $status, $id_de)
    {



        $sql = $this->mysqli->prepare(
        "SELECT f.id_de, f.status, f.id
        FROM app_filas_c as f
        WHERE f.id_fila='$id_fila' AND f.id_horario='$id_horario' AND f.id_para='$id_para' AND f.status='$status' AND f.id_de<>'$id_de'
        GROUP BY f.id_de
        ORDER BY f.data_cadastro ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_de, $this->status, $this->id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $i = 1;
        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $gcm = New Gcm();
                $result = $gcm->consultaTypeAfter($this->id_de);


                $Param['posicao'] = $i;
                $Param['id'] = $this->id;
                $Param['id_de'] = $this->id_de;
                $Param['status'] = $this->status;
                $Param['type'] = $result[0]['type'];
                $Param['id_fcm'] = $result[0]['id'];
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
                $i++;
            }
        }
        return $usuarios;
    }

    public function consultaDia()
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
}
