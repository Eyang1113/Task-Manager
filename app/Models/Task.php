<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;
    protected $fillable = ['user_id', 'title', 'description', 'due_date', 'status', 'priority'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fileRelation(){
        return $this->hasMany(TaskFile::class, 'task_id');
    }

    public const STATUS_OPTIONS = [
        'todo' => 'To Do',
        'in_progress' => 'In Progress',
        'done' => 'Done',
    ];

    public const PRIORITY_OPTIONS = [
        '0' => 'Low',
        '1' => 'Medium',
        '2' => 'High',
    ];
}
