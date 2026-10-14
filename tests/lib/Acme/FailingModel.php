<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord\Model;
use RuntimeException;

/**
 * A model that fails to install.
 *
 * @extends Model<Node>
 */
class FailingModel extends Model
{
    public function install(): void
    {
        throw new RuntimeException("Unable to install");
    }
}
