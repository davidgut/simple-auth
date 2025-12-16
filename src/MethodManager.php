<?php

namespace DavidGut\SimpleAuth;

use DavidGut\SimpleAuth\Method;
use Illuminate\Support\Collection;

class MethodManager
{
    private Collection $methods;

    public function __construct()
    {
        $this->methods = collect(config('simple-auth.methods', []))
            ->filter(fn(array $config) => ($config['enabled'] ?? true))
            ->map(fn(array $config) => new $config['class'])
            ->filter(fn(Method $method) => $method->isEnabled());
    }

    public function getMethods(): Collection
    {
        return $this->methods;
    }

    public function getMethod(string $identifier): Method|null
    {
        return $this->methods->first(
            fn(Method $method) => $method->getIdentifier() === $identifier
        );
    }

    public function getDefaultMethod(): Method|null
    {
        return $this->getMethod(identifier: config('simple-auth.default'));
    }

    public function getOtherEnabledMethods(string|Method $method): Collection
    {
        $identifier = $method instanceof Method
            ? $method->getIdentifier()
            : $method;

        return $this->methods->reject(
            fn(Method $authMethod) => $authMethod->getIdentifier() === $identifier
        );
    }
}
