<?php

namespace Bstu\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BstuUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
