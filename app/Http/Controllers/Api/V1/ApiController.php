<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;

class ApiController extends Controller
{
    use ApiResponses;

    protected string $policyClass;

    public function isAble($permission, $relatedModel)
    {
        return $this->authorize($permission, [$relatedModel, $this->policyClass]);
    }

    public function include(string $relationship): bool
    {
        $include = request()->include;

        if (!$include) {
            return false;
        }

        $includedValues = explode(',', strtolower($include));

        return in_array(strtolower($relationship), $includedValues);
    }
}
