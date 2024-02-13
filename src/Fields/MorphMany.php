<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\ResourceManager;
use Illuminate\Support\Str;

class MorphMany extends HasMany
{
    public function displayInIndex($object)
    {
        return view('thrust::fields.morphMany', [
            'value'         => $this->getIndexText($object),
            'withLink'      => $this->withLink,
            'link'          => $this->link ? str_replace('{id}', $object->id, $this->link) : null,
            'relationship'  => $this->field,
            'id'            => $object->id,
            'icon'          => $this->icon,
            'resourceName'  => app(ResourceManager::class)->resourceNameFromModel($object),
        ]);
    }
}
