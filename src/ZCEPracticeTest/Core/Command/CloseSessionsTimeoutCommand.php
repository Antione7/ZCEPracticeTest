<?php

namespace ZCEPracticeTest\Core\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManager;

class CloseSessionsTimeoutCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param SessionRepository $sessionRepository
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct();
        
        $this->em = $em;
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
        $nbClosedSessions = 0;

        $sessionRepository = $this->em->getRepository('ZCE:Session');
    	$sessions = $sessionRepository->findAll();
    	
    	for($i = 0; $i < count($sessions); $i++){
    	    $dateStart = $sessions[$i]->getDateStart();
    	    $diff = ($now->getTimestamp() - $dateStart->getTimestamp())/60;
    	    if(is_null($sessions[$i]->getDateFinished()) && $diff > 90 && $sessions[$i]->getStatus() !== 2){
    	        $sessions[$i]->setStatus(2);
    	        $nbClosedSessions++;
    	    }
        }
           
    	if($nbClosedSessions > 0){
    	    $this->em->flush();
    	    $output->writeln($nbClosedSessions.' sessions closed at '.$now->format('l, d-M-Y H:i:s T'));
    	}
    }
}