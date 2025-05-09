<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    use softDeletes;

    protected $guarded = [];
    protected $casts = [
        'due_date' => 'date',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tasks_attachment(){
        return $this->hasMany(TaskAttachment::class);
    }

    public function tasks_comments(){
        return $this->hasMany(TaskComment::class);
    }

    public function tasks_history(){
        return $this->hasMany(TaskHistory::class);
    }
}
