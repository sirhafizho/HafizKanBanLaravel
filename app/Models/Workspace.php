<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Workspace extends Model
{
    use HasFactory;

    /**
     * The policy mappings for the model.
     *
     * @var array
     */
    protected $policies = [
        Workspace::class => WorkspacePolicy::class,
    ];

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'order',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskLists()
    {
        return $this->hasMany(TaskList::class);
    }
}
