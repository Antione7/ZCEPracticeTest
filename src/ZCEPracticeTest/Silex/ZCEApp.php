<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\Yaml\Yaml;
use Silex\Application;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use SimpleUser\UserServiceProvider;
use ZCEPracticeTest\Core\Service\QuestionManager;
use ZCEPracticeTest\Core\Service\QuizFactory;
use ZCEPracticeTest\Core\Service\ZCPEQuizFactory;
use ZCEPracticeTest\Core\Service\AnswerFactory;
use ZCEPracticeTest\Silex\Provider\RestAPIProvider;
use ZCEPracticeTest\Silex\Provider\FrontProvider;
use ZCEPracticeTest\Silex\Provider\CreditsSystemProvider;
use ZCEPracticeTest\Silex\Provider\MailsProvider;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        
        $this->loadParameters();
        $this->loadConfig();
        $this->registerProviders();
        $this->registerDoctrineDBAL($this['parameters']['database']);
        $this->registerDoctrineORM();
        $this->registerServices();
        $this->registerSimpleUser();
        $this->registerRestAPI();
        $this->registerFront();
        $this->registerCreditsSystem();
        $this->registerMails();
        $this->registerRoutes();
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
        $this->register(new \Silex\Provider\SwiftmailerServiceProvider(), array(
            'swiftmailer.options' => $this['parameters']['swiftmailer'],
        ));
        $this->register(new \Silex\Provider\TranslationServiceProvider());
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
                    
                    /**
                     * SimpleUser mapping (register superclass SimpleUser\User)
                     */
                    array(
                        'type' => 'yml',
                        'namespace' => 'ZCEPracticeTest\Credits\Entity',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Credits/Resources/doctrine',
                        'alias' => 'ZCECredits',
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
        
        $this['zce.core.answer_factory'] = $this->share(function () {
            return new AnswerFactory(
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
        $this->register(new FrontProvider());
    }
    
    private function registerCreditsSystem()
    {
        $this->register(new CreditsSystemProvider());
    }
    
    private function registerMails()
    {
        $this->register(new MailsProvider());
    }
    
    /**
     * Register routes from a configuration file
     * If a error exists (404 or 500) an appropriate response is send,
     * and if the called page is /, the user is redirected to the home of default language
     * 
     * @return RouteCollection|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function registerRoutes()
    {
        $this['routes'] = $this->extend('routes', function (RouteCollection $routes, Application $app) {
            $loader     = new YamlFileLoader(new FileLocator($app['project.root'] . '/app/config'));
            $collection = $loader->load('routes.yml');
            $routes->addCollection($collection);
        
            return $routes;
        });
        
        $this->error(function (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                
                if ('/' === $this['request']->getRequestUri()) {
                    return $this->redirect('/' . $this['locale'] . '/');
                }
                
                return new Response('The requested page could not be found. ' . $this['request']->getRequestUri(), 404);
            }

            $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
            return new Response('We are sorry, but something went terribly wrong.' . $e->getMessage(), $code);
        });
    }
}
