<?php

namespace Nutnet\RKeeper7Api\DTO;

use Nutnet\RKeeper7Api\Contracts\MenuItemRkeeper7DTO as MenuItemRkeeper7DTOInterface;
use Nutnet\RKeeper7Api\DTO\Rkeeper7DTO;

class MenuItemRkeeper7DTO extends Rkeeper7DTO implements MenuItemRkeeper7DTOInterface {

  /**
   * @var Название блюда
   */
  private $name;

  /**
   * @var Rkeeper Guid
   */
  private $guid;

  /**
   * @var Rkeeper parent Ident
   */
  private $parent_id;

  /**
   * @var Rkeeper Ident
   */
  private $id;

  /**
   * @var Rkeeper Code
   */
  private $code;

  /**
   * @var Rkeerep Status
   */
  private $status;

  /**
   * @var  Rkeeper Price
   */
  private $price;

  /**
   * @var Энергетическая ценность
   */
  private $calories;

  /**
   * @var Белки
   */
  private $proteins;

  /**
   * @var Жиры
   */
  private $fats;

  /**
   * @var Углеводы
   */
  private $carbohydrates;

  /**
   * @var Вес
   */
  private $weight;

  /**
   * @var Диаметр пиццы
   */
  private $diameter = NULL;

  public function __construct($name, $guid, $parent_id, $id, $code, $status, $price, $calories, $proteins, $fats, $carbohydrates, $weight) {
    $this->name = $name;
    $this->guid = $guid;
    $this->parent_id = $parent_id;
    $this->id = $id;
    $this->code = $code;
    $this->status = $status;
    $this->price = $price;
    $this->calories = $calories;
    $this->proteins = $proteins;
    $this->fats = $fats;
    $this->carbohydrates = $carbohydrates;
    $this->weight = $weight;

  }


  public function getName() {
    return $this->name;
  }

  public function getGUID() {
    return $this->guid;
  }

  public function getParentID() {
    return $this->parent_id;
  }

  public function getID() {
    return $this->id;
  }

  public function getCode() {
    return $this->code;
  }

  public function getStatus() {

    if ($this->status == 'rsActive') {
      return 1;
    }

    if ($this->status == 'rsInactive') {
      return 0;
    }

    if ($this->status == 'rsDeleted') {
      return 0;
    }

    return 0;
  }

  public function getCalories() {
    return $this->calories;
  }

  public function getProteins() {
    return $this->proteins;
  }

  public function getFats() {
    return $this->fats;
  }

  public function getCarbohydrates() {
    return $this->carbohydrates;
  }

  public function getWeight() {
    return $this->weight;
  }

  public function getDiameter() {
    return $this->diameter;
  }

  public function setDiameter($diameter) {
    $this->diameter = $diameter;
  }

  public function getPrice() {
    return $this->price/100;
  }

}