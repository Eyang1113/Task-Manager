<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['user_id', 'category_name'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
