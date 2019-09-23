<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 30.05.17
 */

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\Exceptions\CantReadResponseException;

/**
 * Class ResponseConverter
 * @package Nutnet\RKeeper7Api
 */
class ResponseConverter implements ResponseConverterInterface
{

  /**
   * @param \GuzzleHttp\Psr7\Response $response
   *
   * @return mixed|\Nutnet\RKeeper7Api\Contracts\SimpleXMLElement|\SimpleXMLElement
   * @throws \Nutnet\RKeeper7Api\Exceptions\CantReadResponseException
   */
    public function convert(Response $response, $as_array = true)
    {
        @$xml = simplexml_load_string($response->getBody()->getContents());

        if (false === $xml) {
            throw new CantReadResponseException('Error parsing xml response');
        }

        return ($as_array) ? $this->xmlToArray($xml) : $xml;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array
     */
    protected function xmlToArray(\SimpleXMLElement $xml): array
    {
      $parser = function (\SimpleXMLElement $xml, array $collection = []) use (&$parser) {
        $nodes = $xml->children();
        $attributes = $xml->attributes();

        if (0 !== count($attributes)) {
          foreach ($attributes as $attrName => $attrValue) {
            $collection['attributes'][$attrName] = strval($attrValue);
          }
        }

        if (0 === $nodes->count()) {
          $collection['value'] = strval($xml);
          return $collection;
        }

        foreach ($nodes as $nodeName => $nodeValue) {
          if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
            $collection[$nodeName] = $parser($nodeValue);
            continue;
          }

          $collection[$nodeName][] = $parser($nodeValue);
        }

        return $collection;
      };

      return [
        $xml->getName() => $parser($xml)
      ];
    }

    public function is_assoc($var)
    {
      return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
    }
}
