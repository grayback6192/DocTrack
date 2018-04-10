<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
 
    protected $table = "group";
    public $timestamps = FALSE;
    public $primaryKey = "group_id";

    protected $fillable = [
        'group_id', 'groupName', 'groupDescription', 'creator_user_id', 'group_group_id', 'status', 'client_id','businessKey',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
