<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    /**
     * robię wg tego : http://symfony.com/doc/current/bundles/FOSUserBundle/overriding_controllers.html
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
