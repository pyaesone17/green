<?php
namespace Green\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Green\Models\User;
use Green\Traits\{PsrToHttpFoundation,HttpFoundationToPsr};
use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Support\{PasswordHasher,Auth};

class AuthController extends MainController
{
    use PsrToHttpFoundation,HttpFoundationToPsr;

    public function getToken(ServerRequestInterface $request, ResponseInterface $response)
    {        
        $request = $this->toSymfonyRequest($request);

        $this->validate($request->json(),[
            'password' => 'required',
            'email' => 'required'
        ]);

        list('email' => $email, 'password' => $password) = $request->json();

        if (Auth::attempt($email,$password)) {
            $token = Auth::createToken($email);

            $response = new JsonResponse([
                'status_code' => 200,
                'token' => "$token"
            ],200);

            return $this->toPsrResponse($response);
        } else {
            $response = new JsonResponse([
                'status_code' => 401,
                'reason_phrase' => "Incorrect email or password"
            ],401);

            return $this->toPsrResponse($response);
        }
    }
}
