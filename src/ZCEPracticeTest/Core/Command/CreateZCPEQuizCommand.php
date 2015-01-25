<?php

namespace ZCEPracticeTest\Core\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use ZCEPracticeTest\Core\Service\ZCPEQuizFactory;

class CreateZCPEQuizCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @var ZCPEQuizFactory
     */
    private $zcpeQuizFactory;
    
    /**
     * @param EntityManagerInterface $em
     * @param ZCPEQuizFactory $zcpeQuizFactory
     */
    public function __construct(EntityManagerInterface $em, ZCPEQuizFactory $zcpeQuizFactory)
    {
        parent::__construct();
        
        $this->em = $em;
        $this->zcpeQuizFactory = $zcpeQuizFactory;
    }
    
    protected function configure()
    {
        $this
            ->setName('create:zcpe:quiz')
            ->setDescription('Create and persist a zcpe quiz')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Set a name to the quiz')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Creating ZCPE quiz...        ');
        
        $zcpeQuiz = $this->zcpeQuizFactory->createStandardZCPEQuiz();
        
        if ($input->hasOption('name')) {
            $name = $input->getOption('name');
            
            if (strlen($name) > 0) {
                $zcpeQuiz->setName($name);
            }
        }
        
        $output->writeln('[OK]');
        
        $output->write('Saving quiz into database... ');
        
        $this->em->persist($zcpeQuiz);
        $this->em->flush();
        
        $output->writeln('[OK]');
        
        $output->writeln('');
        $output->write('ZCPE quiz created');
        
        if (null === $zcpeQuiz->getName()) {
            $output->writeln('.');
        } else {
            $output->writeln(' with name "'.$zcpeQuiz->getName().'".');
        }
    }
}
