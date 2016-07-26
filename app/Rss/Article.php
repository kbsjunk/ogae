<?php

namespace Ogae\Rss;

use Vinelab\Rss\Article as BaseArticle;

class Article extends BaseArticle
{
  public function __construct($article)
  {
    foreach ($article as $attribute => $value) {
      $this->info[$attribute] = (string) $value;
    }

    $ns = $article->getNamespaces(true);

    foreach($article->children($ns['dc']) as $attribute => $value) {
      $this->info[$attribute] = (string) $value;
    }

    foreach($article->children($ns['content']) as $attribute => $value) {
      $this->info[$attribute] = (string) $value;
    }
  }
}
