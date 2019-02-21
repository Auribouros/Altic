<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class AlticController extends AbstractController
{

    /**
     * @Route("/teacher", name="altic_teacherWelcome")
     */
    public function teacherWelcome()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$pupilsList = ' ';
    	$teacherFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/teacherWelcome.html.twig',
    						 ['pupils'=>$pupilsList, 'userName'=>$teacherFullName, 'profilePic'=>'default']);
    }

    /**
     * @Route("/teacher/{name}", name="altic_teacherPupilData")
     */
    public function teacherPupilData($name)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilData.html.twig',
    						 ['userName'=>$teacherFullName, 'pupilName'=>$name, 'profilePic'=>'default']);
    }

    /**
     * @Route("/teacher/{name}/{number}", name="altic_teacherPupilDataTable")
     */
    public function teacherPupilDataTable($name, $number)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilDataTable.html.twig',
    						 ['pupilName'=>$name, 'tableNumber'=>$number, 'userName'=>$teacherFullName, 'profilePic'=>'default']);
    }

    #########################################################

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
    public function pupilWelcome()
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

            /*return $this->render('altic/pupilWelcome.html.twig',
                                 [
                                    'userName'=>$pupilFullName,
                                    'profilePic'=>$profilePic,
                                    'advice1'=>$advice1,
                                    'advice2'=>$advice2
                                ]);*/
            $levelArray = $user-> getNiveaux();
            $percentArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $nbMax=0;
            $percentArray[0]=(int)(sizeof($levelArray)/132);
            foreach ($levelArray as $level){
                if($level->getNumero()>$nbMax){
                    if($level->getNumero()%12==0&&$level->getNumero()/12!=0){
                        $percentArray[$level->getNumero()/12] = 100;
                    }
                    if($level->getNumero()-12*(int)($level->getNumero()/12) <0){
                        $percentArray[(int)($level->getNumero()/12)] = (int)(100*($level->getNumero()-12*(int)($level->getNumero()/12))/12);
                    }

                } 


            }
            return $this->render('altic/pupilWelcome.html.twig',
                                 [
                                 'userName'=>$pupilFullName,
                                 'profilePic'=>$profilePic,
                                 'advice1'=>$advice1,
                                 'advice2'=>$advice2,
                                 'percentArray'=>$percentArray
                                ]);
        }
        

    }

    /**
     * @Route("/pupil/{number}", name="altic_pupilTable")
     */
    public function pupilTable($number)
    {
        $profilePic = 'images/pupil/characters/1.png';
    	$pupilFullName = 'Kévin Martin';
    	return $this->render('altic/pupilTable.html.twig',
    						 ['userName'=>$pupilFullName, 'tableNumber'=>$number, 'profilePic'=>$profilePic]);
    }

    #########################################################
    /**
     * @Route("/pwdLost", name="altic_pwdLost")
     */
    public function pwdLost()
    {
        return $this->render('altic/pwdLost.html.twig', ['userName'=>'', 'profilePic'=>'default']);
    }

    /**
     * @Route("/modifyAccount", name="altic_modifyAccount")
     */
    public function modifyAccount()
    {
        return $this->render('altic/modifyAccount.html.twig', ['userName'=>'Nom Utilisateur', 'profilePic'=>'default']);
    }
}
