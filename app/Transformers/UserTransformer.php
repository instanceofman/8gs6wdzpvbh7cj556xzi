<?php


namespace App\Transformers;


class UserTransformer extends Transfomer
{
    protected function transformItem($record)
    {
        return [
            'name' => $record['name'],
            'email' => $record['email'],
            'address' => $record['address'],
            'tel' => $record['tel']
        ];
    }
}
