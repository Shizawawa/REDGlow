<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(): Response
    {

      $users = $this->getDoctrine()
          ->getRepository(User::class)
          ->findAll();

        return $this->render('user/index.html.twig', ['users' => $users,
            'controller_name' => 'Utilisateurs',
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    /*public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }*/

    /**
     * @Route("/show/{id}", name="user_show")
     */
    public function show($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('user/show.html.twig', 
            array('user' => $user, ));

    }



    /**
     * @Route("/edit/{id}", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) 
    {
      $user = $this->getDoctrine()->getRepository(User::class)->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($user);
      $entityManager->flush();
      $response = new Response();
      $response->send();

    }
}
