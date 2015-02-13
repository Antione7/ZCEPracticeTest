<?php

namespace ZCEPracticeTest\Twig;

/**
 * Twig extension to generate and return content based
 * on the translation method (with Twig or AngularJS)
 *
 * @author cgrandval
 */
class BasedOnTranslationMethodExtension extends \Twig_Extension
{
    /**
     * Translator object
     * @var \Symfony\Component\Translation\Translator $translator
     */
    protected $translator;

    /**
     * Request object
     * @var \Symfony\Component\HttpFoundation\Request $request
     */
    protected $request;

    /**
     * 
     * @param \Silex\Application $app
     * @param \Symfony\Component\Translation\Translator $translator
     */
    public function __construct (\Silex\Application $app)
    {
        $this->translator = $app['translator'];
        $this->request = $app['request'];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "basedOnTranslationMethod";
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array (
            "flagBasedOnTranslationMethod" => new \Twig_Function_Method($this, "flagBasedOnTranslationMethod"),
            "formatBasedOnTranslationMethod" => new \Twig_Function_Method($this, "formatBasedOnTranslationMethod"),
        );
    }

    /**
     * Return the flags generated for
     * Twig or AngularJS
     * 
     * @return string
     */
    public function flagBasedOnTranslationMethod ()
    {
        if ('panel' === $this->getControllerName()) {

            return <<<PHP_EOT
                <ul class="nav navbar-nav navbar-right lang-flag" ng-controller="TranslateCtrl">
                    <li><button ng-click="changeLang('fr_FR');"><img src="/images/flag-france.png" alt="Français" title="Français" /></button></li>
                    <li><button ng-click="changeLang('en_EN');"><img src="/images/flag-united-kingdom.png" alt="English" title="English" /></button></li>
                    <li><button ng-click="changeLang('pt_BR');"><img src="/images/flag-brazil.png" alt="Português do Brasil" title="Português do Brasil" /></button></li>
                </ul>
PHP_EOT;
        } else {
            $sPathInfoWL = $this->getPathInfoWithoutLang();

            return <<<PHP_EOT
                <ul class="nav navbar-nav navbar-right lang-flag">
                    <li><a href="/fr/{$sPathInfoWL}"><img src="/images/flag-france.png" alt="Français" title="Français" /></a></li>
                    <li><a href="/en/{$sPathInfoWL}"><img src="/images/flag-united-kingdom.png" alt="English" title="English" /></a></li>
                    <li><a href="/pt/{$sPathInfoWL}"><img src="/images/flag-brazil.png" alt="Português do Brasil" title="Português do Brasil" /></a></li>
                </ul>
PHP_EOT;
        }
    }

    /**
     * Return the string formatted to be translated
     * with Twig or AngularJS
     *
     * @param string $sStringToTranslate
     * @return string
     */
    public function formatBasedOnTranslationMethod ($sStringToTranslate)
    {
        if ('panel' === $this->getControllerName()) {
            return "{{ '" . $sStringToTranslate . "'|translate }}";
        }
    
        return $this->translator->trans($sStringToTranslate);
    }

    /**
     * Retrieve the controller name
     * 
     * @return string
     */
    private function getControllerName ()
    {
        $pattern = '/\.?([^.]*).controller/';
        $matches = array();
        preg_match($pattern, $this->request->get('_controller'), $matches);
        
        return strtolower($matches[1]);
    }
    
    /**
     * Return the pathInfo of the request
     * without the code lang
     * 
     * @return string
     */
    private function getPathInfoWithoutLang()
    {
        return substr($this->request->getPathInfo(), strpos($this->request->getPathInfo(), '/', 1) + 1);
    }
}
