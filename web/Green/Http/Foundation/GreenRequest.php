<?php 
namespace Green\Http\Foundation;

use Lcobucci\JWT\ValidationData;
use Green\Exceptions\InvalidTokenException;
use Lcobucci\JWT\Parser;
use Green\Models\User;

/**
 * This is a wrapper class for Symfony Request
 * 
 * for adding more powerful method
 */
class GreenRequest
{
    public function __construct($symfonyRequest)
    {
        $this->symfonyRequest = $symfonyRequest;
    }

    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }

    public function json($key=null,$default=null)
    {
        $data = [];
        if ($content = $this->symfonyRequest->getContent()) {
            $data = json_decode($content, true);
        }
        
        if($key!==null){
            return isset($data[$key]) ? $data[$key] : $default;
        }

        return $data;
    }

    public function all()
    {
        $method = $this->getMethod();

        if($method==="GET"){
            return $this->query;
        } else {
            return $this->attributes;
        }
    }

    public function checkAuthenticated()
    {
        return $this->auth();
    }

    public function auth()
    {
        $rawToken = $this->getRawToken();
        $token = '';

        try{
            $token = (new Parser())->parse((string) $rawToken);
        } catch(\Exception $e) {
            throw new InvalidTokenException("Invalid token");
        } 

        if($this->validate($token)){
            $user = User::whereEmail($token->getClaim('user_email'))->firstOrFail();
            return $user;
        } else {
            throw new InvalidTokenException("Token expired");
        }
    }

    public function validate($token)
    {
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer('Hellofresh');
        $data->setAudience('Hellofresh');
        $data->setId('4f1g23a12aa');

        return $token->validate($data);
    }

    public function getRawToken()
    {
        $authorization = $this->headers->get('Authorization');
        
        $token =  sscanf( $authorization, 'Bearer %s')[0];

        if($token==''){
            throw new \League\Route\Http\Exception\UnauthorizedException();
        }
        
        return $token;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->symfonyRequest, $method], $args);
    }

    public function __get($name)
    {
        return $this->symfonyRequest->{$name};
    }
}
