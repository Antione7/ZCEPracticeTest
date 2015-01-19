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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Credits\Exception\CreditsSystemException;
use ZCEPracticeTest\Credits\Service\CreditsManager;

/**
 * @category Listener
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class CreditUseListener implements EventSubscriberInterface
{
    /**
     * @var CreditsManager
     */
    private $creditsManager;
    
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * @param CreditsManager $creditsManager
     * @param ObjectManager $om
     */
    public function __construct(CreditsManager $creditsManager, ObjectManager $om)
    {
        $this->creditsManager = $creditsManager;
        $this->om = $om;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                'onKernelRequest',
            ),
            KernelEvents::RESPONSE => array(
                'onKernelResponse',
            ),
        );
    }
    
    /**
     * Return whether route need a credit
     * 
     * @param string $routeName
     * @return boolean
     */
    private static function routeNeedsCredit($routeName)
    {
        return in_array($routeName, array(
            'api-post-session',
        ));
    }
    
    /**
     * If this request needs a credit,
     * check if user has at least one credit.
     * 
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $routeName = $request->get('_route');
        
        if (self::routeNeedsCredit($routeName)) {
            if (!$this->creditsManager->hasCredits()) {
                $event->setResponse(self::createDenyResponse());
            }
        }
    }
    
    /**
     * If this request needs a credit,
     * check if user has at least one credit,
     * and use a credit if request has no errors.
     * 
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $routeName = $request->get('_route');
        $response = $event->getResponse();
        
        if (self::routeNeedsCredit($routeName)) {
            if (!($response instanceof JsonResponse)) {
                throw new CreditsSystemException('Rest api response is not a JsonReponse');
            }
            
            $data = json_decode($response->getContent());
            
            if (!$data->ok) {
                return;
            }
            
            if ($this->creditsManager->hasCredits()) {
                $this->creditsManager->useCredits();
                $this->updateCredits();
            } else {
                $event->setResponse(self::createDenyResponse());
            }
        }
    }
    
    /**
     * Persist and flush updated credits data
     */
    private function updateCredits()
    {
        $credits = $this->creditsManager->getCredits();
        $this->om->persist($credits);
        $this->om->flush();
    }
    
    /**
     * Return a deny response from credits system
     * 
     * @return JsonResponse
     */
    private static function createDenyResponse()
    {
        return new JsonResponse(array(
            'ok' => false,
            'reason' => 'need.credit',
        ));
    }
}
