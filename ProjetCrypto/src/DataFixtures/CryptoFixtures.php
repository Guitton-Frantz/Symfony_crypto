<?php

namespace App\DataFixtures;

use App\Entity\Cryptomonnaie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CryptoFixtures extends Fixture{
    public const BITCOIN_REFERENCE = 'bitcoin_crypto';

    public function load(ObjectManager $manager)
    {
        $crypto = new Cryptomonnaie();
        $crypto->setCategorie("crypto-actif")
                ->setDateCreation(date_create('2009-03-01'))
                ->setMarketCap(898000000000)
                ->setName("Bitcoin")
                ->setPrice(47240)
                ->setProjet("Simplement Bitcoin")
                ->setSlug('BTC');
        $manager->persist($crypto);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::TEST_USER_REFERENCE constant
        $this->addReference(self::BITCOIN_REFERENCE, $crypto);
    }
}
