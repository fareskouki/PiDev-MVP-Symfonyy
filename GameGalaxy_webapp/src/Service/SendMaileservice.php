<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMaileservice
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $contexte
    ):void{
        //creationde l'email
        $email= (new TemplatedEmail())->from($from)
        ->to($to)
        ->subject($subject)
        ->htmlTemplate("email/$template.html.twig")
        ->context($contexte);
        //enovie de mail
        $this->mailer->send($email);
    }
}