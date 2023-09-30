<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord\Schema\Date;
use ICanBoogie\ActiveRecord\Schema\Text;

class Article extends Node
{
    #[Text]
    public string $body;

    #[Date]
    public string $date;
}
