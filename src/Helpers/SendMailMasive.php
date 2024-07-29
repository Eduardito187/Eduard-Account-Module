<?php

namespace Eduard\Account\Helpers;

use Exception;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;

class SendMailMasive
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $headers = [];

    public function __construct(string $title, string $to, string $template)
    {
        $this->to = $to;
        $this->title = $title;
        $this->message = $this->renderView("mail.mailing", ["name" => $title, "template" => $template]);
        $this->setHeaders();
        $this->createMail();
    }

    protected function setHeaders()
    {
        $this->headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: EduardSearch <eduard-search@grazcompany.com>',
            'Reply-To: eduard-search@grazcompany.com',
            'X-Mailer: PHP/' . phpversion()
        ];
    }

    protected function renderView($view, $data)
    {
        if (View::exists($view)) {
            return View::make($view, $data)->render();
        }

        throw new Exception("View {$view} not found");
    }

    public function createMail()
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'eduard-search@grazcompany.com';
            $mail->Password = '13011973_Tati';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Timeout = 300;
            $mail->SMTPKeepAlive = true;

            // Configuración del remitente y destinatario
            $mail->setFrom('eduard-search@grazcompany.com', 'EduardSearch');
            $mail->addAddress($this->to, 'Destinatario');

            // Configuración del contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $this->title;
            $mail->Body = $this->message;
            $mail->WordWrap = 120;

            // Adjuntar archivos (opcional)
            // $mail->addAttachment('/path/to/file');

            $mail->send();
            Log::info('Correo enviado exitosamente.');
        } catch (Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
?>