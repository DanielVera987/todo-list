<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'estado', 'etiqueta_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function etiqueta(){
       return $this->belongsTo('App\Etiqueta', 'etiqueta_id');
    }
}
