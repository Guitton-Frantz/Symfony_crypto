<?php

namespace App\Controller;

use App\Entity\Cryptomonnaie;
use App\Entity\Note;
use App\Form\CryptoSearchType;
use App\Form\CryptoType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MeilleureNote;
/**
 * @Route("/{_locale}")
 */
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
     * Lister toutes les cryptos
     * @Route("/classement", name="cryptomonnaie.classment")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function classement(EntityManagerInterface $em):Response
    {
        $mn = new MeilleureNote($em->getRepository(Note::class)->findAll());
        $cryptos = $em->getRepository(Cryptomonnaie::class)->findAll();

        $mn = $mn->meilleurCrypto();
        return $this->render('cryptomonnaie/classement.html.twig', [
            'cryptos' => $cryptos,
            'bestnote' => $mn,
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
     * Afficher commentaire d'une crypto.
     * @Route("/cryptomonnaie/{id}/comm", name="cryptomonnaie.afficherComm", requirements={"id" = "\d+"})
     * @param Cryptomonnaie $crypto
     * @return Response
     */
    public function showComm(Cryptomonnaie $crypto) : Response
    {
        return $this->render('cryptomonnaie/showComm.html.twig', [
            'crypto' => $crypto,
        ]);
    }



    /**
     * Créer une nouvelle crypto.
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     * @Route("/new-crypto", name="cryptomonnaie.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $crypto = new Cryptomonnaie();
        $form = $this->createForm(CryptoType::class, $crypto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $crypto->setCreator($this->getUser());
            $em->persist($crypto);
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');
        }
        return $this->render('cryptomonnaie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Éditer une cryptomonnaie.
     *
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
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
     * Supprimer une crypto.
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     * @Route("stage/{id}/delete", name="cryptomonnaie.delete")
     * @param Request $request
     * @param Cryptomonnaie $crypto
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, Cryptomonnaie $crypto, EntityManagerInterface $em) : Response
    {
        if ($crypto->getCreator() == $this->getUser()) {


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
        }else{
            return $this->redirectToRoute('cryptomonnaie.list');
        }
    }

    /**
     * Permet de rechercher une crypto selon un formulaire
     * @Route("/search", name="cryptomonnaie.search")
     * @return void
     */
    public function search(Request $request, EntityManagerInterface $em) : Response
    {
        $data = new Cryptomonnaie();
        $form = $this->createForm(CryptoSearchType::class, $data);
        $form->handleRequest($request);
        $dataSearch = [];
        if ($form->isSubmitted() && $form->isValid()) {
            if($data->getMarketCap() !== null){
                $dataSearch['MarketCap'] = $data->getMarketCap();
            }
            if($data->getSlug() !== null){
                $dataSearch['slug'] = $data->getSlug();
            }
            if($data->getDateCreation() !== null){
                $dataSearch['dateCreation'] = $data->getDateCreation();
            }
            if($data->getPrice() !== null){
                $dataSearch['price'] = $data->getPrice();
            }
            if($data->getCategorie() !== null){
                $dataSearch['categorie'] = $data->getCategorie();
            }
            if($data->getName() !== null){
                $dataSearch['name'] = $data->getName();
            }
            if($data->getProjet() !== null){
                $dataSearch['projet'] = $data->getProjet();
            }
            $cryptos = $em->getRepository(Cryptomonnaie::class)->findBy(
                $dataSearch
            );

            return $this->render('cryptomonnaie/list.html.twig', ['cryptos' => $cryptos]);
        }

        return $this->render('cryptomonnaie/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
