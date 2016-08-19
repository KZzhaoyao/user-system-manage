<?php

namespace AppBundle;

use AppBundle\Common\ExtensionalBundle;

class AppBundle extends ExtensionalBundle
{
	public function getEnabledExtensions()
    {
        return array('DataTag', 'DataDict');
    }
}
