<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Services;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\ChoiceQuestion;

class InputOutput extends SymfonyStyle
{
    /**
     * Ask a question and return the answer.
     */
    public function question(string $question): string
    {
        return $this->ask(sprintf($question));
    }
}
