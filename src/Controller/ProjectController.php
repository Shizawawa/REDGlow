<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use App\Entity\User;
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
        $em = $this->getDoctrine()->getManager(); 
        $users = $em->getRepository(User::class)->findAll(); 
        dump($users);

        $listUsers = array();
        foreach ($users as $user) {
            $listUsers[$user->username] = $user->id ;
        }
            dump($listUsers);

        $form = $this->createFormBuilder($project, array(
            'action' =>$this->generateUrl('project_list'),
            'method' => 'POST',
        ));

        $form->add("name", TextType::class)
            ->add("description", TextareaType::class)
            /*->add('user_id', ChoiceType::class, 
                array(
                    'choices' => $listUsers
            ))*/
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
    public function edit(Request $request, User $project): Response
    {
        $form = $this->createForm(Project::class, $project);
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
    public function delete(Request $request, $id) {
      $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($project);
      $entityManager->flush();
      $response = new Response();
      $response->send();
    }
   
    

}
