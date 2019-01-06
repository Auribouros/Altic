<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AlticController extends AbstractController
{
    /**
     * @Route("/", name="altic_welcome")
     */
    public function index()
    {
        return $this->render('altic/index.html.twig', ['userName'=>'']);
    }

    /**
     * @Route("/teacher", name="altic_teacherWelcome")
     */
    public function teacherWelcome()
    {
    	$pupilsList = ' ';
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherWelcome.html.twig',
    						 ['pupils'=>$pupilsList, 'userName'=>$teacherFullName]);
    }

    /**
     * @Route("/teacher/{name}", name="altic_teacherPupilData")
     */
    public function teacherPupilData($name)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilData.html.twig',
    						 ['userName'=>$teacherFullName, 'pupilName'=>$name]);
    }

    /**
     * @Route("/teacher/{name}/{number}", name="altic_teacherPupilDataTable")
     */
    public function teacherPupilDataTable($name, $number)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilDataTable.html.twig',
    						 ['pupilName'=>$name, 'tableNumber'=>$number, 'userName'=>$teacherFullName]);
    }

    #########################################################

    /**
     * @Route("/pupil", name="altic_pupil")
     */
    public function pupilWelcome()
    {
    	$pupilFullName = 'Kévin Martin';
    	return $this->render('altic/pupilWelcome.html.twig',
    						 ['userName'=>$pupilFullName]);
    }

    /**
     * @Route("/pupil/{number}", name="altic_pupilTable")
     */
    public function pupilTable($number)
    {
    	$pupilFullName = 'Kévin Martin';
    	return $this->render('altic/pupilTable.html.twig',
    						 ['userName'=>$pupilFullName, 'tableNumber'=>$number]);
    }

    #########################################################

    /**
     * @Route("/pwdLost", name="altic_pwdLost")
     */
    public function pwdLost()
    {
        return $this->render('altic/pwdLost.html.twig', ['userName'=>'']);
    }

    /**
     * @Route("/modifyAccount", name="altic_modifyAccount")
     */
    public function modifyAccount()
    {
        return $this->render('altic/modifyAccount.html.twig', ['userName'=>'Nom Utilisateur']);
    }

}
