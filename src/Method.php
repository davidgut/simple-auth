<?php

namespace DavidGut\SimpleAuth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

abstract class Method
{
    /**
     * The name of the authentication method.
     */
    protected ?string $name = null;

    /**
     * Get the name of the auth method.
     */
    abstract public function getName(): string;

    /**
     * Get the description of the auth method.
     */
    abstract public function getDescription(): string;

    /**
     * Authenticate the user.
     */
    abstract public function authenticate(Request $request): RedirectResponse;

    /**
     * Check if the auth method is enabled.
     */
    public function isEnabled(): bool
    {
        return config("simple-auth.methods.{$this->getIdentifier()}.enabled", true)
            && $this->hasRequiredDependencies();
    }

    /**
     * Check if the auth method has all required dependencies.
     */
    protected function hasRequiredDependencies(): bool
    {
        return true;
    }

    /**
     * Check if the current auth method is the default method.
     */
    public function isDefault(): bool
    {
        return config("simple-auth.default") === $this->getIdentifier();
    }

    /**
     * Get the identifier for the auth method.
     */
    public function getIdentifier(): string
    {
        if ($this->name) {
            return $this->name;
        }

        // Assuming subclasses will be named 'SomethingMethod', we strip 'Method'.
        return Str::snake(str_replace('Method', '', class_basename($this)));
    }

    /**
     * Get the view name for the auth method.
     */
    public function getViewName(): string
    {
        return "simple-auth::methods.{$this->getIdentifier()}";
    }

    /**
     * Get the button text for the auth method.
     */
    public function getButtonText(): string
    {
        return 'Continue with ' . $this->getName();
    }
}
