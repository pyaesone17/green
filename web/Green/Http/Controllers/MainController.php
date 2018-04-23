<?php 

namespace Green\Http\Controllers;
use Green\Validations\ValidatorFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Exceptions\ValidationException;
use Green\Traits\Validateable;

class MainController 
{
    use Validateable;
}