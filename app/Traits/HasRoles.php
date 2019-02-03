<?php

declare(strict_types=1);

namespace App\Traits;

use App\Role;

trait HasRoles
{
    /**
     * Assign role to participant.
     *
     * @param string $query
     *
     * @return bool
     */
    public function assignRole(string $query)
    {
        $role = $this->channel->roles->firstWhere('name', $query);

        if ($role) {
            $this->roles()->attach($role);

            return true;
        }

        return false;
    }

    /**
     * Check if participant has role.
     *
     * @param string $query
     *
     * @return bool
     */
    public function hasRole(string $query)
    {
        return $this->roles()->exists($query);
    }
}
