<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_list_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'order',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
}
