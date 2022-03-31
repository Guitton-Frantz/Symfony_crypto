<?php
namespace App\Service;

use App\Entity\Cryptomonnaie;
use App\Form\CryptoSearchType;
use App\Form\CryptoType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MeilleurNote;



class MeilleurNote
{
    public function meilleurCrypto()
    {
        $queryScore = $this->getDoctrine()->getRepository('Cryptomonnaie::class');

        $queryAvgNote = $queryScore->createQueryBuilder('c')
        ->select("avg(c.note) as moy")
        ->orderBy("moy", 'ASC')
        ->getQuery();

        $avgScore = $queryAvgNote->getResult();
        
        return $avgScore;
    }
}