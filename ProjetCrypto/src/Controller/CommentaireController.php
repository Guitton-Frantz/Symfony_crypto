<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cryptomonnaie;
use App\Entity\User;
use App\Entity\Commentaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\CommType;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="app_commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

/**
     * Créer un nouveau commetaire.
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     * @Route("cryptomonnaie/{id}/new-comm", name="commentaire.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request,Cryptomonnaie $crypto, EntityManagerInterface $em) : Response
    {
        $comm = new Commentaire();
        $form = $this->createForm(CommType::class, $comm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comm->setCryptomonnaie($crypto);
            $em->persist($comm);
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');

        }
        return $this->render('commentaire/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}