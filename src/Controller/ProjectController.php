<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Route("/project", name="project")
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
    	$form = $this->getForm($project); 

    	$form->handleRequest($request); 
    	
    	if ($form->isSubmitted()) {
    		$project = $form->getData(); 
    		$project->setName($project->getName());
    		$project->setDescription($project->getDescription());

    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->persist($project);
    		$entityManager->flush();
    	}

        return $this->render('project/new.html.twig', [
            'controller_name' => 'Nouveau projet',
            'form' => $form->createView(),
        ]);
    }

    private function getForm(project $project){
        $form = $this->createFormBuilder($project, array(
            'action' =>$this->generateUrl('project_list'),
            'method' => 'POST',

        ));

        $form->add("name", TextType::class)
        	->add("description", TextType::class)
            ->add('submit', SubmitType::class, array('label' => 'Ajouter'));
        return $form->getForm();
    }

     /**
     * @Route("/project/list", name="project_list")
     */
    public function listAction(Request $request)
    {
    	$project = new Project(); 
    	$form = $this->getForm($project); 

    	$form->handleRequest($request); 
    	
    	if ($form->isSubmitted()) {
    		$project = $form->getData(); 
    		$project->setName($project->getName());
    		$project->setDescription($project->getDescription());

    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->persist($project);
    		$entityManager->flush();
    	}

    	$em = $this->getDoctrine()->getManager(); 

	    $projects = $em->getRepository(Project::class)->findAll(); 
	    // dump($projects); 


    	return $this->render('project/index.html.twig', [
            'controller_name' => 'Liste des projets',
            'projects' => $projects,
        ]);
    } 

    /**
     * @Route("/project/show", name="project_show")
     */
    public function show()
    {
    	
    }

}
