<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

use Symfony\Component\Console\Question\ChoiceQuestion;

trait HasMultipleChoice
{
    protected function multiChoice($message, $choices, $hasCancel = false)
    {
        if ($hasCancel) $choices[] = 'Cancel';

        $question = new ChoiceQuestion(
            $message,
            $choices,
            0
        );

        $question->setAutocompleterValues($choices);
        $helper = $this->getHelper('question');
        return $helper->ask($this->input, $this->output, $question);
    }
}
