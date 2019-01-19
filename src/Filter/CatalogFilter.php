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
     * @var array
     */
    public $sort;

    /**
     * @var string
     */
    public $sortRaw;


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
        if ($date && !empty($date['from'])) {
            $instance->dateFrom = new \DateTime($date['from']);
        }

        if ($date && !empty($date['to'])) {
            $instance->dateTo = new \DateTime($date['to']);
        }

        $options = $request->get('options');
        $instance->options = $options;

        $instance->sort = $request->get('sort');

        if (!empty($instance->sort)) {
            $instance->sort = array_filter(
                $instance->sort,
                function($item) {
                    return !empty($item);
                }
            );


            $instance->sortRaw = implode('', array_map(
                function ($v, $k) { return sprintf('%s.%s', $k, $v); },
                $instance->sort,
                array_keys($instance->sort)
            ));
        }

        return $instance;
    }

    /**
     * @param $sortColumn
     * @return bool
     */
    public function hasSortColumn($sortColumn): bool
    {
        return $this->sortRaw && $this->sortRaw === $sortColumn;
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
