<?php

namespace {{ namespace }}\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 * Class AuthCode
 * @package {{ namespace }}\Entity
 */
class AuthCode extends BaseAuthCode
{
    protected $id;

    protected $client;

    protected $user;
}
