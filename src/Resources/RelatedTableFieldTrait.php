<?php

namespace WebCaravel\Admin\Resources;

use Illuminate\Database\Eloquent\Model;

trait RelatedTableFieldTrait
{
    public Model $relatedRecord;


    public function bootRelatedTableFieldTrait()
    {
        $this->extraQueries[] = function($query) {
            return $query->whereBelongsTo($this->relatedRecord);
        };
    }
}
