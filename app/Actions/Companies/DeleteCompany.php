<?php

namespace App\Actions\Companies;

use App\Models\Company;

class DeleteCompany
{
    /**
     * Deletes an company
     * @param  Company  $company
     */
    public function delete(Company $company)
    {
        $company->delete();
    }

}
