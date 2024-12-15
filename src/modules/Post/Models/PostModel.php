<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\UserModel;

class PostModel extends Model {
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, "user_id", "id");
    }
}
