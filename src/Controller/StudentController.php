<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}