<?php

namespace Nekodev\Drafty\Traits;

trait Draftable {

    // List all draft data
    private $draftData = [];

    /**
     * getDraft
     * Return a Draft instance or False is any Draft Exist
     * @return Draft|False
     */
    public function getDraft()
    {
        if($draft_model = $this->draft()->first()) {
            $this->draftData = json_decode($draft_model->draft_content);
            foreach ($this->draftData as $key => $value) {
                $draft_model->{$key} = $value;
            }
            return $draft_model;
        }
        return false;
    }

    /**
     * getDraft
     * Return a Draft instance or Model is any Draft Exist
     * @return Draft|this
     */
    public function getDraftIfExist()
    {
        if($draft_model = $this->draft()->first()) {
            $this->draftData = json_decode($draft_model->draft_content);
            foreach ($this->draftData as $key => $value) {
                $draft_model->{$key} = $value;
            }
            return $draft_model;
        }
        return $this;
    }

    /**
     * saveAsDraft
     * Save Model as Draft. Update Draft if exist.
     * @return void
     */
    public function saveAsDraft()
    {
        $values = [];
        foreach($this->attributes as $key => $value)
        {
            if($key != 'id') $values[$key] = $value;
        }
        if($this->hasDraft()) {
            $this->draft()->update(['draft_content' => json_encode($values)]);
        } else {
            $this->draft()->create(['draft_content' => json_encode($values)]);
        }
        return $this->draft()->first();
    }
    
    /**
     * hasDraft
     * Check if model has draft
     * @return void
     */
    public function hasDraft()
    {
        return !is_null($this->draft);
    }
    
    /**
     * removeDraft
     * Remove draft from model if exist
     * @return void
     */
    public function removeDraft()
    {
        $this->draft()->delete();
    }
    
    /**
     * Apply draft from model
     * @return Model
     */
    public function applyDraft()
    {
        if($draft = $this->getDraft())
        {
            foreach($this->attributes as $key => $value)
            {
                if($draft->$key && $key != 'id') {
                    $this->attributes[$key] = $draft->$key;
                }
            }
        }

        return $this;
    }

    /**
     * save
     * Override save method from model.
     * Remove the draft if exist.
     * Update Media Collection if using Spatie MediaLibrary
     * @param  mixed $options can specified cleen_medias to true for clear media collection on save
     * @return void
     */
    public function save(array $options = array())
    {
        $saved = parent::save();
        if (interface_exists('\Spatie\MediaLibrary\HasMedia') && $this->hasDraft())
        {
            if($this->draft->media->count() > 0)
            {
                // if(array_key_exists('clean_medias', $options) && $options['clean_medias'] == true) {
                    $collections = array_unique($this->draft->media->pluck('collection_name')->toArray());
                    foreach($collections as $collection) 
                    {
                        $this->clearMediaCollection($collection);
                    }
                // }
                foreach($this->draft->media as $media)
                {
                    $media->model()->associate($this);
                    $media->save();
                }
            }
        }
        if($this->hasDraft()) $this->removeDraft();
        return $saved;
    }

    public function delete()
    {
        $this->draft()->delete();
        $deleted = parent::delete();
        return $deleted;
    }

        
    /**
     * Return the current model
     *
     * @return Model
     */
    public function model()
    {
        return $this;
    }

}
