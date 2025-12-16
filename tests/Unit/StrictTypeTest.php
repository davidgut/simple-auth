<?php

use DavidGut\SimpleAuth\Method;
use DavidGut\SimpleAuth\MethodManager;
use DavidGut\SimpleAuth\Methods\MagicLinkMethod;
use DavidGut\SimpleAuth\Methods\PasswordMethod;
use Illuminate\Support\Collection;

it('enforces strict return types for getMethod', function () {
    config()->set('simple-auth.methods', [
        'password' => ['class' => PasswordMethod::class],
    ]);

    $manager = new MethodManager(app());
    $method = $manager->getMethod('password');

    expect($method)->toBeInstanceOf(Method::class)
        ->and($method)->toBeInstanceOf(PasswordMethod::class);
});

it('enforces strict return types for getMethods', function () {
    config()->set('simple-auth.methods', [
        'password' => ['class' => PasswordMethod::class],
    ]);

    $manager = new MethodManager(app());
    $methods = $manager->getMethods();

    expect($methods)->toBeInstanceOf(Collection::class)
        ->and($methods->first())->toBeInstanceOf(Method::class);
});

it('enforces strict return types for getDefaultMethod', function () {
    config()->set('simple-auth.methods', [
        'password' => ['class' => PasswordMethod::class],
    ]);
    config()->set('simple-auth.default', 'password');

    $manager = new MethodManager(app());
    $method = $manager->getDefaultMethod();

    expect($method)->toBeInstanceOf(Method::class)
        ->and($method)->toBeInstanceOf(PasswordMethod::class);
});

it('returns null when method does not exist or extends wrong class', function () {
    $manager = new MethodManager(app());
    expect($manager->getMethod('invalid'))->toBeNull();
});
