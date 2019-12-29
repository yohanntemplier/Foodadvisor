<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Form\CommentType;
use App\Form\RestaurantSearchType;
use App\Form\SearchRestaurantType;
use App\Repository\CommentRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @param RestaurantRepository $restaurantRepository
     * @param CommentRepository $commentRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(RestaurantRepository $restaurantRepository,CommentRepository $commentRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $search = new RestaurantSearch();
        $form = $this->createForm(RestaurantSearchType::class, $search);
        $form->handleRequest($request);
        $restaurant = $restaurantRepository->findAllRestaurantsQuery($search);
        $restaurants = [];
        foreach ($restaurant as $key => $resto)
        {
            $restaurants[$key]["averageScore"] = $commentRepository->findAverageOfAllActiveReviewsForOneRestaurant($resto);
            $restaurants[$key]["restaurant"] = $resto;
        }        $restaurantsPaginated = $paginator->paginate($restaurants, $request->query->getInt('page', 1), /*page number*/
        6 /*limit per page*/);
        return $this->render('restaurant/index.html.twig', [
            'restaurants'=> $restaurantsPaginated,
            'moyenne' => $restaurants[$key]["averageScore"],
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{slug}-{id}", name="restaurant_show",requirements={"slug": "[a-z0-9\-]*"} ,methods={"GET","POST"})
     */
    public function show(Restaurant $restaurant,CommentRepository $commentRepository ,Request $request): Response
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy([
            'restaurants' => $restaurant,
            'isActive' => 1
        ],['date' => 'desc'
        ]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $moyenne = $commentRepository->findAverageOfAllActiveReviewsForOneRestaurant($restaurant);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setRestaurants($restaurant);
            $comment->setDate(new \DateTime('now'));

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($comment);
            $doctrine->flush();
            $this->addFlash('success','Votre commentaire est bien enregistré');

            return $this->redirectToRoute('restaurant_show',[
                    'id' => $restaurant->getId(),
                    'slug' => $restaurant->getSlug()
                ]);
        }
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            'comments' => $comments,
            'moyenne' => $moyenne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/comment", name="restaurant_comment",methods={"GET","POST"})
     */
    public function Comment(Restaurant $restaurant, CommentRepository $commentRepository): Response
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy([
            'restaurants' => $restaurant,
            'isActive' => 1
        ],['date' => 'desc'
        ]);
        $moyenne = $commentRepository->findAverageOfAllActiveReviewsForOneRestaurant($restaurant);
        return $this->render('restaurant/comment.html.twig', [
            'restaurant' => $restaurant,
            'comments' => $comments,
            'moyenne' => $moyenne,

        ]);

    }

    /**
     * @Route("/favoris", name="restaurant_favoris",methods={"GET","POST"})
     */
    public function Favorite(RestaurantRepository $restaurantRepository,CommentRepository $commentRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $restaurant = $restaurantRepository->findAll();
        $restaurants = [];
        foreach ($restaurant as $key => $resto)
        {
            $restaurants[$key]["averageScore"] = $commentRepository->findAverageOfAllActiveReviewsForOneRestaurant($resto);
            $restaurants[$key]["restaurant"] = $resto;
        }
        $restaurantsPaginated = $paginator->paginate($restaurants, $request->query->getInt('page', 1), /*page number*/
        6 /*limit per page*/);
        $favoris = asort($restaurants[$key]["averageScore"]);


        return $this->render('restaurant/favoris.html.twig', [
            'moyenne' => $restaurants[$key]["averageScore"],
            'restaurants' => $restaurantsPaginated,
            'favoris' => $favoris,
        ]);
    }


}