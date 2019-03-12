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
use App\Form\modifyFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModifyAccountType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\AddTeacherType;


class AlticController extends AbstractController
{

    /**
     * @Route("/teacher", name="altic_teacherWelcome")
     */
    public function teacherWelcome()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$teacherFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/teacherWelcome.html.twig',
    						 ['pupils'=>'', 'userName'=>$teacherFullName, 'profilePic'=>'default']);
    }

    /**
     * @Route("/teacher/{name}", name="altic_teacherPupilData")
     */
    public function teacherPupilData($name)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$teacherFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/teacherPupilData.html.twig',
    						 ['userName'=>$teacherFullName, 'pupilName'=>$name, 'profilePic'=>'default']);
    }

    /**
     * @Route("/teacher/{name}/{number}", name="altic_teacherPupilDataTable")
     */
    public function teacherPupilDataTable($name, $number)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$pupilsList = ' ';
    	$teacherFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/teacherPupilDataTable.html.twig',
    						 ['pupilName'=>$name, 'tableNumber'=>$number, 'userName'=>$teacherFullName, 'profilePic'=>'default']);
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
                $begining=0;
                $ending=11;
                $inc=1;
                break;
            case 'decroissant':
                $begining=10;
                $ending=-1;
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
                $value=rand(0,10);
                if (! isset($questions[$value])) {
                    $questions[$value] = new Question();
                    $questions[$value]->setLibelle("$table x $value");
                    $begining += 1;
                }
            } while ($begining<11);
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
        foreach ($questions as $key=> $value) {//pour chaque question
        /*
        INITIALISATION
        */
        unset($answers);//on dedefinis la variable answer
        $ARightAnswer=false;//deviens vrai si une reponse juste est implementer
        $i=0;//le compteur prend la valeur 0
        $nbOfSameAnswers=0; //le nombre de reponse d ela meme table deja implementer
        $nbOfCurrentRandomAnswer=0;//le nombre de reponse autre deja implementer
        //calculate the number of random answers
        $nbOfRandomAnswers=($level->getNombreDeReponses())-($level->getNbReponsesProposeesDeLaMemeTable())-1;

        /*
            generate answers
        */
        while ($i!=$level->getNombreDeReponses()) {//tant que toute les reponse n'ont pas ete implementer
            $answerType=rand(0,3);//on prend une valeur de 0 à 3
            switch ($answerType) {
                case 0://si answeer type est egale a 0
                if( ! $ARightAnswer){//si la bonne reponse n'a pas ete ajouté
                    //generate the right answer
                    $answers[$table*$key]=new ReponsePropose();//on creer une nouvelle reponse
                    $answers[$table*$key]->setReponse($table*$key);//la reponse prend la valeur du numero de la table * la cle (qui correspond au deuxieme facteur de la multiplication)
                    $ARightAnswer=true;//on passe la bonne reponse a vrai
                    $i+=1;//on ajoutes 1 au nombre de reponse ajouté
                }
                break;
                case 1:
                    //generate an answer from the same table
                    if ($nbOfSameAnswers <= $level->getNbReponsesProposeesDeLaMemeTable()) {//si toute les reponse de la meme table ne sont pas implementer
                        $aMultiplier=rand(0,10);//on prend une valeur a multiplier de 0 a 10
                        if( ! isset($answers[$table*$aMultiplier])){//si la reponse n'est pas encore implementer
                       $answers[$table*$aMultiplier]=new ReponsePropose();//on cree une nouvelle reponse
                       $answers[$table*$aMultiplier]->setReponse($table*$aMultiplier);//on creer une reponse qui va avoir comme valeur le numero de la table * la valeur a multiplier
                        $nbOfSameAnswers+=1;//on indique que le nombre de reponse de la meme table a augmenter
                        $i+=1;//on indique que le nombre de reponse implmenter a augmenter
                        }
                    }
                    break;
                case 2:
                    break;
                case 3:
                    //generate everything else
                    if ($nbOfCurrentRandomAnswer <= $nbOfRandomAnswers) {//si toute les autre reponse n'ont pas encore ete implmenter
                        $valeur=rand(0,$level->getEcartEntreLesReponses());//on prend une valeur aleatoire entre 0 et l'ecat voulue entre les reponse
                        $estAddition =rand(0,1);//on prend une valeur qui peut etre soit 0 soit 1 pour definir si on doit additionner ou soustraire
                        if(( ! isset($answers[$table*$key+$valeur]))||( ! isset($answers[$table*$key-$valeur])&&$answers[$table*$key-$valeur]>0)){//si la valeur n'est pas definis et que la soustraction n'est pasinferieur a 0
                            if ($estAddition==1) {//on additione
                                $answers[$table*$key+$valeur]=new ReponsePropose();//on creer un nouvelle reponse
                                $answers[$table*$key+$valeur]->setReponse($table*$key+$valeur);//la reponse est la bonne reponse + la valeur
                            } else {
                                $answers[$table*$key-$valeur]= new ReponsePropose();
                                $answers[$table*$key-$valeur]->setReponse($table*$key-$valeur);//la reponse est la bonne reponse - la valeur
                            }
                            $nbOfCurrentRandomAnswer+=1;//on augmente le nombre de reponse aleatoire
                            $i+=1;//on augmente le nombre de reponse implemnter en tout
                        }
                    }
                    break;
                }
            }
            $value->answers=$answers;//lie le tableau dobjet reponse a la question
        }

        return $questions;
    }

    private function generateAdvice($totalMastery, $minimalMastery)
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
                $advice1 = $levels[$analysedColumn];
                $isMastered = false;
                $isTotallyMastered = false;
                break;
            }

            $analysedColumn++;

        }

        $maxColumn = $analysedColumn;
            //check if a timetable is not totally mastered
        if ($maxColumn != 0) {
                //init
            $analysedColumn = 0;
                //find
            while ($analysedColumn != $maxColumn) {

                if ($totalMastery[$analysedColumn] == false) {

                    ($advice2 != '')? $advice2 += ', ' : $isTotallyMastered = false;
                    $advice2 += $levels[$analysedColumn];

                }

                $analysedColumn++;

            }
        }//END IF

        return ['advice1' => $advice1, 'advice2' => $advice2];
    }

    private function simplifyQuestionsAnswers($questions,$table){
        $questionsAnswerArray = array();
        foreach ($questions as $key => $question) {
            $questionAnswerArray=array($question->getLibelle());
            foreach ($question->getReponsepropose() as $cle => $value) {
                if($key*$table == $value->getReponse()){
                    array_push($questionAnswerArray,$value->getReponse()."good");
                }else{
                    array_push($questionAnswerArray,$value->getReponse()."bad");
                }
            }
            array_push($questionsAnswerArray,$questionAnswerArray);
        }

        return $questionsAnswerArray;
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
                        $totalMasteryLevel[$tableOrderIndexFromLevel] = true;
                        break;
                    }

                    $tmpLevelNb -= $totalMasteryLevel;
                    $tableOrderIndexFromLevel++;
                }
            }

            $advice = $this->generateAdvice($minimalMastery, $totalMastery);
            $advice1 = 'Je te conseille d\'aider ' . $advice['advice1'];
            $advice2 = ($advice['advice2'] != '')? 'Tu peux continuer d\aider' . $advice['advice2'] : '';

            $levelArray = $user-> getNiveaux();
            //initialisation du tableau permettant de contenir les pourcentages de complétion des niveaux
            $percentArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            /*La première case (% complet) regarde la taille du tableau récupéré et la divise par 132 afin d'obtenir le nombre
            de niveaux completés sur le nombre total
            Les deux dernières cases du tableau correspondent au nombre d'entraînements et au temps total passé*/
            $percentArray[0]=(int)(sizeof($levelArray)/132);
            //Pour tout niveau considéré comme $level
            foreach ($levelArray as $level){
                //SI le niveau à son numéro modulo 12 étant égal à 0 ET que sa division par 12 n'est pas 0
                if($level->getNumero()%12==0&&$level->getNumero()/12!=0){
                    //ALORS ce niveau est le dernier niveau d'une table et ladite table est completée à 100%
                    $percentArray[$level->getNumero()/12] = 100;
                }
                //SI le niveau à son numéro - 12 fois la table dans laquelle il est inférieur à zéro
                if($level->getNumero()-12*(int)($level->getNumero()/12) <0){
                    /*ALORS le pourcentage de completion de ladite table vaut le numéro du niveau en fonction de la table (de 1 à 12)
                    ledit numero divisé par 12 pour obtenir le pourcentage de completion de la table*/
                    $percentArray[(int)($level->getNumero()/12)] = (int)(100*($level->getNumero()-12*(int)($level->getNumero()/12))/12);
                }
                /*(int)($level->getNumero()/12) est le numero de la table en fonction du niveau
                */

            }

            $addTeacher= $this->createForm(AddTeacherType::class);
            $lynxTeacher = NULL;
            $addTeacher->handleRequest($request);
            $repositoryUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class);
            if($addTeacher->isSubmitted() && $addTeacher->isValid()){
                $mailTeacher = $addTeacher->get('email')->getData();
                $teacher = $repositoryUtilisateur->findOneTeacherByEmail($mailTeacher);
                $entityManager = $this->getDoctrine()->getManager();
                if(!empty($teacher)){
                    $user->addProfesseurLie($teacher[0]);
                }
                $entityManager->persist($user);
                $entityManager->flush();
            }
            $lynxTeacher= $user->getProfesseurLie();
            return $this->render('altic/pupilWelcome.html.twig',
                                 [
                                'teacherLynx'=>$lynxTeacher,
                                 'addTeacher'=>$addTeacher->createView(),
                                 'userName'=>$pupilFullName,
                                 'profilePic'=>$user->getAvatar(),
                                 'advice1'=>$advice1,
                                 'advice2'=>$advice2,
                                 'percentArray'=>$percentArray,
                                 'debug'=>$masteredLevels
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

        return $this->render('altic/choiceAvatar.html.twig', [
            'tableNumber'=>$tableNumber,
            'levelNumber'=>$levelNumber,
            'mapName'=>$mapName,
            'playableCharacters'=>$playableCharacters,
            'userName'=>$pupilFullName,
            'profilePic'=>$user->getAvatar()
            ]);
    }

    /**
     * @Route("/pupil/endgame", name="altic_endgame")
     */
    public function endgame(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $pupilFullName = $user->getNom()." ".$user->getPrenom();
        return $this->render('altic/endgame.html.twig', [
            'userName'=>$pupilFullName, 
            'profilePic'=>'default']);
    }

    /**
     * @Route("/pupil/{number}", name="altic_pupilTable")
     */
    public function pupilTable($number)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //represents all the global levels numbers for the current table
        $levelsNumbers = array();
        //represents the first global level number for each table
        $minLevelFromTable = array(2=>1, 5=>13, 10=>25, 1=>37, 4=>49, 3=>61, 0=>73, 6=>85, 8=>97, 9=>109, 7=>121);

        //arrays representing the games order
            $map0 = array('startMAP.png', 'castleMAP.png', 'riverMAP.png', 'caveMAP.png', 'castleMAP.png', 'mountainMAP.png', 'caveMAP.png', 'mountainMAP.png', 'riverMAP.png', 'riverMAP.png', 'caveMAP.png', 'endMAP.png');
            $map1 = array('startMAP.png', 'endMAP.png');
            $map2 = array('startMAP.png', 'endMAP.png');
            $map3 = array('startMAP.png', 'endMAP.png');
            $map4 = array('startMAP.png', 'endMAP.png');
            $map5 = array('startMAP.png', 'endMAP.png');
            $map6 = array('startMAP.png', 'endMAP.png');
            $map7 = array('startMAP.png', 'endMAP.png');
            $map8 = array('startMAP.png', 'endMAP.png');
            $map9 = array('startMAP.png', 'endMAP.png');
            $map10 = array('startMAP.png', 'endMAP.png');     
            $maps = array($map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0, $map0);
        $images = $maps[$number];

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

        $profilePic = 'images/pupil/characters/1.png';
    	$pupilFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/pupilTable.html.twig',
    						 [
                                'userName'=>$pupilFullName,
                                'tableNumber'=>$number,
                                'profilePic'=>$user->getAvatar(),
                                'images'=>$images,
                                'bCanPlay'=>$bCanPlay,
                                'levelsNumbers'=>$levelsNumbers
                            ]);
    }

    /**
     * @Route("/pupil/{tableNumber}/{levelNumber}/{mapName}/{avatarImage}", name="altic_pupilTraining")
     */
    public function pupilTraining($tableNumber, $levelNumber, $mapName, $avatarImage)
    {
        //array representing a game for a given map
        $gameFromMap = array(
            'castleMAP.png'=>'caveGame',
            'riverMAP.png'=>'fishingGame',
            'caveMAP.png'=>'caveGame',
            'mountainMAP.png'=>'mountainGame'
        );
        $gameName = $gameFromMap[$mapName];

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $repositoryNiveau = $this->getDoctrine()->getRepository(Niveau::class);
        $level = $repositoryNiveau->findBy(["numero" => $levelNumber])[0];
        $localLevel = ($levelNumber % 12 == 0)? 12 : $levelNumber % 12;

        $questionsAnswers = $this->generateAnswers($tableNumber, $this->generateQuestions($tableNumber, $level), $level);

        return $this->render("altic/$gameName.html.twig",
            [
                'questionsAndAnswers'=>$this->simplifyQuestionsAnswers($questionsAnswers, $tableNumber),
                'table'=>$tableNumber,
                'localLevel'=>$localLevel,
                'celestinImg'=>"images/pupil/characters/$avatarImage",
                'wizardImg'=>"images/pupil/characters/$avatarImage"
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
        'profilePic'=>'default','modifyForm'=>$form->createView()]);
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
