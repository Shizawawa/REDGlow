<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use App\Entity\User;

use App\Form\ProjectType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * @Route("/project", name="project_index")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager(); 

	    $projects = $em->getRepository(Project::class)->findAll(); 
	    // dump($projects); 


    	return $this->render('project/index.html.twig', [
            'controller_name' => 'Liste des projets',
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/new", name="project_new")
     */
    public function newAction(Request $request)
    {
       	$project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/show/{id}", name="project_show")
     */
    public function show($id)
    {
    	$project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        return $this->render('project/show.html.twig', 
            array('project' => $project, ));

    }

    /**
     * @Route("/project/edit/{id}", name="project_edit", methods="GET|POST")
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', ['id' => $project->getId()]);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) 
    {
      $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($project);
      $entityManager->flush();
      $response = new Response();
      $response->send();
    }
}
