<?php

namespace App\Service;

use App\Entity\Contact;
use Twig\Environment;

class ContactService{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        $message = (new \Swift_Message($contact->getType()))
            ->setFrom('noreply@food.fr')
            ->setTo('foodadvisor.services@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig',[
                'contact' => $contact
            ]),'text/html');
        $this->mailer->send($message);
    }
}