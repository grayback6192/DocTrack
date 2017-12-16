<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserGroupPosition extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "userpositiongroup";
    public $timestamps = FALSE;
    public $primaryKey = "upg_id";

    protected $fillable = [
        'upg_id', 'position_pos_id', 'rights_rights_id', 'user_user_id', 'client_id','group_group_id','businessKey','upg_status',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
