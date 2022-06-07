<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/home", name="app_home")
     * @return Response
     */
    public function index(): Response
    {
        $latestProperties = $this->repository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'lastProperties' => $latestProperties
        ]);
    }
}
