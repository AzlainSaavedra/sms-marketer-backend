<?php

use Faker\Factory as Faker;
use App\Models\carros;
use App\Repositories\carrosRepository;

trait MakecarrosTrait
{
    /**
     * Create fake instance of carros and save it in database
     *
     * @param array $carrosFields
     * @return carros
     */
    public function makecarros($carrosFields = [])
    {
        /** @var carrosRepository $carrosRepo */
        $carrosRepo = App::make(carrosRepository::class);
        $theme = $this->fakecarrosData($carrosFields);
        return $carrosRepo->create($theme);
    }

    /**
     * Get fake instance of carros
     *
     * @param array $carrosFields
     * @return carros
     */
    public function fakecarros($carrosFields = [])
    {
        return new carros($this->fakecarrosData($carrosFields));
    }

    /**
     * Get fake data of carros
     *
     * @param array $postFields
     * @return array
     */
    public function fakecarrosData($carrosFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'id' => $fake->randomDigitNotNull,
            'marca' => $fake->word,
            'modelo' => $fake->word,
            'placa' => $fake->word,
            'anio' => $fake->randomDigitNotNull
        ], $carrosFields);
    }
}
