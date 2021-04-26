<?php

namespace App\Actions\Organizations;

use App\Models\Organization;

class DeleteOrganization
{
    /**
     * Deletes an organization
     * @param  Organization  $organization
     */
    public function delete(Organization $organization)
    {
        $organization->delete();
    }

}
