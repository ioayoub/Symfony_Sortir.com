<?php

namespace App\Entity;

class TripSearch
{
    private $campusSearch;
    private $manualSearch;
    private $startDateSearch;
    private $endDateSearch;
    private $isOrganizerSearch;
    private $isSubscribedSearch;
    private $isNotSubscribedSearch;
    private $isOutdatedSearch;

    /**
     * Get the value of campusSearch
     */
    public function getCampusSearch()
    {
        return $this->campusSearch;
    }

    /**
     * Set the value of campusSearch
     * @var string|null
     */
    public function setCampusSearch($campusSearch): self
    {
        $this->campusSearch = $campusSearch;

        return $this;
    }

    /**
     * Get the value of manualSearch
     */
    public function getManualSearch()
    {
        return $this->manualSearch;
    }

    /**
     * Set the value of manualSearch
     */
    public function setManualSearch($manualSearch): self
    {
        $this->manualSearch = $manualSearch;

        return $this;
    }

    /**
     * Get the value of startDateSearch
     */
    public function getStartDateSearch()
    {
        return $this->startDateSearch;
    }

    /**
     * Set the value of startDateSearch
     */
    public function setStartDateSearch($startDateSearch): self
    {
        $this->startDateSearch = $startDateSearch;

        return $this;
    }

    /**
     * Get the value of endDateSearch
     */
    public function getEndDateSearch()
    {
        return $this->endDateSearch;
    }

    /**
     * Set the value of endDateSearch
     */
    public function setEndDateSearch($endDateSearch): self
    {
        $this->endDateSearch = $endDateSearch;

        return $this;
    }

    /**
     * Get the value of isOrganizerSearch
     */
    public function getIsOrganizerSearch()
    {
        return $this->isOrganizerSearch;
    }

    /**
     * Set the value of isOrganizerSearch
     */
    public function setIsOrganizerSearch($isOrganizerSearch): self
    {
        $this->isOrganizerSearch = $isOrganizerSearch;

        return $this;
    }

    /**
     * Get the value of isSubribedSearch
     */
    public function getIsSubscribedSearch()
    {
        return $this->isSubscribedSearch;
    }

    /**
     * Set the value of isSubribedSearch
     * 
     */
    public function setIsSubscribedSearch($isSubscribedSearch): self
    {
        $this->isSubscribedSearch = $isSubscribedSearch;

        return $this;
    }

    /**
     * Get the value of isNotSubcribedSearch
     */
    public function getIsNotSubscribedSearch()
    {
        return $this->isNotSubscribedSearch;
    }

    /**
     * Set the value of isNotSubcribedSearch
     */
    public function setIsNotSubcribedSearch($isNotSubscribedSearch): self
    {
        $this->isNotSubscribedSearch = $isNotSubscribedSearch;

        return $this;
    }

    /**
     * Get the value of isOutdatedSearch
     */
    public function getIsOutdatedSearch()
    {
        return $this->isOutdatedSearch;
    }

    /**
     * Set the value of isOutdatedSearch
     */
    public function setIsOutdatedSearch($isOutdatedSearch): self
    {
        $this->isOutdatedSearch = $isOutdatedSearch;

        return $this;
    }
}
