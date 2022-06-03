<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Entity\Personne;
use App\Form\OnlyPersonneType;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {

        $user = $this->getUser();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'user'=>$user
        ]);
    }

    #[Route("/personne/add", name: "personne_add")]
    function addForm(Request $request, EntityManagerInterface $em)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        // $form = $this->createFormBuilder($personne)
        //     ->add('nom', TextType::class, array('required' => true))
        //     ->add('prenom', TextType::class)
        //     ->add('save', SubmitType::class, ['label' => 'Ajouter une personne'])
        //     ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('personne_list');
        }
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }

    #[Route("/personne/list", name: "personne_list")]
    function list(EntityManagerInterface $em)
    {
        $personnes = $em->getRepository(Personne::class)->findAll();
        

        return $this->render('personne/show.html.twig', [
            'controller_name' => 'Liste des Personnes',
            'personnes' => $personnes,
        ]);
    }

    #[Route("/onlypersonne/add", name: "only_personne_add")]
    function addFormOnly(Request $request, EntityManagerInterface $em)
    {
        $personne = new Personne();
        $form = $this->createForm(OnlyPersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute("personne_show_all");
        }
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }
}
