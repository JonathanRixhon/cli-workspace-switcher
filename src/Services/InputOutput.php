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

    /**
     * Display a message in case of right answer.
     */
    public function right(string $message): void
    {
        $this->block($message, null, 'fg=white;bg=green', ' ', true);
    }

    /**
     * Display a message in case of wrong answer.
     */
    public function wrong(string $message): void
    {
        $this->block($message, null, 'fg=white;bg=red', ' ', true);
    }
}
