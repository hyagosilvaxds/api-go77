<?php


require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
require_once HELPERS . '/HorariosHelper.class.php';


class Horarios extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->helper = new HorariosHelper();
        $this->tabela = "app_users_horarios";
    }

    public function listDias($id_user)
    {

        $sql = $this->mysqli->prepare("SELECT id, day, status
        FROM `app_atendimento_day`
        WHERE app_users_id ='$id_user'
        ORDER BY day ASC
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->day, $this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                if ($this->day == 7) {
                    $this->day_nome = 'Domingo';
                } elseif ($this->day == 1) {
                    $this->day_nome = 'Segunda';
                } elseif ($this->day == 2) {
                    $this->day_nome = 'Terça';
                } elseif ($this->day == 3) {
                    $this->day_nome = 'Quarta';
                } elseif ($this->day == 4) {
                    $this->day_nome = 'Quinta';
                } elseif ($this->day == 5) {
                    $this->day_nome = 'Sexta';
                } elseif ($this->day == 6) {
                    $this->day_nome = 'Sábado';
                }

                $Param['id'] = $this->id;
                $Param['day'] = $this->day;
                $Param['day_nome'] = $this->day_nome;
                $Param['status'] = $this->status;

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function deleteHorario($id) {
       
        $sql = $this->mysqli->prepare("DELETE FROM `app_atendimento_times` WHERE id = '$id'");
        $sql->execute();
        $linhas_afetadas = $sql->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Horário deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o horário"
            ];
        }

        return $param;
    }
    public function changeStatus($id) {
        
        $sql = $this->mysqli->prepare("
        UPDATE `app_atendimento_day` 
        SET `status`= CASE
        WHEN status='1' THEN '2'
        ELSE '1' END
         WHERE id='$id'"
        );
        $sql->execute();
        $linhas_afetadas = $sql->affected_rows;
        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Status alterado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao alterar o status"
            ];
        }
        return $param;
    }
    public function listhorarios($id_day)
    {

        $sql = $this->mysqli->prepare("SELECT id, horario_in, horario_out
        FROM `app_atendimento_times`
        WHERE app_atendimento_day_id ='$id_day'
        ORDER BY horario_out ASC
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->horario_in, $this->horario_out);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $this->id;
                $Param['horario_in'] = $this->horario_in;
                $Param['horario_out'] = $this->horario_out;

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function savehorarios($day, $horario_in,$horario_out)
    {   

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_atendimento_times`(`app_atendimento_day_id`, `horario_in`, `horario_out`)
            VALUES (
                '$day', '$horario_in','$horario_out'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        if($this->id_cadastro>0){
        $Param = [
            "status" => "01",
            "msg" => "Horário adicionado",
            "id" => $this->id_cadastro
        ];
        }else{
        $Param = [
            "status" => "02",
            "msg" => "Falha ao salvar",
            "id" => $this->id_cadastro
        ];
        }

        return $Param;
    }
    public function updatehorarios($id,$horario_in,$horario_out) {
        
        $sql = $this->mysqli->prepare("
        UPDATE `app_atendimento_times` 
        SET `horario_in`= '$horario_in',`horario_out`= '$horario_out'
         WHERE id='$id'"
        );
        $sql->execute();
        $linhas_afetadas = $sql->affected_rows;
        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Horário alterado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao alterar o horário"
            ];
        }
        return $param;
    }


  
}
