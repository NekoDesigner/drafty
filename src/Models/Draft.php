<?php

namespace Nekodev\Drafty\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $table = 'drafts';
    protected $guarded = [];
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

    /**
     * Get the owning draftable model.
     */
    public function draftable()
    {
        return $this->morphTo();
    }

    public function model()
    {
        return $this->draftable;
    }
}
