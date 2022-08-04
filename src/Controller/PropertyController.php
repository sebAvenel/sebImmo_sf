<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertyFilterSearch;
use App\Form\ContactType;
use App\Form\PropertyFilterSearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="app_property")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertyFilterSearch;
        $form = $this->createForm(PropertyFilterSearchType::class, $search);
        $form->handleRequest($request);
        $datas = $this->repository->findBySearch($search);
        if (empty($datas)) {
            $this->addFlash('error', 'Aucun bien trouvé');
        }
        $properties = $paginator->paginate(
            $datas,
            $request->query->getInt('page', 1),
            8
        );
        $properties->setCustomParameters([
            'align' => 'center'
        ]);

        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request): Response
    {

        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        //$property = $this->repository->findOneBy(['id' => $property->getId()]);

        $contact = new Contact;
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'votre messsage a bien été envoyé');
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()
        ]);
    }
}
