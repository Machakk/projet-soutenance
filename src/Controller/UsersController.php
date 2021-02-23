<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/users/create", name="create_user")
     */
    public function createUser(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = new Users();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_users'); 
        }

        return $this->render('admin/userForm.html.twig', [
            'userForm'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users/update-{id}", name="update_user")
     */
    public function updateUser(UsersRepository $usersRepository, $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $usersRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('plainPassword')->getData() !== null) 
            {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/users/delete-{id}", name="delete_user")
     */
    public function deleteUser(UsersRepository $usersRepository, $id)
    {
        $user = $usersRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('admin_users');
    }
}
