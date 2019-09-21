<?php

namespace Nutnet\RKeeper7Api\Contracts;

use Nutnet\RKeeper7Api\Contracts\Rkeeper7DTO as Rkeeper7DTOInterface;

interface CategoryRkeeper7DTO extends Rkeeper7DTOInterface
{

  public function getName();

  public function getGUID();

  public function getParentID();

  public function getID();

  public function getCode();

  public function getStatus();
}