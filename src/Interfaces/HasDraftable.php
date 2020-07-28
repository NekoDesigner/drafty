<?php

namespace Nekodev\Drafty\Interfaces;

interface HasDraftable {

    /**
     * draft
     * Return Draft Model from :
     * 'Nekodev\Drafty\Models\Draft' -> Without Spatie/MediaLibrary
     * 'Nekodev\Drafty\Models\MediaLibrary\Draft' -> With Spatie/MediaLibrary
     * @example return $this->morphOne('Nekodev\Drafty\Models\MediaLibrary\Draft', 'draftable');
     * @return Draft
     */
    public function draft();
}
