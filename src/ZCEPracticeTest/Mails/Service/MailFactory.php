<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  Mails
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Mails\Service;

use Swift_Message;
use Twig_Environment;

/**
 * @category Service
 * @package  Mails
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class MailFactory
{
    /**
     * @var Twig_Environment
     */
    private $templating;
    
    /**
     * @var array
     */
    private $mailParameters;
    
    /**
     * @param Twig_Environment $templating
     * @param array $sender
     */
    public function __construct(Twig_Environment $templating, array $mailParameters)
    {
        $this->templating = $templating;
        $this->mailParameters = $mailParameters;
    }
    
    /**
     * @param array $to
     * @param string $subject
     * @param string $body
     * 
     * @return Swift_Message
     */
    public function createStandardMail($subject)
    {
        $sender = $this->mailParameters['sender'];
        $subjectTag = $this->mailParameters['subjectTag'];
        
        $message = Swift_Message::newInstance()
            ->setSubject(($subjectTag ? "[$subjectTag] " : '').$subject)
            ->setFrom(array($sender['email'] => $sender['name']))
        ;
        
        return $message;
    }
    
    /**
     * @param string $subject
     * @param string $template
     * @param array $variables
     * 
     * @return Swift_Message
     */
    public function createTemplateMail($subject, $template, array $variables = array())
    {
        $message = $this->createStandardMail($subject);
        
        $message
            ->setBody($this->templating->render($template, $variables))
            ->setContentType('text/html')
        ;
        
        return $message;
    }
}
