<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Utilisateur;
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
                    $questions[$value]=new Question("$table x $value");
                    $begining += 1;
                }
            } while ($begining<11);
        }else {
            //ordered question
            for ($i=$begining; $i!=$ending ; $i+=$inc) {
                $questions[$i]=new Question("$table x $i");
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
        unset($answers);
        $ARightAnswer=false;
        $i=0;
        $nbOfSameAnswers=0; 
        $nbOfCurrentRandomAnswer=0;
        //calculate the number of random answers
        $nbOfRandomAnswers=($level->getNombreDeReponses())-($level->getNbReponsesProposeesDeLaMemeTable())-1;

        /*
            generate answers
        */
        while ($i!=$level->getNombreDeReponses()) {
            $answerType=rand(0,3);
            switch ($answerType) {
                case 0:
                if( ! $ARightAnswer){
                    //generate the right answer
                    $answers[$table*$key]=new Answer("".$table*$key);
                    $ARightAnswer=true;
                    $i+=1;
                }
                break;
                case 1:
                    //generate an answer from the same table
                    if ($nbOfSameAnswers <= $level->getNbReponsesProposeesDeLaMemeTable()) {
                        $aMultiplier=rand(0,10);
                        if( ! isset($answers[$table*$aMultiplier])){
                       $answers[$table*$aMultiplier]=new Answer("".$table*$aMultiplier);
                        $nbOfSameAnswers+=1;
                        $i+=1;
                        }
                    }
                    break;
                case 2:
                    break;
                case 3:
                    //generate everything else
                    if ($nbOfCurrentRandomAnswer <= $nbOfRandomAnswers) {
                        $valeur=rand(0,$level->ecartEntreLesReponse);
                        $estAddition =rand(0,1);
                        if(( ! isset($answers[$table*$key+$valeur]))||( ! isset($answers[$table*$key-$valeur]))){
                            if ($estAddition==1) {
                                $answers[$table*$key+$valeur]=new Answer("".$table*$key+$valeur);
                            } else {
                                $answers[$table*$key-$valeur]= new Answer("".$table*$key-$valeur);
                            }
                            $nbOfCurrentRandomAnswer+=1;
                            $i+=1;
                        }
                    }
                    break;
                }
            }
            $value->answers=$answers;
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
            $profilePic = 'images/pupil/characters/1.png';
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
            $percentArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $nbMax=0;
            $percentArray[0]=(int)(sizeof($levelArray)/132);
            foreach ($levelArray as $level){
                if($level->getNumero()%12==0&&$level->getNumero()/12!=0){
                    $percentArray[$level->getNumero()/12] = 100;
                }
                if($level->getNumero()-12*(int)($level->getNumero()/12) <0){
                    $percentArray[(int)($level->getNumero()/12)] = (int)(100*($level->getNumero()-12*(int)($level->getNumero()/12))/12);
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
                            'vous avez deja ajoute cet enseignant'
                        );

                    }else{
                        $user->addProfesseurLie($teacher[0]);

                    }
                }else{
                    $this->addFlash(
                        'warning',
                        'Aucun professeur ne possede cet email'
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
                                 'userName'=>$pupilFullName,
                                 'profilePic'=>$profilePic,
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
     * @Route("/pupil/{number}", name="altic_pupilTable")
     */
    public function pupilTable($number)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

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
        $range = array('min'=>$number*12, 'max'=>$number*12+12);
        $masteredLevels = $user->getNiveaux();

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
                                'profilePic'=>$profilePic,
                                'images'=>$images,
                                'bCanPlay'=>$bCanPlay
                            ]);
    }

    /**
     * @Route("/pupil/{tableNumber}/{levelNumber}", name="altic_pupilTraining")
     */
    public function pupilTraining($tableNumber, $levelNumber)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $repositoryNiveau = $this->getDoctrine()->getRepository(Niveau::class);
        $level = $repositoryNiveau->findBy(["numero" => $levelNumber]);

        $questionsAnswers = generateAnswers($tableNumber, generateQuestions($tableNumber, $level), $level);

        return $this->render('altic/game.html.twig', ['questionsAndAnswers'=>$questionsAnswers]);
    }

    #########################################################
    /**
     * @Route("/pwdLost", name="altic_pwdLost")
     */
    public function pwdLost()
    {
        return $this->render('altic/pwdLost.html.twig');
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
