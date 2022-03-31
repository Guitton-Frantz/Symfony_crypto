<?php

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NoteFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager)
    {
        $note1 = new Note();

        $note1->setContenu("3")
            ->setUser($this->getReference(UserFixtures::TEST_USER_REFERENCE))
            ->setCrypto($this->getReference(CryptoFixtures::BITCOIN_REFERENCE));

        
       

        $note2=new Note();
        $note2->setContenu("4")
            ->setUser($this->getReference(UserFixtures::MARIUS_USER_REFERENCE))
            ->setCrypto($this->getReference(CryptoFixtures::ETHEREUM_REFERENCE));

   
        
        $note3=new Note();
        $note3->setContenu("1")
            ->setUser($this->getReference(UserFixtures::EVAN_USER_REFERENCE))
            ->setCrypto($this->getReference(CryptoFixtures::ETHEREUM_REFERENCE));

        $manager->persist($note1);
        $manager->persist($note2);
        $manager->persist($note3);
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