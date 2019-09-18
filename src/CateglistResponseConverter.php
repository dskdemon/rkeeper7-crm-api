<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 30.05.17
 */

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\ResponseConverter;

/**
 * Class ResponseConverter
 * @package Nutnet\RKeeper7Api
 */
class CateglistResponseConverter extends ResponseConverter implements ResponseConverterInterface
{

  /**
   * @param \GuzzleHttp\Psr7\Response $response
   *
   * @return mixed|\SimpleXMLElement
   * @throws \Nutnet\RKeeper7Api\Exceptions\CantReadResponseException
   */
  public function convert(Response $response)
  {
    $data = [];

    //Преобразуем ответ
    $response_data = parent::convert($response);

    if (isset($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'])
        && !$this->is_assoc($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'])) {

      while(list( , $node) = each($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'])) {
        $data[] = [
          'rkeeper_name' => $node['attributes']['Name'],
          'rkeeper_parent' => $node['attributes']['Parent'],
          'rkeeper_Ident' => $node['attributes']['Ident'],
          'rkeeper_Code' => $node['attributes']['Code']
        ];

        if (isset($node['RIChildItems'])) {
          $this->convert_childrens($node['RIChildItems'], $data);
        }
      }

    }

    return $data;
  }

  public function convert_childrens($RIChildItems, &$data)
  {

    if (!$this->is_assoc($RIChildItems['TCategListItem'])) {
      while(list( , $node) = each($RIChildItems['TCategListItem'])) {
        $data[] = [
          'rkeeper_name' => $node['attributes']['Name'],
          'rkeeper_parent' => $node['attributes']['Parent'],
          'rkeeper_Ident' => $node['attributes']['Ident'],
          'rkeeper_Code' => $node['attributes']['Code']
        ];

        if (isset($node['RIChildItems'])) {
          $this->convert_childrens($node['RIChildItems'], $data);
        }
      }
    } else {
      $data[] = [
        'rkeeper_name' => $RIChildItems['TCategListItem']['attributes']['Name'],
        'rkeeper_parent' => $RIChildItems['TCategListItem']['attributes']['Parent'],
        'rkeeper_Ident' => $RIChildItems['TCategListItem']['attributes']['Ident'],
        'rkeeper_Code' => $RIChildItems['TCategListItem']['attributes']['Code']
      ];
    }
  }
}
