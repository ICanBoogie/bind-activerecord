<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord;

class SampleRecord extends ActiveRecord
{
    public string $email;

    /**
     * @inheritdoc
     */
    public function create_validation_rules(): array
    {
        return [

            'email' => 'required|email'

        ];
    }
}
