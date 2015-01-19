<?php

/**
 * PHP version 5.5
 *
 * @category Listener
 * @package  Mails
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */

namespace ZCEPracticeTest\Mails\Listener;

use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZCEPracticeTest\Core\Event\SessionEvent;
use ZCEPracticeTest\Mails\Service\MailFactory;

/**
 * Send emails after some events
 * 
 * @category Listener
 * @package  Mails
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class EventsListener implements EventSubscriberInterface
{
    /**
     * @var MailFactory
     */
    private $mailFactory;
    
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    
    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(MailFactory $mailFactory, Swift_Mailer $mailer)
    {
        $this->mailFactory = $mailFactory;
        $this->mailer = $mailer;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            SessionEvent::SESSION_ENDED => array(
                'onSessionEnded',
            ),
        );
    }
    
    /**
     * @param SessionEvent $event
     */
    public function onSessionEnded(SessionEvent $event)
    {
        $session = $event->getSession();
        $user = $session->getUser();
        
        $message = $this->mailFactory
            ->createTemplateMail('Session terminée', '@mails/session-ended.html.twig', array(
                'user'      => $user,
                'session'   => $session,
            ))
            ->setTo(array($user->getEmail() => $user->getDisplayName()))
        ;

        $this->mailer->send($message);
    }
}
