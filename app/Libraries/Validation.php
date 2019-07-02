<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Libraries\Response;

class Validation
{
    private static $ruler;
    private static $validator;

    public static function rules(array $ruler)
    {
        self::$ruler = $ruler;
        return (new self);
    }

    public function validate(Request $request, array $rules = [])
    {
        if (!empty(self::$ruler)) {
            $func = debug_backtrace()[1]['function'];
            $ruler = self::$ruler[$func];

            foreach ($rules as $key => $val) {
                $ruler[$key] = $val;
            }
        } else {
            $ruler = $rules;
        }

        self::$validator = Validator::make($request->all(), $ruler);

        return (new self);
    }

    public function fails()
    {
        return self::$validator->fails();
    }

    public function errors()
    {
        return Response::error("request is not complete", self::$validator->errors());
    }
}