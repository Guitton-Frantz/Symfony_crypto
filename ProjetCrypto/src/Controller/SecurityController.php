<?php

namespace App\Controller;

use App\Entity\Cryptomonnaie;
use App\Entity\User;
use App\Form\CryptoType;
use App\Form\FavorisType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/profile", name="app_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile(AuthenticationUtils $authenticationUtils, EntityManagerInterface $em): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // Recupere l'utilisateur actuel
        $user = ($em->getRepository(User::class)->findBy(array('email' => $lastUsername)))[0];
        // Recupere les favoris de l'utilisateur actuel
        $favoris = $user->getFavoris();

        return $this->render('security/profile.html.twig', ['last_username' => $lastUsername,
            'favoris' => $favoris,
            'error' => $error]);
    }

    /**
     * ajouter une nouvelle crypto favorite.
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     * @Route("add-favoris", name="favoris.add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addFavoris(AuthenticationUtils $authenticationUtils,Request $request, EntityManagerInterface $em) : Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $user = ($em->getRepository(User::class)->findBy(array('email' => $lastUsername)))[0];
        // Recupere les crypto
        $cryptos = $em->getRepository(Cryptomonnaie::class)->findAll();
        $options = [];
        foreach ($cryptos as $crypto){
            $options[$crypto->getName()] = $crypto;
        }

        $form = $this->createForm(FavorisType::class, ['cryptos' => $options]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             //echo $form->get('favoris')->getData();
            $user->addFavori($form->get('favoris')->getData());
            $em->flush();
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('Security/add-favoris.html.twig', [
            'form' => $form->createView(),
        ]);
    }}
