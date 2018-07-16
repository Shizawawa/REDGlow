<?php

namespace App\Controller;

use App\Entity\State;
use App\Form\StateType;
use App\Repository\StateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/state")
 */
class StateController extends Controller
{
    /**
     * @Route("/", name="state_index", methods="GET")
     */
    public function index(StateRepository $stateRepository): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (false === $securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }
        else
            return $this->render('state/index.html.twig', ['states' => $stateRepository->findAll()]);
    }

    /**
     * @Route("/new", name="state_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush();

            return $this->redirectToRoute('state_index');
        }

        return $this->render('state/new.html.twig', [
            'state' => $state,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="state_show", methods="GET")
     */
    public function show(State $state): Response
    {
        return $this->render('state/show.html.twig', ['state' => $state]);
    }

    /**
     * @Route("/{id}/edit", name="state_edit", methods="GET|POST")
     */
    public function edit(Request $request, State $state): Response
    {
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('state_edit', ['id' => $state->getId()]);
        }

        return $this->render('state/edit.html.twig', [
            'state' => $state,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="state_delete", methods="DELETE")
     */
    public function delete(Request $request, State $state): Response
    {
        if ($this->isCsrfTokenValid('delete'.$state->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush();
        }

        return $this->redirectToRoute('state_index');
    }
}
