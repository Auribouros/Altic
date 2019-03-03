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
        $tablesOrder = array(2, 5, 10, 1, 4, 3, 0, 6, 8, 9, 7);
        $baseLevels = array_fill(0, 12, new Niveau());
        $games = array_fill(0, 4, new Jeu());
        $tables = array_fill(0, 11, new TableDeMultiplication());
        $levels = array_fill(0, 132, new Niveau());
        $regions = array_fill(0, 11, new Region());

        //baseLevels init
            $baseLevels[0]->setNumero(-1);
            $baseLevels[0]->setEcartEntreLesReponses(10);
            $baseLevels[0]->setNombreDeReponses(3);
            $baseLevels[0]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[0]->setReponsesSimilaires(false);
            $baseLevels[0]->setTempsDisponible(null);
            $baseLevels[0]->setOrdreDesQuestions('croissant');
            $baseLevels[0]->setQuestionsATrous(false);
            //
            $baseLevels[1]->setNumero(-1);
            $baseLevels[1]->setEcartEntreLesReponses(10);
            $baseLevels[1]->setNombreDeReponses(3);
            $baseLevels[1]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[1]->setReponsesSimilaires(false);
            $baseLevels[1]->setTempsDisponible(null);
            $baseLevels[1]->setOrdreDesQuestions('decroissant');
            $baseLevels[1]->setQuestionsATrous(false);
            //
            $baseLevels[2]->setNumero(-1);
            $baseLevels[2]->setEcartEntreLesReponses(7);
            $baseLevels[2]->setNombreDeReponses(3);
            $baseLevels[2]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[2]->setReponsesSimilaires(true);
            $baseLevels[2]->setTempsDisponible(null);
            $baseLevels[2]->setOrdreDesQuestions('aleatoire');
            $baseLevels[2]->setQuestionsATrous(false);
            //
            $baseLevels[3]->setNumero(-1);
            $baseLevels[3]->setEcartEntreLesReponses(7);
            $baseLevels[3]->setNombreDeReponses(4);
            $baseLevels[3]->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevels[3]->setReponsesSimilaires(false);
            $baseLevels[3]->setTempsDisponible(30);
            $baseLevels[3]->setOrdreDesQuestions('croissant');
            $baseLevels[3]->setQuestionsATrous(false);
            //
            $baseLevels[4]->setNumero(-1);
            $baseLevels[4]->setEcartEntreLesReponses(5);
            $baseLevels[4]->setNombreDeReponses(4);
            $baseLevels[4]->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevels[4]->setReponsesSimilaires(false);
            $baseLevels[4]->setTempsDisponible(20);
            $baseLevels[4]->setOrdreDesQuestions('decroissant');
            $baseLevels[4]->setQuestionsATrous(false);
            //
            $baseLevels[5]->setNumero(-1);
            $baseLevels[5]->setEcartEntreLesReponses(5);
            $baseLevels[5]->setNombreDeReponses(4);
            $baseLevels[5]->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevels[5]->setReponsesSimilaires(true);
            $baseLevels[5]->setTempsDisponible(10);
            $baseLevels[5]->setOrdreDesQuestions('aleatoire');
            $baseLevels[5]->setQuestionsATrous(false);
            //
            $baseLevels[6]->setNumero(-1);
            $baseLevels[6]->setEcartEntreLesReponses(5);
            $baseLevels[6]->setNombreDeReponses(4);
            $baseLevels[6]->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevels[6]->setReponsesSimilaires(true);
            $baseLevels[6]->setTempsDisponible(10);
            $baseLevels[6]->setOrdreDesQuestions('croissant');
            $baseLevels[6]->setQuestionsATrous(false);
            //
            $baseLevels[7]->setNumero(-1);
            $baseLevels[7]->setEcartEntreLesReponses(10);
            $baseLevels[7]->setNombreDeReponses(0);
            $baseLevels[7]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[7]->setReponsesSimilaires(false);
            $baseLevels[7]->setTempsDisponible(20);
            $baseLevels[7]->setOrdreDesQuestions('croissant');
            $baseLevels[7]->setQuestionsATrous(true);
            //
            $baseLevels[8]->setNumero(-1);
            $baseLevels[8]->setEcartEntreLesReponses(10);
            $baseLevels[8]->setNombreDeReponses(0);
            $baseLevels[8]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[8]->setReponsesSimilaires(false);
            $baseLevels[8]->setTempsDisponible(10);
            $baseLevels[8]->setOrdreDesQuestions('croissant');
            $baseLevels[8]->setQuestionsATrous(true);
            //
            $baseLevels[9]->setNumero(-1);
            $baseLevels[9]->setEcartEntreLesReponses(10);
            $baseLevels[9]->setNombreDeReponses(0);
            $baseLevels[9]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[9]->setReponsesSimilaires(false);
            $baseLevels[9]->setTempsDisponible(10);
            $baseLevels[9]->setOrdreDesQuestions('croissant');
            $baseLevels[9]->setQuestionsATrous(true);
            //
            $baseLevels[10]->setNumero(-1);
            $baseLevels[10]->setEcartEntreLesReponses(10);
            $baseLevels[10]->setNombreDeReponses(0);
            $baseLevels[10]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[10]->setReponsesSimilaires(false);
            $baseLevels[10]->setTempsDisponible(10);
            $baseLevels[10]->setOrdreDesQuestions('croissant');
            $baseLevels[10]->setQuestionsATrous(true);
            //
            $baseLevels[11]->setNumero(-1);
            $baseLevels[11]->setEcartEntreLesReponses(10);
            $baseLevels[11]->setNombreDeReponses(0);
            $baseLevels[11]->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevels[11]->setReponsesSimilaires(false);
            $baseLevels[11]->setTempsDisponible(10);
            $baseLevels[11]->setOrdreDesQuestions('croissant');
            $baseLevels[11]->setQuestionsATrous(true);
            //

        //games init
            $games[0]->setCheminAcces('altic/cave.html.twig');
            $games[1]->setCheminAcces('altic/moutain.html.twig');
            $games[2]->setCheminAcces('altic/doors.html.twig');
            $games[3]->setCheminAcces('altic/fishing.html.twig');

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
            }

        $manager->flush();
    }
}
