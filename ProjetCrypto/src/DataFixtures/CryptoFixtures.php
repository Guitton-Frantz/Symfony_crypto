<?php

namespace App\DataFixtures;

use App\Entity\Cryptomonnaie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CryptoFixtures extends Fixture{
    public const BITCOIN_REFERENCE = 'bitcoin_crypto';
    public const ETHEREUM_REFERENCE = 'ethereum_crypto';


    public function load(ObjectManager $manager)
    {
        $btc = new Cryptomonnaie();
        $btc->setCategorie("crypto-actif")
                ->setDateCreation(date_create('2009-03-01'))
                ->setMarketCap(898000000000)
                ->setName("Bitcoin")
                ->setPrice(47240)
                ->setProjet("Simplement Bitcoin")
                ->setSlug('BTC')
                ->setCreator($this->getReference(UserFixtures::MARIUS_USER_REFERENCE))
        ;

        $format = "d/m/Y";

        $eth = new Cryptomonnaie();
        $eth->setCategorie("protocole")
            ->setDateCreation(DateTime::createFromFormat($format, '30/07/2015'))
            ->setMarketCap(411000000000)
            ->setName("Ethereum")
            ->setPrice(3420)
            ->setProjet("Protocole d'échanges décentralisés permettant la création par les utilisateurs de contrats intelligents. Ces contrats intelligents sont basés sur un protocole informatique permettant de vérifier ou de mettre en application un contrat mutuel.")
            ->setSlug('ETH')
            ->setCreator($this->getReference(UserFixtures::EVAN_USER_REFERENCE))
        ;
        $manager->persist($btc);
        $manager->persist($eth);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::TEST_USER_REFERENCE constant
        $this->addReference(self::BITCOIN_REFERENCE, $btc);
        $this->addReference(self::ETHEREUM_REFERENCE, $eth);

    }
}
