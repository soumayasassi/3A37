<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/readc', name: 'read_classroom')]
    public function read(ManagerRegistry $doctrine): Response
    {
        //récupération de la liste des classrooms
        $classrooms = $doctrine
            ->getRepository(Classroom::class)
            ->findAll();
        return $this->render('classroom/read.html.twig',
        ["classrooms"=>$classrooms]);
    }



    #[Route('/readcl', name: 'readc')]
    public function readClub(ClassroomRepository $repository) :Response
    {

        $classrooms = $repository->findAll();
        return $this->render('classroom/read.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }


    #[Route('/add', name: 'addc')]
    public function  add(ManagerRegistry $doctrine, Request  $request) : Response
    { $classroom = new Classroom() ;
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('readc');
        }
        return $this->renderForm("classroom/add.html.twig",
            ["f"=>$form]) ;


    }
}
