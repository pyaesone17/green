# Green PHP pure framework

### Implementing pure PHP micro framework from scratch using some popular components.

Register your route in web/index.php

```php
$router->map('GET','/recipes','\Green\Http\Controllers\RecipeController::index');
```

RecipeController

```php

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

