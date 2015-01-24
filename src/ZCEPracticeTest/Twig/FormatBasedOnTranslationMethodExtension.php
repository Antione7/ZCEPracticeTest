<?php

namespace ZCEPracticeTest\Twig;

use Symfony\Component\Translation\Translator;

/**
 * Twig extension to format a string based
 * on the translation method (with Twig or AngularJS)
 *
 * @author cgrandval
 */
class FormatBasedOnTranslationMethodExtension extends \Twig_Extension
{
    protected $translator;

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
        return "formatBasedOnTranslationMethod";
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array (
            "formatBasedOnTranslationMethod" => new \Twig_Function_Method($this, "formatBasedOnTranslationMethod"),
        );
    }

    /**
     * Return the string formatted to be translated
     * with Twig or AngularJS
     * 
     * @param string $sStringToTranslate
     * @param bool $bUseAngularJS
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
     * @return string
     */
    public function getControllerName ()
    {
        $pattern = '/\.([^.]*).controller/';
        $matches = array();
        preg_match($pattern, $this->request->get('_controller'), $matches);
        
        return strtolower($matches[1]);
    }
}