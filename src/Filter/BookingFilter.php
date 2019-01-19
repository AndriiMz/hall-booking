<?php

namespace App\Filter;

use Symfony\Component\HttpFoundation\Request;

class BookingFilter
{
    /**
     * @var \DateTime
     */
    public $dateFrom;

    /**
     * @var \DateTime
     */
    public $dateTo;

    /**
     * @param Request $request
     * @return BookingFilter
     */
    public static function fromRequest(Request $request): BookingFilter
    {
        $instance = new self();


        $date = $request->get('date');
        if ($date && !empty($date['from'])) {
            $instance->dateFrom = new \DateTime($date['from']);
        }

        if ($date && !empty($date['to'])) {
            $instance->dateTo = new \DateTime($date['to']);
        }

        return $instance;
    }
}
