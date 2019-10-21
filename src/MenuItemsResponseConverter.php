<?php

namespace Nutnet\RKeeper7Api;

use GuzzleHttp\Psr7\Response;
use Nutnet\RKeeper7Api\Contracts\ResponseConverter as ResponseConverterInterface;
use Nutnet\RKeeper7Api\ResponseConverter;
use Nutnet\RKeeper7Api\DTO\MenuItemRkeeper7DTO;

class MenuItemsResponseConverter extends ResponseConverter implements ResponseConverterInterface {

  /**
   * @param \GuzzleHttp\Psr7\Response $response
   *
   * @return mixed|\Nutnet\RKeeper7Api\Contracts\SimpleXMLElement|\SimpleXMLElement|void
   */
  public function convert(Response $response, $as_array = FALSE) {

    $data = [];
    $xml = parent::convert($response, $as_array);
    $items = $xml->xpath('//TRK7MenuItem');

    if (!empty($items)) {

      foreach ($items as $node) {
          $item_array = $this->xmlToArray($node);

          //Значения по умолчанию, если комментарий на заполнен в Rkeeper
          $calories = $proteins = $fats = $carbohydrates = $weight = '';

          $comment = $this->convertComment($item_array['TRK7MenuItem']['attributes']['Comment']);

          if (isset($comment->calories)) {
              $calories = $comment->calories;
          }

          if (isset($comment->formulа)) {
              $formula = $this->convertFormula($comment->formulа);
              $proteins = $formula['proteins'];
              $fats = $formula['fats'];
              $carbohydrates = $formula['carbohydrates'];
          }

          if (isset($comment->weight)) {
              $weight = $comment->weight;
          }

          $dto = new MenuItemRkeeper7DTO(
              $item_array['TRK7MenuItem']['attributes']['Name'],
              $item_array['TRK7MenuItem']['attributes']['GUIDString'],
              $item_array['TRK7MenuItem']['attributes']['Parent'],
              $item_array['TRK7MenuItem']['attributes']['Ident'],
              $item_array['TRK7MenuItem']['attributes']['Code'],
              $item_array['TRK7MenuItem']['attributes']['Status'],
              $item_array['TRK7MenuItem']['attributes']['PRICETYPES-3'],
              $calories,
              $proteins,
              $fats,
              $carbohydrates,
              $weight
          );

          if (!empty($comment->diametr)) {
              $dto->setDiameter($comment->diametr);
          }

          $data[] = $dto;
      }
    }
    return $data;
  }

  private function convertComment($rkeeper_comment) {
    return json_decode($rkeeper_comment);
  }

  private function convertFormula($formula) {
    $formula_data = explode('|', $formula);

    return [
      'proteins' => (isset($formula_data[0])) ? $formula_data[0] : NULL,
      'fats' => (isset($formula_data[1])) ? $formula_data[1] : NULL,
      'carbohydrates' => (isset($formula_data[2])) ? $formula_data[2] : NULL
    ];
  }
}