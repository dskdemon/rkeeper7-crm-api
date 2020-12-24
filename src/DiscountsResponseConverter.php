<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\DTO\DiscountRkeeper7DTO;
use Nutnet\RKeeper7Api\ResponseConverter;

class DiscountsResponseConverter extends ResponseConverter implements ResponseConverterInterface {

    const DISCOUNT_GROUP_ID = "1000025";

    public function convert(Response $response, $as_array = false)
    {
        $data = [];

        $xml = parent::convert($response, $as_array);
        $items = $xml->xpath('//RK7Reference/Items/Item[@Parent= ' . self::DISCOUNT_GROUP_ID . ']');

        if ($items) {
            foreach ($items as $item) {
               $data[] =  $this->processDiscountItem($item);
            }
        }

        return $data;
    }

    protected function processDiscountItem(\SimpleXMLElement $item)
    {
        $node = $this->xmlToArray($item);
        $value = ($this->is_assoc($node['Item']['RIChildItems']['TDiscountDetail'])) ? $node['Item']['RIChildItems']['TDiscountDetail']['attributes']['DPercent'] : $node['Item']['RIChildItems']['TDiscountDetail'][0]['attributes']['DPercent'];

        return new DiscountRkeeper7DTO(
            $node['Item']['attributes']['GUIDString'],
            $node['Item']['attributes']['Ident'],
            $node['Item']['attributes']['Name'],
            $node['Item']['attributes']['Code'],
            $node['Item']['attributes']['Status'],
            $node['Item']['attributes']['OnDish'],
            $node['Item']['attributes']['OnOrder'],
            $value
        );
    }
}
