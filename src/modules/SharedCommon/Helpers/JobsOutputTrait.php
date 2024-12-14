<?php

namespace Modules\SharedCommon\Helpers;

trait JobsOutputTrait {
    public function printStart(string $task, string $otherAttributes = ""): void {
        if (empty($task))
            throw new \Exception("task is required");

        $attribute = $this->attribute($otherAttributes);
        echo "STARTING | {$task}{$attribute}" . PHP_EOL;
    }

    public function printError(string $task, \Exception $e, string $otherAttributes = ""): void {
        if (empty($task))
            throw new \Exception("task is required");

        $attribute = $this->attribute($otherAttributes);
        echo "ERROR | {$task}{$attribute} | Message: {$e->getMessage()}" . PHP_EOL . PHP_EOL;
    }

    public function printFinish(string $task, string $otherAttributes = ""): void {
        if (empty($task))
            throw new \Exception("task is required");

        $attribute = $this->attribute($otherAttributes);
        echo "FINISH | {$task}{$attribute}" . PHP_EOL . PHP_EOL;
    }

    private function attribute(string $otherAttributes = ""): string {
        return empty($otherAttributes) ?  "" : " | {$otherAttributes}";
    }
}
