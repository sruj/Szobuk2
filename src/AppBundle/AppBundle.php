<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    //robię wg tego : http://symfony.com/doc/current/bundles/FOSUserBundle/overriding_controllers.html
    public function getParent()
    {
//        return 'FOSUserBundle';
    }
}
