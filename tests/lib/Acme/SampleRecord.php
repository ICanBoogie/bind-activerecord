<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
