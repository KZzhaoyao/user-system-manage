<?php
namespace AppBundle\Twig;

class HtmlExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));
        return array(
            new \Twig_SimpleFunction('select_options', array($this, 'selectOptions'), $options)
        );
    }

    public function selectOptions($choices, $selected = null, $empty = null)
    {
        $html = '';

        if (!is_null($empty)) {
            if (is_array($empty)) {
                foreach ($empty as $key => $value) {
                    $html .= "<option value=\"{$key}\">{$value}</option>";
                }
            } else {
                $html .= "<option value=\"\">{$empty}</option>";
            }
        }

        foreach ($choices as $value => $name) {
            if ($selected == $value) {
                $html .= "<option value=\"{$value}\" selected=\"selected\">{$name}</option>";
            } else {
                $html .= "<option value=\"{$value}\">{$name}</option>";
            }
        }

        return $html;
    }

    public function getName()
    {
        return 'twig.html_extension';
    }

}