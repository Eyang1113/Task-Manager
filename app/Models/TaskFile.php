<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    protected $fillable = ['task_id', 'filename', 'path'];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
}
