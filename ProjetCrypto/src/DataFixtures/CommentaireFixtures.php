<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager)
    {
        $com = new Commentaire();

        $com->setCom("J'adore le projet")
            ->setUser($this->getReference(UserFixtures::TEST_USER_REFERENCE))
            ->setCryptomonnaie($this->getReference(CryptoFixtures::BITCOIN_REFERENCE));

        $manager->persist($com);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CryptoFixtures::class,
        ];
    }
}