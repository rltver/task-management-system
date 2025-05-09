<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskHistory extends Model
{
    /** @use HasFactory<\Database\Factories\TaskHistoryFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
