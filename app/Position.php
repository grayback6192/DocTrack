<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    protected $table = "position";
    public $timestamps = FALSE;
    public $primaryKey = "pos_id";

    protected $fillable = [
    		'pos_id', 'posName', 'posDescription', 'status', 'client_id'
    ];
}
