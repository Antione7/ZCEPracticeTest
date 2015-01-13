<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\Yaml\Yaml;
use Silex\Application;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use SimpleUser\UserServiceProvider;
use ZCEPracticeTest\Core\Service\QuestionManager;
use ZCEPracticeTest\Core\Service\QuizFactory;
use ZCEPracticeTest\Core\Service\ZCPEQuizFactory;
use ZCEPracticeTest\Silex\Provider\RestAPIProvider;
use ZCEPracticeTest\Silex\Provider\FrontProvider;

class ZCEApp extends Application
{
    /**
     * Constructor
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        
        $this['controllers']->value('locale', $this['locale']);
        
        $this->loadParameters();
        $this->loadConfig();
        $this->registerProviders();
        $this->registerDoctrineDBAL($this['parameters']['database']);
        $this->registerDoctrineORM();
        $this->registerServices();
        $this->registerSimpleUser();
        $this->registerRestAPI();
        $this->registerFront();
    }
    
    /**
     * Load environment parameters and inject them into application
     * 
     * @throws \Exception if not parameters file
     */
    private function loadParameters()
    {
        $parametersFile = $this['project.root'].'/app/config/parameters.yml';
        
        if (file_exists($parametersFile)) {
            $parameters = Yaml::parse($parametersFile);
        } elseif (file_exists($parametersFile.'.dist')) {
            $parameters = Yaml::parse($parametersFile.'.dist');
        } else {
            throw new \Exception('No '.$parametersFile.' file found');
        }
        
        $this['parameters'] = $parameters;
    }
    
    /**
     * Load config parameters
     * 
     * @throws \Exception if not config file
     */
    private function loadConfig()
    {
        $configFile = $this['project.root'].'/app/config/config.yml';
        
        if (file_exists($configFile)) {
            $config = Yaml::parse($configFile);
        } else {
            throw new \Exception('No '.$configFile.' file found');
        }
        
        $this['config'] = $config;
        
        $this['security.firewalls'] = $config['security']['firewalls'];
        $this['swiftmailer.options'] = $config['swiftmailer'];
    }
    
    /**
     * Register all needed providers
     */
    private function registerProviders()
    {
        $this->register(new \Silex\Provider\SecurityServiceProvider());
        $this->register(new \Silex\Provider\RememberMeServiceProvider());
        $this->register(new \Silex\Provider\SessionServiceProvider());
        $this->register(new \Silex\Provider\ServiceControllerServiceProvider());
        $this->register(new \Silex\Provider\UrlGeneratorServiceProvider());
        $this->register(new \Silex\Provider\TwigServiceProvider());
        $this->register(new \Silex\Provider\SwiftmailerServiceProvider());
        $this->register(new \Silex\Provider\TranslationServiceProvider(), $this['parameters']['translation']);
    }
    
    /**
     * Register doctrine DBAL with db parameters
     * 
     * @param array $dbParameters
     */
    public function registerDoctrineDBAL($dbParameters)
    {
        $this->register(new \Silex\Provider\DoctrineServiceProvider(), $dbParameters);
    }
    
    /**
     * Register and configure doctrine ORM
     */
    private function registerDoctrineORM()
    {
        $this->register(new DoctrineOrmServiceProvider(), array(
            'orm.proxies_dir' => $this['project.root'].'/var/cache/doctrine/proxies',
            'orm.em.options' => array(
                'mappings' => array(
                    /**
                     * Core mappings
                     */
                    array(
                        'type' => 'yml',
                        'namespace' => 'ZCEPracticeTest\Core\Entity',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Core/Resources/config/doctrine',
                        'alias' => 'ZCE',
                    ),
                    
                    /**
                     * SimpleUser mapping (register superclass SimpleUser\User)
                     */
                    array(
                        'type' => 'yml',
                        'namespace' => 'SimpleUser',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Core/Resources/config/doctrine',
                    ),
                ),
            ),
        ));
    }
    
    /**
     * Register simple user library
     * Add user management and routes.
     */
    private function registerSimpleUser()
    {
        $simpleUserProvider = new UserServiceProvider();
        
        $this->register($simpleUserProvider);
        
        $this['user.options'] = $this['config']['simple.user'];
        
        $security = $this['security.firewalls'];
        $security['secured_area']['users'] = $this->share(function ($app) {
            return $app['user.manager'];
        });
        $this['security.firewalls'] = $security;
        
        $this->mount('/user', $simpleUserProvider);
    }
    
    private function registerServices()
    {
        $this['zce.core.question_manager'] = $this->share(function () {
            return new QuestionManager();
        });
        
        $this['zce.core.quiz_factory'] = $this->share(function () {
            return new QuizFactory($this['zce.core.question_manager']);
        });
        
        $this['zce.core.zcpe_quiz_factory'] = $this->share(function () {
            return new ZCPEQuizFactory(
                $this['zce.core.quiz_factory'],
                $this['orm.em']->getRepository('ZCE:Topic'),
                $this['orm.em']->getRepository('ZCE:Question')
            );
        });
    }
    
    private function registerRestAPI()
    {
        $restAPIProvider = new RestAPIProvider();
        
        $this->register($restAPIProvider);
        $this->mount('/api', $restAPIProvider);
    }
    
    private function registerFront()
    {
        $frontProvider = new FrontProvider();
        
        $this->register($frontProvider);
        $this->mount('/', $frontProvider);
    }
}
