<?php 

namespace Green\Traits;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Green\Http\Foundation\GreenRequest;

trait PsrToHttpFoundation
{
    public function toSymfonyRequest($psrRequest)
    { 
        $httpFoundationFactory = new HttpFoundationFactory();

        // convert a Request
        // $psrRequest is an instance of Psr\Http\Message\ServerRequestInterface
        $symfonyRequest = $httpFoundationFactory->createRequest($psrRequest);

        return new GreenRequest($symfonyRequest); 
    } 
}
