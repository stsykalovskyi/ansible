<?php

namespace {{ namespace }}\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * Class Client
 * @package {{ namespace }}\Entity
 */
class Client extends BaseClient
{
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}
