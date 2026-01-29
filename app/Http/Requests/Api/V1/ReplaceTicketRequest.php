<?php

namespace App\Http\Requests\Api\V1;

class ReplaceTicketRequest extends BaseTicketRequest
{
    public function rules(): array
    {
        $rules = [
            "data.attributes.title" => "required|string",
            "data.attributes.description" => "required|string",
            "data.attributes.status" => "required|string|in:A,C,H,X",
        ];

        if (request()->routeIs('tickets.*')) {
            $rules["data.relationships.author.data.id"] = "required|integer|exists:users,id";
        }

        return $rules;
    }


    public function authorize(): bool
    {
        return true;
    }
}
