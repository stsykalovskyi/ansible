<?php

namespace {{ namespace }}\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 * Class AccessToken
 * @package {{ namespace }}\Entity
 */
class AccessToken extends BaseAccessToken
{
    protected $id;

    protected $client;

    protected $user;
}
