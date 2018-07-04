<?php

namespace App\Controller;

use App\Entity\Task;
//use Doctrine\DBAL\Types\DateType;
use function PHPSTORM_META\type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskController extends Controller
{
    /**
     * @Route("/task", name="task")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager();
    	$task = $em->getRepository(Task::class)->findAll();
    	dump($task);
    	//$task = $em->getRepository(Task::class)->findBy($array('name' => 'monName'));
        return $this->render('task/index.html.twig', [
            'controller_name' => 'Mes tâches',
            'task_list' => $task,
        ]);
    }

    /**
     * @Route("/task/{id}", name="task_show")
     */
    public function showAction(Task $task)
    {
        return $this->render('task/show.html.twig', [
            'controller_name' => 'Mes tâches',
            'task' => $task,
        ]);
    }

    /**
     * @Route("/task/new", name="task_new")
     */
    public function new(Request $request)
    {
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('name', TextType::class)
            ->add('description', Textype::class)
            //->add('start_at', DateType::class)
            //->add('planned_end_at', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Créer une Tâche'))
            ->getForm();

        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task');
        }

        return $this->render('task/new.html.twig', [
            'controller_name' => 'Mes tâches',
            'form' => $form->createView(),
        ]);
    }


}
