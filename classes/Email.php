<?php 

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];

        $phpmailer->setFrom('cuentas@taskflow.com');
        $phpmailer->addAddress('cuentas@taskflow.com', 'taskflow.com');
        $phpmailer->Subject = 'Confirma tu cuenta';

        //Set HTML
        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>" . $this->nombre . "</strong> has creado una cuenta en TaskFlow, solo debes confirmarla en el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] ."/confirmar?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= '</html>';

        $phpmailer->Body = $contenido;
        //Enviar correo
        $phpmailer->send();
    }

    public function enviarInstrucciones() {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];

        $phpmailer->setFrom('cuentas@taskflow.com');
        $phpmailer->addAddress('cuentas@taskflow.com', 'taskflow.com');
        $phpmailer->Subject = 'Reestablecer tu contraseña';

        //Set HTML
        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>". $this->nombre ."</strong> has solicitado reestablecer la contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] ."/reestablecer?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= '</html>';

        $phpmailer->Body = $contenido;
        //Enviar correo
        $phpmailer->send();
    }
}


?>