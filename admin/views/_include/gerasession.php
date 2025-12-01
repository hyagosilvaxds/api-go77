<?php
      $request = file_get_contents('php://input');
      $input = json_decode($request);

      if(isset($input->id)) {
            session_cache_expire(180);
            session_start();

            $_SESSION['skipit_id'] = $input->id;
            $_SESSION['id_grupo'] = $input->id_grupo;
            $_SESSION['avatar'] = $input->avatar;
            
      }
?>
