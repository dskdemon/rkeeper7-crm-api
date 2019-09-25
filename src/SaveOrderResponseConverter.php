<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;

class SaveOrderResponseConverter extends ResponseConverter implements ResponseConverterInterface
{
  public function convert(Response $response, $as_array = TRUE) {
    $data = [];

    //Преобразуем ответ
    $response_data = parent::convert($response, $as_array);

    return $data;
  }
}