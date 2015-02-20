<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Front\Controller;

use Symfony\Component\HttpFoundation\Response;
use Assetic\AssetManager;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Asset\AssetCache;
use Assetic\Filter\JSMinFilter;
use Assetic\Cache\FilesystemCache;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class AssetController
{
    /**
     * @var string
     */
    private $rootDir;
    
    /**
     * @var string
     */
    private $cacheDir;
    
    /**
     *
     * @var type @var bool
     */
    private $debug;
    
    /**
     * @param string $rootDir
     * @param string $cacheDir
     * @param bool $debug
     */
    public function __construct($rootDir, $cacheDir, $debug)
    {
        $this->rootDir = $rootDir;
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
    }
    
    /**
     * @param string $extension
     * 
     * @return Response
     */
    public function jsAction($extension)
    {
        $jsFilters = array();
        
        if ('min.js' === $extension) {
            $jsFilters []= new JSMinFilter();
        }
        
        $js = new AssetCollection(array(
            new FileAsset($this->rootDir . '/web/ng-front/app.js'),
            new GlobAsset($this->rootDir . '/web/ng-front/config/*.js'),
            new GlobAsset($this->rootDir . '/web/ng-front/services/*.js'),
            new GlobAsset($this->rootDir . '/web/ng-front/controllers/*.js'),
        ), $jsFilters);
        
        $cachedJs = new AssetCache($js, new FilesystemCache($this->cacheDir . '/assetic'));

        $response = new Response();
        
        $response->setContent($cachedJs->dump());
        
        return $response;
    }
}
