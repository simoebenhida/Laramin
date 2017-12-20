<?php
namespace Simoja\Laramin\Traits;

trait Taggable {

    public function getTags()
    {
        return $this->tags()->where('parent_type',get_class($this))->get();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_relations', 'parent_id', 'tag_id');
    }


} ?>
