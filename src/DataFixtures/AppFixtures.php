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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder =$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user1 = new Utilisateur();
        $user1->setEmail("lucy@christ.crux");
        $user1->setNom("christ");
        $user1->setPrenom("lucy");
        $user1->setPassword(
            $this->encoder->encodePassword($user1,"lucy")
        );
        $user1->setEstEnseignant(false);
        $manager->persist($user1);

        for ($i = 0; $i < 10; $i++) {
            $training = new Entrainement();
            $training->setDate(new \DateTime('@'.\strtotime('now')));
            $training->setDuree(mt_rand(10, 100));
            $training->setUtilisateur($user1->getId());
            $manager->persist($training);
        }
        $tablesOrder = array(2, 5, 10, 1, 4, 3, 0, 6, 8, 9, 7);
        $baseLevels = array_fill(0, 12, new Niveau());
        $games = array_fill(0, 4, new Jeu());
        $tables = array_fill(0, 11, new TableDeMultiplication());
        $levels = array_fill(0, 132, new Niveau());
        $regions = array_fill(0, 11, new Region());

        $test1 = new Jeu();
        $test1->setCheminAcces('test1');
        $test2 = new Jeu();
        $test2->setCheminAcces('test2');
        $test3 = new Jeu();
        $test3->setCheminAcces('test3');
        $test4 = new Jeu();
        $test4->setCheminAcces('test4');
        $manager->persist($test1);
        $manager->persist($test2);
        $manager->persist($test3);
        $manager->persist($test4);

        //baseLevels init
            $baseLevel1 = new Niveau();
            $baseLevel1->setNumero(1);
            $baseLevel1->setEcartEntreLesReponses(10);
            $baseLevel1->setNombreDeReponses(3);
            $baseLevel1->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel1->setReponsesSimilaires(false);
            $baseLevel1->setTempsDisponible(null);
            $baseLevel1->setOrdreDesQuestions('croissant');
            $baseLevel1->setQuestionsATrous(false);
            $baseLevel1->setJeu($test1);
            $manager->persist($baseLevel1);
            $user1->addNiveau($baseLevel1);
            //
            $baseLevel2 = new Niveau();
            $baseLevel2->setNumero(2);
            $baseLevel2->setEcartEntreLesReponses(10);
            $baseLevel2->setNombreDeReponses(3);
            $baseLevel2->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel2->setReponsesSimilaires(false);
            $baseLevel2->setTempsDisponible(null);
            $baseLevel2->setOrdreDesQuestions('decroissant');
            $baseLevel2->setQuestionsATrous(false);
            $baseLevel2->setJeu($test1);
            $manager->persist($baseLevel2);
            $user1->addNiveau($baseLevel2);
            //
            $baseLevel3 = new Niveau();
            $baseLevel3->setNumero(3);
            $baseLevel3->setEcartEntreLesReponses(7);
            $baseLevel3->setNombreDeReponses(3);
            $baseLevel3->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel3->setReponsesSimilaires(true);
            $baseLevel3->setTempsDisponible(null);
            $baseLevel3->setOrdreDesQuestions('aleatoire');
            $baseLevel3->setQuestionsATrous(false);
            $baseLevel3->setJeu($test1);
            $manager->persist($baseLevel3);
            $user1->addNiveau($baseLevel3);
            //
            $baseLevel4 = new Niveau();
            $baseLevel4->setNumero(4);
            $baseLevel4->setEcartEntreLesReponses(7);
            $baseLevel4->setNombreDeReponses(4);
            $baseLevel4->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel4->setReponsesSimilaires(false);
            $baseLevel4->setTempsDisponible(30);
            $baseLevel4->setOrdreDesQuestions('croissant');
            $baseLevel4->setQuestionsATrous(false);
            $baseLevel4->setJeu($test1);
            $manager->persist($baseLevel4);
            $user1->addNiveau($baseLevel4);
            //
            $baseLevel5 = new Niveau();
            $baseLevel5->setNumero(5);
            $baseLevel5->setEcartEntreLesReponses(5);
            $baseLevel5->setNombreDeReponses(4);
            $baseLevel5->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel5->setReponsesSimilaires(false);
            $baseLevel5->setTempsDisponible(20);
            $baseLevel5->setOrdreDesQuestions('decroissant');
            $baseLevel5->setQuestionsATrous(false);
            $baseLevel5->setJeu($test1);
            $manager->persist($baseLevel5);
            $user1->addNiveau($baseLevel5);
            //
            $baseLevel6 = new Niveau();
            $baseLevel6->setNumero(6);
            $baseLevel6->setEcartEntreLesReponses(5);
            $baseLevel6->setNombreDeReponses(4);
            $baseLevel6->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel6->setReponsesSimilaires(true);
            $baseLevel6->setTempsDisponible(10);
            $baseLevel6->setOrdreDesQuestions('aleatoire');
            $baseLevel6->setQuestionsATrous(false);
            $baseLevel6->setJeu($test1);
            $manager->persist($baseLevel6);
            $user1->addNiveau($baseLevel6);
            //
            $baseLevel7 = new Niveau();
            $baseLevel7->setNumero(7);
            $baseLevel7->setEcartEntreLesReponses(5);
            $baseLevel7->setNombreDeReponses(4);
            $baseLevel7->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel7->setReponsesSimilaires(true);
            $baseLevel7->setTempsDisponible(10);
            $baseLevel7->setOrdreDesQuestions('croissant');
            $baseLevel7->setQuestionsATrous(false);
            $baseLevel7->setJeu($test1);
            $manager->persist($baseLevel7);
            //
            $baseLevel8 = new Niveau();
            $baseLevel8->setNumero(8);
            $baseLevel8->setEcartEntreLesReponses(10);
            $baseLevel8->setNombreDeReponses(0);
            $baseLevel8->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel8->setReponsesSimilaires(false);
            $baseLevel8->setTempsDisponible(20);
            $baseLevel8->setOrdreDesQuestions('croissant');
            $baseLevel8->setQuestionsATrous(true);
            $baseLevel8->setJeu($test1);
            $manager->persist($baseLevel8);
            //
            $baseLevel9 = new Niveau();
            $baseLevel9->setNumero(9);
            $baseLevel9->setEcartEntreLesReponses(10);
            $baseLevel9->setNombreDeReponses(0);
            $baseLevel9->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel9->setReponsesSimilaires(false);
            $baseLevel9->setTempsDisponible(10);
            $baseLevel9->setOrdreDesQuestions('croissant');
            $baseLevel9->setQuestionsATrous(true);
            $baseLevel9->setJeu($test1);
            $manager->persist($baseLevel9);
            //
            $baseLevel10 = new Niveau();
            $baseLevel10->setNumero(10);
            $baseLevel10->setEcartEntreLesReponses(10);
            $baseLevel10->setNombreDeReponses(0);
            $baseLevel10->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel10->setReponsesSimilaires(false);
            $baseLevel10->setTempsDisponible(10);
            $baseLevel10->setOrdreDesQuestions('croissant');
            $baseLevel10->setQuestionsATrous(true);
            $baseLevel10->setJeu($test1);
            $manager->persist($baseLevel10);
            //
            $baseLevel11 = new Niveau();
            $baseLevel11->setNumero(11);
            $baseLevel11->setEcartEntreLesReponses(10);
            $baseLevel11->setNombreDeReponses(0);
            $baseLevel11->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel11->setReponsesSimilaires(false);
            $baseLevel11->setTempsDisponible(10);
            $baseLevel11->setOrdreDesQuestions('croissant');
            $baseLevel11->setQuestionsATrous(true);
            $baseLevel11->setJeu($test1);
            $manager->persist($baseLevel11);
            //
            $baseLevel12 = new Niveau();
            $baseLevel12->setNumero(12);
            $baseLevel12->setEcartEntreLesReponses(10);
            $baseLevel12->setNombreDeReponses(0);
            $baseLevel12->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel12->setReponsesSimilaires(false);
            $baseLevel12->setTempsDisponible(10);
            $baseLevel12->setOrdreDesQuestions('croissant');
            $baseLevel12->setQuestionsATrous(true);
            $baseLevel12->setJeu($test1);
            $manager->persist($baseLevel12);
            //
            $baseLevel13 = new Niveau();
            $baseLevel13->setNumero(13);
            $baseLevel13->setEcartEntreLesReponses(10);
            $baseLevel13->setNombreDeReponses(3);
            $baseLevel13->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel13->setReponsesSimilaires(false);
            $baseLevel13->setTempsDisponible(null);
            $baseLevel13->setOrdreDesQuestions('croissant');
            $baseLevel13->setQuestionsATrous(false);
            $baseLevel13->setJeu($test1);
            $manager->persist($baseLevel13);
            $user1->addNiveau($baseLevel13);
            //
            $baseLevel14 = new Niveau();
            $baseLevel14->setNumero(14);
            $baseLevel14->setEcartEntreLesReponses(10);
            $baseLevel14->setNombreDeReponses(3);
            $baseLevel14->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel14->setReponsesSimilaires(false);
            $baseLevel14->setTempsDisponible(null);
            $baseLevel14->setOrdreDesQuestions('decroissant');
            $baseLevel14->setQuestionsATrous(false);
            $baseLevel14->setJeu($test1);
            $manager->persist($baseLevel14);
            $user1->addNiveau($baseLevel14);
            //
            
        /*
        //games init
            $games[0]->setCheminAcces('altic/cave.html.twig');
            $games[1]->setCheminAcces('altic/moutain.html.twig');
            $games[2]->setCheminAcces('altic/doors.html.twig');
            $games[3]->setCheminAcces('altic/fishing.html.twig');
        *//*for ($i=0; $i < 4; $i++) { 
            $manager->persist($games[$i]);
        }*//*
        //regions init
            $regions[0]->setNom('');
            $regions[0]->setImgMagicien('');
            //
            $regions[1]->setNom('');
            $regions[1]->setImgMagicien('');
            //
            $regions[2]->setNom('');
            $regions[2]->setImgMagicien('');
            //
            $regions[3]->setNom('');
            $regions[3]->setImgMagicien('');
            //
            $regions[4]->setNom('');
            $regions[4]->setImgMagicien('');
            //
            $regions[5]->setNom('');
            $regions[5]->setImgMagicien('');
            //
            $regions[6]->setNom('');
            $regions[6]->setImgMagicien('');
            //
            $regions[7]->setNom('');
            $regions[7]->setImgMagicien('');
            //
            $regions[8]->setNom('');
            $regions[8]->setImgMagicien('');
            //
            $regions[9]->setNom('');
            $regions[9]->setImgMagicien('');
            //
            $regions[10]->setNom('');
            $regions[10]->setImgMagicien('');
            //
        foreach ($regions as $region) {
            $manager->persist($region);
        }

            //levels init
            for ($i=0; $i < 11; $i++) { 
                for ($j=1; $j < 13; $j++) { 
                    $currentLevel = $levels[$i*12+($j-1)];
                    $currentLevel->setNumero($i*12+$j);
                    $currentLevel->setEcartEntreLesReponses($baseLevels[$j-1]->getEcartEntreLesReponses());
                    $currentLevel->setNombreDeReponses($baseLevels[$j-1]->getNombreDeReponses());
                    $currentLevel->setNbReponsesProposeesDeLaMemeTable($baseLevels[$j-1]->getNbReponsesProposeesDeLaMemeTable());
                    $currentLevel->setReponsesSimilaires($baseLevels[$j-1]->getReponsesSimilaires());
                    $currentLevel->setTempsDisponible($baseLevels[$j-1]->getTempsDisponible());
                    $currentLevel->setOrdreDesQuestions($baseLevels[$j-1]->getOrdreDesQuestions());
                    $currentLevel->setQuestionsATrous($baseLevels[$j-1]->getQuestionsATrous());
                    $currentLevel->setJeu($games[0]);
                    //$manager->persist($currentLevel);
                }
            }

        //tables init
            for ($i = 0; $i < 11; $i++) { 
                $tables[$i]->setNumero($tablesOrder[$i]);
                $tables[$i]->setRegion($regions[$tablesOrder[$i]]);
                for ($j=0; $j < 12; $j++) {
                    $tables[$i]->addNiveau($levels[$i*12+$j]);
                }
                $manager->persist($tables[$i]);
            }*/
            $region = new Region();
            $region->setNom('');
            $region->setImgMagicien('');
            $manager->persist($region);
            $table1 = new TableDeMultiplication();
            $table1->setNumero(1);
            $table1->setRegion($region);
            $table1->addNiveau($baseLevel1);
            $table1->addNiveau($baseLevel2);
            $table1->addNiveau($baseLevel3);
            $table1->addNiveau($baseLevel4);
            $table1->addNiveau($baseLevel5);
            $table1->addNiveau($baseLevel6);
            $table1->addNiveau($baseLevel7);
            $table1->addNiveau($baseLevel8);
            $table1->addNiveau($baseLevel9);
            $table1->addNiveau($baseLevel10);
            $table1->addNiveau($baseLevel11);
            $table1->addNiveau($baseLevel12);
            $baseLevel1->addTableDeMultiplication($table1);
            $baseLevel2->addTableDeMultiplication($table1);
            $baseLevel3->addTableDeMultiplication($table1);
            $baseLevel4->addTableDeMultiplication($table1);
            $baseLevel5->addTableDeMultiplication($table1);
            $manager->persist($table1);
            $table2 = new TableDeMultiplication();
            $table2->setNumero(2);
            $table2->setRegion($region);
            $table2->addNiveau($baseLevel13);
            $table2->addNiveau($baseLevel14);
            $manager->persist($table2);
            
        
        $manager->flush();
    }
}
