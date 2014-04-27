<?php

namespace Bstu\Bundle\TestOrganizationBundle\Distance;

interface DistanceCalculatorInterface
{
    /**
     * Calculate distance between two words
     * 
     * @param string $str1
     * @param string $str2
     * @return integer
     */
    public function calculate($str1, $str2);
}
