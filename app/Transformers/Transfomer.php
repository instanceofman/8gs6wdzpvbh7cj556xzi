<?php


namespace App\Transformers;


use Intass\Model;

abstract class Transfomer
{
    protected abstract function transformItem($record);

    public function transform($record)
    {
        if ($record instanceof Model) {
            $record = $record->toArray();
        }

        return $this->transformItem($record);
    }
}
