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
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'aa752136ef7fd4';
        $phpmailer->Password = '56b97a59d72502';

        $phpmailer->setFrom('cuentas@taskflow.com');
        $phpmailer->addAddress('cuentas@taskflow.com', 'taskflow.com');
        $phpmailer->Subject = 'Confirma tu cuenta';

        //Set HTML
        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>" . $this->nombre . "</strong> has creado una cuenta en TaskFlow, solo debes confirmarla en el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= '</html>';

        $phpmailer->Body = $contenido;
        //Enviar correo
        $phpmailer->send();
    }
}


?>