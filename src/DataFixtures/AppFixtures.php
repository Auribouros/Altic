<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\Niveau;
use App\Entity\Jeu;
use App\Entity\TableDeMultiplication;
use App\Entity\Region;
use App\Entity\PersonnageJouable;
use App\Entity\Entrainement;
use App\Entity\Question;
use App\Entity\ReponsePropose;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$rep1 = new ReponsePropose();
    	$rep2 = new ReponsePropose();
    	$rep3 = new ReponsePropose();

    	$quest1 = new Question();
    	$quest2 = new Question();
    	$quest3 = new Question();

    	$ent1 = new Entrainement();
    	$ent2 = new Entrainement();
    	$ent3 = new Entrainement();

    	$pj1 = new PersonnageJouable();
    	$pj2 = new PersonnageJouable();
    	$pj3 = new PersonnageJouable();

    	$jeu1 = new Jeu();
    	$jeu2 = new Jeu();
    	$jeu3 = new Jeu();
    	$jeu4 = new Jeu();

    	$eleve1 = new Utilisateur();
    	$eleve2 = new Utilisateur();
    	$eleve3 = new Utilisateur();

    	$table0 = new TableDeMultiplication();
    	$table1 = new TableDeMultiplication();
    	$table2 = new TableDeMultiplication();
    	$table3 = new TableDeMultiplication();
    	$table4 = new TableDeMultiplication();
    	$table5 = new TableDeMultiplication();
    	$table6 = new TableDeMultiplication();
    	$table7 = new TableDeMultiplication();
    	$table8 = new TableDeMultiplication();
    	$table9 = new TableDeMultiplication();
    	$table10 = new TableDeMultiplication();    	

		$niveau1 = new Niveau();
		$niveau2 = new Niveau();
		$niveau3 = new Niveau();

		$region1 = new Region();
		$region2 = new Region();
		$region3 = new Region();


		$rep1->setReponse(3);
		$manager->persist($rep1);

		$rep2->setReponse(4);
		$manager->persist($rep2);

		$rep3->setReponse(5);
		$manager->persist($rep3);


		$quest1->setLibelle('3 X 4 =');
		$quest1->setReponseEnfant(9);
		$manager->persist($quest1);

		$quest2->setLibelle('3 X 3 =');
		$quest2->setReponseEnfant(9);
		$manager->persist($quest2);

		$quest3->setLibelle('3 X 2 =');
		$quest3->setReponseEnfant(4);
		$manager->persist($quest3);


		$ent1->setDuree(150);
		$ent1->setDate(date_create('2014-04-05'));
		$manager->persist($ent1);

		$ent2->setDuree(145);
		$ent2->setDate(date_create('2014-04-04'));
		$manager->persist($ent2);

		$ent3->setDuree(150);
		$ent3->setDate(date_create('2014-04-03'));
		$manager->persist($ent3);


		$pj1->setPersonnageDebloque(True);
		$pj1->setImage("imgPerso1.jpg");
		$manager->persist($pj1);

		$pj2->setPersonnageDebloque(False);
		$pj2->setImage("imgPerso2.jpg");
		$manager->persist($pj2);

		$pj3->setPersonnageDebloque(True);
		$pj3->setImage("imgPerso3.jpg");
		$manager->persist($pj3);


    	$region1->setNom("nomRegion1");
    	$region1->setImgMagicien("imgMag1.jpg");
    	$region1->setTableDeMultiplication($table0);
    	$manager->persist($region1);

    	$region2->setNom("nomRegion2");
    	$region2->setImgMagicien("imgMag2.jpg");
    	$region2->setTableDeMultiplication($table1);
    	$manager->persist($region2);

    	$region3->setNom("nomRegion3");
    	$region3->setImgMagicien("imgMag3.jpg");
    	$region3->setTableDeMultiplication($table2);
    	$manager->persist($region3);
		

      	$jeu1->setCheminAcces("le_chemin_du_jeu_1");
    	$jeu1->addNiveau($niveau1);
    	$manager->persist($jeu1);

    	$jeu2->setCheminAcces("le_chemin_du_jeu_2");
    	$jeu2->addNiveau($niveau2);
    	$manager->persist($jeu2);

    	$jeu3->setCheminAcces("le_chemin_du_jeu_3");
    	$jeu3->addNiveau($niveau3);
    	$manager->persist($jeu3);

    	$jeu4->setCheminAcces("le_chemin_du_jeu_4");
    	$manager->persist($jeu4);


        $eleve1->setEmail("pascalbenoit@gmail.com");
        $eleve1->setAvatar("img1.jpg");
        $eleve1->setNom("Pascal");
        $eleve1->setPrenom("Benoit");
        $eleve1->setPassword("saucisson");
        $eleve1->setEstEnseignant(False);
        $manager->persist($eleve1);

        $eleve2->setEmail("didierhenri@gmail.com");
        $eleve2->setAvatar("img2.jpg");
        $eleve2->setNom("Didier");
        $eleve2->setPrenom("Henri");
        $eleve2->setPassword("unbonverredeblanc");
        $eleve2->setEstEnseignant(False);
        $manager->persist($eleve2);

        $eleve3->setEmail("jeansebastopole@gmail.com");
        $eleve3->setAvatar("img3.jpg");
        $eleve3->setNom("Jean");
        $eleve3->setPrenom("Sebastopole");
        $eleve3->setPassword("unebouteilledejurancon");
        $eleve3->setEstEnseignant(False);
        $manager->persist($eleve3);


        $table0->setNumero(0);
        $table0->setRegion($region1);
        $manager->persist($table0);

        $table1->setNumero(1);
        $table1->setRegion($region2);
        $manager->persist($table1);

        $table2->setNumero(2);
        $table2->setRegion($region3);
        $manager->persist($table2);

        $table3->setNumero(3);
        $manager->persist($table3);

        $table4->setNumero(4);
        $manager->persist($table4);

        $table5->setNumero(5);
        $manager->persist($table5);

        $table6->setNumero(6);
        $manager->persist($table6);

        $table7->setNumero(7);
        $manager->persist($table7);

        $table8->setNumero(8);
        $manager->persist($table8);

        $table9->setNumero(9);
        $manager->persist($table9);

        $table10->setNumero(10);
        $manager->persist($table10);

		
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
		

        $manager->flush();        
    }
}
