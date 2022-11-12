<?php

namespace App\Services;

use App\Helpers\Responses;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionClass;

/**
 * Class Service
 * @package App\Services
 */
abstract class Service
{
    use Responses;

    /**
     * Get service
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $subNamespace = '\\';

        if (substr($name, 0, 5) === 'admin') {
            $subNamespace .= 'Admin\\';
            $name = substr($name, 5);
        }

        $child = (new ReflectionClass(self::class))->getNamespaceName() . $subNamespace . ucfirst($name);

        if (class_exists($child)) {
            try {
                return app()->make($child);
            } catch (BindingResolutionException $e) {
                return null;
            }
        }

        return null;
    }
}
