<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 30.05.17
 */

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\ResponseConverter;
use Nutnet\RKeeper7Api\DTO\CategoryRkeeper7DTO;

/**
 * Class ResponseConverter
 * @package Nutnet\RKeeper7Api
 */
class CateglistResponseConverter extends ResponseConverter implements ResponseConverterInterface
{

  /**
   * @param \GuzzleHttp\Psr7\Response $response
   * @param bool $as_array
   *
   * @return array|mixed|\Nutnet\RKeeper7Api\Contracts\SimpleXMLElement|\SimpleXMLElement
   * @throws \Nutnet\RKeeper7Api\Exceptions\CantReadResponseException
   */
  public function convert(Response $response, $as_array = TRUE)
  {
    $data = [];

    //Преобразуем ответ
    $response_data = parent::convert($response, $as_array);

    if (isset($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'])
        && !$this->is_assoc($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'])) {

      foreach ($response_data['RK7QueryResult']['RK7Reference']['Items']['Item']['RIChildItems']['TCategListItem'] as $node) {
          $data[] = new CategoryRkeeper7DTO(
              $node['attributes']['Name'],
              $node['attributes']['GUIDString'],
              $node['attributes']['Parent'],
              $node['attributes']['Ident'],
              $node['attributes']['Code'],
              $node['attributes']['Status']
          );

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

      foreach ($RIChildItems['TCategListItem'] as $node) {
          $data[] = new CategoryRkeeper7DTO(
              $node['attributes']['Name'],
              $node['attributes']['GUIDString'],
              $node['attributes']['Parent'],
              $node['attributes']['Ident'],
              $node['attributes']['Code'],
              $node['attributes']['Status']
          );

          if (isset($node['RIChildItems'])) {
              $this->convert_childrens($node['RIChildItems'], $data);
          }
      }
    } else {

      $data[] = new CategoryRkeeper7DTO(
        $RIChildItems['TCategListItem']['attributes']['Name'],
        $RIChildItems['TCategListItem']['attributes']['GUIDString'],
        $RIChildItems['TCategListItem']['attributes']['Parent'],
        $RIChildItems['TCategListItem']['attributes']['Ident'],
        $RIChildItems['TCategListItem']['attributes']['Code'],
        $RIChildItems['TCategListItem']['attributes']['Status']
      );
    }
  }
}
