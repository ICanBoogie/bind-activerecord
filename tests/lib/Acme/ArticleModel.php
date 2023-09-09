<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord\Model\Record;

#[Record(Article::class)]
class ArticleModel extends NodeModel
{
}
