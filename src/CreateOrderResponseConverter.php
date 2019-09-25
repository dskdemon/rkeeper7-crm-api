<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\Exceptions\CreateOrderResponseError;
use Nutnet\RKeeper7Api\Exceptions\CreateOrderResponseSchemaError;

class CreateOrderResponseConverter extends ResponseConverter implements ResponseConverterInterface
{
  public function convert(Response $response, $as_array = TRUE) {
    $data = [];

    //Преобразуем ответ
    $response_data = parent::convert($response, $as_array);

    if (!isset($response_data['RK7QueryResult']['attributes']['Status'])) {
      throw new CreateOrderResponseSchemaError();
    }

    if ($response_data['RK7QueryResult']['attributes']['Status'] == 'Ok') {

      $data['order_id'] = $response_data['RK7QueryResult']['attributes']['OrderID'];
      $data['guid'] = $response_data['RK7QueryResult']['attributes']['guid'];

    } else {
        throw new CreateOrderResponseError();
    }

    return $data;
  }
}