<?php

namespace App\Core\Mail;

class SendMail
{

    public static function send($to, $title, $mess)
    {
        $transport = \Swift_SmtpTransport::newInstance('smtp.mail', 465, 'ssl')
            ->setUsername('ist70')
            ->setPassword('');

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
            ->setFrom('ist70@mail.ru')
            ->setTo($to)
            ->setSubject($title)
            ->setBody($mess);

        return $mailer->send($message);
    }

}
