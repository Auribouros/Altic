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
        $user2 = new Utilisateur();
        $user2->setEmail("lucy@christ.crux");
        $user2->setNom("christ");
        $user2->setPrenom("lucy");
        $user2->setPassword(
            $this->encoder->encodePassword($user2,"lucy")
        );

        $user2->setEstEnseignant(false);
        $manager->persist($user2);

        for ($i = 0; $i < 10; $i++) {
            $training = new Entrainement();
            $training->setDate(new \DateTime('@'.\strtotime('now')));
            $training->setDuree(mt_rand(10, 1000));
            $training->setUtilisateur($user2);
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
            $user2->addNiveau($baseLevel1);
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
            $user2->addNiveau($baseLevel2);
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
            $user2->addNiveau($baseLevel3);
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
            $user2->addNiveau($baseLevel4);
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
            $user2->addNiveau($baseLevel5);
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
            $user2->addNiveau($baseLevel6);
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
            $user2->addNiveau($baseLevel7);
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
            $user2->addNiveau($baseLevel8);
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
            $user2->addNiveau($baseLevel9);
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
            $user2->addNiveau($baseLevel10);
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
            $user2->addNiveau($baseLevel11);
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
            $user2->addNiveau($baseLevel12);
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
            $user2->addNiveau($baseLevel13);
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
            $user2->addNiveau($baseLevel14);
            //
            $baseLevel15 = new Niveau();
            $baseLevel15->setNumero(15);
            $baseLevel15->setEcartEntreLesReponses(7);
            $baseLevel15->setNombreDeReponses(3);
            $baseLevel15->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel15->setReponsesSimilaires(true);
            $baseLevel15->setTempsDisponible(null);
            $baseLevel15->setOrdreDesQuestions('aleatoire');
            $baseLevel15->setQuestionsATrous(false);
            $baseLevel15->setJeu($test1);
            $manager->persist($baseLevel15);
            $user2->addNiveau($baseLevel15);
            //
            $baseLevel16 = new Niveau();
            $baseLevel16->setNumero(16);
            $baseLevel16->setEcartEntreLesReponses(7);
            $baseLevel16->setNombreDeReponses(4);
            $baseLevel16->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel16->setReponsesSimilaires(false);
            $baseLevel16->setTempsDisponible(30);
            $baseLevel16->setOrdreDesQuestions('croissant');
            $baseLevel16->setQuestionsATrous(false);
            $baseLevel16->setJeu($test1);
            $manager->persist($baseLevel16);
            $user2->addNiveau($baseLevel16);
            //
            $baseLevel17 = new Niveau();
            $baseLevel17->setNumero(17);
            $baseLevel17->setEcartEntreLesReponses(5);
            $baseLevel17->setNombreDeReponses(4);
            $baseLevel17->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel17->setReponsesSimilaires(false);
            $baseLevel17->setTempsDisponible(20);
            $baseLevel17->setOrdreDesQuestions('decroissant');
            $baseLevel17->setQuestionsATrous(false);
            $baseLevel17->setJeu($test1);
            $manager->persist($baseLevel17);
            //
            $baseLevel18 = new Niveau();
            $baseLevel18->setNumero(18);
            $baseLevel18->setEcartEntreLesReponses(5);
            $baseLevel18->setNombreDeReponses(4);
            $baseLevel18->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel18->setReponsesSimilaires(true);
            $baseLevel18->setTempsDisponible(10);
            $baseLevel18->setOrdreDesQuestions('aleatoire');
            $baseLevel18->setQuestionsATrous(false);
            $baseLevel18->setJeu($test1);
            $manager->persist($baseLevel18);
            //
            $baseLevel19 = new Niveau();
            $baseLevel19->setNumero(19);
            $baseLevel19->setEcartEntreLesReponses(5);
            $baseLevel19->setNombreDeReponses(4);
            $baseLevel19->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel19->setReponsesSimilaires(true);
            $baseLevel19->setTempsDisponible(10);
            $baseLevel19->setOrdreDesQuestions('croissant');
            $baseLevel19->setQuestionsATrous(false);
            $baseLevel19->setJeu($test1);
            $manager->persist($baseLevel19);
            //
            $baseLevel20 = new Niveau();
            $baseLevel20->setNumero(20);
            $baseLevel20->setEcartEntreLesReponses(10);
            $baseLevel20->setNombreDeReponses(0);
            $baseLevel20->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel20->setReponsesSimilaires(false);
            $baseLevel20->setTempsDisponible(20);
            $baseLevel20->setOrdreDesQuestions('croissant');
            $baseLevel20->setQuestionsATrous(true);
            $baseLevel20->setJeu($test1);
            $manager->persist($baseLevel20);
            $user2->addNiveau($baseLevel20);
            //
            $baseLevel21 = new Niveau();
            $baseLevel21->setNumero(21);
            $baseLevel21->setEcartEntreLesReponses(10);
            $baseLevel21->setNombreDeReponses(0);
            $baseLevel21->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel21->setReponsesSimilaires(false);
            $baseLevel21->setTempsDisponible(10);
            $baseLevel21->setOrdreDesQuestions('croissant');
            $baseLevel21->setQuestionsATrous(true);
            $baseLevel21->setJeu($test1);
            $manager->persist($baseLevel21);
            $user2->addNiveau($baseLevel21);
            //
            $baseLevel22 = new Niveau();
            $baseLevel22->setNumero(22);
            $baseLevel22->setEcartEntreLesReponses(10);
            $baseLevel22->setNombreDeReponses(0);
            $baseLevel22->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel22->setReponsesSimilaires(false);
            $baseLevel22->setTempsDisponible(10);
            $baseLevel22->setOrdreDesQuestions('croissant');
            $baseLevel22->setQuestionsATrous(true);
            $baseLevel22->setJeu($test1);
            $manager->persist($baseLevel22);
            $user2->addNiveau($baseLevel22);
            //
            $baseLevel23 = new Niveau();
            $baseLevel23->setNumero(23);
            $baseLevel23->setEcartEntreLesReponses(10);
            $baseLevel23->setNombreDeReponses(0);
            $baseLevel23->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel23->setReponsesSimilaires(false);
            $baseLevel23->setTempsDisponible(10);
            $baseLevel23->setOrdreDesQuestions('croissant');
            $baseLevel23->setQuestionsATrous(true);
            $baseLevel23->setJeu($test1);
            $manager->persist($baseLevel23);
            $user2->addNiveau($baseLevel23);
            //
            $baseLevel24 = new Niveau();
            $baseLevel24->setNumero(24);
            $baseLevel24->setEcartEntreLesReponses(10);
            $baseLevel24->setNombreDeReponses(0);
            $baseLevel24->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel24->setReponsesSimilaires(false);
            $baseLevel24->setTempsDisponible(10);
            $baseLevel24->setOrdreDesQuestions('croissant');
            $baseLevel24->setQuestionsATrous(true);
            $baseLevel24->setJeu($test1);
            $manager->persist($baseLevel24);
            $user2->addNiveau($baseLevel24);
            //
            $baseLevel25 = new Niveau();
            $baseLevel25->setNumero(25);
            $baseLevel25->setEcartEntreLesReponses(10);
            $baseLevel25->setNombreDeReponses(3);
            $baseLevel25->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel25->setReponsesSimilaires(false);
            $baseLevel25->setTempsDisponible(null);
            $baseLevel25->setOrdreDesQuestions('croissant');
            $baseLevel25->setQuestionsATrous(false);
            $baseLevel25->setJeu($test1);
            $manager->persist($baseLevel25);
            $user2->addNiveau($baseLevel25);
            //
            $baseLevel26 = new Niveau();
            $baseLevel26->setNumero(26);
            $baseLevel26->setEcartEntreLesReponses(10);
            $baseLevel26->setNombreDeReponses(3);
            $baseLevel26->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel26->setReponsesSimilaires(false);
            $baseLevel26->setTempsDisponible(null);
            $baseLevel26->setOrdreDesQuestions('decroissant');
            $baseLevel26->setQuestionsATrous(false);
            $baseLevel26->setJeu($test1);
            $manager->persist($baseLevel26);
            $user2->addNiveau($baseLevel26);
            //
            $baseLevel27 = new Niveau();
            $baseLevel27->setNumero(27);
            $baseLevel27->setEcartEntreLesReponses(7);
            $baseLevel27->setNombreDeReponses(3);
            $baseLevel27->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel27->setReponsesSimilaires(true);
            $baseLevel27->setTempsDisponible(null);
            $baseLevel27->setOrdreDesQuestions('aleatoire');
            $baseLevel27->setQuestionsATrous(false);
            $baseLevel27->setJeu($test1);
            $manager->persist($baseLevel27);
            $user2->addNiveau($baseLevel27);
            //
            $baseLevel28 = new Niveau();
            $baseLevel28->setNumero(28);
            $baseLevel28->setEcartEntreLesReponses(7);
            $baseLevel28->setNombreDeReponses(4);
            $baseLevel28->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel28->setReponsesSimilaires(false);
            $baseLevel28->setTempsDisponible(30);
            $baseLevel28->setOrdreDesQuestions('croissant');
            $baseLevel28->setQuestionsATrous(false);
            $baseLevel28->setJeu($test1);
            $manager->persist($baseLevel28);
            $user2->addNiveau($baseLevel28);
            //
            $baseLevel29 = new Niveau();
            $baseLevel29->setNumero(29);
            $baseLevel29->setEcartEntreLesReponses(5);
            $baseLevel29->setNombreDeReponses(4);
            $baseLevel29->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel29->setReponsesSimilaires(false);
            $baseLevel29->setTempsDisponible(20);
            $baseLevel29->setOrdreDesQuestions('decroissant');
            $baseLevel29->setQuestionsATrous(false);
            $baseLevel29->setJeu($test1);
            $manager->persist($baseLevel29);
            $user2->addNiveau($baseLevel29);
            //
            $baseLevel30 = new Niveau();
            $baseLevel30->setNumero(30);
            $baseLevel30->setEcartEntreLesReponses(5);
            $baseLevel30->setNombreDeReponses(4);
            $baseLevel30->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel30->setReponsesSimilaires(true);
            $baseLevel30->setTempsDisponible(10);
            $baseLevel30->setOrdreDesQuestions('aleatoire');
            $baseLevel30->setQuestionsATrous(false);
            $baseLevel30->setJeu($test1);
            $manager->persist($baseLevel30);
            $user2->addNiveau($baseLevel30);
            //
            $baseLevel31 = new Niveau();
            $baseLevel31->setNumero(31);
            $baseLevel31->setEcartEntreLesReponses(5);
            $baseLevel31->setNombreDeReponses(4);
            $baseLevel31->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel31->setReponsesSimilaires(true);
            $baseLevel31->setTempsDisponible(10);
            $baseLevel31->setOrdreDesQuestions('croissant');
            $baseLevel31->setQuestionsATrous(false);
            $baseLevel31->setJeu($test1);
            $manager->persist($baseLevel31);
            $user2->addNiveau($baseLevel31);
            //
            $baseLevel32 = new Niveau();
            $baseLevel32->setNumero(32);
            $baseLevel32->setEcartEntreLesReponses(10);
            $baseLevel32->setNombreDeReponses(0);
            $baseLevel32->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel32->setReponsesSimilaires(false);
            $baseLevel32->setTempsDisponible(20);
            $baseLevel32->setOrdreDesQuestions('croissant');
            $baseLevel32->setQuestionsATrous(true);
            $baseLevel32->setJeu($test1);
            $manager->persist($baseLevel32);
            $user2->addNiveau($baseLevel32);
            //
            $baseLevel33 = new Niveau();
            $baseLevel33->setNumero(33);
            $baseLevel33->setEcartEntreLesReponses(10);
            $baseLevel33->setNombreDeReponses(0);
            $baseLevel33->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel33->setReponsesSimilaires(false);
            $baseLevel33->setTempsDisponible(10);
            $baseLevel33->setOrdreDesQuestions('croissant');
            $baseLevel33->setQuestionsATrous(true);
            $baseLevel33->setJeu($test1);
            $manager->persist($baseLevel33);
            $user2->addNiveau($baseLevel33);
            //
            $baseLevel34 = new Niveau();
            $baseLevel34->setNumero(34);
            $baseLevel34->setEcartEntreLesReponses(10);
            $baseLevel34->setNombreDeReponses(0);
            $baseLevel34->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel34->setReponsesSimilaires(false);
            $baseLevel34->setTempsDisponible(10);
            $baseLevel34->setOrdreDesQuestions('croissant');
            $baseLevel34->setQuestionsATrous(true);
            $baseLevel34->setJeu($test1);
            $manager->persist($baseLevel34);
            $user2->addNiveau($baseLevel34);
            //
            $baseLevel35 = new Niveau();
            $baseLevel35->setNumero(35);
            $baseLevel35->setEcartEntreLesReponses(10);
            $baseLevel35->setNombreDeReponses(0);
            $baseLevel35->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel35->setReponsesSimilaires(false);
            $baseLevel35->setTempsDisponible(10);
            $baseLevel35->setOrdreDesQuestions('croissant');
            $baseLevel35->setQuestionsATrous(true);
            $baseLevel35->setJeu($test1);
            $manager->persist($baseLevel35);
            $user2->addNiveau($baseLevel35);
            //
            $baseLevel36 = new Niveau();
            $baseLevel36->setNumero(36);
            $baseLevel36->setEcartEntreLesReponses(10);
            $baseLevel36->setNombreDeReponses(0);
            $baseLevel36->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel36->setReponsesSimilaires(false);
            $baseLevel36->setTempsDisponible(10);
            $baseLevel36->setOrdreDesQuestions('croissant');
            $baseLevel36->setQuestionsATrous(true);
            $baseLevel36->setJeu($test1);
            $manager->persist($baseLevel36);
            $user2->addNiveau($baseLevel36);
            //
            $baseLevel37 = new Niveau();
            $baseLevel37->setNumero(37);
            $baseLevel37->setEcartEntreLesReponses(10);
            $baseLevel37->setNombreDeReponses(3);
            $baseLevel37->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel37->setReponsesSimilaires(false);
            $baseLevel37->setTempsDisponible(null);
            $baseLevel37->setOrdreDesQuestions('croissant');
            $baseLevel37->setQuestionsATrous(false);
            $baseLevel37->setJeu($test1);
            $manager->persist($baseLevel37);
            $user2->addNiveau($baseLevel37);
            //
            $baseLevel38 = new Niveau();
            $baseLevel38->setNumero(38);
            $baseLevel38->setEcartEntreLesReponses(10);
            $baseLevel38->setNombreDeReponses(3);
            $baseLevel38->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel38->setReponsesSimilaires(false);
            $baseLevel38->setTempsDisponible(null);
            $baseLevel38->setOrdreDesQuestions('decroissant');
            $baseLevel38->setQuestionsATrous(false);
            $baseLevel38->setJeu($test1);
            $manager->persist($baseLevel38);
            $user2->addNiveau($baseLevel38);
            //
            $baseLevel39 = new Niveau();
            $baseLevel39->setNumero(39);
            $baseLevel39->setEcartEntreLesReponses(7);
            $baseLevel39->setNombreDeReponses(3);
            $baseLevel39->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel39->setReponsesSimilaires(true);
            $baseLevel39->setTempsDisponible(null);
            $baseLevel39->setOrdreDesQuestions('aleatoire');
            $baseLevel39->setQuestionsATrous(false);
            $baseLevel39->setJeu($test1);
            $manager->persist($baseLevel39);
            $user2->addNiveau($baseLevel39);
            //
            $baseLevel40 = new Niveau();
            $baseLevel40->setNumero(40);
            $baseLevel40->setEcartEntreLesReponses(7);
            $baseLevel40->setNombreDeReponses(4);
            $baseLevel40->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel40->setReponsesSimilaires(false);
            $baseLevel40->setTempsDisponible(30);
            $baseLevel40->setOrdreDesQuestions('croissant');
            $baseLevel40->setQuestionsATrous(false);
            $baseLevel40->setJeu($test1);
            $manager->persist($baseLevel40);
            $user2->addNiveau($baseLevel40);
            //
            $baseLevel41 = new Niveau();
            $baseLevel41->setNumero(41);
            $baseLevel41->setEcartEntreLesReponses(5);
            $baseLevel41->setNombreDeReponses(4);
            $baseLevel41->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel41->setReponsesSimilaires(false);
            $baseLevel41->setTempsDisponible(20);
            $baseLevel41->setOrdreDesQuestions('decroissant');
            $baseLevel41->setQuestionsATrous(false);
            $baseLevel41->setJeu($test1);
            $manager->persist($baseLevel41);
            $user2->addNiveau($baseLevel41);
            //
            $baseLevel42 = new Niveau();
            $baseLevel42->setNumero(42);
            $baseLevel42->setEcartEntreLesReponses(5);
            $baseLevel42->setNombreDeReponses(4);
            $baseLevel42->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel42->setReponsesSimilaires(true);
            $baseLevel42->setTempsDisponible(10);
            $baseLevel42->setOrdreDesQuestions('aleatoire');
            $baseLevel42->setQuestionsATrous(false);
            $baseLevel42->setJeu($test1);
            $manager->persist($baseLevel42);
            $user2->addNiveau($baseLevel42);
            //
            $baseLevel43 = new Niveau();
            $baseLevel43->setNumero(43);
            $baseLevel43->setEcartEntreLesReponses(5);
            $baseLevel43->setNombreDeReponses(4);
            $baseLevel43->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel43->setReponsesSimilaires(true);
            $baseLevel43->setTempsDisponible(10);
            $baseLevel43->setOrdreDesQuestions('croissant');
            $baseLevel43->setQuestionsATrous(false);
            $baseLevel43->setJeu($test1);
            $manager->persist($baseLevel43);
            $user2->addNiveau($baseLevel43);
            //
            $baseLevel44 = new Niveau();
            $baseLevel44->setNumero(44);
            $baseLevel44->setEcartEntreLesReponses(10);
            $baseLevel44->setNombreDeReponses(0);
            $baseLevel44->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel44->setReponsesSimilaires(false);
            $baseLevel44->setTempsDisponible(20);
            $baseLevel44->setOrdreDesQuestions('croissant');
            $baseLevel44->setQuestionsATrous(true);
            $baseLevel44->setJeu($test1);
            $manager->persist($baseLevel44);
            $user2->addNiveau($baseLevel44);
            //
            $baseLevel45 = new Niveau();
            $baseLevel45->setNumero(45);
            $baseLevel45->setEcartEntreLesReponses(10);
            $baseLevel45->setNombreDeReponses(0);
            $baseLevel45->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel45->setReponsesSimilaires(false);
            $baseLevel45->setTempsDisponible(10);
            $baseLevel45->setOrdreDesQuestions('croissant');
            $baseLevel45->setQuestionsATrous(true);
            $baseLevel45->setJeu($test1);
            $manager->persist($baseLevel45);
            $user2->addNiveau($baseLevel45);
            //
            $baseLevel46 = new Niveau();
            $baseLevel46->setNumero(46);
            $baseLevel46->setEcartEntreLesReponses(10);
            $baseLevel46->setNombreDeReponses(0);
            $baseLevel46->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel46->setReponsesSimilaires(false);
            $baseLevel46->setTempsDisponible(10);
            $baseLevel46->setOrdreDesQuestions('croissant');
            $baseLevel46->setQuestionsATrous(true);
            $baseLevel46->setJeu($test1);
            $manager->persist($baseLevel46);
            $user2->addNiveau($baseLevel46);
            //
            $baseLevel47 = new Niveau();
            $baseLevel47->setNumero(47);
            $baseLevel47->setEcartEntreLesReponses(10);
            $baseLevel47->setNombreDeReponses(0);
            $baseLevel47->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel47->setReponsesSimilaires(false);
            $baseLevel47->setTempsDisponible(10);
            $baseLevel47->setOrdreDesQuestions('croissant');
            $baseLevel47->setQuestionsATrous(true);
            $baseLevel47->setJeu($test1);
            $manager->persist($baseLevel47);
            $user2->addNiveau($baseLevel47);
            //
            $baseLevel48 = new Niveau();
            $baseLevel48->setNumero(48);
            $baseLevel48->setEcartEntreLesReponses(10);
            $baseLevel48->setNombreDeReponses(0);
            $baseLevel48->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel48->setReponsesSimilaires(false);
            $baseLevel48->setTempsDisponible(10);
            $baseLevel48->setOrdreDesQuestions('croissant');
            $baseLevel48->setQuestionsATrous(true);
            $baseLevel48->setJeu($test1);
            $manager->persist($baseLevel48);
            $user2->addNiveau($baseLevel48);
            //
            $baseLevel49 = new Niveau();
            $baseLevel49->setNumero(49);
            $baseLevel49->setEcartEntreLesReponses(10);
            $baseLevel49->setNombreDeReponses(3);
            $baseLevel49->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel49->setReponsesSimilaires(false);
            $baseLevel49->setTempsDisponible(null);
            $baseLevel49->setOrdreDesQuestions('croissant');
            $baseLevel49->setQuestionsATrous(false);
            $baseLevel49->setJeu($test1);
            $manager->persist($baseLevel49);
            $user2->addNiveau($baseLevel49);
            //
            $baseLevel50 = new Niveau();
            $baseLevel50->setNumero(50);
            $baseLevel50->setEcartEntreLesReponses(10);
            $baseLevel50->setNombreDeReponses(3);
            $baseLevel50->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel50->setReponsesSimilaires(false);
            $baseLevel50->setTempsDisponible(null);
            $baseLevel50->setOrdreDesQuestions('decroissant');
            $baseLevel50->setQuestionsATrous(false);
            $baseLevel50->setJeu($test1);
            $manager->persist($baseLevel50);
            $user2->addNiveau($baseLevel50);
            //
            $baseLevel51 = new Niveau();
            $baseLevel51->setNumero(51);
            $baseLevel51->setEcartEntreLesReponses(7);
            $baseLevel51->setNombreDeReponses(3);
            $baseLevel51->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel51->setReponsesSimilaires(true);
            $baseLevel51->setTempsDisponible(null);
            $baseLevel51->setOrdreDesQuestions('aleatoire');
            $baseLevel51->setQuestionsATrous(false);
            $baseLevel51->setJeu($test1);
            $manager->persist($baseLevel51);
            $user2->addNiveau($baseLevel51);
            //
            $baseLevel52 = new Niveau();
            $baseLevel52->setNumero(52);
            $baseLevel52->setEcartEntreLesReponses(7);
            $baseLevel52->setNombreDeReponses(4);
            $baseLevel52->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel52->setReponsesSimilaires(false);
            $baseLevel52->setTempsDisponible(30);
            $baseLevel52->setOrdreDesQuestions('croissant');
            $baseLevel52->setQuestionsATrous(false);
            $baseLevel52->setJeu($test1);
            $manager->persist($baseLevel52);
            $user2->addNiveau($baseLevel52);
            //
            $baseLevel53 = new Niveau();
            $baseLevel53->setNumero(53);
            $baseLevel53->setEcartEntreLesReponses(5);
            $baseLevel53->setNombreDeReponses(4);
            $baseLevel53->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel53->setReponsesSimilaires(false);
            $baseLevel53->setTempsDisponible(20);
            $baseLevel53->setOrdreDesQuestions('decroissant');
            $baseLevel53->setQuestionsATrous(false);
            $baseLevel53->setJeu($test1);
            $manager->persist($baseLevel53);
            $user2->addNiveau($baseLevel53);
            //
            $baseLevel54 = new Niveau();
            $baseLevel54->setNumero(54);
            $baseLevel54->setEcartEntreLesReponses(5);
            $baseLevel54->setNombreDeReponses(4);
            $baseLevel54->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel54->setReponsesSimilaires(true);
            $baseLevel54->setTempsDisponible(10);
            $baseLevel54->setOrdreDesQuestions('aleatoire');
            $baseLevel54->setQuestionsATrous(false);
            $baseLevel54->setJeu($test1);
            $manager->persist($baseLevel54);
            $user2->addNiveau($baseLevel54);
            //
            $baseLevel55 = new Niveau();
            $baseLevel55->setNumero(55);
            $baseLevel55->setEcartEntreLesReponses(5);
            $baseLevel55->setNombreDeReponses(4);
            $baseLevel55->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel55->setReponsesSimilaires(true);
            $baseLevel55->setTempsDisponible(10);
            $baseLevel55->setOrdreDesQuestions('croissant');
            $baseLevel55->setQuestionsATrous(false);
            $baseLevel55->setJeu($test1);
            $manager->persist($baseLevel55);
            $user2->addNiveau($baseLevel55);
            //
            $baseLevel56 = new Niveau();
            $baseLevel56->setNumero(56);
            $baseLevel56->setEcartEntreLesReponses(10);
            $baseLevel56->setNombreDeReponses(0);
            $baseLevel56->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel56->setReponsesSimilaires(false);
            $baseLevel56->setTempsDisponible(20);
            $baseLevel56->setOrdreDesQuestions('croissant');
            $baseLevel56->setQuestionsATrous(true);
            $baseLevel56->setJeu($test1);
            $manager->persist($baseLevel56);
            $user2->addNiveau($baseLevel56);
            //
            $baseLevel57 = new Niveau();
            $baseLevel57->setNumero(57);
            $baseLevel57->setEcartEntreLesReponses(10);
            $baseLevel57->setNombreDeReponses(0);
            $baseLevel57->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel57->setReponsesSimilaires(false);
            $baseLevel57->setTempsDisponible(10);
            $baseLevel57->setOrdreDesQuestions('croissant');
            $baseLevel57->setQuestionsATrous(true);
            $baseLevel57->setJeu($test1);
            $manager->persist($baseLevel57);
            $user2->addNiveau($baseLevel57);
            //
            $baseLevel58 = new Niveau();
            $baseLevel58->setNumero(58);
            $baseLevel58->setEcartEntreLesReponses(10);
            $baseLevel58->setNombreDeReponses(0);
            $baseLevel58->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel58->setReponsesSimilaires(false);
            $baseLevel58->setTempsDisponible(10);
            $baseLevel58->setOrdreDesQuestions('croissant');
            $baseLevel58->setQuestionsATrous(true);
            $baseLevel58->setJeu($test1);
            $manager->persist($baseLevel58);
            $user2->addNiveau($baseLevel58);
            //
            $baseLevel59 = new Niveau();
            $baseLevel59->setNumero(59);
            $baseLevel59->setEcartEntreLesReponses(10);
            $baseLevel59->setNombreDeReponses(0);
            $baseLevel59->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel59->setReponsesSimilaires(false);
            $baseLevel59->setTempsDisponible(10);
            $baseLevel59->setOrdreDesQuestions('croissant');
            $baseLevel59->setQuestionsATrous(true);
            $baseLevel59->setJeu($test1);
            $manager->persist($baseLevel59);
            $user2->addNiveau($baseLevel59);
            //
            $baseLevel60 = new Niveau();
            $baseLevel60->setNumero(60);
            $baseLevel60->setEcartEntreLesReponses(10);
            $baseLevel60->setNombreDeReponses(0);
            $baseLevel60->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel60->setReponsesSimilaires(false);
            $baseLevel60->setTempsDisponible(10);
            $baseLevel60->setOrdreDesQuestions('croissant');
            $baseLevel60->setQuestionsATrous(true);
            $baseLevel60->setJeu($test1);
            $manager->persist($baseLevel60);
            $user2->addNiveau($baseLevel60);
            //
            $baseLevel61 = new Niveau();
            $baseLevel61->setNumero(61);
            $baseLevel61->setEcartEntreLesReponses(10);
            $baseLevel61->setNombreDeReponses(3);
            $baseLevel61->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel61->setReponsesSimilaires(false);
            $baseLevel61->setTempsDisponible(null);
            $baseLevel61->setOrdreDesQuestions('croissant');
            $baseLevel61->setQuestionsATrous(false);
            $baseLevel61->setJeu($test1);
            $manager->persist($baseLevel61);
            $user2->addNiveau($baseLevel61);
            //
            $baseLevel62 = new Niveau();
            $baseLevel62->setNumero(62);
            $baseLevel62->setEcartEntreLesReponses(10);
            $baseLevel62->setNombreDeReponses(3);
            $baseLevel62->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel62->setReponsesSimilaires(false);
            $baseLevel62->setTempsDisponible(null);
            $baseLevel62->setOrdreDesQuestions('decroissant');
            $baseLevel62->setQuestionsATrous(false);
            $baseLevel62->setJeu($test1);
            $manager->persist($baseLevel62);
            $user2->addNiveau($baseLevel62);
            //
            $baseLevel63 = new Niveau();
            $baseLevel63->setNumero(63);
            $baseLevel63->setEcartEntreLesReponses(7);
            $baseLevel63->setNombreDeReponses(3);
            $baseLevel63->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel63->setReponsesSimilaires(true);
            $baseLevel63->setTempsDisponible(null);
            $baseLevel63->setOrdreDesQuestions('aleatoire');
            $baseLevel63->setQuestionsATrous(false);
            $baseLevel63->setJeu($test1);
            $manager->persist($baseLevel63);
            $user2->addNiveau($baseLevel63);
            //
            $baseLevel64 = new Niveau();
            $baseLevel64->setNumero(64);
            $baseLevel64->setEcartEntreLesReponses(7);
            $baseLevel64->setNombreDeReponses(4);
            $baseLevel64->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel64->setReponsesSimilaires(false);
            $baseLevel64->setTempsDisponible(30);
            $baseLevel64->setOrdreDesQuestions('croissant');
            $baseLevel64->setQuestionsATrous(false);
            $baseLevel64->setJeu($test1);
            $manager->persist($baseLevel64);
            $user2->addNiveau($baseLevel64);
            //
            $baseLevel65 = new Niveau();
            $baseLevel65->setNumero(65);
            $baseLevel65->setEcartEntreLesReponses(5);
            $baseLevel65->setNombreDeReponses(4);
            $baseLevel65->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel65->setReponsesSimilaires(false);
            $baseLevel65->setTempsDisponible(20);
            $baseLevel65->setOrdreDesQuestions('decroissant');
            $baseLevel65->setQuestionsATrous(false);
            $baseLevel65->setJeu($test1);
            $manager->persist($baseLevel65);
            $user2->addNiveau($baseLevel65);
            //
            $baseLevel66 = new Niveau();
            $baseLevel66->setNumero(66);
            $baseLevel66->setEcartEntreLesReponses(5);
            $baseLevel66->setNombreDeReponses(4);
            $baseLevel66->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel66->setReponsesSimilaires(true);
            $baseLevel66->setTempsDisponible(10);
            $baseLevel66->setOrdreDesQuestions('aleatoire');
            $baseLevel66->setQuestionsATrous(false);
            $baseLevel66->setJeu($test1);
            $manager->persist($baseLevel66);
            $user2->addNiveau($baseLevel66);
            //
            $baseLevel67 = new Niveau();
            $baseLevel67->setNumero(67);
            $baseLevel67->setEcartEntreLesReponses(5);
            $baseLevel67->setNombreDeReponses(4);
            $baseLevel67->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel67->setReponsesSimilaires(true);
            $baseLevel67->setTempsDisponible(10);
            $baseLevel67->setOrdreDesQuestions('croissant');
            $baseLevel67->setQuestionsATrous(false);
            $baseLevel67->setJeu($test1);
            $manager->persist($baseLevel67);
            $user2->addNiveau($baseLevel67);
            //
            $baseLevel68 = new Niveau();
            $baseLevel68->setNumero(68);
            $baseLevel68->setEcartEntreLesReponses(10);
            $baseLevel68->setNombreDeReponses(0);
            $baseLevel68->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel68->setReponsesSimilaires(false);
            $baseLevel68->setTempsDisponible(20);
            $baseLevel68->setOrdreDesQuestions('croissant');
            $baseLevel68->setQuestionsATrous(true);
            $baseLevel68->setJeu($test1);
            $manager->persist($baseLevel68);
            $user2->addNiveau($baseLevel68);
            //
            $baseLevel69 = new Niveau();
            $baseLevel69->setNumero(69);
            $baseLevel69->setEcartEntreLesReponses(10);
            $baseLevel69->setNombreDeReponses(0);
            $baseLevel69->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel69->setReponsesSimilaires(false);
            $baseLevel69->setTempsDisponible(10);
            $baseLevel69->setOrdreDesQuestions('croissant');
            $baseLevel69->setQuestionsATrous(true);
            $baseLevel69->setJeu($test1);
            $manager->persist($baseLevel69);
            $user2->addNiveau($baseLevel69);
            //
            $baseLevel70 = new Niveau();
            $baseLevel70->setNumero(70);
            $baseLevel70->setEcartEntreLesReponses(10);
            $baseLevel70->setNombreDeReponses(0);
            $baseLevel70->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel70->setReponsesSimilaires(false);
            $baseLevel70->setTempsDisponible(10);
            $baseLevel70->setOrdreDesQuestions('croissant');
            $baseLevel70->setQuestionsATrous(true);
            $baseLevel70->setJeu($test1);
            $manager->persist($baseLevel70);
            $user2->addNiveau($baseLevel70);
            //
            $baseLevel71 = new Niveau();
            $baseLevel71->setNumero(71);
            $baseLevel71->setEcartEntreLesReponses(10);
            $baseLevel71->setNombreDeReponses(0);
            $baseLevel71->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel71->setReponsesSimilaires(false);
            $baseLevel71->setTempsDisponible(10);
            $baseLevel71->setOrdreDesQuestions('croissant');
            $baseLevel71->setQuestionsATrous(true);
            $baseLevel71->setJeu($test1);
            $manager->persist($baseLevel71);
            $user2->addNiveau($baseLevel71);
            //
            $baseLevel72 = new Niveau();
            $baseLevel72->setNumero(72);
            $baseLevel72->setEcartEntreLesReponses(10);
            $baseLevel72->setNombreDeReponses(0);
            $baseLevel72->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel72->setReponsesSimilaires(false);
            $baseLevel72->setTempsDisponible(10);
            $baseLevel72->setOrdreDesQuestions('croissant');
            $baseLevel72->setQuestionsATrous(true);
            $baseLevel72->setJeu($test1);
            $manager->persist($baseLevel72);
            $user2->addNiveau($baseLevel72);
            //
            $baseLevel73 = new Niveau();
            $baseLevel73->setNumero(73);
            $baseLevel73->setEcartEntreLesReponses(10);
            $baseLevel73->setNombreDeReponses(3);
            $baseLevel73->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel73->setReponsesSimilaires(false);
            $baseLevel73->setTempsDisponible(null);
            $baseLevel73->setOrdreDesQuestions('croissant');
            $baseLevel73->setQuestionsATrous(false);
            $baseLevel73->setJeu($test1);
            $manager->persist($baseLevel73);
            $user2->addNiveau($baseLevel73);
            //
            $baseLevel74 = new Niveau();
            $baseLevel74->setNumero(74);
            $baseLevel74->setEcartEntreLesReponses(10);
            $baseLevel74->setNombreDeReponses(3);
            $baseLevel74->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel74->setReponsesSimilaires(false);
            $baseLevel74->setTempsDisponible(null);
            $baseLevel74->setOrdreDesQuestions('decroissant');
            $baseLevel74->setQuestionsATrous(false);
            $baseLevel74->setJeu($test1);
            $manager->persist($baseLevel74);
            $user2->addNiveau($baseLevel74);
            //
            $baseLevel75 = new Niveau();
            $baseLevel75->setNumero(75);
            $baseLevel75->setEcartEntreLesReponses(7);
            $baseLevel75->setNombreDeReponses(3);
            $baseLevel75->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel75->setReponsesSimilaires(true);
            $baseLevel75->setTempsDisponible(null);
            $baseLevel75->setOrdreDesQuestions('aleatoire');
            $baseLevel75->setQuestionsATrous(false);
            $baseLevel75->setJeu($test1);
            $manager->persist($baseLevel75);
            $user2->addNiveau($baseLevel75);
            //
            $baseLevel76 = new Niveau();
            $baseLevel76->setNumero(76);
            $baseLevel76->setEcartEntreLesReponses(7);
            $baseLevel76->setNombreDeReponses(4);
            $baseLevel76->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel76->setReponsesSimilaires(false);
            $baseLevel76->setTempsDisponible(30);
            $baseLevel76->setOrdreDesQuestions('croissant');
            $baseLevel76->setQuestionsATrous(false);
            $baseLevel76->setJeu($test1);
            $manager->persist($baseLevel76);
            $user2->addNiveau($baseLevel76);
            //
            $baseLevel77 = new Niveau();
            $baseLevel77->setNumero(77);
            $baseLevel77->setEcartEntreLesReponses(5);
            $baseLevel77->setNombreDeReponses(4);
            $baseLevel77->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel77->setReponsesSimilaires(false);
            $baseLevel77->setTempsDisponible(20);
            $baseLevel77->setOrdreDesQuestions('decroissant');
            $baseLevel77->setQuestionsATrous(false);
            $baseLevel77->setJeu($test1);
            $manager->persist($baseLevel77);
            $user2->addNiveau($baseLevel77);
            //
            $baseLevel78 = new Niveau();
            $baseLevel78->setNumero(78);
            $baseLevel78->setEcartEntreLesReponses(5);
            $baseLevel78->setNombreDeReponses(4);
            $baseLevel78->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel78->setReponsesSimilaires(true);
            $baseLevel78->setTempsDisponible(10);
            $baseLevel78->setOrdreDesQuestions('aleatoire');
            $baseLevel78->setQuestionsATrous(false);
            $baseLevel78->setJeu($test1);
            $manager->persist($baseLevel78);
            $user2->addNiveau($baseLevel78);
            //
            $baseLevel79 = new Niveau();
            $baseLevel79->setNumero(79);
            $baseLevel79->setEcartEntreLesReponses(5);
            $baseLevel79->setNombreDeReponses(4);
            $baseLevel79->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel79->setReponsesSimilaires(true);
            $baseLevel79->setTempsDisponible(10);
            $baseLevel79->setOrdreDesQuestions('croissant');
            $baseLevel79->setQuestionsATrous(false);
            $baseLevel79->setJeu($test1);
            $manager->persist($baseLevel79);
            $user2->addNiveau($baseLevel79);
            //
            $baseLevel80 = new Niveau();
            $baseLevel80->setNumero(80);
            $baseLevel80->setEcartEntreLesReponses(10);
            $baseLevel80->setNombreDeReponses(0);
            $baseLevel80->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel80->setReponsesSimilaires(false);
            $baseLevel80->setTempsDisponible(20);
            $baseLevel80->setOrdreDesQuestions('croissant');
            $baseLevel80->setQuestionsATrous(true);
            $baseLevel80->setJeu($test1);
            $manager->persist($baseLevel80);
            $user2->addNiveau($baseLevel80);
            //
            $baseLevel81 = new Niveau();
            $baseLevel81->setNumero(81);
            $baseLevel81->setEcartEntreLesReponses(10);
            $baseLevel81->setNombreDeReponses(0);
            $baseLevel81->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel81->setReponsesSimilaires(false);
            $baseLevel81->setTempsDisponible(10);
            $baseLevel81->setOrdreDesQuestions('croissant');
            $baseLevel81->setQuestionsATrous(true);
            $baseLevel81->setJeu($test1);
            $manager->persist($baseLevel81);
            $user2->addNiveau($baseLevel81);
            //
            $baseLevel82 = new Niveau();
            $baseLevel82->setNumero(82);
            $baseLevel82->setEcartEntreLesReponses(10);
            $baseLevel82->setNombreDeReponses(0);
            $baseLevel82->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel82->setReponsesSimilaires(false);
            $baseLevel82->setTempsDisponible(10);
            $baseLevel82->setOrdreDesQuestions('croissant');
            $baseLevel82->setQuestionsATrous(true);
            $baseLevel82->setJeu($test1);
            $manager->persist($baseLevel82);
            $user2->addNiveau($baseLevel82);
            //
            $baseLevel83 = new Niveau();
            $baseLevel83->setNumero(83);
            $baseLevel83->setEcartEntreLesReponses(10);
            $baseLevel83->setNombreDeReponses(0);
            $baseLevel83->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel83->setReponsesSimilaires(false);
            $baseLevel83->setTempsDisponible(10);
            $baseLevel83->setOrdreDesQuestions('croissant');
            $baseLevel83->setQuestionsATrous(true);
            $baseLevel83->setJeu($test1);
            $manager->persist($baseLevel83);
            $user2->addNiveau($baseLevel83);
            //
            $baseLevel84 = new Niveau();
            $baseLevel84->setNumero(84);
            $baseLevel84->setEcartEntreLesReponses(10);
            $baseLevel84->setNombreDeReponses(0);
            $baseLevel84->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel84->setReponsesSimilaires(false);
            $baseLevel84->setTempsDisponible(10);
            $baseLevel84->setOrdreDesQuestions('croissant');
            $baseLevel84->setQuestionsATrous(true);
            $baseLevel84->setJeu($test1);
            $manager->persist($baseLevel84);
            $user2->addNiveau($baseLevel84);
            //
            $baseLevel85 = new Niveau();
            $baseLevel85->setNumero(85);
            $baseLevel85->setEcartEntreLesReponses(10);
            $baseLevel85->setNombreDeReponses(3);
            $baseLevel85->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel85->setReponsesSimilaires(false);
            $baseLevel85->setTempsDisponible(null);
            $baseLevel85->setOrdreDesQuestions('croissant');
            $baseLevel85->setQuestionsATrous(false);
            $baseLevel85->setJeu($test1);
            $manager->persist($baseLevel85);
            $user2->addNiveau($baseLevel85);
            //
            $baseLevel86 = new Niveau();
            $baseLevel86->setNumero(86);
            $baseLevel86->setEcartEntreLesReponses(10);
            $baseLevel86->setNombreDeReponses(3);
            $baseLevel86->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel86->setReponsesSimilaires(false);
            $baseLevel86->setTempsDisponible(null);
            $baseLevel86->setOrdreDesQuestions('decroissant');
            $baseLevel86->setQuestionsATrous(false);
            $baseLevel86->setJeu($test1);
            $manager->persist($baseLevel86);
            $user2->addNiveau($baseLevel86);
            //
            $baseLevel87 = new Niveau();
            $baseLevel87->setNumero(87);
            $baseLevel87->setEcartEntreLesReponses(7);
            $baseLevel87->setNombreDeReponses(3);
            $baseLevel87->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel87->setReponsesSimilaires(true);
            $baseLevel87->setTempsDisponible(null);
            $baseLevel87->setOrdreDesQuestions('aleatoire');
            $baseLevel87->setQuestionsATrous(false);
            $baseLevel87->setJeu($test1);
            $manager->persist($baseLevel87);
            $user2->addNiveau($baseLevel87);
            //
            $baseLevel88 = new Niveau();
            $baseLevel88->setNumero(88);
            $baseLevel88->setEcartEntreLesReponses(7);
            $baseLevel88->setNombreDeReponses(4);
            $baseLevel88->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel88->setReponsesSimilaires(false);
            $baseLevel88->setTempsDisponible(30);
            $baseLevel88->setOrdreDesQuestions('croissant');
            $baseLevel88->setQuestionsATrous(false);
            $baseLevel88->setJeu($test1);
            $manager->persist($baseLevel88);
            $user2->addNiveau($baseLevel88);
            //
            $baseLevel89 = new Niveau();
            $baseLevel89->setNumero(89);
            $baseLevel89->setEcartEntreLesReponses(5);
            $baseLevel89->setNombreDeReponses(4);
            $baseLevel89->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel89->setReponsesSimilaires(false);
            $baseLevel89->setTempsDisponible(20);
            $baseLevel89->setOrdreDesQuestions('decroissant');
            $baseLevel89->setQuestionsATrous(false);
            $baseLevel89->setJeu($test1);
            $manager->persist($baseLevel89);
            $user2->addNiveau($baseLevel89);
            //
            $baseLevel90 = new Niveau();
            $baseLevel90->setNumero(90);
            $baseLevel90->setEcartEntreLesReponses(5);
            $baseLevel90->setNombreDeReponses(4);
            $baseLevel90->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel90->setReponsesSimilaires(true);
            $baseLevel90->setTempsDisponible(10);
            $baseLevel90->setOrdreDesQuestions('aleatoire');
            $baseLevel90->setQuestionsATrous(false);
            $baseLevel90->setJeu($test1);
            $manager->persist($baseLevel90);
            $user2->addNiveau($baseLevel90);
            //
            $baseLevel91 = new Niveau();
            $baseLevel91->setNumero(91);
            $baseLevel91->setEcartEntreLesReponses(5);
            $baseLevel91->setNombreDeReponses(4);
            $baseLevel91->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel91->setReponsesSimilaires(true);
            $baseLevel91->setTempsDisponible(10);
            $baseLevel91->setOrdreDesQuestions('croissant');
            $baseLevel91->setQuestionsATrous(false);
            $baseLevel91->setJeu($test1);
            $manager->persist($baseLevel91);
            $user2->addNiveau($baseLevel91);
            //
            $baseLevel92 = new Niveau();
            $baseLevel92->setNumero(92);
            $baseLevel92->setEcartEntreLesReponses(10);
            $baseLevel92->setNombreDeReponses(0);
            $baseLevel92->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel92->setReponsesSimilaires(false);
            $baseLevel92->setTempsDisponible(20);
            $baseLevel92->setOrdreDesQuestions('croissant');
            $baseLevel92->setQuestionsATrous(true);
            $baseLevel92->setJeu($test1);
            $manager->persist($baseLevel92);
            $user2->addNiveau($baseLevel92);
            //
            $baseLevel93 = new Niveau();
            $baseLevel93->setNumero(93);
            $baseLevel93->setEcartEntreLesReponses(10);
            $baseLevel93->setNombreDeReponses(0);
            $baseLevel93->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel93->setReponsesSimilaires(false);
            $baseLevel93->setTempsDisponible(10);
            $baseLevel93->setOrdreDesQuestions('croissant');
            $baseLevel93->setQuestionsATrous(true);
            $baseLevel93->setJeu($test1);
            $manager->persist($baseLevel93);
            $user2->addNiveau($baseLevel93);
            //
            $baseLevel94 = new Niveau();
            $baseLevel94->setNumero(94);
            $baseLevel94->setEcartEntreLesReponses(10);
            $baseLevel94->setNombreDeReponses(0);
            $baseLevel94->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel94->setReponsesSimilaires(false);
            $baseLevel94->setTempsDisponible(10);
            $baseLevel94->setOrdreDesQuestions('croissant');
            $baseLevel94->setQuestionsATrous(true);
            $baseLevel94->setJeu($test1);
            $manager->persist($baseLevel94);
            $user2->addNiveau($baseLevel94);
            //
            $baseLevel95 = new Niveau();
            $baseLevel95->setNumero(95);
            $baseLevel95->setEcartEntreLesReponses(10);
            $baseLevel95->setNombreDeReponses(0);
            $baseLevel95->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel95->setReponsesSimilaires(false);
            $baseLevel95->setTempsDisponible(10);
            $baseLevel95->setOrdreDesQuestions('croissant');
            $baseLevel95->setQuestionsATrous(true);
            $baseLevel95->setJeu($test1);
            $manager->persist($baseLevel95);
            $user2->addNiveau($baseLevel95);
            //
            $baseLevel96 = new Niveau();
            $baseLevel96->setNumero(96);
            $baseLevel96->setEcartEntreLesReponses(10);
            $baseLevel96->setNombreDeReponses(0);
            $baseLevel96->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel96->setReponsesSimilaires(false);
            $baseLevel96->setTempsDisponible(10);
            $baseLevel96->setOrdreDesQuestions('croissant');
            $baseLevel96->setQuestionsATrous(true);
            $baseLevel96->setJeu($test1);
            $manager->persist($baseLevel96);
            $user2->addNiveau($baseLevel96);
            //
            $baseLevel97 = new Niveau();
            $baseLevel97->setNumero(97);
            $baseLevel97->setEcartEntreLesReponses(10);
            $baseLevel97->setNombreDeReponses(3);
            $baseLevel97->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel97->setReponsesSimilaires(false);
            $baseLevel97->setTempsDisponible(null);
            $baseLevel97->setOrdreDesQuestions('croissant');
            $baseLevel97->setQuestionsATrous(false);
            $baseLevel97->setJeu($test1);
            $manager->persist($baseLevel97);
            $user2->addNiveau($baseLevel97);
            //
            $baseLevel98 = new Niveau();
            $baseLevel98->setNumero(98);
            $baseLevel98->setEcartEntreLesReponses(10);
            $baseLevel98->setNombreDeReponses(3);
            $baseLevel98->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel98->setReponsesSimilaires(false);
            $baseLevel98->setTempsDisponible(null);
            $baseLevel98->setOrdreDesQuestions('decroissant');
            $baseLevel98->setQuestionsATrous(false);
            $baseLevel98->setJeu($test1);
            $manager->persist($baseLevel98);
            $user2->addNiveau($baseLevel98);
            //
            $baseLevel99 = new Niveau();
            $baseLevel99->setNumero(99);
            $baseLevel99->setEcartEntreLesReponses(7);
            $baseLevel99->setNombreDeReponses(3);
            $baseLevel99->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel99->setReponsesSimilaires(true);
            $baseLevel99->setTempsDisponible(null);
            $baseLevel99->setOrdreDesQuestions('aleatoire');
            $baseLevel99->setQuestionsATrous(false);
            $baseLevel99->setJeu($test1);
            $manager->persist($baseLevel99);
            $user2->addNiveau($baseLevel99);
            //
            $baseLevel100 = new Niveau();
            $baseLevel100->setNumero(100);
            $baseLevel100->setEcartEntreLesReponses(7);
            $baseLevel100->setNombreDeReponses(4);
            $baseLevel100->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel100->setReponsesSimilaires(false);
            $baseLevel100->setTempsDisponible(30);
            $baseLevel100->setOrdreDesQuestions('croissant');
            $baseLevel100->setQuestionsATrous(false);
            $baseLevel100->setJeu($test1);
            $manager->persist($baseLevel100);
            $user2->addNiveau($baseLevel100);
            //
            $baseLevel101 = new Niveau();
            $baseLevel101->setNumero(101);
            $baseLevel101->setEcartEntreLesReponses(5);
            $baseLevel101->setNombreDeReponses(4);
            $baseLevel101->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel101->setReponsesSimilaires(false);
            $baseLevel101->setTempsDisponible(20);
            $baseLevel101->setOrdreDesQuestions('decroissant');
            $baseLevel101->setQuestionsATrous(false);
            $baseLevel101->setJeu($test1);
            $manager->persist($baseLevel101);
            $user2->addNiveau($baseLevel101);
            //
            $baseLevel102 = new Niveau();
            $baseLevel102->setNumero(102);
            $baseLevel102->setEcartEntreLesReponses(5);
            $baseLevel102->setNombreDeReponses(4);
            $baseLevel102->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel102->setReponsesSimilaires(true);
            $baseLevel102->setTempsDisponible(10);
            $baseLevel102->setOrdreDesQuestions('aleatoire');
            $baseLevel102->setQuestionsATrous(false);
            $baseLevel102->setJeu($test1);
            $manager->persist($baseLevel102);
            $user2->addNiveau($baseLevel102);
            //
            $baseLevel103 = new Niveau();
            $baseLevel103->setNumero(103);
            $baseLevel103->setEcartEntreLesReponses(5);
            $baseLevel103->setNombreDeReponses(4);
            $baseLevel103->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel103->setReponsesSimilaires(true);
            $baseLevel103->setTempsDisponible(10);
            $baseLevel103->setOrdreDesQuestions('croissant');
            $baseLevel103->setQuestionsATrous(false);
            $baseLevel103->setJeu($test1);
            $manager->persist($baseLevel103);
            $user2->addNiveau($baseLevel103);
            //
            $baseLevel104 = new Niveau();
            $baseLevel104->setNumero(104);
            $baseLevel104->setEcartEntreLesReponses(10);
            $baseLevel104->setNombreDeReponses(0);
            $baseLevel104->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel104->setReponsesSimilaires(false);
            $baseLevel104->setTempsDisponible(20);
            $baseLevel104->setOrdreDesQuestions('croissant');
            $baseLevel104->setQuestionsATrous(true);
            $baseLevel104->setJeu($test1);
            $manager->persist($baseLevel104);
            $user2->addNiveau($baseLevel104);
            //
            $baseLevel105 = new Niveau();
            $baseLevel105->setNumero(105);
            $baseLevel105->setEcartEntreLesReponses(10);
            $baseLevel105->setNombreDeReponses(0);
            $baseLevel105->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel105->setReponsesSimilaires(false);
            $baseLevel105->setTempsDisponible(10);
            $baseLevel105->setOrdreDesQuestions('croissant');
            $baseLevel105->setQuestionsATrous(true);
            $baseLevel105->setJeu($test1);
            $manager->persist($baseLevel105);
            $user2->addNiveau($baseLevel105);
            //
            $baseLevel106 = new Niveau();
            $baseLevel106->setNumero(106);
            $baseLevel106->setEcartEntreLesReponses(10);
            $baseLevel106->setNombreDeReponses(0);
            $baseLevel106->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel106->setReponsesSimilaires(false);
            $baseLevel106->setTempsDisponible(10);
            $baseLevel106->setOrdreDesQuestions('croissant');
            $baseLevel106->setQuestionsATrous(true);
            $baseLevel106->setJeu($test1);
            $manager->persist($baseLevel106);
            $user2->addNiveau($baseLevel106);
            //
            $baseLevel107 = new Niveau();
            $baseLevel107->setNumero(107);
            $baseLevel107->setEcartEntreLesReponses(10);
            $baseLevel107->setNombreDeReponses(0);
            $baseLevel107->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel107->setReponsesSimilaires(false);
            $baseLevel107->setTempsDisponible(10);
            $baseLevel107->setOrdreDesQuestions('croissant');
            $baseLevel107->setQuestionsATrous(true);
            $baseLevel107->setJeu($test1);
            $manager->persist($baseLevel107);
            $user2->addNiveau($baseLevel107);
            //
            $baseLevel108 = new Niveau();
            $baseLevel108->setNumero(108);
            $baseLevel108->setEcartEntreLesReponses(10);
            $baseLevel108->setNombreDeReponses(0);
            $baseLevel108->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel108->setReponsesSimilaires(false);
            $baseLevel108->setTempsDisponible(10);
            $baseLevel108->setOrdreDesQuestions('croissant');
            $baseLevel108->setQuestionsATrous(true);
            $baseLevel108->setJeu($test1);
            $manager->persist($baseLevel108);
            $user2->addNiveau($baseLevel108);
            //
            $baseLevel109 = new Niveau();
            $baseLevel109->setNumero(109);
            $baseLevel109->setEcartEntreLesReponses(10);
            $baseLevel109->setNombreDeReponses(3);
            $baseLevel109->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel109->setReponsesSimilaires(false);
            $baseLevel109->setTempsDisponible(null);
            $baseLevel109->setOrdreDesQuestions('croissant');
            $baseLevel109->setQuestionsATrous(false);
            $baseLevel109->setJeu($test1);
            $manager->persist($baseLevel109);
            $user2->addNiveau($baseLevel109);
            //
            $baseLevel110 = new Niveau();
            $baseLevel110->setNumero(110);
            $baseLevel110->setEcartEntreLesReponses(10);
            $baseLevel110->setNombreDeReponses(3);
            $baseLevel110->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel110->setReponsesSimilaires(false);
            $baseLevel110->setTempsDisponible(null);
            $baseLevel110->setOrdreDesQuestions('decroissant');
            $baseLevel110->setQuestionsATrous(false);
            $baseLevel110->setJeu($test1);
            $manager->persist($baseLevel110);
            $user2->addNiveau($baseLevel110);
            //
            $baseLevel111 = new Niveau();
            $baseLevel111->setNumero(111);
            $baseLevel111->setEcartEntreLesReponses(7);
            $baseLevel111->setNombreDeReponses(3);
            $baseLevel111->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel111->setReponsesSimilaires(true);
            $baseLevel111->setTempsDisponible(null);
            $baseLevel111->setOrdreDesQuestions('aleatoire');
            $baseLevel111->setQuestionsATrous(false);
            $baseLevel111->setJeu($test1);
            $manager->persist($baseLevel111);
            $user2->addNiveau($baseLevel111);
            //
            $baseLevel112 = new Niveau();
            $baseLevel112->setNumero(112);
            $baseLevel112->setEcartEntreLesReponses(7);
            $baseLevel112->setNombreDeReponses(4);
            $baseLevel112->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel112->setReponsesSimilaires(false);
            $baseLevel112->setTempsDisponible(30);
            $baseLevel112->setOrdreDesQuestions('croissant');
            $baseLevel112->setQuestionsATrous(false);
            $baseLevel112->setJeu($test1);
            $manager->persist($baseLevel112);
            $user2->addNiveau($baseLevel112);
            //
            $baseLevel113 = new Niveau();
            $baseLevel113->setNumero(113);
            $baseLevel113->setEcartEntreLesReponses(5);
            $baseLevel113->setNombreDeReponses(4);
            $baseLevel113->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel113->setReponsesSimilaires(false);
            $baseLevel113->setTempsDisponible(20);
            $baseLevel113->setOrdreDesQuestions('decroissant');
            $baseLevel113->setQuestionsATrous(false);
            $baseLevel113->setJeu($test1);
            $manager->persist($baseLevel113);
            $user2->addNiveau($baseLevel113);
            //
            $baseLevel114 = new Niveau();
            $baseLevel114->setNumero(114);
            $baseLevel114->setEcartEntreLesReponses(5);
            $baseLevel114->setNombreDeReponses(4);
            $baseLevel114->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel114->setReponsesSimilaires(true);
            $baseLevel114->setTempsDisponible(10);
            $baseLevel114->setOrdreDesQuestions('aleatoire');
            $baseLevel114->setQuestionsATrous(false);
            $baseLevel114->setJeu($test1);
            $manager->persist($baseLevel114);
            $user2->addNiveau($baseLevel114);
            //
            $baseLevel115 = new Niveau();
            $baseLevel115->setNumero(115);
            $baseLevel115->setEcartEntreLesReponses(5);
            $baseLevel115->setNombreDeReponses(4);
            $baseLevel115->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel115->setReponsesSimilaires(true);
            $baseLevel115->setTempsDisponible(10);
            $baseLevel115->setOrdreDesQuestions('croissant');
            $baseLevel115->setQuestionsATrous(false);
            $baseLevel115->setJeu($test1);
            $manager->persist($baseLevel115);
            $user2->addNiveau($baseLevel115);
            //
            $baseLevel116 = new Niveau();
            $baseLevel116->setNumero(116);
            $baseLevel116->setEcartEntreLesReponses(10);
            $baseLevel116->setNombreDeReponses(0);
            $baseLevel116->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel116->setReponsesSimilaires(false);
            $baseLevel116->setTempsDisponible(20);
            $baseLevel116->setOrdreDesQuestions('croissant');
            $baseLevel116->setQuestionsATrous(true);
            $baseLevel116->setJeu($test1);
            $manager->persist($baseLevel116);
            $user2->addNiveau($baseLevel116);
            //
            $baseLevel117 = new Niveau();
            $baseLevel117->setNumero(117);
            $baseLevel117->setEcartEntreLesReponses(10);
            $baseLevel117->setNombreDeReponses(0);
            $baseLevel117->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel117->setReponsesSimilaires(false);
            $baseLevel117->setTempsDisponible(10);
            $baseLevel117->setOrdreDesQuestions('croissant');
            $baseLevel117->setQuestionsATrous(true);
            $baseLevel117->setJeu($test1);
            $manager->persist($baseLevel117);
            $user2->addNiveau($baseLevel117);
            //
            $baseLevel118 = new Niveau();
            $baseLevel118->setNumero(118);
            $baseLevel118->setEcartEntreLesReponses(10);
            $baseLevel118->setNombreDeReponses(0);
            $baseLevel118->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel118->setReponsesSimilaires(false);
            $baseLevel118->setTempsDisponible(10);
            $baseLevel118->setOrdreDesQuestions('croissant');
            $baseLevel118->setQuestionsATrous(true);
            $baseLevel118->setJeu($test1);
            $manager->persist($baseLevel118);
            $user2->addNiveau($baseLevel118);
            //
            $baseLevel119 = new Niveau();
            $baseLevel119->setNumero(119);
            $baseLevel119->setEcartEntreLesReponses(10);
            $baseLevel119->setNombreDeReponses(0);
            $baseLevel119->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel119->setReponsesSimilaires(false);
            $baseLevel119->setTempsDisponible(10);
            $baseLevel119->setOrdreDesQuestions('croissant');
            $baseLevel119->setQuestionsATrous(true);
            $baseLevel119->setJeu($test1);
            $manager->persist($baseLevel119);
            $user2->addNiveau($baseLevel119);
            //
            $baseLevel120 = new Niveau();
            $baseLevel120->setNumero(120);
            $baseLevel120->setEcartEntreLesReponses(10);
            $baseLevel120->setNombreDeReponses(0);
            $baseLevel120->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel120->setReponsesSimilaires(false);
            $baseLevel120->setTempsDisponible(10);
            $baseLevel120->setOrdreDesQuestions('croissant');
            $baseLevel120->setQuestionsATrous(true);
            $baseLevel120->setJeu($test1);
            $manager->persist($baseLevel120);
            $user2->addNiveau($baseLevel120);
            //
            $baseLevel121 = new Niveau();
            $baseLevel121->setNumero(121);
            $baseLevel121->setEcartEntreLesReponses(10);
            $baseLevel121->setNombreDeReponses(3);
            $baseLevel121->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel121->setReponsesSimilaires(false);
            $baseLevel121->setTempsDisponible(null);
            $baseLevel121->setOrdreDesQuestions('croissant');
            $baseLevel121->setQuestionsATrous(false);
            $baseLevel121->setJeu($test1);
            $manager->persist($baseLevel121);
            $user2->addNiveau($baseLevel121);
            //
            $baseLevel122 = new Niveau();
            $baseLevel122->setNumero(122);
            $baseLevel122->setEcartEntreLesReponses(10);
            $baseLevel122->setNombreDeReponses(3);
            $baseLevel122->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel122->setReponsesSimilaires(false);
            $baseLevel122->setTempsDisponible(null);
            $baseLevel122->setOrdreDesQuestions('decroissant');
            $baseLevel122->setQuestionsATrous(false);
            $baseLevel122->setJeu($test1);
            $manager->persist($baseLevel122);
            $user2->addNiveau($baseLevel122);
            //
            $baseLevel123 = new Niveau();
            $baseLevel123->setNumero(123);
            $baseLevel123->setEcartEntreLesReponses(7);
            $baseLevel123->setNombreDeReponses(3);
            $baseLevel123->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel123->setReponsesSimilaires(true);
            $baseLevel123->setTempsDisponible(null);
            $baseLevel123->setOrdreDesQuestions('aleatoire');
            $baseLevel123->setQuestionsATrous(false);
            $baseLevel123->setJeu($test1);
            $manager->persist($baseLevel123);
            $user2->addNiveau($baseLevel123);
            //
            $baseLevel124 = new Niveau();
            $baseLevel124->setNumero(124);
            $baseLevel124->setEcartEntreLesReponses(7);
            $baseLevel124->setNombreDeReponses(4);
            $baseLevel124->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel124->setReponsesSimilaires(false);
            $baseLevel124->setTempsDisponible(30);
            $baseLevel124->setOrdreDesQuestions('croissant');
            $baseLevel124->setQuestionsATrous(false);
            $baseLevel124->setJeu($test1);
            $manager->persist($baseLevel124);
            $user2->addNiveau($baseLevel124);
            //
            $baseLevel125 = new Niveau();
            $baseLevel125->setNumero(125);
            $baseLevel125->setEcartEntreLesReponses(5);
            $baseLevel125->setNombreDeReponses(4);
            $baseLevel125->setNbReponsesProposeesDeLaMemeTable(1);
            $baseLevel125->setReponsesSimilaires(false);
            $baseLevel125->setTempsDisponible(20);
            $baseLevel125->setOrdreDesQuestions('decroissant');
            $baseLevel125->setQuestionsATrous(false);
            $baseLevel125->setJeu($test1);
            $manager->persist($baseLevel125);
            $user2->addNiveau($baseLevel125);
            //
            $baseLevel126 = new Niveau();
            $baseLevel126->setNumero(126);
            $baseLevel126->setEcartEntreLesReponses(5);
            $baseLevel126->setNombreDeReponses(4);
            $baseLevel126->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel126->setReponsesSimilaires(true);
            $baseLevel126->setTempsDisponible(10);
            $baseLevel126->setOrdreDesQuestions('aleatoire');
            $baseLevel126->setQuestionsATrous(false);
            $baseLevel126->setJeu($test1);
            $manager->persist($baseLevel126);
            $user2->addNiveau($baseLevel126);
            //
            $baseLevel127 = new Niveau();
            $baseLevel127->setNumero(127);
            $baseLevel127->setEcartEntreLesReponses(5);
            $baseLevel127->setNombreDeReponses(4);
            $baseLevel127->setNbReponsesProposeesDeLaMemeTable(2);
            $baseLevel127->setReponsesSimilaires(true);
            $baseLevel127->setTempsDisponible(10);
            $baseLevel127->setOrdreDesQuestions('croissant');
            $baseLevel127->setQuestionsATrous(false);
            $baseLevel127->setJeu($test1);
            $manager->persist($baseLevel127);
            $user2->addNiveau($baseLevel127);
            //
            $baseLevel128 = new Niveau();
            $baseLevel128->setNumero(128);
            $baseLevel128->setEcartEntreLesReponses(10);
            $baseLevel128->setNombreDeReponses(0);
            $baseLevel128->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel128->setReponsesSimilaires(false);
            $baseLevel128->setTempsDisponible(20);
            $baseLevel128->setOrdreDesQuestions('croissant');
            $baseLevel128->setQuestionsATrous(true);
            $baseLevel128->setJeu($test1);
            $manager->persist($baseLevel128);
            $user2->addNiveau($baseLevel128);
            //
            $baseLevel129 = new Niveau();
            $baseLevel129->setNumero(129);
            $baseLevel129->setEcartEntreLesReponses(10);
            $baseLevel129->setNombreDeReponses(0);
            $baseLevel129->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel129->setReponsesSimilaires(false);
            $baseLevel129->setTempsDisponible(10);
            $baseLevel129->setOrdreDesQuestions('croissant');
            $baseLevel129->setQuestionsATrous(true);
            $baseLevel129->setJeu($test1);
            $manager->persist($baseLevel129);
            $user2->addNiveau($baseLevel129);
            //
            $baseLevel130 = new Niveau();
            $baseLevel130->setNumero(130);
            $baseLevel130->setEcartEntreLesReponses(10);
            $baseLevel130->setNombreDeReponses(0);
            $baseLevel130->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel130->setReponsesSimilaires(false);
            $baseLevel130->setTempsDisponible(10);
            $baseLevel130->setOrdreDesQuestions('croissant');
            $baseLevel130->setQuestionsATrous(true);
            $baseLevel130->setJeu($test1);
            $manager->persist($baseLevel130);
            $user2->addNiveau($baseLevel130);
            //
            $baseLevel131 = new Niveau();
            $baseLevel131->setNumero(131);
            $baseLevel131->setEcartEntreLesReponses(10);
            $baseLevel131->setNombreDeReponses(0);
            $baseLevel131->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel131->setReponsesSimilaires(false);
            $baseLevel131->setTempsDisponible(10);
            $baseLevel131->setOrdreDesQuestions('croissant');
            $baseLevel131->setQuestionsATrous(true);
            $baseLevel131->setJeu($test1);
            $manager->persist($baseLevel131);
            $user2->addNiveau($baseLevel131);
            //
            $baseLevel132 = new Niveau();
            $baseLevel132->setNumero(132);
            $baseLevel132->setEcartEntreLesReponses(10);
            $baseLevel132->setNombreDeReponses(0);
            $baseLevel132->setNbReponsesProposeesDeLaMemeTable(0);
            $baseLevel132->setReponsesSimilaires(false);
            $baseLevel132->setTempsDisponible(10);
            $baseLevel132->setOrdreDesQuestions('croissant');
            $baseLevel132->setQuestionsATrous(true);
            $baseLevel132->setJeu($test1);
            $manager->persist($baseLevel132);
            $user2->addNiveau($baseLevel132);
            //
            
            
        /*
        //games init
            $games[0]->setCheminAcces('altic/cave.html.twig');
            $games[1]->setCheminAcces('altic/moutain.html.twig');
            $games[2]->setCheminAcces('altic/doors.html.twig');
            $games[3]->setCheminAcces('altic/fishing.html.twig');
        */ /*for ($i=0; $i < 4; $i++) { 
            $manager->persist($games[$i]);
        }*
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
            /*$baseLevel1->addTableDeMultiplication($table1);
            $baseLevel2->addTableDeMultiplication($table1);
            $baseLevel3->addTableDeMultiplication($table1);
            $baseLevel4->addTableDeMultiplication($table1);
            $baseLevel5->addTableDeMultiplication($table1);*/
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
