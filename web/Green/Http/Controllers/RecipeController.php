<?php
namespace Green\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Traits\PsrToHttpFoundation;
use Green\Traits\HttpFoundationToPsr;
use Green\Services\RecipeService;

class RecipeController extends MainController
{
    use PsrToHttpFoundation,HttpFoundationToPsr;

    public function __construct()
    {
        $this->recipeService = new RecipeService;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $request = $this->toSymfonyRequest($request);
        $recipes = $this->recipeService->all($request->query);

        $response = new JsonResponse($recipes);
        return $this->toPsrResponse($response);
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $recipe = $this->recipeService->find($args['id']);

        $response = new JsonResponse(['data' => $recipe]);
        return $this->toPsrResponse($response);
    }

    public function store(ServerRequestInterface $request, ResponseInterface $response)
    {
        $request = $this->toSymfonyRequest($request);

        $attributes = $request->json();
        $attributes['user_id'] = $request->auth()->id;
        $newRecipe = $this->recipeService->create($attributes);

        $response = new JsonResponse(['status'=> 'success', 'data' => $newRecipe]);
        return $this->toPsrResponse($response);
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $request = $this->toSymfonyRequest($request);

        $attributes = $request->json();
        $recipe = $this->recipeService->update($args['id'], $attributes);

        $response = new JsonResponse(['status'=> 'success','data' => $recipe]);
        return $this->toPsrResponse($response);
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $recipe = $this->recipeService->delete($args['id']);
        $response = new JsonResponse([
            'success' => true
        ]);

        return $this->toPsrResponse($response);
    }

    public function rating(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $request = $this->toSymfonyRequest($request);
        
        $attributes = $request->json();
        $attributes['user_id'] = $request->auth()->id;
        $recipe = $this->recipeService->rate($args['id'], $attributes);
        
        $response = new JsonResponse(['status'=> 'success', 'recipe' => $recipe]);
        return $this->toPsrResponse($response);
    }
}
