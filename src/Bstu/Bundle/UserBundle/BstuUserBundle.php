<?php

namespace Bstu\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BstuUserBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
