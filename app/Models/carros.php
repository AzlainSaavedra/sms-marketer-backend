<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="carros",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="marca",
 *          description="marca",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="modelo",
 *          description="modelo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="placa",
 *          description="placa",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="anio",
 *          description="anio",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class carros extends Model
{
    use SoftDeletes;

    public $table = 'carros';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'marca',
        'modelo',
        'placa',
        'anio'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'marca' => 'string',
        'modelo' => 'string',
        'placa' => 'string',
        'anio' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
