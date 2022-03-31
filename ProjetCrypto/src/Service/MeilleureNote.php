<?php
// src/Service/MeilleurNote.php
namespace App\Service;

use App\Entity\Cryptomonnaie;
use App\Form\CryptoSearchType;
use App\Form\CryptoType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle;


class MeilleureNote{


    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    public function meilleurCrypto()
    {
        $scoreMoy =[];

        
        foreach ($this->obj as $q){
            if($q->getUser()!=null){
                $name = $q->getCrypto();
                $scoreMoy["$name"] =+ $q->getContenu();
            }
        }
        arsort($scoreMoy);

        return $scoreMoy;


    }
}