<?php

namespace {{ project_name|title }}\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class {{ project_name|title }}UserBundle
 * @package Gamehub\UserBundle
 */
class {{ project_name|title }}UserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
