<?php

arch('DTOs are readonly classes')
    ->expect('EvoAi\LaravelSdk\DTOs')
    ->toBeReadonly()
    ->ignoring('EvoAi\LaravelSdk\DTOs\Concerns');

arch('Services are final readonly classes')
    ->expect('EvoAi\LaravelSdk\Services')
    ->toBeFinal()
    ->toBeReadonly();

arch('Enums are backed string enums')
    ->expect('EvoAi\LaravelSdk\Enums')
    ->toBeEnums();

arch('No debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

arch('DTOs implement Arrayable')
    ->expect('EvoAi\LaravelSdk\DTOs')
    ->toImplement(\Illuminate\Contracts\Support\Arrayable::class)
    ->ignoring('EvoAi\LaravelSdk\DTOs\Concerns');

arch('Events are readonly classes')
    ->expect('EvoAi\LaravelSdk\Events')
    ->toBeReadonly();

arch('Exceptions extend EvoAiException')
    ->expect('EvoAi\LaravelSdk\Exceptions')
    ->toExtend(\EvoAi\LaravelSdk\Exceptions\EvoAiException::class)
    ->ignoring(\EvoAi\LaravelSdk\Exceptions\EvoAiException::class);
