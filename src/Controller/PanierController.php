<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $pdo = $this -> getDoctrine()->getManager();

        $panier = new Panier();

        $form = $this -> createForm(PanierType::class, $panier);

        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form->isValid()){
            //le formulaire a été envoyé, on le sauvegarde
            $pdo->persist($panier); //prepare
            $pdo->flush(); //execute

            $this->addFlash("success", "Catégorie ajoutée");
        }

        $paniers = $pdo ->getRepository(Panier::class)->findAll();

        return $this->render('panier/index.html.twig', [
            'panier' => $paniers,
            'form' => $form->createView(),
        ]);
    }
}
