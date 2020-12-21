<?php

namespace Nutnet\RKeeper7Api\Contracts;

interface DiscountRkeeper7DTO
{
    public function getGuid(): string;

    public function getId(): int;

    public function getName(): string;

    public function getCode(): int;

    public function getStatus();

    public function isOnDish(): bool;

    public function isOnOrder(): bool;

    public function getValue(): int;
}