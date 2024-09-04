<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

class MailerService
{  
    public function __construct(private MailerInterface $mailer , private TransportInterface $transport)
    {
    }

    public function sendEmail(
        $to,
        $content ,
        $subject = 'le sujet',
    ) {

 $email = (new Email())
            ->from("tayouprofessionnel@gmail.com")
            ->to($to)
            ->subject($subject)
            ->text('le text')
            ->html($content);
           
            try {
                $this->transport->send($email);
                return true;
            } catch (TransportExceptionInterface $e) {
                echo 'Erreur d\'envoi de mail : ' . $e->getMessage();
                return false;
            }
        
     
    }
}
