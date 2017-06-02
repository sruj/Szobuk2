<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-14
 * Time: 17:55
 */

namespace AppBundle\EventListener;

use AppBundle\Event\PurchasePlacedEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Swift_Mailer;

class SendEmailNotificationToClientListener
{
    private $twig;
    private $session;

    public function __construct(Swift_Mailer $mailer,\Twig_Environment $twig, Session $session )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->session = $session;
    }

    public function onPurchasePlaced(PurchasePlacedEvent $event)
    {
        $body = $this->renderTemplate($event);
        $mailTo = $event->getPurchase()->getIdclient()->getEmail();
        $messageToKlient = $this->setMessage($mailTo, $body);
        $this->mailer->send($messageToKlient);
    }

    private function renderTemplate($event)
    {
        return $this->twig->render(
            'AppBundle:Cart:mail_confirmation.html.twig',
            array(
                'order'=>$event->getPurchase(),
                'produkty'=>$event->getPurchase()->getPurchaseProducts(),
                'suma'=>$this->session->get('sum')
            )
        );
    }

    /**
     * @param $mailTo
     * @param $body
     * @return mixed
     */
    protected function setMessage($mailTo, $body)
    {
        return $messageToKlient = \Swift_Message::newInstance()
            ->setSubject('Księgarnia Szobuk - potwierdzenie zamówienia')
            ->setFrom('send@example.com')
            ->setTo($mailTo)
            ->setBody($body, 'text/html')
            ->addPart($body, 'text/plain');
    }
}