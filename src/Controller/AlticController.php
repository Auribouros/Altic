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
            return $this->render('altic/pupilWelcome.html.twig',
                                 ['userName'=>$pupilFullName, 'profilePic'=>$profilePic]);
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
