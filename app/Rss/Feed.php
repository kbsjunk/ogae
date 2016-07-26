<?php

namespace Ogae\Rss;

use Vinelab\Rss\Feed as BaseFeed;

class Feed extends BaseFeed
{
  public function addArticle($entry)
  {
      $article = Article::make($entry);
      $this->articles->push($article);
      return $article;
  }
}
