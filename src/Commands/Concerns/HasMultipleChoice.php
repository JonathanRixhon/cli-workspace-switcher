<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

use Symfony\Component\Console\Question\ChoiceQuestion;

trait HasMultipleChoice
{
    protected function multiChoice($message, $choices)
    {
        $question = new ChoiceQuestion(
            $message,
            array_values($choices),
            0
        );

        $question->setAutocompleterValues(array_keys($choices));
        $helper = $this->getHelper('question');
        return $helper->ask($this->input, $this->output, $question);
    }
}
