<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord;

class Node extends ActiveRecord
{
    public int $id;
    public string $title;
}
