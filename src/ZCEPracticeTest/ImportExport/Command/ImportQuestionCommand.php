<?php

namespace ZCEPracticeTest\ImportExport\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManager;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\ImportExport\Service\QuestionImport;

class ImportQuestionCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @var QuestionImport
     */
    private $questionImport;
    
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, QuestionImport $questionImport)
    {
        parent::__construct();
        
        $this->em = $em;
        $this->questionImport = $questionImport;
    }
    
    protected function configure()
    {
        $this
            ->setName('import:question')
            ->setDescription('Import questions from csv file to database')
            ->addArgument('file')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Do the import')
            ->addOption('skip-header', null, InputOption::VALUE_NONE, 'Skip the first line')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('file');
        
        if (!is_file($filename)) {
            throw new \Exception(realpath($filename).' is not a file.');
        }
        
        if (!file_exists($filename)) {
            throw new \Exception('File '.realpath($filename).' not found.');
        }
        
        if (!is_readable($filename)) {
            throw new \Exception('File '.realpath($filename).' not readable.');
        }
        
        $fp = fopen($input->getArgument('file'), 'r');
        
        $questions = $this->questionImport->processFile($fp, $input->getOption('skip-header'));
        
        $output->writeln('');
        $output->writeln(count($questions).' questions found.');
        $output->writeln('');
        
        if ($output->getVerbosity() > OutputInterface::VERBOSITY_NORMAL) {
            foreach ($questions as $question) {
                $output->writeln($this->displayQuestion($question));
            }
        }
        
        $output->writeln('');
        
        if ($input->getOption('force')) {
            foreach ($questions as $question) {
                $this->em->persist($question);
            }
            
            $this->em->flush();
            
            $output->writeln('Questions have been persisted.');
        } else {
            $output->writeln('Nothing have been persisted.');
            $output->writeln('Add option --force to persist questions into database.');
        }
    }
    
    private function displayQuestion(Question $question)
    {
        $s = '';
        
        $s .= ($question->getType() === Question::TYPE_QCM) ? 'QCM   ' : 'FREE  ';
        $s .= str_pad(substr($question->getTopic()->getEntitled(), 0, 8), 10);
        $s .= str_pad(substr($question->getEntitled(), 0, 50).(strlen($question->getEntitled()) > 50 ? '...' : ''), 55);
        
        if ($question->getType() === Question::TYPE_QCM) {
            $s .= count($question->getQuestionQCMChoices()).' choices, choose '.$question->getNbAnswers();
        }
        
        if ($question->getType() === Question::TYPE_FREE) {
            $s .= '"'.$question->getFreeAnswer().'"';
        }
        
        return $s;
    }
}
