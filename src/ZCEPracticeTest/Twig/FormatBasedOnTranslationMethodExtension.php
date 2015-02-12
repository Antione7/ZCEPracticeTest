<?php

namespace ZCEPracticeTest\Twig;

/**
 * Twig extension to format a string based
 * on the translation method (with Twig or AngularJS)
 *
 * @author cgrandval
 */
class FormatBasedOnTranslationMethodExtension extends \Twig_Extension
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
        $pattern = '/\.?([^.]*).controller/';
        $matches = array();
        preg_match($pattern, $this->request->get('_controller'), $matches);
        
        return strtolower($matches[1]);
    }
}
