<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
//use App\Entity\Niveau;
use App\Entity\Jeu;
use App\Entity\TableDeMultiplication;
//use App\Entity\Region;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	/*
    	$region1 = new Region();
    	$region1->setNom("nomRegion1");
    	$region1->setImgMagicien("imgMag1.jpg");
    	$region1->setTableDeMultiplication($table);
    	$manager->persist($region1);

    	$region2 = new Region();
    	$region2->setNom("nomRegion2");
    	$region2->setImgMagicien("imgMag2.jpg");
    	$region2->setTableDeMultiplication($table);
    	$manager->persist($region2);

    	$region3 = new Region();
    	$region3->setNom("nomRegion3");
    	$region3->setImgMagicien("imgMag3.jpg");
    	$region3->setTableDeMultiplication($table);
    	$manager->persist($region3);
		*/

    	$jeu1 = new Jeu();
    	$jeu1->setCheminAcces("le_chemin_du_jeu_1");
    	$manager->persist($jeu1);

    	$jeu2 = new Jeu();
    	$jeu2->setCheminAcces("le_chemin_du_jeu_2");
    	$manager->persist($jeu2);

    	$jeu3 = new Jeu();
    	$jeu3->setCheminAcces("le_chemin_du_jeu_3");
    	$manager->persist($jeu3);

    	$jeu4 = new Jeu();
    	$jeu4->setCheminAcces("le_chemin_du_jeu_4");
    	$manager->persist($jeu4);


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


        for ($i = 0; $i <= 10; $i++){
        	$table = new TableDeMultiplication();
        	$table->setNumero($i);
        	$manager->persist($table);
        }

		/*
        $niveau1 = new Niveau();
        $niveau1->setNumero(1);
        $niveau1->setEcartEntreLesReponses(10);
        $niveau1->setNombreDeReponses(3);
        $niveau1->setNbReponsesProposeesDeLaMemeTable(0);
        $niveau1->setReponsesSimilaires(False);
        $niveau1->setTempsDisponible(100);
        $niveau1->setOrdreDesQuestions("croissant");
        $niveau1->setQuestionsATrous(False);
        $niveau1->setJeu($jeu1);
        $manager->persist($niveau1);

        $niveau2 = new Niveau();
        $niveau2->setNumero(2);
        $niveau2->setEcartEntreLesReponses(10);
        $niveau2->setNombreDeReponses(3);
        $niveau2->setNbReponsesProposeesDeLaMemeTable(0);
        $niveau2->setReponsesSimilaires(False);
        $niveau2->setTempsDisponible(100);
        $niveau2->setOrdreDesQuestions("decroissant");
        $niveau2->setQuestionsATrous(False);
        $niveau1->setJeu($jeu2);
        $manager->persist($niveau2);

        $niveau3 = new Niveau();
        $niveau3->setNumero(3);
        $niveau3->setEcartEntreLesReponses(7);
        $niveau3->setNombreDeReponses(3);
        $niveau3->setNbReponsesProposeesDeLaMemeTable(0);
        $niveau3->setReponsesSimilaires(True);
        $niveau3->setTempsDisponible(100);
        $niveau3->setOrdreDesQuestions("aleatoire");
        $niveau3->setQuestionsATrous(False);
        $niveau1->setJeu($jeu3);
        $manager->persist($niveau3);
		*/

        $manager->flush();        
    }
}
