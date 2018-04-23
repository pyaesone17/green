# Green PHP pure framework

### Implementing pure PHP micro framework from scratch using some popular components.

Register your route in web/index.php

```php
$router->map('GET','/recipes','\Green\Http\Controllers\RecipeController::index');
```

RecipeController

```php


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
```

See more under Green\Http\Controllers and Green\Services

### Error handling 
It is configured to response json error response.

The default will show error detail for debugging purpose.

You can disable under web/config/app.php

```php
<?php 

return [
    'debug' => false
];
```

### Authentication
It is supported by Jwt token. You can access current user using like below. If the user is not authenticated, it will response 
token error.

```php
$request->user();
````
