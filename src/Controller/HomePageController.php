<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/foodadvisor", name="home_page")
     */
    public function index(RestaurantRepository $restaurantRepository)
    {
        $lastRestaurant = $restaurantRepository->findLatest();
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'restaurants' => $lastRestaurant,
        ]);
    }
}
