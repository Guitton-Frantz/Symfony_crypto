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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/{_locale}/")
 */
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
     * Require ROLE_USER
     *
     * @IsGranted("ROLE_USER")
     * @Route("/cryptomonnaie/{id}/new-comm", name="commentaire.create")
     * @param Request $request
     * @param Cryptomonnaie $crypto
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request,Cryptomonnaie $crypto,EntityManagerInterface $em) : Response
    {
        $comm = new Commentaire();
        $form = $this->createForm(CommType::class, $comm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comm->setCryptomonnaie($crypto);
            $user = $this->getUser();

            $repository = $this->getDoctrine()->getRepository(User::class);
            $data_users = $repository->findOneBy(['id' => $user->getId()]);
            $comm->setUser($data_users);
            $em->persist($comm);
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');

        }
        return $this->render('commentaire/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Éditer un commentaire.
     *
     * Require ROLE_USER
     *
     * @IsGranted("ROLE_USER")
     * @Route("commentaire/{id}/edit", name="commentaire.edit")
     * @param Request $request
     * @param Commentaire $commentaire
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(CommType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('commentaire/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprimer une commentaire.
     * Require ROLE_USER
     *
     * @IsGranted("ROLE_USER")
     * @Route("commentaire/{id}/delete", name="commentaire.delete")
     * @param Request $request
     * @param Commentaire $commentaire
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $em) : Response
    {
        if ($commentaire->getUser() == $this->getUser()) {


            $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('commentaire.delete', ['id' => $commentaire->getId()]))
                ->getForm();
            $form->handleRequest($request);
            if (!$form->isSubmitted() || !$form->isValid()) {
                return $this->render('commentaire/delete.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form->createView(),
                ]);
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
            return $this->redirectToRoute('app_profile');
        }else{
            return $this->redirectToRoute('app_profile');
        }
    }
}