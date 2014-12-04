<?php

namespace ZCEPracticeTest\Core\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use ZCEPracticeTest\Silex\Console\ZCECommand;

class LoadFixturesCommand extends ZCECommand
{
    protected function configure()
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Purge database and load fixtures')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $loader = new Loader();
        $em = $app['orm.em'];
        
        $output->writeln('');
        
        $loader->loadFromDirectory(__DIR__.'/../DataFixtures/ORM');
        $fixtures = $loader->getFixtures();
        
        foreach ($fixtures as $fixture) {
            $output->writeln('Found '.get_class($fixture));
        }
        
        $output->writeln('');
        $output->writeln('Purge database...');
        
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        
        $output->writeln('Load fixtures...');
        $output->writeln('');
        
        $executor->execute($fixtures);
        
        $output->writeln('done.');
    }
}
