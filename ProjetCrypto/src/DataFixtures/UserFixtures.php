<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const TEST_USER_REFERENCE = 'test-user';
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $userTest = new User();
        $userTest->setEmail("test@gmail.com")
            ->setRoles(["ROLE_USER,ROLE_ADMIN"])
            ->setPassword($this->passwordEncoder->encodePassword(
            $userTest, 'test'
        ));
        $manager->persist($userTest);
        $manager->flush();
        // other fixtures can get this object using the UserFixtures::TEST_USER_REFERENCE constant
        $this->addReference(self::TEST_USER_REFERENCE, $userTest);
    }
}
