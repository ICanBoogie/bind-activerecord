<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\Schema\Character;
use ICanBoogie\ActiveRecord\Schema\Id;
use ICanBoogie\ActiveRecord\Schema\Serial;

class Node extends ActiveRecord
{
    #[Serial, Id]
    public int $id;

    #[Character]
    public string $title;
}
