<?php

namespace Oni\Framework;

use WP_User;

/**
 * @author  Themosis
 * @link    https://github.com/themosis/framework/blob/master/src/Themosis/User/User.php
 */

class User extends WP_User
{

    /**
     * @var \Oni\Framework\Application
     */
    protected $app;

    /**
     * @param \Oni\Framework\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Check if the user has role.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * Set User role.
     *
     * @param string $role
     *
     * @return \Oni\Framework\User\User
     */
    public function setRole($role)
    {
        $this->set_role($role);

        return $this;
    }

    /**
     * Check if the user can do a defined capability.
     *
     * @param string $capability
     *
     * @return bool
     */
    public function can($capability)
    {
        return user_can($this, $capability);
    }

    /**
     * Update the user properties.
     *
     * @param array $userdata
     *
     * @return \Oni\Framework\User\User|\WP_Error
     */
    public function update(array $userdata)
    {
        $userdata = array_merge($userdata, ['ID' => $this->ID]);

        $user = $this;

        $user = wp_update_user($userdata);

        if (is_wp_error($user)) {
            return $user;
        }

        return $this;
    }
}