<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\UserEditDataFormType;
use App\Form\Admin\UserEditPasswordFormType;
use App\Form\Admin\UserRegistrationByAdminFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/user")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminUserController extends AbstractController
{

    /**
     * @Route("/", name="admin.user.index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.user.new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationByAdminFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit-data", name="admin.user.edit.data", methods={"GET", "POST"})
     */
    public function editData(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserEditDataFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('admin.user.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit-password", name="admin.user.edit.password", methods={"GET", "POST"})
     */
    public function editPassword(Request $request, User $user, UserPasswordEncoderInterface $userPasswordEncoder, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserEditPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->add($user);
            return $this->redirectToRoute('admin.user.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit_mdp.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.user.delete", methods="DELETE")
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('admin.user.index', [], Response::HTTP_SEE_OTHER);
    }
}
