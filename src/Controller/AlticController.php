<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Utilisateur;
use App\Entity\Niveau;
use App\Entity\Question;
use App\Entity\ReponsePropose;
use App\Entity\PersonnageJouable;
use App\Entity\Entrainement;
use App\Entity\Jeu;
use App\Form\modifyFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModifyAccountType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\AddTeacherType;
use \Datetime as DateTime;


class AlticController extends AbstractController
{

    /**
     * @Route("/teacher", name="altic_teacherWelcome")
     */
    public function teacherWelcome()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $teacherFullName = $user->getNom() . " " . $user->getPrenom();
        $pupils = $user->getElevesLie();
        $pupilStats = array();
        $i = 0;
        foreach ($pupils as $enf) {
            $pupilStats[$i] = array();
            $levelArray = $enf->getNiveaux();
            $pupilStats[$i][0] = $enf->getNom() . " " . $enf->getPrenom();
            for($j=1;$j<12;$j++){
                $pupilStats[$i][$j]=0;
            }
            foreach ($levelArray as $level) {
                if ($level->getNumero() % 12 == 0) {
                    $pupilStats[$i][$level->getNumero() / 12] = 100;
                } else {
                    $pupilStats[$i][(int) ($level->getNumero() / 12) + 1] = (int) (100 * ($level->getNumero() - 12 * (int) ($level->getNumero() / 12)) / 12);
                }
                
            }
            array_push($pupilStats[$i], $enf->getId());
            $i++;
        }
        return $this->render('altic/teacherWelcome.html.twig',
            [
            'pupils' => $pupilStats,
            'userName' => $teacherFullName,
            'profilePic' => 'default',
            'pupilStats' => $pupilStats
            ]);
    }

    /**
     * @Route("/teacher/remove/{id}", name="altic_teacherRemovePupil")
     */
    public function removePupil($id)
    {
        $user = $this->getUser();
        $repositoryUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class);
        $pupil = $repositoryUtilisateur->find($id);
        $user->removeElevesLie($pupil);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("altic_teacherWelcome");
    }

    /**
     * @Route("/teacher/{id}", name="altic_teacherPupilData")
     */
    public function teacherPupilData($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $teacherFullName = $user->getNom()." ".$user->getPrenom();
        $pupils = $user->getElevesLie();
        $time = 0;
        foreach ($pupils as $enf) {
            if($id==$enf->getId()){
                $trainArray = $enf->getEntrainement();
                $levelArray = $enf->getNiveaux();
                $pupilStats[0][0] = $enf->getNom() . " " . $enf->getPrenom();
                //Number of plays
                $pupilStats[0][1] = (int)(sizeof($enf->getEntrainement()));
                //Total progression
                $pupilStats[0][2] = (int)((sizeof($levelArray)*100)/132);
                foreach ($trainArray as $training){
                    $time += $training->getDuree();
                }
                $hours = (int)($time/3600);
                $time = $time - ($hours*3600);
                $mints = (int)($time/60);
                $time = $time - ($mints*60);
                $secs = $time;
                $time = $time - $secs;
                $pupilStats[0][3]=$hours;
                $pupilStats[0][4]=$mints;
                $pupilStats[0][5]=$secs;
                for($j=1;$j<12;$j++){
                    $pupilStats[$j][0]=0;
                    $pupilStats[$j][1]=0;
                }
                foreach ($levelArray as $level){
                    //SI le niveau à son numéro modulo 12 étant égal à 0 ET que sa division par 12 n'est pas 0
                    if($level->getNumero()%12==0){
                        //ALORS ce niveau est le dernier niveau d'une table et ladite table est completée à 100%
                        $pupilStats[$level->getNumero()/12][0] = 100;
                    }else{
                    //Sinon on calcule petit à petit le pourcentage de completion de la table
                        $pupilStats[(int)($level->getNumero()/12)+1][0] = (int)(100*($level->getNumero()-12*(int)($level->getNumero()/12))/12);
                    }
                }
                foreach ($trainArray as $train){
                    $levTrain=$train->getNiveaux();
                    $pupilStats[(int)($levTrain[0]->getNumero()/12)+1][1]+=1;
                }
            }
        }
    	return $this->render('altic/teacherPupilData.html.twig',
    						 [
                             'userName'=>$teacherFullName,
                             'pupilId'=>$id,
                             'profilePic'=>'default',
                             'pupilStats'=>$pupilStats
                             ]);
    }

    /**
     * @Route("/teacher/{id}/{number}", name="altic_teacherPupilDataTable")
     */
    public function teacherPupilDataTable($id, $number)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$pupilsList = ' ';
        $teacherFullName = $user->getNom()." ".$user->getPrenom();
        $pupils = $user->getElevesLie();
        $pupilData[0][0]=0;
        $progress =0;
        //Prendre tous les tuples élève
        foreach ($pupils as $enf) {
            //Si l'enfant est l'enfant correspondant à l'id reçue
            if($id==$enf->getId()){
                //Récupérer les niveaux liés à l'élève
                $levelArray = $enf->getNiveaux();
                //Pour chaque niveau, je dois récupérer les entraînements faits dessus
                foreach($levelArray as $level){
                    //Récupérer la table de multiplication liée au niveau
                    $table = $level->getTableDeMultiplication();
                    //Si le numéro de la table est le même que celui récupéré
                    if($number==$tableNbr[0]->getNumero()){
                        //J'incrémente progress ????
                        $progress+=1;
                        //Je récupére les entraînements liés au niveau
                        $trainLev = $level->getEntrainement();
                        //Je mets le nombre d'entraînements faits sur ce niveau et je l'additionne avec les autres
                        $pupilData[0][0]+= (int)(sizeof($trainLev));
                        //A l'indice de premiere dimension n en fonction de la table, au second indice 0 on met le tableau d'entraînement lié au niveau
                        $pupilData[$level->getNumero()-12*(int)($level->getNumero()/12)][0]=$level->getEntrainement();
                        //Condition est i<Taille du tableau d'entraînements
                        for ($i=0; $i<(sizeof($pupilData[$level->getNumero()-12*(int)($level->getNumero()/12)][0])) ; $i++) {
                            //Dans $trainArrayOnTable, on met chaque entraînement fait sur ce niveau
                            array_push($trainArrayOnTable, $pupilData[$level->getNumero()-12*(int)($level->getNumero()/12)][0][$i]);
                        }
                        //Pour chaque entraînement
                        foreach($trainArrayOnTable as $trainin){
                            //On récupère les questions de l'entraînement
                            array_push($arrayQuestions, $trainin->getQuestion());
                            array_push($arrayDates, $trainin->getDate());
                        }
                        foreach($arrayQuestions as $quo){
                            array_push($arrayQuLib, $quo->getLibelle());
                            array_push($arrayQuRep, $quo->getReponseEnfant());
                            array_push($arrayQuProp, $quo->getReponsepropose());
                        }
                        foreach($arrayQuProp as $RepProp){
                            array_push($arrayAnswers, $repProp->getReponse());
                        }
                        $percentProgress = (int)(($progress/12)*100);

                    }
                }
                
                
             
            }
        }
    	return $this->render('altic/teacherPupilDataTable.html.twig',
    						 ['pupilId'=>$id, 'tableNumber'=>$number, 'userName'=>$teacherFullName, 'profilePic'=>'default']);
    }

    #########################################################

    private function generateQuestions($table, $level)
    {
        /*
        INITIALISATION
        */
        //generate questions
        $value=0;
        //calculate begining and end
        switch ($level->getOrdreDesQuestions()) {
            case 'croissant':
                $begining=1;
                $ending=11;
                $inc=1;
                break;
            case 'decroissant':
                $begining=10;
                $ending=0;
                $inc=-1;
                break;
            default:
                $ending=0;
                $begining=0;
                $inc=-2;
                break;
        }
         //generate questions
        if ($inc==-2) {
            //random question
            do {
                $value=rand(1,10);
                if (! isset($questions[$value])) {
                    $questions[$value] = new Question();
                    $questions[$value]->setLibelle("$table x $value");
                    $begining += 1;
                }
            } while ($begining<10);
        }else {
            //ordered question
            for ($i=$begining; $i!=$ending ; $i+=$inc) {
                $questions[$i] = new Question();
                $questions[$i]->setLibelle("$table x $i");
            }
        }

        return $questions;
    }

    private function generateAnswers($table, $questions, $level)
    {
        foreach ($questions as $key=> $value) {
            /*
            INITIALISATION
            */
            $answers = array();
            $ARightAnswer=false;
            $i=0;
            if( $level->getReponsesSimilaires()){
            $AReponseSim = false;
            $nbSupp = 2;
        }else {
            $nbSupp =1;
            $AReponseSim = true;
        }
            $nbOfSameAnswers=0; 
            $nbOfCurrentRandomAnswer=0;
            //calculate the number of random answers
            $nbOfRandomAnswers=($level->getNombreDeReponses())-($level->getNbReponsesProposeesDeLaMemeTable()+$nbSupp);

            /*
                generate answers
            */
            while ($i!=$level->getNombreDeReponses()) {
                $answerType=rand(0,3);
                switch ($answerType) {
                    case 0:
                    if( ! $ARightAnswer){
                        //generate the right answer
                        $answers[$table*$key]=new ReponsePropose();
                        $answers[$table*$key]->setReponse($table*$key);
                        $ARightAnswer=true;
                        $i+=1;
                    }
                    break;
                    case 1:
                        //generate an answer from the same table
                        if ($nbOfSameAnswers != $level->getNbReponsesProposeesDeLaMemeTable()) {
                            $aMultiplier=rand(0,10);
                            if( ! isset($answers[$table*$aMultiplier]) && ($aMultiplier != $key)){
                           $answers[$table*$aMultiplier]=new ReponsePropose();
                           $answers[$table*$aMultiplier]->setReponse($table*$aMultiplier);
                            $nbOfSameAnswers+=1;
                            $i+=1;
                            }
                        }
                        break;
                    case 2: 
                    if(! $AReponseSim){
                        $aInverser = $key*$table;
                        $arrayNumber=str_split($aInverser);
                        if(count($arrayNumber)>=2){
                        $inverse=$arrayNumber[1].$arrayNumber[0];
                        if(abs(($table*$key)-$inverse)<=20){
                            if( ! isset($answers[$inverse]) && ($inverse!= $aInverser)){
                                $answers[$inverse]=new ReponsePropose();
                                $answers[$inverse]->setReponse($inverse);
                            $i+=1;
                            $AReponseSim =true;
                    }else{
                        $nbOfRandomAnswers+=1;
                        $AReponseSim =true;
                    }
                    }else{
                        $nbOfRandomAnswers+=1;
                        $AReponseSim =true;
                    }
                        }else{
                        $nbOfRandomAnswers+=1;
                        $AReponseSim =true;
                        }
                }
                        break;
                    case 3:
                        //generate everything else
                        if ($nbOfCurrentRandomAnswer != $nbOfRandomAnswers) {
                            $valeur=rand(1,$level->getEcartEntreLesReponses());
                            $estAddition =rand(0,1);
                                if(( ! isset($answers[$table*$key+$valeur]))||( ! isset($answers[$table*$key-$valeur]))){
                                    if ($estAddition==1) {
                                        $answers[$table*$key+$valeur]=new ReponsePropose();
                                        $answers[$table*$key+$valeur]->setReponse($table*$key+$valeur);
                                        $nbOfCurrentRandomAnswer+=1;
                                        $i+=1;
                                    } else {
                                        if($table*$key-$valeur>=0){
                                        $answers[$table*$key-$valeur]= new ReponsePropose();
                                        $answers[$table*$key-$valeur]->setReponse($table*$key-$valeur);
                                        $nbOfCurrentRandomAnswer+=1;
                                        $i+=1;
                                    }
                                    }
                                }
                        }
                        break;
                    }
            }
            foreach ($answers as $answer) {
                $value->addReponsepropose($answer);
            }
        }

        return $questions;
    }

    private function getTableNameFromNumber($number)
    {
        $names = [2=>'Imoc', 5=>'Isia', 10=>'Vorod', 1=>'Elemia', 4=>'Rania', 3=>'Pona', 0=>'Nesa', 6=>'Sovia', 8=>'Caguma', 9=>'Belam', 7=>'Will'];

        return $names[$number];
    }

    private function generateAdvice($minimalMastery, $totalMastery)
    {
        $isMastered = true;
        $isTotallyMastered = true;
        $advice1 = '';
        $advice2 = '';
        $levels = array(
            0 => 2,
            1 => 5,
            2 => 10,
            3 => 1,
            4 => 4,
            5 => 3,
            6 => 0,
            7 => 6,
            8 => 8,
            9 => 9,
            10 => 7
        );
        $maxColumn = 0;

                //find level on which to provide advice
            //check if a time table is not mastered
                //init
        $analysedColumn = 0;
                //find
        while ($analysedColumn != 11) {
            
            if ($minimalMastery[$analysedColumn] == false) {
                $advice1 = $this->getTableNameFromNumber($levels[$analysedColumn]);
                $isMastered = false;
                $isTotallyMastered = false;
                $maxColumn = $analysedColumn;
                break;
            }

            $analysedColumn++;

        }
            //check if a timetable is not totally mastered
        if ($maxColumn != 0) {
                //init
            $analysedColumn = 0;
                //find
            while ($analysedColumn != $maxColumn) {

                if (!$totalMastery[$analysedColumn]) {

                    ($advice2 != '')? $advice2 .= ', ' : $isTotallyMastered = false;
                    $advice2 = $this->getTableNameFromNumber($advice2.$levels[$analysedColumn]);

                }

                $analysedColumn++;

            }
        }//END IF

        return ['advice1' => $advice1, 'advice2' => $advice2];
    }

    private function simplifyQuestionsAnswers($questions,$table,$level){
        $questionsAnswerArray = array();
        foreach ($questions as $key => $question) {
            $questionAnswerArray=array($question->getLibelle().'t'.$level->getTempsDisponible());
            if(!$level->getQuestionsATrous()){
            foreach ($question->getReponsepropose() as $cle => $value) {
                if($key*$table == $value->getReponse()){
                    array_push($questionAnswerArray,$value->getReponse()."good");
                }else{
                    array_push($questionAnswerArray,$value->getReponse()."bad");
                }
            }
        }else{
            array_push($questionAnswerArray,$key*$table);
        }

            array_push($questionsAnswerArray,$questionAnswerArray);
        }

        return $questionsAnswerArray;
    }

    private function getLevelMaps()
    {
        $map0 = array('crack.png', 'rockland.png', 'fantasy.png', 'desertMountain.png', 'fantasy.png', 'crack.png', 'fantasy2.png', 'crack.png', 'fantasy.png', 'fantasy.png', 'fantasy2.png', 'highMountain.png');
        $map1 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map2 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map3 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map4 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map5 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map6 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map7 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map8 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map9 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');
        $map10 = array('castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png');     
        $maps = array($map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0);

        return $maps;
    }

    private function getRegionFromTable($number)
    {
        $regions = [0 => 'Nesa', 1 => 'Elemia', 2 => 'Imoc', 3 => 'Pona', 4 => 'Rania', 5 => 'Isia', 6 => 'Sovia', 7 => 'Will', 8 => 'Caguma', 9 => 'Belam', 10 => 'Vorod'];

        return $regions[$number];
    }

    /**
     * @Route("/pupil", name="altic_pupil")
     */
    public function pupilWelcome(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($user->getEstEnseignant()) {
           return $this->redirect(
               $this->generateUrl('altic_teacherWelcome')
           );
        } else {
            $pupilFullName = $user->getNom()." ".$user->getPrenom();

            $trophyArray=array_fill(0, 11, false);
            //initialise mastery levels to non mastered
            $minimalMastery = array();
            $totalMastery = array();
            $minimalMasteryLevel = 9;
            $totalMasteryLevel = 12;
            $tableOrderIndexFromLevel = 0;

            for ($i=0; $i < 11; $i++) { 
                $minimalMastery[$i] = false;
                $totalMastery[$i] = false;
            }

            //get all mastered levels and asign them properly to mastery levels
            $masteredLevels = $user->getNiveaux();

            foreach ($masteredLevels as $level) {

                $tmpLevelNb = $level->getNumero();
                $tableOrderIndexFromLevel = 0;

                while ($tmpLevelNb > 0) {

                    if ($tmpLevelNb == $minimalMasteryLevel) {
                        $minimalMastery[$tableOrderIndexFromLevel] = true;
                        break;
                    }
                    else if ($tmpLevelNb == $totalMasteryLevel) {
                        $minimalMastery[$tableOrderIndexFromLevel] = true; 
                        $totalMastery[$tableOrderIndexFromLevel] = true;
                        break;
                    }

                    $tmpLevelNb -= $totalMasteryLevel;
                    $tableOrderIndexFromLevel++;
                }
            }
            $advice = $this->generateAdvice($minimalMastery, $totalMastery);
            $advice1 = 'Je te conseille d\'aller délivrer le prisonnier sur ' . $advice['advice1'];
            $advice2 = ($advice['advice2'] != '')? 'Tu peux continuer d\'essayer de délivrer les prisonniers de ' . $advice['advice2'] : '';
            //Récupération des données en base
            $levelArray = $user-> getNiveaux();
            $trainArray = $user->getEntrainement();
            //initialisation du tableau permettant de contenir les pourcentages de complétion des niveaux
            $percentArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $percentArray[12]=sizeof($trainArray);
            $time = 0;
            foreach ($trainArray as $training){
                $time += $training->getDuree();
            }
            $hours = (int)($time/3600);
            $time = $time - ($hours*3600);
            $mints = (int)($time/60);
            $time = $time - ($mints*60);
            $secs = $time;
            $time = $time - $secs;
            $percentArray[13]=$hours;
            $percentArray[14]=$mints;
            $percentArray[15]=$secs;
            /*La première case (% complet) regarde la taille du tableau récupéré et la divise par 132 afin d'obtenir le nombre
            de niveaux completés sur le nombre total
            Les deux dernières cases du tableau correspondent au nombre d'entraînements et au temps total passé*/
            $percentArray[0]=(int)((sizeof($levelArray)*100)/132);
            //Pour tout niveau considéré comme $level
            foreach ($levelArray as $level){
                //SI le niveau à son numéro modulo 12 étant égal à 0 ET que sa division par 12 n'est pas 0
                if($level->getNumero()%12==0){
                    //ALORS ce niveau est le dernier niveau d'une table et ladite table est completée à 100%
                    $percentArray[$level->getNumero()/12] = 100;
                }else{
                //Sinon on calcule petit à petit le pourcentage de completion de la table
                    $percentArray[(int)($level->getNumero()/12)+1] = (int)(100*($level->getNumero()-12*(int)($level->getNumero()/12))/12);
                }
                /*(int)($level->getNumero()/12) est le numero de la table en fonction du niveau
                */
                
                for($i=1;$i<=11;$i++){
                    switch ($i) {
                        case 1:
                            $imageNumber = 2;
                        break;
                        case 2:
                            $imageNumber = 5;
                         break;
                        case 3:
                            $imageNumber = 10;
                        break;
                        case 4:
                            $imageNumber = 1;
                        break;
                        case 5:
                            $imageNumber = 4;
                        break;
                         case 6:
                            $imageNumber = 3;
                        break;
                        case 7:
                            $imageNumber = 0;
                        break;
                        case 8:
                            $imageNumber = 6;
                        break;
                        case 9  :
                            $imageNumber = 8;
                        break;
                        case 10:
                            $imageNumber = 9;
                        break;
                        case 11:
                            $imageNumber = 7;
                        break;
                    }
                if ($percentArray[$i]==100) {
                    $trophyArray["$imageNumber"]=true;
                }else {
                    $trophyArray["$imageNumber"]=false;
                }
            }
        }

            $addTeacher= $this->createForm(AddTeacherType::class);
            $lynxTeacher = NULL;
            $isAlreadyAdd = false;
            $addTeacher->handleRequest($request);
            $repositoryUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class);
            if($addTeacher->isSubmitted() && $addTeacher->isValid()){
                $mailTeacher = $addTeacher->get('email')->getData();
                $teacher = $repositoryUtilisateur->findOneTeacherByEmail($mailTeacher);
                $entityManager = $this->getDoctrine()->getManager();
                if(!empty($teacher)){
                    foreach ($user->getProfesseurLie() as $value) {
                        foreach ($teacher as $value2) {
                            if($value->getEmail() == $value2->getEmail()){
                                $isAlreadyAdd =true;
                            }
                        }
                    }
                    if($isAlreadyAdd){
                        $this->addFlash(
                            'warning',
                            'Tu as déjà ajouté cet enseignant'
                        );

                    }else{
                        $user->addProfesseurLie($teacher[0]);

                    }
                }else{
                    $this->addFlash(
                        'warning',
                        'Aucun professeur ne possède cet email'
                    );
                }
                $entityManager->persist($user);
                $entityManager->flush();
            }
            $lynxTeacher= $user->getProfesseurLie();
            return $this->render('altic/pupilWelcome.html.twig',
                                 [
                                'teacherLynx'=>$lynxTeacher,
                                 'addTeacher'=>$addTeacher->createView(),
                                 'hallOfTrophy'=>$trophyArray,
                                 'userName'=>$pupilFullName,
                                 'profilePic'=>$user->getAvatar(),
                                 'advice1'=>$advice1,
                                 'advice2'=>$advice2,
                                 'percentArray'=>$percentArray
                                ]);
        }
    }
    /**
     * @Route("/removeTeacher/{id}", name="altic_removeTeacher")
     */
    public function removeTeacher($id){
        $repositoryUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class);
        $teacher = $repositoryUtilisateur->find($id);
        $user =$this->getUser();
        $user->removeProfesseurLie($teacher);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("altic_pupil");
    }

    /**
     * @Route("/pupil/{tableNumber}/{levelNumber}/{mapName}", name= "altic_choiceAvatar")
     */
    public function choiceAvatar($tableNumber, $levelNumber, $mapName){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $pupilFullName = $user->getNom()." ".$user->getPrenom();
        $playableCharacters = $user->getPersonnagejouable();

        if (sizeof($playableCharacters) > 1) {
            
            return $this->render('altic/choiceAvatar.html.twig', [
                'tableNumber'=>$tableNumber,
                'levelNumber'=>$levelNumber,
                'mapName'=>$mapName,
                'playableCharacters'=>$playableCharacters,
                'userName'=>$pupilFullName,
                'profilePic'=>$user->getAvatar()
                ]);

        }
        else {

            return $this->redirect(
               $this->generateUrl('altic_pupilTraining', [
                    'tableNumber'=>$tableNumber,
                    'levelNumber'=>$levelNumber,
                    'mapName'=>$mapName,
                    'avatarImage'=>'celestin.png'
                ])
            );

        }
    }

    /**
     * @Route("/pupil/endgame", name="altic_endgame")
     */
    public function endgame(){

        //base variables
            $charactersToWinFromLevel = array(12=>'2.png', 24=>'5.png', 36=>'10.png', 48=>'1.png', 60=>'4.png', 72=>'3.png', 84=>'0.png', 96=>'6.png', 108=>'8.png', 130=>'7.png');
            $templateLevels = array_fill(0, 12, new Niveau());
            $games = array_fill(0, 4, new Jeu());
            foreach ($games as $game) {
                $game->setCheminAcces('test');
            }

            $templateLevels[0]->setNumero(-1);
            $templateLevels[0]->setEcartEntreLesReponses(10);
            $templateLevels[0]->setNombreDeReponses(3);
            $templateLevels[0]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[0]->setReponsesSimilaires(false);
            $templateLevels[0]->setTempsDisponible(null);
            $templateLevels[0]->setOrdreDesQuestions('croissant');
            $templateLevels[0]->setQuestionsATrous(false);
            //
            $templateLevels[1]->setNumero(-1);
            $templateLevels[1]->setEcartEntreLesReponses(10);
            $templateLevels[1]->setNombreDeReponses(3);
            $templateLevels[1]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[1]->setReponsesSimilaires(false);
            $templateLevels[1]->setTempsDisponible(null);
            $templateLevels[1]->setOrdreDesQuestions('decroissant');
            $templateLevels[1]->setQuestionsATrous(false);
            //
            $templateLevels[2]->setNumero(-1);
            $templateLevels[2]->setEcartEntreLesReponses(7);
            $templateLevels[2]->setNombreDeReponses(3);
            $templateLevels[2]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[2]->setReponsesSimilaires(true);
            $templateLevels[2]->setTempsDisponible(null);
            $templateLevels[2]->setOrdreDesQuestions('aleatoire');
            $templateLevels[2]->setQuestionsATrous(false);
            //
            $templateLevels[3]->setNumero(-1);
            $templateLevels[3]->setEcartEntreLesReponses(7);
            $templateLevels[3]->setNombreDeReponses(4);
            $templateLevels[3]->setNbReponsesProposeesDeLaMemeTable(1);
            $templateLevels[3]->setReponsesSimilaires(false);
            $templateLevels[3]->setTempsDisponible(30);
            $templateLevels[3]->setOrdreDesQuestions('croissant');
            $templateLevels[3]->setQuestionsATrous(false);
            //
            $templateLevels[4]->setNumero(-1);
            $templateLevels[4]->setEcartEntreLesReponses(5);
            $templateLevels[4]->setNombreDeReponses(4);
            $templateLevels[4]->setNbReponsesProposeesDeLaMemeTable(1);
            $templateLevels[4]->setReponsesSimilaires(false);
            $templateLevels[4]->setTempsDisponible(20);
            $templateLevels[4]->setOrdreDesQuestions('decroissant');
            $templateLevels[4]->setQuestionsATrous(false);
            //
            $templateLevels[5]->setNumero(-1);
            $templateLevels[5]->setEcartEntreLesReponses(5);
            $templateLevels[5]->setNombreDeReponses(4);
            $templateLevels[5]->setNbReponsesProposeesDeLaMemeTable(2);
            $templateLevels[5]->setReponsesSimilaires(true);
            $templateLevels[5]->setTempsDisponible(10);
            $templateLevels[5]->setOrdreDesQuestions('aleatoire');
            $templateLevels[5]->setQuestionsATrous(false);
            //
            $templateLevels[6]->setNumero(-1);
            $templateLevels[6]->setEcartEntreLesReponses(5);
            $templateLevels[6]->setNombreDeReponses(4);
            $templateLevels[6]->setNbReponsesProposeesDeLaMemeTable(2);
            $templateLevels[6]->setReponsesSimilaires(true);
            $templateLevels[6]->setTempsDisponible(10);
            $templateLevels[6]->setOrdreDesQuestions('croissant');
            $templateLevels[6]->setQuestionsATrous(false);
            //
            $templateLevels[7]->setNumero(-1);
            $templateLevels[7]->setEcartEntreLesReponses(10);
            $templateLevels[7]->setNombreDeReponses(0);
            $templateLevels[7]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[7]->setReponsesSimilaires(false);
            $templateLevels[7]->setTempsDisponible(20);
            $templateLevels[7]->setOrdreDesQuestions('croissant');
            $templateLevels[7]->setQuestionsATrous(true);
            //
            $templateLevels[8]->setNumero(-1);
            $templateLevels[8]->setEcartEntreLesReponses(10);
            $templateLevels[8]->setNombreDeReponses(0);
            $templateLevels[8]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[8]->setReponsesSimilaires(false);
            $templateLevels[8]->setTempsDisponible(10);
            $templateLevels[8]->setOrdreDesQuestions('croissant');
            $templateLevels[8]->setQuestionsATrous(true);
            //
            $templateLevels[9]->setNumero(-1);
            $templateLevels[9]->setEcartEntreLesReponses(10);
            $templateLevels[9]->setNombreDeReponses(0);
            $templateLevels[9]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[9]->setReponsesSimilaires(false);
            $templateLevels[9]->setTempsDisponible(10);
            $templateLevels[9]->setOrdreDesQuestions('croissant');
            $templateLevels[9]->setQuestionsATrous(true);
            //
            $templateLevels[10]->setNumero(-1);
            $templateLevels[10]->setEcartEntreLesReponses(10);
            $templateLevels[10]->setNombreDeReponses(0);
            $templateLevels[10]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[10]->setReponsesSimilaires(false);
            $templateLevels[10]->setTempsDisponible(10);
            $templateLevels[10]->setOrdreDesQuestions('croissant');
            $templateLevels[10]->setQuestionsATrous(true);
            //
            $templateLevels[11]->setNumero(-1);
            $templateLevels[11]->setEcartEntreLesReponses(10);
            $templateLevels[11]->setNombreDeReponses(0);
            $templateLevels[11]->setNbReponsesProposeesDeLaMemeTable(0);
            $templateLevels[11]->setReponsesSimilaires(false);
            $templateLevels[11]->setTempsDisponible(10);
            $templateLevels[11]->setOrdreDesQuestions('croissant');
            $templateLevels[11]->setQuestionsATrous(true);

        $questionsAnswers = $_POST['questionAnswers'];
        $givenAnswers = $_POST['givenAnswers'];
        $timeElapsedSeconds = $_POST['timeElapsedSeconds'];
        $globalLevelNumber = $_POST['globalLevel'];
        $localLevelNumber = $_POST['localLevel'];
        $table = $_POST['table'];
        $nbRightAnswers = $_POST['nbRightAnswers'];
        $avatarImage = $_POST['avatarImg'];
        $templateQuestionsAnswers = array();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $user->setAvatar(explode('.', $avatarImage)[0] . '.png');
        $pupilFullName = $user->getNom()." ".$user->getPrenom();
        $bCanPlayLevel = array_fill(0, 133, false);
        $masteredLevels = $user->getNiveaux();

        foreach ($masteredLevels as $playableLevel) {
            $bCanPlayLevel[$playableLevel->getNumero() - 1] = true;
        }

        $repositoryNiveau = $this->getDoctrine()->getRepository(Niveau::class);
        $entityManager = $this->getDoctrine()->getManager();

        //prepare data
        $questions = array();
        $suggestedAnswers = array();
        $level = $repositoryNiveau->findOneByNumero($globalLevelNumber);
       
        $trainingSession = new Entrainement();
        $trainingSession->setDuree($timeElapsedSeconds);
        $trainingSession->setDate(new DateTime());
        $trainingSession->setUtilisateur($user);

        for ($j = 0; $j < sizeof($questionsAnswers); $j++) {

            $row = $questionsAnswers[$j];
            $explodedQuestion = explode('t', $row[0])[0];
            $explodedQuestion = explode(' x ', $explodedQuestion);
            $currentExplodedQuestion = [$explodedQuestion[0], $explodedQuestion[1]];
            array_push($templateQuestionsAnswers, $currentExplodedQuestion);
            
            for ($i=0; $i < sizeof($row); $i++) {
                if ($i == 0) {
                    $currentQuestion = new Question();
                    $currentQuestion->setLibelle(str_replace('t', '', $row[$i]));
                    $currentQuestion->setReponseEnfant($givenAnswers[$j]);
                    array_push($questions, $currentQuestion);
                }
                else {
                    $suggestedAnswer = new ReponsePropose();
                    $suggestedAnswer->setReponse((int)preg_replace('/[a-z]*/', '', $row[$i]));
                    $questions[$j]->addReponsepropose($suggestedAnswer);
                    $entityManager->persist($suggestedAnswer);
                    $entityManager->persist($questions[$j]);
                }
            }

            $trainingSession->addQuestion($questions[$j]);

        }

        if ($level) {
            $trainingSession->addNiveau($level);
        }
        else {
            $entityManager->persist($games[0]);
            $templateLevel = $templateLevels[$localLevel-1];
            $level = new Niveau();
            $level->setNumero($globalLevelNumber);
            $level->setEcartEntreLesReponses($templateLevel->getEcartEntreLesReponses());
            $level->setNombreDeReponses($templateLevel->getNombreDeReponses());
            $level->setNbReponsesProposeesDeLaMemeTable($templateLevel->getNbReponsesProposeesDeLaMemeTable());
            $level->setReponsesSimilaires($templateLevel->getReponsesSimilaires());
            $level->setTempsDisponible($templateLevel->getTempsDisponible());
            $level->setOrdreDesQuestions($templateLevel->getOrdreDesQuestions());
            $level->setQuestionsATrous($templateLevel->getQuestionsATrous());
            $level->addTableDeMultiplication($table);
            $level->setJeu($games[0]);
            $entityManager->persist($level);
            $trainingSession->addNiveau($level);
        }


        if ($nbRightAnswers >= 8) {
            $user->addNiveau($level);
            foreach ($charactersToWinFromLevel as $index => $character) {
                if ($globalLevelNumber == $index) {
                    $wonCharacter = new PersonnageJouable();
                    $wonCharacter->setPersonnageDebloque(true);
                    $wonCharacter->setImage($character);
                    $entityManager->persist($wonCharacter);
                    $user->addPersonnageJouable($wonCharacter);
                }
            }
        }

        $entityManager->persist($user);
        $entityManager->persist($trainingSession);

        //send data
        $entityManager->flush();

        return $this->render('altic/endgame.html.twig', [
            'userName'=>$pupilFullName, 
            'profilePic'=>$user->getAvatar(),
            'gameData'=>$level,
            'nbRightAnswers'=>$nbRightAnswers,
            'avatarImg'=>$avatarImage,
            'globalLevel'=>$globalLevelNumber,
            'localLevel'=>$localLevelNumber,
            'tableNumber'=>$table,
            'maps'=>$this->getLevelMaps()[$table],
            'timeElapsed'=>$timeElapsedSeconds,
            'questions'=>$templateQuestionsAnswers,
            'givenAnswers'=>$givenAnswers,
            'regionName'=>$this->getRegionFromTable($table),
            'bCanPlay'=>$bCanPlayLevel
            ]);
    }

    /**
     * @Route("/pupil/{number}/{island}", name="altic_pupilTable")
     */
    public function pupilTable($number, $island)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //represents all the global levels numbers for the current table
        $levelsNumbers = array();
        //represents the first global level number for each table
        $minLevelFromTable = array(2=>1, 5=>13, 10=>25, 1=>37, 4=>49, 3=>61, 0=>73, 6=>85, 8=>97, 9=>109, 7=>121);

        $images = $this->getLevelMaps()[$number];

        //array telling if the level can be played, each element representing a level
        $bCanPlay = array_fill(0, 12, false);
        $alreadyMasteredLevels = array();
        //the range of levels in this context
        $range = array('min'=>$minLevelFromTable[$number], 'max'=>$minLevelFromTable[$number]+11);
        $masteredLevels = $user->getNiveaux();
        //init levelsNumbers
        for ($i=$range['min']; $i <= $range['max']; $i++) { 
            array_push($levelsNumbers, $i);
        }

        //get all mastered levels in range
        if (sizeof($masteredLevels) > 0) {
            foreach ($masteredLevels as $level) {
                    
                if ($level->getNumero() >= $range['min'] && $level->getNumero() <= $range['max']) {
                    array_push($alreadyMasteredLevels, $level);
                }

            }
        }
        //set bCanPlay accordingly
        if (sizeof($alreadyMasteredLevels) > 0 && sizeof($alreadyMasteredLevels) < 12) {
            for ($i=0; $i <= sizeof($alreadyMasteredLevels); $i++) { 
                $bCanPlay[$i] = true;
            }
        }
        else if(sizeof($alreadyMasteredLevels) == 0) {
            $bCanPlay[0] = true;
        }
        else {

            for ($i=0; $i < 12; $i++) { 
                $bCanPlay[$i] = true;
            }

        }

        $profilePic = 'images/pupil/characters/constantin.png';
    	$pupilFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/pupilTable.html.twig',
    						 [
                                'userName'=>$pupilFullName,
                                'tableNumber'=>$number,
                                'profilePic'=>$user->getAvatar(),
                                'images'=>$images,
                                'bCanPlay'=>$bCanPlay,
                                'levelsNumbers'=>$levelsNumbers,
                                'island'=>$island
                            ]);
    }

    /**
     * @Route("/pupil/{tableNumber}/{levelNumber}/{mapName}/{avatarImage}", name="altic_pupilTraining")
     */
    public function pupilTraining($tableNumber, $levelNumber, $mapName, $avatarImage)
    {
        $mapName .= '.png';
        $avatarImage .= (strpos($avatarImage, '.png') !== false)? '' : '.png';
        //array representing a game for a given map

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $repositoryNiveau = $this->getDoctrine()->getRepository(Niveau::class);
        $level = $repositoryNiveau->findBy(["numero" => $levelNumber])[0];
        $localLevel = ($levelNumber % 12 == 0)? 12 : $levelNumber % 12;

        $questionsAnswers = $this->generateAnswers($tableNumber, $this->generateQuestions($tableNumber, $level), $level);

        return $this->render("altic/game.html.twig",
            [
                'questionsAndAnswers'=>$this->simplifyQuestionsAnswers($questionsAnswers, $tableNumber, $level),
                'table'=>$tableNumber,
                'localLevel'=>$localLevel,
                'globalLevel'=>$levelNumber,
                'celestinImg'=>"images/pupil/characters/$avatarImage",
                'wizardImg'=>"images/pupil/characters/mago.png",
                'map'=>$mapName
            ]);
    }

    #########################################################
    /**
     * @Route("/pwdLost", name="altic_pwdLost")
     */
    public function pwdLost()
    {
        return $this->render('altic/pwdLost.html.twig', [
            'userName'=>'', 
            'profilePic'=>'default']);
    }

    /**
     * @Route("/modifyAccount", name="altic_modifyAccount")
     */
    public function modifyAccount(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $pupilFullName = $user->getNom()." ".$user->getPrenom();
        $form = $this->createForm(ModifyAccountType::class);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $modifyData= $form->getData();
            if($encoder->isPasswordValid($user,$modifyData['oldPassword'])){
                $user->setPassword( 
                    $encoder->encodePassword(
                        $user,
                        $modifyData['newPassword']
                    )
                 );
                 $entityManager= $this->getDoctrine()->getManager();
                 $entityManager->persist($user);
                 $entityManager->flush();
            }else{
                $this->addFlash(
                    'notice',
                    'mot de passe incorect!'
                );
            }
        }
        return $this->render('altic/modifyAccount.html.twig', ['userName'=>$pupilFullName, 
        'profilePic'=>$user->getAvatar(),'modifyForm'=>$form->createView()]);
    }
    
    /**
     * @Route("/deleteAccount", name="altic_deleteAccount")
     */
    public function deleteAccount(){
        
      $em = $this->getDoctrine()->getManager();
      $id = $this->getUser()->getId();

      $usrRepo = $em->getRepository(Utilisateur::class);
      $deluser = $usrRepo->find($id);
      $em->remove($deluser);
      $em->flush();
        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();
        return $this->redirectToRoute("index");
    }
}
