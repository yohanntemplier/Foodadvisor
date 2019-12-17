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


}