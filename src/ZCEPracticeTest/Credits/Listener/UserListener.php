<?php

/**
 * PHP version 5.5
 *
 * @category Listener
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */

namespace ZCEPracticeTest\Credits\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SimpleUser\UserEvents;
use SimpleUser\UserEvent;
use ZCEPracticeTest\Credits\Service\CreditsInitializer;

/**
 * @category Listener
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class UserListener implements EventSubscriberInterface
{
    /**
     * @var CreditsInitializer
     */
    private $creditsInitializer;
    
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * @param CreditsInitializer $creditsInitializer
     * @param ObjectManager $om
     */
    public function __construct(CreditsInitializer $creditsInitializer, ObjectManager $om)
    {
        $this->creditsInitializer = $creditsInitializer;
        $this->om = $om;
    }
    
    
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::AFTER_INSERT => array(
                'onUserCreated',
            ),
        );
    }
    
    /**
     * @param UserEvent $event
     */
    public function onUserCreated(UserEvent $event)
    {
        $user = $this->om->find('ZCE:User', $event->getUser()->getId());
        
        $credits = $this->creditsInitializer->initCreditsForUser($user);
        
        $this->om->persist($credits);
        $this->om->flush();
    }
}
