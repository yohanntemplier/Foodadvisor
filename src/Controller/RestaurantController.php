<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Form\RestaurantSearchType;
use App\Form\SearchRestaurantType;
use App\Repository\RestaurantRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $form = $this->createForm(SearchRestaurantType::class);
        $form->handleRequest($request);

        $restaurants = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $restaurants = $restaurantRepository->findRestaurants($data);
        } else {
            $restaurants = $this->getDoctrine()->getRepository(Restaurant::Class)
                ->findAll();
        }

        $restaurant=$restaurantRepository->findAll();
        $resto = $paginator->paginate($restaurant, $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/);
        return $this->render('restaurant/index.html.twig', [
            'resto' => $resto,
            'restaurants'=> $restaurants,
            'form'        => $form->createView()
        ]);
    }


    /**
     * @Route("/{slug}-{id}", name="restaurant_show",requirements={"slug": "[a-z0-9\-]*"} ,methods={"GET","POST"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }
}