<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
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
