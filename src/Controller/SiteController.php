<?php

namespace App\Controller;

use App\Entity\Client;
use App\Enum\RequestTypeEnum;
use App\Filter\CatalogFilter;
use App\Service\BasketService;
use App\Service\BookingService;
use App\Service\CatalogService;
use App\Service\OptionService;
use App\Service\PriceService;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends Controller
{
    /**
     * @var CatalogService
     */
    private $catalogService;
    /**
     * @var OptionService
     */
    private $optionService;

    /**
     * @var PriceService $priceService
     */
    private $priceService;

    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * @var BasketService
     */
    private $basketService;

    /**
     * SiteController constructor.
     * @param CatalogService $catalogService
     * @param OptionService $optionService
     * @param PriceService $priceService
     * @param BookingService $bookingService
     * @param RegistrationService $registrationService
     * @param BasketService $basketService
     */
    public function __construct(
        CatalogService $catalogService,
        OptionService $optionService,
        PriceService $priceService,
        BookingService $bookingService,
        RegistrationService $registrationService,
        BasketService $basketService
    )
    {
        $this->catalogService = $catalogService;
        $this->optionService = $optionService;
        $this->priceService = $priceService;
        $this->bookingService = $bookingService;
        $this->registrationService = $registrationService;
        $this->basketService = $basketService;
    }

    /**
     * @Route("/catalog", name="catalog")
     * @param Request $request
     * @return Response
     */
    public function catalogAction(Request $request): Response
    {
        $filter = CatalogFilter::fromRequest($request);
        $basketItems = $this->basketService->getIndexes();

        return $this->render(
            'site/catalog.html.twig',
            [
                'options' => $this->optionService->getList(),
                'halls' => $this->catalogService->getAll(
                    $filter
                ),
                'priceService' => $this->priceService,
                'filter' => $filter,
                'basketItems' => $basketItems
            ]
        );
    }

    /**
     * @Route("/item/{id}", name="item", requirements={ "id": "\d+" })
     * @var int $id
     * @return Response
     */
    public function itemAction(int $id): Response
    {
        $item = $this->catalogService->getItem($id);
        $options = $item->getOptions();
        $prices = $this->priceService->getByHall($item);
        $price = $this->priceService->getByDate($item);
        $bookings = $item->getBooking();

        $basketItems = $this->basketService->getIndexes();

        return $this->render(
            'site/item.html.twig',
            [
                'hall' => $item,
                'options' => $options,
                'price' => $price,
                'prices' => $prices,
                'basketItems' => $basketItems,
                'bookings' => $bookings
            ]
        );
    }

    /**
     * @Route("/book/{id}", name="book", requirements={ "id": "\d+" })
     * @var Request $request
     * @var int $id
     * @return Response
     */
    public function bookAction(Request $request, int $id): Response
    {
        $item = $this->catalogService->getItem($id);
        $price = $this->priceService->getByDate($item);

        $user = $this->getUser();

        if (!($user instanceof Client)) {
            $user = null;
        }

        if ($request->isMethod(RequestTypeEnum::POST)) {
            $user = $this->getUser();
            if (null === $user) {
                $user = $this->registrationService->fromBookingRequest($request);
            }

            $booking = $this->bookingService->add(
                $request,
                $user,
                $item
            );

            return $this->redirectToRoute(
                'book_success',
                [
                    'id' => $booking->getId()
                ]
            );
        }

        return $this->render(
            'site/book.html.twig',
            [
                'hall' => $item,
                'price' => $price,
                'user' => $user
            ]
        );
    }

    /**
     * @Route("/book/success/{id}", name="book_success", requirements={ "id": "\d+" })
     * @var int $id
     * @return Response
     */
    public function bookSuccessAction(int $id): Response
    {
        $booking = $this->bookingService->getById($id);
        $user = $this->getUser();

        return $this->render(
            'site/book-success.html.twig',
            [
                'booking' => $booking,
                'user' => $user
            ]
        );
    }

    /**
     * @Route("/about", name="about")
     * @var int $id
     * @return Response
     */
    public function aboutAction(): Response
    {
        return $this->render(
            'site/about.html.twig'
        );
    }

}
