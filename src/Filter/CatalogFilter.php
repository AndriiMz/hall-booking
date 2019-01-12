<?php

namespace App\Filter;

use Symfony\Component\HttpFoundation\Request;

class CatalogFilter
{
    /**
     * @var int
     */
    public $priceFrom;

    /**
     * @var int
     */
    public $priceTo;

    /**
     * @var \DateTime
     */
    public $dateFrom;

    /**
     * @var \DateTime
     */
    public $dateTo;

    /**
     * @var array
     */
    public $options;

    /**
     * @param Request $request
     * @return CatalogFilter
     */
    public static function fromRequest(Request $request): CatalogFilter
    {
        $instance = new self();

        $price = $request->get('price');
        if ($price) {
            $instance->priceFrom = (int)$price['from'];
            $instance->priceTo = (int)$price['to'];
        }

        $date = $request->get('date');
        if ($date) {
            $instance->dateFrom = new \DateTime($date['from']);
            $instance->dateTo = new \DateTime($date['to']);
        }

        $options = $request->get('options');
        $instance->options = $options;

        return $instance;
    }


    /**
     * @return bool
     */
    public function hasPriceFiltering(): bool
    {
        return $this->priceFrom ||
            $this->priceTo ||
            $this->dateFrom ||
            $this->dateTo;
    }
}
