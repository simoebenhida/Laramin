<?php
namespace Simoja\Laramin\Traits;

trait Taggable {

    public function TagsModel($slug)
    {
        return $this->tags()->where('parent',$slug)->get();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_relations', 'other_id', 'tag_id');
    }

} ?>
