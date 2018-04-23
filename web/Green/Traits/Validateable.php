<?php 

namespace Green\Traits;

use Green\Validations\ValidatorFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Exceptions\ValidationException;

trait Validateable
{
    public function validate($data, $rules)
    {
        $validator = new ValidatorFactory();

        $validation = $validator->make($data, $rules);
        if ($validation->fails()) { 
            $errors = $validation->errors();
            $v = new ValidationException();
            $v->setErrors($errors->toArray());
            throw $v;
        }
    }
}
