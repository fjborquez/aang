<?php

namespace App\Traits;

use App\Models\BaseModel;
use InvalidArgumentException;

trait BaseModelTrait
{
    /**
     * Validates the given model to ensure all required fields are populated.
     *
     * This method checks if the essential attributes of the model,
     * such as 'name' and 'description', are not null or empty.
     *
     * @param BaseModel $model The model instance to be validated.
     * @return void
     */
    public function validate(BaseModel $model): void
    {
        $requiredAttributes = $model->getRequiredAttributes() ?? [];

        foreach ($requiredAttributes as $attribute) {
            $value = $model->getAttribute($attribute);

            if (is_null($value)) {
                throw new InvalidArgumentException("The '{$attribute}' attribute is required and cannot be null.");
            }

            if (is_string($value) && trim($value) === '') {
                throw new InvalidArgumentException("The '{$attribute}' attribute is required and cannot be empty.");
            }
        }
    }
}
