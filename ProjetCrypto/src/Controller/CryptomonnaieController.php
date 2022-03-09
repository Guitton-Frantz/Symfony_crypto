<?php

namespace App\Controller;

use App\Entity\Cryptomonnaie;
use App\Form\CryptoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CryptomonnaieController extends AbstractController
{

    /**
     * Lister toutes les cryptos
     * @Route("/cryptomonnaie", name="cryptomonnaie.list")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function list(EntityManagerInterface $em): Response
    {
        $cryptos = $em->getRepository(Cryptomonnaie::class)->findAll();
        return $this->render('cryptomonnaie/list.html.twig', [
            'cryptos' => $cryptos,
        ]);
    }

    /**
     * Chercher et afficher une crypto.
     * @Route("/cryptomonnaie/{id}", name="cryptomonnaie.show", requirements={"id" = "\d+"})
     * @param Cryptomonnaie $crypto
     * @return Response
     */
    public function show(Cryptomonnaie $crypto) : Response
    {
        return $this->render('cryptomonnaie/show.html.twig', [
            'crypto' => $crypto,
        ]);
    }


    /**
     * Créer une nouvelle crypto.
     * @Route("new-crypto", name="cryptomonnaie.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $stage = new Cryptomonnaie();
        $form = $this->createForm(CryptoType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stage);
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');
        }
        return $this->render('cryptomonnaie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Éditer une cryptomonnaie.
     * @Route("cryptomonnaie/{id}/edit", name="cryptomonnaie.edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Cryptomonnaie $crypto, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(CryptoType::class, $crypto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');
        }
        return $this->render('cryptomonnaie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprimer un stage.
     * @Route("stage/{id}/delete", name="cryptomonnaie.delete")
     * @param Request $request
     * @param Cryptomonnaie $crypto
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Cryptomonnaie $crypto, EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('cryptomonnaie.delete', ['id' => $crypto->getId()]))
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('cryptomonnaie/delete.html.twig', [
                'crypto' => $crypto,
                'form' => $form->createView(),
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($crypto);
        $em->flush();
        return $this->redirectToRoute('cryptomonnaie.list');
    }
}
