<?php

namespace Nutnet\RKeeper7Api\DTO;

use Nutnet\RKeeper7Api\Contracts\CategoryRkeeper7DTO as CategoryRkeeper7DTOInterface;
use Nutnet\RKeeper7Api\DTO\Rkeeper7DTO;

class CategoryRkeeper7DTO extends Rkeeper7DTO implements CategoryRkeeper7DTOInterface {

  /**
   * @var Название категории
   */
  private $name;

  /**
   * @var Rkeeper GUID
   */
  private $guid;

  /**
   * @var Rkeeper parent ident
   */
  private $parent_id;

  /**
   * @var Rkeeper ID
   */
  private $ident;

  /**
   * @var Rkeeper code
   */
  private $code;

  /**
   * @var Rkeeper статус категории
   */
  private $status;

  /**
   * CategoryRkeeper7DTO constructor.
   *
   * @param $name
   * @param $guid
   * @param $parent_id
   * @param $ident
   * @param $code
   * @param $status
   */
  public function __construct($name, $guid, $parent_id, $ident, $code, $status) {
    $this->name = $name;
    $this->guid = $guid;
    $this->parent_id = $parent_id;
    $this->ident = $ident;
    $this->code = $code;
    $this->status = $status;
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
    return $this->ident;
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
      return 3;
    }

    return 0;
  }

  public function isDeleted() {
      return ($this->status == 'rsDeleted') ? true : false;
  }
}