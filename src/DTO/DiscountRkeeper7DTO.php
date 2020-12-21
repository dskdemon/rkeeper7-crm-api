<?php

namespace Nutnet\RKeeper7Api\DTO;

use Nutnet\RKeeper7Api\DTO\Rkeeper7DTO;
use Nutnet\RKeeper7Api\Contracts\DiscountRkeeper7DTO as DiscountRkeeper7DTOInterface;

class DiscountRkeeper7DTO extends Rkeeper7DTO implements DiscountRkeeper7DTOInterface
{
    /**
     * @var string Rkeeper Guid
     */
    private $guid;

    /**
     * @var integer Rkeeper ID
     */
    private $id;

    /**
     * @var string Название
     */
    private $name;

    /**
     * @var string Code
     */
    private $code;

    /**
     * @var string Статус
     */
    private $status;

    /**
     * @var bool Флаг: Скидка для блюда
     */
    private $on_dish;

    /**
     * @var bool Флаг: скидка на заказ
     */
    private $on_order;

    /**
     * @var integer Значение в тысячных
     */
    private $value;

    public function __construct($guid, $id, $name, $code, $status, $on_dish, $on_order, $value)
    {
        $this->guid = $guid;
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->status = $status;
        $this->on_dish = $on_dish;
        $this->on_order = $on_order;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return intval($this->id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return intval($this->code);
    }

    /**
     * @return mixed
     */
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

    /**
     * @return bool
     */
    public function isOnDish(): bool
    {
        return filter_var($this->on_dish, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return bool
     */
    public function isOnOrder(): bool
    {
        return filter_var($this->on_order, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return intval($this->value);
    }
}

