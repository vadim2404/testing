<?php

namespace Bstu\Bundle\TestOrganizationBundle\Twig\Extension;

class JsonDecodeExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getName() 
    {
        return 'json_decode.extension';
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            'json_decode'   => new \Twig_Filter_Method($this, 'jsonDecode'),
        ];
    }

    /**
     * json_decode
     * 
     * @param string $str
     * @return mixed
     */
    public function jsonDecode($str)
    {
        return json_decode($str);
    }
}