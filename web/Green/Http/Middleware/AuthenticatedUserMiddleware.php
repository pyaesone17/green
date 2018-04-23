<?php 
namespace Green\Http\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Green\Traits\{PsrToHttpFoundation,HttpFoundationToPsr};

class AuthenticatedUserMiddleware
{
    use PsrToHttpFoundation,HttpFoundationToPsr;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $request = $this->toSymfonyRequest($request);
        $request->checkAuthenticated();

        $request = $this->toPsrRequest($request->symfonyRequest);
        $response = $next($request, $response);
        return $response;
    }   
}