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
use ZCEPracticeTest\Credits\Service\CreditsManager;
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
     * @var CreditsManager
     */
    private $creditsManager;
    
    /**
     * @var string
     */
    private $locale;
    
    /**
     * @param MailFactory $mailFactory
     * @param Swift_Mailer $mailer
     * @param CreditsManager $creditsManager
     * @param string $locale
     */
    public function __construct(MailFactory $mailFactory, Swift_Mailer $mailer, CreditsManager $creditsManager, $locale)
    {
        $this->mailFactory = $mailFactory;
        $this->mailer = $mailer;
        $this->creditsManager = $creditsManager;
        $this->locale = $locale;
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
        $subject = [
            'en' => 'Session ended',
            'fr' => 'Session terminée',
            'pt' => 'Sessão terminada'
        ];
        $this->locale = $event->getLocale();
        $session = $event->getSession();
        $user = $session->getUser();
        $credits = $this->creditsManager->getCredits();
        
        $message = $this->mailFactory
            ->createTemplateMail($subject[$this->locale], '@mails/session-ended.'.$this->locale.'.html.twig', array(
                'user'      => $user,
                'session'   => $session,
                'credits'   => $credits,
            ))
            ->setTo(array($user->getEmail() => $user->getDisplayName()))
        ;

        $this->mailer->send($message);
    }
}
