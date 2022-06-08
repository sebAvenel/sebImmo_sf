<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin.property.edit")
     * @return Response
     */
    public function edit(Property $property): Response
    {
        return $this->render('admin/edit.html.twig', [
            'property' => $property
        ]);
    }
}
