<?php

namespace App\Repositories;

use App\Models\carros;
use InfyOm\Generator\Common\BaseRepository;

class carrosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'marca',
        'modelo',
        'placa',
        'anio'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return carros::class;
    }
}
