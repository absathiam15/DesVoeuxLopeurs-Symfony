<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\EntityEtudiant;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index()
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }

     /**
     * @Route("/etudiant/addetudiant", name="etudiant_addetudiant", methods={"POST", "GET"})
     */
    public function addetudiant(Request $request, EntityManagerInterface $em) : Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em -> persist($etudiant);
            $em -> flush();
        }
        return $this->render('etudiant/addetudiant.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/etudiant/listetudiant", name="etudiant_listetudiant", methods={"POST", "GET"})
     */
    public function listetudiant(EtudiantRepository $etudiantRepository)
    {
        $etudiants = $etudiantRepository->findAll();
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
       
    }

     /**
     * @Route("/etudiant/{id<[0-9]+>}/update", name="etudiant_update", methods={"POST", "GET"})
     */
    public function update(Request $request, EntityManagerInterface $em, Etudiant $etudiant):Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em -> flush();
                return $this->redirectToRoute('etudiant_update');
            }
        return $this->render('chambre/index.html.twig', [
            'chambre' => $etudiant,
            'form' => $form->createView()
        ]);
    }


     /**
     * @Route("etudiant/{id<[0-9]+>}/delete", name="etudiant_delete")
     */
    public function delete(EntityManagerInterface $em, Etudiant $etudiant)
    {
        $em->remove($etudiant);
        $em->flush();
        return $this->redirectToRoute('etudiant_delete');
    }
}
 