<?php

namespace {{ namespace }}\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package {{namespace}}\Entity
 */
class User extends BaseUser
{
    protected $id;

    protected $avatar;

    /**
     * @return mixed
     */
    public function avatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return $this
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }
}
