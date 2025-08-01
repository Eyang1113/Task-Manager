<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubTask extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['task_id', 'title', 'description', 'is_done'];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
}
