<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('student', name : 'app_student' )]
public function index() : Response
{
    return new Response("Bonjour mes étudiants") ;
}

    #[Route('/readstudent', name: 'readstudent')]
    public function readstudent(StudentRepository $repository) :Response
    {

        $students = $repository->findAll();
        return $this->render('student/read.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/add', name: 'addstudent')]
    public function  add(ManagerRegistry $doctrine, Request  $request) : Response
    { $student = new Student() ;
        $form = $this->createForm(StudentType::class, $student);
        $form->add('ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('readstudent');
        }
        return $this->renderForm("student/add.html.twig",
            ["f"=>$form]) ;

    }
}