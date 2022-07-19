<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyFilterSearch
{
    /**
     * @var int|null
     */
    public $minValue;

    /**
     * @var int|null
     */
    public $maxValue;

    /**
     * @var int|null
     * @Assert\GreaterThan(10)
     */
    public $minSurface;

    /**
     * @var int|null
     * @Assert\LessThan(5000)
     */
    public $maxSurface;

    /**
     * @var int|null
     * @Assert\GreaterThanOrEqual(1)
     */
    public $rooms;

    /**
     * @var int|null
     * @Assert\GreaterThanOrEqual(1)
     */
    public $bedrooms;

    /**
     * @var int|null
     */
    public $heat;

    /**
     * @var string|null
     */
    public $city;

    /**
     * @var string|null
     */
    public $postalCode;

    /**
     * Get the value of minValue
     */
    public function getMinValue(): ?int
    {
        return $this->minValue;
    }

    /**
     * Set the value of minValue
     */
    public function setMinValue(?int $minValue): self
    {
        $this->minValue = $minValue;

        return $this;
    }

    /**
     * Get the value of maxValue
     */
    public function getMaxValue(): ?int
    {
        return $this->maxValue;
    }

    /**
     * Set the value of maxValue
     */
    public function setMaxValue(?int $maxValue): self
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    /**
     * Get the value of minSurface
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     */
    public function setMinSurface(?int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * Get the value of maxSurface
     */
    public function getMaxSurface(): ?int
    {
        return $this->maxSurface;
    }

    /**
     * Set the value of maxSurface
     */
    public function setMaxSurface(?int $maxSurface): self
    {
        $this->maxSurface = $maxSurface;

        return $this;
    }

    /**
     * Get the value of rooms
     */
    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    /**
     * Set the value of rooms
     */
    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get the value of bedrooms
     */
    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    /**
     * Set the value of bedrooms
     */
    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get the value of heat
     */
    public function getHeat(): ?int
    {
        return $this->heat;
    }

    /**
     * Set the value of heat
     */
    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
