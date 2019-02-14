<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class AlticController extends AbstractController
{

    /**
     * @Route("/enseignant", name="altic_enseignantAccueil")
     */
    public function enseignantAccueil()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
    	$pupilsList = ' ';
    	$teacherFullName = $user->getNom()." ".$user->getPrenom();
    	return $this->render('altic/enseignantAccueil.html.twig',
    						 ['pupils'=>$pupilsList, 'nomComplet'=>$teacherFullName, 'imgProfil'=>'default']);
    }

    /**
     * @Route("/enseignant/{nom}", name="altic_enseignantEnfantDonnees")
     */
    public function enseignantEnfantDonnees($nom)
    {
    	$nomCompletEnseignant = 'Jean-Pierre Ravaud';
    	return $this->render('altic/enseignantEnfantDonnees.html.twig',
    						 ['nomComplet'=>$nomCompletEnseignant, 'nomEleve'=>$nom, 'imgProfil'=>'default']);
    }

    /**
     * @Route("/enseignant/{nom}/{nombre}", name="altic_enseignantEnfantDonneesTable")
     */
    public function enseignantEnfantDonneesTable($nom, $nombre)
    {
    	$nomCompletEnseignant = 'Jean-Pierre Ravaud';
    	return $this->render('altic/enseignantEnfantDonneesTable.html.twig',
    						 ['nomEleve'=>$nom, 'numeroTable'=>$nombre, 'nomComplet'=>$nomCompletEnseignant, 'imgProfil'=>'default']);
    }

    #########################################################

    /**
     * @Route("/enfant", name="altic_enfant")
     */
    public function enfantAccueil()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($user->getEstEnseignant()) {
           return $this->redirect(
               $this->generateUrl('altic_enseignantAccueil')
           );
        } else {
            $profilePic = 'images/pupil/characters/1.png';
            $pupilFullName = $user->getNom()." ".$user->getPrenom();
            return $this->render('altic/enfantAccueil.html.twig',
                                 ['nomComplet'=>$pupilFullName, 'imgProfil'=>$profilePic]);
        }
    }

    /**
     * @Route("/enfant/{nombre}", name="altic_enfantTable")
     */
    public function enfantTable($nombre)
    {
        $profilePic = 'images/enfant/characters/1.png';
    	$enfantFullName = 'Kévin Martin';
    	return $this->render('altic/enfantTable.html.twig',
    						 ['nomComplet'=>$nomCompletEnfant, 'numeroTable'=>$nombre, 'imgProfil'=>$imgProfil]);
    }

    #########################################################
    /**
     * @Route("/mdpPerdu", name="altic_mdpPerdu")
     */
    public function mdpPerdu()
    {
        return $this->render('altic/mdpPerdu.html.twig', ['nomComplet'=>'', 'imgProfil'=>'default']);
    }

    /**
     * @Route("/modifierCompte", name="altic_modifierCompte")
     */
    public function modifierCompte()
    {
        return $this->render('altic/modifierCompte.html.twig', ['nomComplet'=>'Nom Utilisateur', 'imgProfil'=>'default']);
    }
}
