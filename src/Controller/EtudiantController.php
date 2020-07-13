<?php

namespace App\Controller;
use App\Entity\Chambre;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\type;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant_index")
     */
    public function index(EtudiantRepository $EtudiantRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $etudiants = $EtudiantRepository->findAll();
        return $this->render('etudiant/index.html.twig', compact(('etudiants')));
    }


    /**
     * @Route("/etudiant/create", name="etudiant_create", methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em, EtudiantRepository $EtudiantRepository):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        $msg = "";
        
         if($form->isSubmitted() && $form->isValid()){
            $chambre_etudiant = $EtudiantRepository->findBy(['chambre'=>$etudiant->getChambre()]);
            $nbreEtudiant = count($chambre_etudiant);
            if ($nbreEtudiant) {
                $type = $chambre_etudiant[0]->getChambre()->getType();
            }
            if ($nbreEtudiant>=2 || ($nbreEtudiant==1 && $type == "individuel")) {
                $msg = 'Chambre pleine';
            }
            else{
                $matricule = $EtudiantRepository->FindAll();
                if (count($matricule)>0) {
                    $matricule = $matricule[count($matricule)-1]->getId()+1;
                }
                else{
                    $matricule = 1;
                }
                
                if($matricule < 10){
                    $matricule = "000".$matricule;
                }else{
                    if($matricule < 100){
                        $matricule = "00".$matricule;
                    }else{
                        if($matricule < 1000){
                            $matricule = "0".$matricule;
                        }
                    }
                }
                $matricule = "2020".$etudiant->getNom()[0].$etudiant->getNom()[1].$etudiant->getPrenom()[strlen($etudiant->getPrenom())-2].$etudiant->getPrenom()[strlen($etudiant->getPrenom())-1].$matricule;
                $matricule=strtoupper($matricule);
                $etudiant->setMatricule($matricule);
                $em->persist($etudiant);
                $em->flush();
                return $this->redirectToRoute('etudiant_index');
            }
            
            
        }
        return $this->render('etudiant/create.html.twig', array(
            'form' => $form->createView(),
            'msg'=>$msg,
        ));
    }
     /**
      * 

     * @Route("/etudiant/{id<[0-9]+>}/update", name="etudiant_update", methods={"POST","GET"})
     */
    public function update(Request $request, EntityManagerInterface $em, EtudiantRepository $EtudiantRepository, Etudiant $etudiant):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $numch =  $etudiant->getChambre();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        $msg = "";
        if($form->isSubmitted() && $form->isValid()){
            if ($numch != $etudiant->getChambre()) {
                $chambre_etudiant = $EtudiantRepository->findBy(['chambre'=>$etudiant->getChambre()]);
                $nbreEtudiant = count($chambre_etudiant);
                if ($nbreEtudiant) {
                    $type = $chambre_etudiant[0]->getChambre()->getType();
                }
                if ($nbreEtudiant>=2 || ($nbreEtudiant==1 && $type == "individuel")) {
                    $msg = 'Chambre pleine';
                }
            }
            else{
                $matricule = "2020".$etudiant->getNom()[0].$etudiant->getNom()[1].$etudiant->getPrenom()[strlen($etudiant->getPrenom())-2].$etudiant->getPrenom()[strlen($etudiant->getPrenom())-1].$etudiant->getMatricule()[8].$etudiant->getMatricule()[9].$etudiant->getMatricule()[10].$etudiant->getMatricule()[11];
                $matricule=strtoupper($matricule);
                $etudiant->setMatricule($matricule);
                $em->flush();
                return $this->redirectToRoute('etudiant_index');
            }
            
        }
        return $this->render('etudiant/create.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
            'msg'=>$msg,
        ]);
    }

    /**
     * @Route("/etudiant/{id<[0-9]+>}/delete_message", name="delete_message")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Etudiant $etudiant
     * @return Response
     */

    public function messageDelete(Request $request, EntityManagerInterface $em, Etudiant $etudiant):Response{
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $jsonData = array();
        $jsonData = array(
            "id"=>$etudiant->getId(),
            "prenom"=>$etudiant->getPrenom(),
            "nom"=>$etudiant->getNom(),
        );
        return new JsonResponse($jsonData);
    }

     /**
      * 

     * @Route("/etudiant/{id<[0-9]+>}/delete", name="etudiant_delete")
     */
    public function delete(EntityManagerInterface $em, Etudiant $etudiant)
    { 
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em->remove($etudiant);
        $em->flush();
        return $this->redirectToRoute('etudiant_index');
    }
}
