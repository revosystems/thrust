<?php

namespace BadChoice\Thrust;

use BadChoice\Thrust\Contracts\CustomBackRoute;
use BadChoice\Thrust\Facades\Thrust;

abstract class ChildResource extends Resource
{
    public static $parentRelation;
    public static $parentChildsRelation;
    public $parentId;

    public function __construct()
    {
        $this->parentId = request('parent_id');
    }

    public function parentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    protected function getBaseQuery()
    {
        $query = parent::getBaseQuery();
        if ($this->parentId) {
            $query->where($this->parentForeignKey(), $this->parentId);
        }
        return $query;
    }

    protected function applySearch(&$query)
    {
        if($this->parentId) return;

        parent::applySearch($query);
    }

    public function parentForeignKey()
    {
        $relation = (new static::$model)->{static::$parentRelation}();
        if (method_exists($relation, 'getForeignKey')) {
            return $relation->getForeignKey();
        }
        return $relation->getForeignKeyName();
    }

    public function parent($object)
    {
        if (is_numeric($object)) {
            return  (new static::$model)->{static::$parentRelation}()->getRelated()->query()->find($object);
        }
        return $object?->{static::$parentRelation};
    }

    public function getParentUrl($parent){
        if ($this instanceof CustomBackRoute){
            return [$this->backRouteTitle() => $this->backRoute()];
        }
        return route('thrust.hasMany', [
            Thrust::resourceNameFromModel($parent),
            $parent->id,
            Thrust::resourceNameFromModel($this)
        ]);
    }

    public function breadcrumbs(mixed $object): array
    {
        $parent = $this->parent($object);
        if (!$parent) { return []; }
        $parentResource = Thrust::make(Thrust::resourceNameFromModel($parent));
        return [
            ...$parentResource->breadcrumbs($parent),
            $parent->{$parentResource->nameField} => $this->getParentUrl($parent),
//            $this->getTitle() => ''
        ];
    }
}
