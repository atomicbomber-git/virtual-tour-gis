<?php

namespace App\ModelTraits;

trait CountsRelatedModels
{
    public function countedRelations(): array
    {
        return [];
    }

    public function relatedModelsCount()
    {
        $count = 0;

        foreach ($this->countedRelations() as $related_entity) {
            if ($this->{"{$related_entity}_count"} === null) {
                $this->loadCount($related_entity);
            }

            $count += $this->{"{$related_entity}_count"};
        }

        return $count;
    }

    public function hasRelatedModels(): bool
    {
        return $this->relatedModelsCount() > 0;
    }

    public function doesntHaveRelatedModels(): bool
    {
        return !$this->hasRelatedModels();
    }
}
