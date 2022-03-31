<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const TEST_USER_REFERENCE = 'test-user';
    public const MARIUS_USER_REFERENCE = 'marius-user';
    public const EVAN_USER_REFERENCE = 'evan-user';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $userTest = new User();
        $userTest->setEmail("test@gmail.com")
            ->setRoles(["ROLE_USER","ROLE_ADMIN"])
            ->setPseudo("ADMIN")
            ->setPassword($this->passwordEncoder->encodePassword(
            $userTest, 'test'
        ));

        $userMarius = new User();
        $userMarius->setEmail("marius@gmail.com")
            ->setRoles(["ROLE_USER"])
            ->setPseudo("Marius")
            ->setPassword($this->passwordEncoder->encodePassword(
                $userMarius, 'marius'
            ));

        $userEvan = new User();
        $userEvan->setEmail("evan@gmail.com")
            ->setRoles(["ROLE_USER"])
            ->setPseudo("Evan")
            ->setPassword($this->passwordEncoder->encodePassword(
                $userEvan, 'evan'
            ));

        $manager->persist($userTest);
        $manager->persist($userMarius);
        $manager->persist($userEvan);

        $manager->flush();
        // other fixtures can get this object using the UserFixtures::TEST_USER_REFERENCE constant
        $this->addReference(self::TEST_USER_REFERENCE, $userTest);
        $this->addReference(self::MARIUS_USER_REFERENCE, $userMarius);
        $this->addReference(self::EVAN_USER_REFERENCE, $userEvan);

    }
}
