<?php

namespace Ogae\Rss;

use Vinelab\Rss\Parsers\XML;
use Vinelab\Rss\Exceptions\InvalidXMLException;
use Vinelab\Rss\Exceptions\InvalidFeedContentException;
use SimpleXMLElement;
use Ogae\Rss\Feed;

class XMLParser extends XML
{

  public function parse($xml)
  {
    if (!$xml instanceof SimpleXMLElement) {
      throw new InvalidXMLException();
    }
    if (!isset($xml->channel->item)) {
      throw new InvalidFeedContentException();
    }

    $xml->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
    $xml->registerXPathNamespace('content', 'http://purl.org/rss/1.0/modules/content/');

    return Feed::make((array) $xml->channel);
  }

}
