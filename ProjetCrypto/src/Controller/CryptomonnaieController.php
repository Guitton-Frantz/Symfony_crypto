<?php

namespace App\Controller;

use App\Entity\Cryptomonnaie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CryptomonnaieController extends AbstractController
{

    /**
     * Lister toutes les cryptos
     * @Route("/cryptomonnaie", name="stage.list")
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
}
