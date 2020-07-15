<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre_index")
     */
    public function index(ChambreRepository $ChambreRepository)
    {
        $chambres = $ChambreRepository->findAll();
        return $this->render('chambre/index.html.twig', compact('chambres'));
    }

    /**
     * @Route("/chambre/create", name="chambre_create", methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em, ChambreRepository $ChambreRepository):Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $num = $chambre->getNumBatiment()->getNumBatiment();
            $num = $num."-".$chambre->NumChambre($ChambreRepository);
            $chambre->setNumChambre($num);
            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute('chambre_index');
            
        }
        return $this->render('chambre/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
     /**
      * 

     * @Route("/chambre/{id<[0-9]+>}/update", name="chambre_update", methods={"POST","GET"})
     */
    public function update(Request $request, EntityManagerInterface $em, Chambre $chambre):Response
    { 
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $num=explode("-", $chambre->getNumChambre());
            $num = $chambre->getNumBatiment()->getNumBatiment().'-'.$num[1];;
            $chambre->setNumChambre($num);
            $em->flush();
            return $this->redirectToRoute('chambre_index');
            
        }
        return $this->render('chambre/create.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

            /**
     * @Route("/chambre/{id<[0-9]+>}/delete ", name="chambre_delete", methods={"POST", "GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Chambre $chambre
     * @return Response
     */
    public function MessageDelete(Request $request, EntityManagerInterface $em, Chambre $chambre):Response{

        $jsonData = array();
        $tabEtudiant = [];

        foreach ($chambre->getEtudiants()->getValues() as $etudiant){
                $tabEtudiant[] = array(
                    'matricule'=>$etudiant->getMatricule(),
                    'prenom'=>$etudiant->getPrenom(),
                );
        }
            $temp = array(
                'id'=> $chambre->getId(),
                'etudiants' => $tabEtudiant,
            );
            $jsonData = $temp;
        return new JsonResponse($jsonData);
    }

     /**
      * 

     * @Route("/chambre/{id<[0-9]+>}/delete_chambre", name="chambre_delete_chambre")
     */
    public function delete(EntityManagerInterface $em, Chambre $chambre)
    { 
        $em->remove($chambre);
        $em->flush();
        return $this->redirectToRoute('chambre_index');
    }

    
}
