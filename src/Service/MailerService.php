<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{  
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(
        $to = "wilfriedtayou6@gmail.com",
        $content = 'le fichier html',
        $subject = 'le sujet',
    ) {

 $email = (new Email())
            ->from("contact.tayoufom@protonmail.com")
            ->to($to)
            ->subject($subject)
            ->text('le text')
            ->html($content);
            
            try {
                $this->mailer->send($email);
                return true;
            } catch (TransportExceptionInterface $e) {
                // some error prevented the email sending; display an
                // error message or try to resend the message
                error_log("Erreur rencotrer : ".$e->getMessage);
                return false;
            }
        
     
    }
}
