<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Libraries\Response;

class Validation
{
    private $rules;
    private $validator;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate(Request $request)
    {
        $func = debug_backtrace()[1]['function'];
        $this->validator = Validator::make($request->all(), $this->rules[$func]);
        return $this;
    }

    public function fails(Type $var = null)
    {
        return $this->validator->fails();
    }

    public function errors($message)
    {
        return Response::error($message, $this->validator->errors());
    }
}