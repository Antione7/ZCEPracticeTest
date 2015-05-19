<?php

namespace ZCEPracticeTest\Core\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManager;
use ZCEPracticeTest\Core\Service\CloseSessionsTimeout;

class CloseSessionsTimeoutCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Monolog\Logger $monolog
     */
    private $monolog;

    /**
     * Constructor
     * 
     * @param SessionRepository $sessionRepository
     */
    public function __construct(EntityManager $em, \Monolog\Logger $monolog)
    {
        parent::__construct();
        
        $this->em = $em;
        $this->monolog = $monolog;
    }

    protected function configure()
    {
        $this
            ->setName('close:sessions:timeout')
            ->setDescription('Close sessions with timeout status')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        
        $closeSessionsTimeout = new CloseSessionsTimeout($this->em);
        
        $nbClosedSessions = $closeSessionsTimeout->closeSessionsTimeout();
  
    	if($nbClosedSessions > 0){

            $message = $nbClosedSessions.' sessions closed at '.$now->format('l, d-M-Y H:i:s T');
    	    
    	    $output->writeln($message);

            $this->monolog->addInfo($message);
    	}
    }
}