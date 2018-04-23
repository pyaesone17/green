<?php 

namespace Green\Services;

use Green\Traits\Validateable;
use Green\Models\Recipe;
use Green\Models\User;
use League\Route\Http\Exception\NotFoundException;

class RecipeService
{
    use Validateable;

    public function all($query)
    {
        $queryBuilder = Recipe::with('ratings');

        foreach ($query as $key => $value) {
            $queryBuilder->search($key, $value);
        }

        $recipes =  $queryBuilder->paginate(20);

        logging('info', "recipe", $recipes);

        return $recipes;
    }

    public function create($attributes)
    {
        $this->validate($attributes, [
            'difficulty' => 'required|integer|between:1,3',
            'name' => 'required',
            'vegetarian' => 'required|boolean',
            'prepare_time' => 'required|integer'
        ]);

        $newRecipe = Recipe::create($attributes);

        return $newRecipe;
    }

    public function update($id, $attributes)
    {
        $recipe = $this->find($id);

        $this->validate($attributes, [
            'difficulty' => 'integer|between:1,3',
            'vegetarian' => 'boolean',
            'prepare_time' => 'integer'
        ]);

        $recipe->update($attributes);

        return $recipe;
    }

    public function rate($id, $attributes)
    {
        $recipe = $this->find($id);

        $this->validate($attributes, [
            'stars' => 'required|integer|between:1,5'
        ]);

        $recipe->ratings()->create($attributes);
        return $recipe->load('ratings');
    }

    public function delete($id)
    {
        $recipe = $this->find($id);
        $recipe->delete();

        return $recipe;
    }

    public function find($id)
    {
        $recipe = Recipe::find($id);

        if ($recipe==null) {
            throw new NotFoundException();
        }

        return $recipe;
    }
}
