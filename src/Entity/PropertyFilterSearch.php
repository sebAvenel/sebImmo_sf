<?php

namespace App\Entity;


class PropertyFilterSearch
{
    /**
     * @var int|null
     */
    public $maxValue;

    /**
     * @var int|null
     */
    public $minSurface;



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
}
