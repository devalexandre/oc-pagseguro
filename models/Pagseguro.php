<?php namespace Indev\Pagseguro\Models;

use Model;


/**
 * Model
 */
class Pagseguro extends Model
{
    use \October\Rain\Database\Traits\Validation;
    


    public $filtable = ['user_id','transaction_id','items','total','reference','status'];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['items'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'indev_pagseguro_';

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User'
    ];
}
