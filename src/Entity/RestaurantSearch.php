<?php

namespace App\Entity;

class RestaurantSearch{

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $cost;

    /**
     * @var integer|null
     */
    private $distance;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return RestaurantSearch
     */
    public function setName(?string $name): RestaurantSearch
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return RestaurantSearch
     */
    public function setType(?string $type): RestaurantSearch
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * @param string|null $cost
     * @return RestaurantSearch
     */
    public function setCost(?string $cost): RestaurantSearch
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * @param int|null $distance
     * @return RestaurantSearch
     */
    public function setDistance(?int $distance): RestaurantSearch
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     * @return RestaurantSearch
     */
    public function setLat(?float $lat): RestaurantSearch
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     * @return RestaurantSearch
     */
    public function setLng(?float $lng): RestaurantSearch
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return RestaurantSearch
     */
    public function setAddress(?string $address): RestaurantSearch
    {
        $this->address = $address;
        return $this;
    }



}