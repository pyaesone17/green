<?php 

namespace Green\Traits;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

trait HttpFoundationToPsr
{
    public function toPsrResponse($symfonyResponse)
    {
        $psr7Factory = new DiactorosFactory();
        $psrResponse = $psr7Factory->createResponse($symfonyResponse);
        return $psrResponse;
    } 

    public function toPsrRequest($symfonyRequest)
    {
        $psr7Factory = new DiactorosFactory();
        $psrRequest = $psr7Factory->createRequest($symfonyRequest);
        return $psrRequest;
    } 
}
