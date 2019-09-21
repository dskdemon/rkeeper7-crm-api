<?php

namespace Nutnet\RKeeper7Api\Contracts;

use Nutnet\RKeeper7Api\Contracts\Rkeeper7DTO as Rkeeper7DTOInterface;

interface MenuItemRkeeper7DTO extends Rkeeper7DTOInterface
{
  public function getName();

  public function getGUID();

  public function getParentID();

  public function getID();

  public function getCode();

  public function getStatus();

  public function getPrice();

  public function getCalories();

  public function getProteins();

  public function getFats();

  public function getCarbohydrates();

  public function getWeight();

  public function getDiameter();
}