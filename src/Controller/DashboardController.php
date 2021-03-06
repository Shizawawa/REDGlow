<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\User; 

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
		$securityContext = $this->container->get('security.authorization_checker');
		if ((false === $securityContext->isGranted('ROLE_USER')) && (false === $securityContext->isGranted('ROLE_ADMIN'))) {
	        throw new AccessDeniedException('Unable to access this page!');
	    }

	    $em = $this->getDoctrine()->getManager();

        $nbTask = $em->getRepository(Task::class)->nbTask();
        $tasks = $em->getRepository(Task::class)->findAll();
	    $projects = $em->getRepository(Project::class)->findAll();
	    $nbProject = $em->getRepository(Project::class)->nbProject();
	   
        // dump($tasks);

	    $token = $this->get('security.token_storage')->getToken();
		$user = $token->getUser();

        // dump($this->get('session')); 

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'Dashboard',
            'user' => $user,
            'task' => $nbTask,
            'project' => $nbProject,
            'tasks' => $tasks,
            'projects' => $projects,
        ]);
    }
}
