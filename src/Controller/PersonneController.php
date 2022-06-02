<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }

    #[Route("/personne/add", name: "personne_add")]
    function addForm()
    {
        $personne = new Personne();
        $form = $this->createFormBuilder($personne)
            ->add('nom', TextType::class, array('required' => true))
            ->add('prenom', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter une personne'])
            ->getForm();
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }
}
