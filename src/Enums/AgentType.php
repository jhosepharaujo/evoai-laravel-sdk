<?php

namespace EvoAi\LaravelSdk\Enums;

enum AgentType: string
{
    case LLM = 'llm';
    case Sequential = 'sequential';
    case Parallel = 'parallel';
    case Loop = 'loop';
    case A2A = 'a2a';
    case Workflow = 'workflow';
    case Task = 'task';

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
