<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
use App\Form\NoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cryptomonnaie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/{_locale}")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/note", name="app_note")
     */
    public function index(): Response
    {
        return $this->render('note/index.html.twig', [
            'controller_name' => 'NoteController',
        ]);
    }

    /**
     * Créer un nouveau commetaire.
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     * @Route("/cryptomonnaie/{id}/new-note", name="note.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request,Cryptomonnaie $crypto,EntityManagerInterface $em) : Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note->setCrypto($crypto);
            $user = $this->getUser();

            $repository = $this->getDoctrine()->getRepository(User::class);
            $data_users = $repository->findOneBy(['id' => $user->getId()]);
            $note->setUser($data_users);
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('cryptomonnaie.list');

        }
        return $this->render('note/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

