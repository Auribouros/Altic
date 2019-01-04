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
        return $this->render('altic/index.html.twig');
    }

    /**
     * @Route("/teacher", name="altic_teacherWelcome")
     */
    public function teacherWelcome()
    {
    	$pupilsList = ' ';
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherWelcome.html.twig',
    						 ['pupils'=>$pupilsList, 'teacherName'=>$teacherFullName]);
    }

    /**
     * @Route("/teacher/{name}", name="altic_teacherPupilData")
     */
    public function teacherPupilData($name)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilData.html.twig',
    						 ['teacherName'=>$teacherFullName, 'pupilName'=>$name]);
    }

    /**
     * @Route("/teacher/{name}/{number}", name="altic_teacherPupilDataTable")
     */
    public function teacherPupilDataTable($name, $number)
    {
    	$teacherFullName = 'Jean-Pierre Ravaud';
    	return $this->render('altic/teacherPupilDataTable.html.twig',
    						 ['pupilName'=>$name, 'tableNumber'=>$number, 'teacherName'=>$teacherFullName]);
    }

    #########################################################

    /**
     * @Route("/pupil", name="altic_pupil")
     */
    public function pupilWelcome()
    {
    	$pupilFullName = 'Kévin Martin';
    	return $this->render('altic/pupilWelcome.html.twig',
    						 ['pupilName'=>$pupilFullName]);
    }

    /**
     * @Route("/pupil/{number}", name="altic_pupilTable")
     */
    public function pupilTable($number)
    {
    	$pupilFullName = 'Kévin Martin';
    	return $this->render('altic/pupilTable.html.twig',
    						 ['pupilName'=>$pupilFullName, 'tableNumber'=>$number]);
    }
}
