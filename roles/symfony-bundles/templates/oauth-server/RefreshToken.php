<?php

namespace {{ namespace }}\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;

/**
 * Class RefreshToken
 * @package {{ namespace }}\Entity
 */
class RefreshToken extends BaseRefreshToken
{
    protected $id;

    protected $client;

    protected $user;
}
