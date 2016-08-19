<?php
namespace AppBundle\Twig;

use AppBundle\Common\ExtensionManager;

class AppExtensions extends \Twig_Extension
{
	protected $container;

    protected $pageScripts;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
        	new \Twig_SimpleFunction('dict', array($this, 'getDict')),
            new \Twig_SimpleFunction('dict_text', array($this, 'getDictText'), array('is_safe' => array('html'))),
        );
    }

    
    public function getName()
    {
        return 'twig.app_extension';
    }

    public function getDict($type)
    {
        return ExtensionManager::instance()->getDataDict($type);
    }

    public function getDictText($type, $key)
    {
        $dict = $this->getDict($type);

        if (empty($dict) || !isset($dict[$key])) {
            return '';
        }

        return $dict[$key];
    }

}