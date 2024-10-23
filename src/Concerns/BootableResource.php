<?php

namespace BadChoice\Thrust\Concerns;

trait BootableResource
{
    /**
     * @var array The resources that have already been booted
     */
    protected static $booted = [];

    public function __construct() {
        if (! isset(static::$booted[static::class])) {
            static::$booted[static::class] = true;

            static::bootTraits();
        }
    }

    protected static function bootTraits()
    {
        $class = static::class;
        
        $booted = [];
        
        foreach (class_uses_recursive($class) as $trait) {
            $method = 'boot'.class_basename($trait);

            if (method_exists($class, $method) && ! in_array($method, $booted)) {
                forward_static_call([$class, $method]);

                $booted[] = $method;
            }
        }
    }
}