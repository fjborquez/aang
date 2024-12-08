<?php

namespace App\Services\NutritionalProfileService;

use App\Contracts\Services\NutritionalProfileService\NutritionalProfileServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Models\NutritionalProfile;
use InvalidArgumentException;

class NutritionalProfileService implements NutritionalProfileServiceInterface
{
    public function __construct(
        private readonly PersonServiceInterface $personService
    ) {}

    public function create(int $personId, array $data = [])
    {
        $this->validate($personId, $data);

        foreach ($data as $profileDetail) {
            $nutritionalProfile = new NutritionalProfile;
            $nutritionalProfile->product_category_id = $profileDetail['product_category_id'];
            $nutritionalProfile->product_category_name = $profileDetail['product_category_name'];
            $nutritionalProfile->consumption_level_id = $profileDetail['consumption_level_id'];
            $nutritionalProfile->person_id = $personId;
            $nutritionalProfile->save();
        }
    }

    public function get(int $personId): array
    {
        $person = $this->personService->get($personId);

        return $person->nutritionalProfile->toArray();
    }

    public function update(int $personId, array $data = [])
    {

        $this->validate($personId, $data);

        $nutritionalProfileComplete = NutritionalProfile::where('person_id', $personId)->get();

        foreach ($data as $newProfileDetail) {
            if (! in_array($newProfileDetail['product_category_id'], $nutritionalProfileComplete->pluck('product_category_id')->all())) {
                $toBeManipulated = new NutritionalProfile;
            } else {
                $toBeManipulated = $nutritionalProfileComplete->where('product_category_id', $newProfileDetail['product_category_id'])
                    ->where('person_id', $personId)->first();

                if ($toBeManipulated == null) {
                    $toBeManipulated = new NutritionalProfile;
                }
            }

            $toBeManipulated->product_category_id = $newProfileDetail['product_category_id'];
            $toBeManipulated->product_category_name = $newProfileDetail['product_category_name'];
            $toBeManipulated->consumption_level_id = $newProfileDetail['consumption_level_id'];
            $toBeManipulated->person_id = $personId;
            $toBeManipulated->save();
        }

        foreach ($nutritionalProfileComplete as $nutritionalProfile) {
            if (! in_array($nutritionalProfile->product_category_id, array_column($data, 'product_category_id'))) {
                $nutritionalProfile->delete();
            }
        }

    }

    public function delete(int $personId, int $productCategoryId)
    {
        $nutritionalProfile = NutritionalProfile::where('product_category_id',
            $productCategoryId)->where('person_id', $personId)->first();

        if ($nutritionalProfile == null) {
            throw new ResourceNotFoundException('Nutritional profile not found');
        }

        $nutritionalProfile->delete();
    }

    private function validate(int $personId, array $data): void
    {
        if ($personId < 1) {
            throw new InvalidArgumentException('Invalid person id');
        }

        if ($this->hasInvalidConsumptionLevel($data)) {
            throw new InvalidArgumentException('Consumption level is invalid');
        }
    }

    private function hasInvalidConsumptionLevel(array $data): bool
    {
        return count(array_filter($data, function ($item) {
            return $item['consumption_level_id'] <= 0;
        })) > 0;
    }
}
