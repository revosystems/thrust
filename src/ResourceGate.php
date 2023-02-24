<?php

namespace BadChoice\Thrust;

use BadChoice\Thrust\Facades\Thrust;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ResourceGate
{
    use AuthorizesRequests;

    public function check($resource, $ability, $object = null)
    {
        if (! $this->can($resource, $ability, $object)) {
            throw new AuthorizationException('This action is unauthorized.');
        }
    }

    public function can($resource, $ability, $object = null)
    {
        $valid = true;
        try{
            $resource = Thrust::make($resource);
            if ($resource::$gate) {
                $valid = auth()->user()->can($resource::$gate);
            }
            $policy = $this->policyFor($resource);
            if ($policy) {
                $valid = $this->checkPolicyValidation($resource, $ability, $object, $policy);
            }
        } catch(\Exception $e) {}
        return $valid;
    }

    public function checkPolicyValidation($resource, $ability, $object, $policy): bool
    {
        $policyInstance = new $policy;
        $abilityResult = $policyInstance->$ability(auth()->user(), $object ?? $resource::$model);
        if (!method_exists($policyInstance, 'before')) {
            return $abilityResult;
        }
        $beforeResult = $policyInstance->before(auth()->user(), $ability, $object);
        if ($beforeResult === null) {
            return $abilityResult;
        }

        return $beforeResult && $abilityResult;
    }

    public function policyFor($resource){
        return $resource::$policy ?? Gate::getPolicyFor($resource::$model);
    }
}
