<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $eleve1 = new Utilisateur();
        $eleve1->setEmail("pascalbenoit@gmail.com");
        $eleve1->setAvatar("img1.jpg");
        $eleve1->setNom("Pascal");
        $eleve1->setPrenom("Benoit");
        $eleve1->setPassword("saucisson");
        $eleve1->setEstEnseignant(False);
        $manager->persist($eleve1);

		$eleve2 = new Utilisateur();
        $eleve2->setEmail("didierhenri@gmail.com");
        $eleve2->setAvatar("img2.jpg");
        $eleve2->setNom("Didier");
        $eleve2->setPrenom("Henri");
        $eleve2->setPassword("unbonverredeblanc");
        $eleve2->setEstEnseignant(False);
        $manager->persist($eleve2);

        $eleve3 = new Utilisateur();
        $eleve3->setEmail("jeansebastopole@gmail.com");
        $eleve3->setAvatar("img3.jpg");
        $eleve3->setNom("Jean");
        $eleve3->setPrenom("Sebastopole");
        $eleve3->setPassword("unebouteilledejurancon");
        $eleve3->setEstEnseignant(False);
        $manager->persist($eleve3);


        $manager->flush();        
    }
}
