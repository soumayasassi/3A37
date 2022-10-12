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



#[Route('/add3', name: 'addc3')]
public function add3(Request  $request, ManagerRegistry $doctrine)
{
    $c = new Classroom() ;
    $form = $this->createFormBuilder($c)
        ->add('name')
        ->add('ajouter')
        ->getForm();
    $form->handleRequest($request) ;
    if ($form->isSubmitted())
    { $em = $doctrine->getManager(); //créer une instance du entity manager doctrine orm symfony
        $em->persist($c);
        $em->flush();
        return $this->redirectToRoute('readc');
    }
    return $this->renderForm("classroom/add.html.twig",
        ["f"=>$form]) ;
}
    #[Route('/delete/{id}', name: 'deletestudent')]
    public function delete( ManagerRegistry $doctrine,$id)
    {$c = $doctrine->getRepository(Classroom::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($c);
        $em->flush() ;
            return $this->redirectToRoute('read_classroom');

    }

    #[Route('/update/{id}', name: 'updatestudent')]
    public function update(Request  $request, ManagerRegistry $doctrine,$id)
    {
        $classroom = $doctrine->getRepository(Classroom::class)->find($id) ;
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('update', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager() ;
            $em->flush();
            return $this->redirectToRoute('read_classroom');
        }
        return $this->renderForm("classroom/update.html.twig",
            ["f"=>$form]) ;
    }

    #[Route('/add2', name: 'addc2')]
    public function  add2(ManagerRegistry $doctrine , Request $request) : Response
    { $c = new Classroom() ;
        if($request->isMethod('POST'))
        { $c->setName($request->get('name'));
            $em = $doctrine->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('readc');
        }
        return $this->render('classroom/add2.html.twig');



    }
}
