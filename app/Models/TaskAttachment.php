<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\TaskAttachmentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
