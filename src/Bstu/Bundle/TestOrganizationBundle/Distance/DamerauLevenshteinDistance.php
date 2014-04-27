<?php

namespace Bstu\Bundle\TestOrganizationBundle\Distance;

class DamerauLevenshteinDistance implements DistanceCalculatorInterface
{
    /**
     * Calculate damerau levenshtein distance
     * 
     * @param string $str1
     * @param string $str2
     * @return integer
     */
    public function calculate($str1, $str2)
    {
        $lenStr1 = strlen($str1); 
        $lenStr2 = strlen($str2);
        
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);
        
        $d = [[]];
        
        for ($j = 0; $j <= $lenStr2; ++$j) {
            $d[0][] = $j;
        }
        
        for ($i = 1; $i <= $lenStr1; ++$i) {
            $d[] = [$i];
            for ($j = 1; $j <= $lenStr2; ++$j) {
                $d[$i][] = 0;
            }
        }
        
        for ($i = 1; $i <= $lenStr1; ++$i) {
            for ($j = 1; $j <= $lenStr2; ++$j) {
                $cost = intval($str1[$i - 1] !== $str2[$j - 1]);
                
                $d[$i][$j] = min(
                    $d[$i - 1][$j] + 1,
                    $d[$i][$j - 1] + 1,
                    $d[$i - 1][$j - 1] + $cost
                );
                
                if (1 < $i && 1 < $j && $str1[$i - 1] === $str2[$j - 2] && $str1[$i - 2] == $str2[$j - 1]) {
                    $d[$i][$j] = min(
                        $d[$i][$j],
                        $d[$i - 2][$j - 2] + $cost
                    );
                }
            }
        }
        
        return $d[$lenStr1][$lenStr2];
    }
}
