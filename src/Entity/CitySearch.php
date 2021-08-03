<?php

namespace App\Entity;

class CitySearch
{
    private $citySearchName;


    /**
     * Get the value of citySearchName
     */
    public function getCitySearchName()
    {
        return $this->citySearchName;
    }

    /**
     * Set the value of citySearchName
     */
    public function setCitySearchName($citySearchName): self
    {
        $this->citySearchName = $citySearchName;

        return $this;
    }
}
