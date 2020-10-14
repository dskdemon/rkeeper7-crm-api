<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\Exceptions\SaveOrderResponseError;
use Nutnet\RKeeper7Api\Exceptions\SaveOrderResponseSchemaError;

class SaveOrderResponseConverter extends ResponseConverter implements ResponseConverterInterface
{
  public function convert(Response $response, $as_array = TRUE) {
    $data = [];

    //Преобразуем ответ
    $response_data = parent::convert($response, $as_array);

    if(!isset($response_data['RK7QueryResult']['attributes']['Status'])) {
    	throw new SaveOrderResponseSchemaError($response_data['RK7QueryResult']['attributes']['ErrorText']);
    }

    if ($response_data['RK7QueryResult']['attributes']['Status'] != 'Ok') {
    	throw new SaveOrderResponseError($response_data['RK7QueryResult']['attributes']['ErrorText']);
    }

    if ($response_data['RK7QueryResult']['attributes']['CMD'] == 'SaveOrder') {
        $data['order_id'] = $response_data['RK7QueryResult']['Order']['attributes']['orderIdent'];
        $data['guid'] = $response_data['RK7QueryResult']['Order']['attributes']['guid'];
    }

    return $data;
  }
}