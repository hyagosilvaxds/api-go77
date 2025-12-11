<?php

require_once MODELS . '/phpMailer/class.phpmailer.php';

class Emails extends PHPMailer
{

  public function cadastro($email, $nome, $pass)
  {

    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    // $this->email_remetente = EMAIL_REMETENTE;
    $this->email_remetente = 'contato@apsmais.com.br';
    $mail->From = 'contato@apsmais.com.br'; // Seu e-mail
    $mail->FromName = "Seja bem-vindo | ApsMais"; // Seu nome
    $mail->AddAddress($email); //E-mail Destinatario
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->Subject = "Seja bem-vindo" . " | APS Mais"; // Assunto da mensagem
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    $mail->Body .= "Sua senha é: " . $pass . " <br/><br/> ";
    $mail->Body .= "Após efetuar o login, altere sua senha.<br/><br/> ";
    $mail->Body .= "Atenciosamente, <br/> ";
    $mail->Body .= "Equipe ApsMais, <br/><br/> ";
    // $mail->Body .= "<img src='".LOGO_EMAIL."' width='120'>";
    $mail->Send();
  }

  public function lembrete($email, $nome, $data)
  {


    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    $this->email_remetente = "contato@app5m.com.br";
    $mail->From = "diogocosta.js@gmail.com"; // Seu e-mail
    $mail->FromName = "Lembrete de consulta"; // Seu nome
    $mail->AddAddress($email); //E-mail Destinatario
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->Subject = "Lembrete de consulta" . " | " . NOME_REMETENTE; // Assunto da mensagem
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    $mail->Body .= "Não esqueça sua consulta dia " . $data . "<br /><br />";
    $mail->Body .= "Atenciosamente, <br/> ";
    $mail->Body .= "Equipe Gabrielli consultório, <br/><br/> ";
    // $mail->Body .= "<img src='".LOGO_EMAIL."' width='120'>";
    $mail->Send();
  }

  public function recuperarsenha($email, $nome, $token)
  {


    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    $this->email_remetente = EMAIL_REMETENTE;
    $mail->From = EMAIL_REMETENTE; // Seu e-mail
    $mail->FromName = "Recuperar Senha | " . NOME_REMETENTE; // Seu nome
    $this->link = LINK_RECUPERAR_SENHA . $token;
    $mail->AddAddress($email); //E-mail Destinatario
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->Subject = "Olá," . " | " . ucwords($nome); // Assunto da mensagem
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    $mail->Body .= "Você perdeu sua senha?.<br />";
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    $mail->Body .= "Sua senha é: " . $token . " <br/><br/> ";
    $mail->Body .= "Após efetuar o login, altere sua senha.<br/><br/> ";
    $mail->Body .= "Atenciosamente, <br/> ";
    $mail->Body .= "Equipe Bae Digital, <br/><br/> ";
    //$mail->Body .= "<img src='" . LOGO_EMAIL . "' width='120'>";
    $mail->Send();
  }

  /* public function recuperarsenha($email, $nome, $token)
  {

    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    $this->email_remetente = EMAIL_REMETENTE;
    $mail->From = EMAIL_REMETENTE; // Seu e-mail
    $mail->FromName = "Recuperar Senha | " . NOME_REMETENTE; // Seu nome
    $this->link = LINK_RECUPERAR_SENHA . $token;
    $mail->AddAddress($email); //E-mail Destinatario
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->Subject = "Olá," . " | " . ucwords($nome); // Assunto da mensagem
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    $mail->Body .= "Você perdeu sua senha?.<br />";
    $mail->Body .= "<strong>Para redefinir sua senha, basta clicar no link abaixo.<br /><br />";
    $mail->Body .= "<strong><a href='$this->link'>Clique aqui</a><br /><br />";
    $mail->Body .= "Atenciosamente, <br/> ";
    $mail->Body .= "Equipe Bae Digital, <br/><br/> ";
    //$mail->Body .= "<img src='" . LOGO_EMAIL . "' width='120'>";
    $mail->Send();
  }*/

  public function confirmarcadastro($email, $nome, $token)
  {

    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    $this->email_remetente = EMAIL_REMETENTE;
    $mail->From = EMAIL_REMETENTE; // Seu e-mail
    $mail->FromName = "Confirmar cadastro | " . NOME_REMETENTE; // Seu nome
    $this->link = LINK_CONFIRMAR . $token;
    $mail->AddAddress($email); //E-mail Destinatario
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->Subject = "Olá, " . ucwords($nome); // Assunto da mensagem
    $mail->Body .= "Prezado(a) <strong>" . ucwords($nome) . "</strong>, <br/><br/>";
    //$mail->Body .= "Você perdeu sua senha?.<br />";
    $mail->Body .= "<strong>Para confirmar sua conta, basta clicar no link abaixo.<br /><br />";
    $mail->Body .= "<strong><a href='$this->link'>Clique aqui</a><br /><br />";
    $mail->Body .= "Atenciosamente, <br/> ";
    $mail->Body .= "Equipe Bae Digital, <br/><br/> ";
    //$mail->Body .= "<img src='" . LOGO_EMAIL . "' width='120'>";
    $mail->Send();
  }

  /**
   * Enviar ingresso por email
   * @param string $email - Email do destinatário
   * @param string $nome - Nome do portador do ingresso
   * @param array $dados_ingresso - Dados do ingresso (nome_evento, data_evento, local, tipo_ingresso, qrcode, valor)
   */
  public function enviarIngresso($email, $nome, $dados_ingresso)
  {
    $mail = new PHPMailer();
    $mail->IsMail(true);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->From = EMAIL_REMETENTE;
    $mail->FromName = "Seu Ingresso | " . NOME_REMETENTE;
    $mail->AddAddress($email);
    $mail->IsHTML(true);
    $mail->Subject = "🎫 Seu ingresso para " . $dados_ingresso['nome_evento'];

    // Gerar QR Code como imagem base64 (usando API externa)
    $qrcode_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($dados_ingresso['qrcode']);

    // Template HTML do ingresso
    $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .ticket-container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .ticket-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .ticket-header h1 { margin: 0; font-size: 24px; }
        .ticket-header p { margin: 10px 0 0; opacity: 0.9; }
        .ticket-body { padding: 30px; }
        .ticket-info { margin-bottom: 20px; }
        .ticket-info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; }
        .ticket-info-label { color: #888; font-size: 14px; }
        .ticket-info-value { color: #333; font-weight: bold; font-size: 14px; }
        .qrcode-section { text-align: center; padding: 20px; background: #f9f9f9; border-radius: 8px; margin: 20px 0; }
        .qrcode-section img { width: 180px; height: 180px; }
        .qrcode-section p { margin: 10px 0 0; color: #666; font-size: 12px; }
        .ticket-footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888; }
        .portador-destaque { background: #e8f5e9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4caf50; }
        .portador-destaque strong { color: #2e7d32; font-size: 18px; }
      </style>
    </head>
    <body>
      <div class="ticket-container">
        <div class="ticket-header">
          <h1>🎫 ' . htmlspecialchars($dados_ingresso['nome_evento']) . '</h1>
          <p>Ingresso Digital</p>
        </div>
        
        <div class="ticket-body">
          <div class="portador-destaque">
            <span style="color:#666;font-size:12px;">PORTADOR DO INGRESSO</span><br>
            <strong>' . htmlspecialchars(ucwords($nome)) . '</strong>
          </div>
          
          <div class="ticket-info">
            <div class="ticket-info-row">
              <span class="ticket-info-label">📅 Data do Evento</span>
              <span class="ticket-info-value">' . htmlspecialchars($dados_ingresso['data_evento']) . '</span>
            </div>
            <div class="ticket-info-row">
              <span class="ticket-info-label">📍 Local</span>
              <span class="ticket-info-value">' . htmlspecialchars($dados_ingresso['local']) . '</span>
            </div>
            <div class="ticket-info-row">
              <span class="ticket-info-label">🎟️ Tipo de Ingresso</span>
              <span class="ticket-info-value">' . htmlspecialchars($dados_ingresso['tipo_ingresso']) . '</span>
            </div>
            <div class="ticket-info-row">
              <span class="ticket-info-label">💰 Valor</span>
              <span class="ticket-info-value">R$ ' . number_format($dados_ingresso['valor'], 2, ',', '.') . '</span>
            </div>
          </div>
          
          <div class="qrcode-section">
            <img src="' . $qrcode_url . '" alt="QR Code do Ingresso">
            <p>Apresente este QR Code na entrada do evento</p>
          </div>
        </div>
        
        <div class="ticket-footer">
          <p>Este é um ingresso digital. Guarde este email e apresente o QR Code na entrada.</p>
          <p><strong>Importante:</strong> Este ingresso é pessoal e intransferível.</p>
          <p>' . NOME_REMETENTE . '</p>
        </div>
      </div>
    </body>
    </html>';

    return $mail->Send();
  }
}

