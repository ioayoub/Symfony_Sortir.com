<?php

namespace App\Entity;

class CampusSearch
{
    private $campusSearchName;



    /**
     * Get the value of campusSearchName
     */
    public function getCampusSearchName()
    {
        return $this->campusSearchName;
    }

    /**
     * Set the value of campusSearchName
     */
    public function setCampusSearchName($campusSearchName): self
    {
        $this->campusSearchName = $campusSearchName;

        return $this;
    }
}
