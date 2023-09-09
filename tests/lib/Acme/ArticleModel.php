<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

class ArticleModel extends NodeModel
{
    protected static string $activerecord_class = Article::class;
}
