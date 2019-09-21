<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\ResponseConverter;

class MenuItemsResponseConverter extends ResponseConverter implements ResponseConverterInterface
{
  /**
   * @param \GuzzleHttp\Psr7\Response $response
   *
   * @return mixed|\Nutnet\RKeeper7Api\Contracts\SimpleXMLElement|\SimpleXMLElement|void
   */
  public function convert(Response $response, $as_array = FALSE) {

    $xml = parent::convert($response, $as_array);

    while(list( , $node) = each($xml->xpath('//TRK7MenuItem'))) {
      $item_array = $this->xmlToArray($node);
      $test = 0;
    }
  }
}