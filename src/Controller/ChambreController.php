<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Request;
// use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\EntityChambre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request as Request;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index()
    {
        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
        ]);
    }

    /**
     * @Route("/chambre/addchambre", name="chambre_addchambre")
     */
    public function addchambre()
    {
        return $this->render('chambre/addchambre.html.twig', [
            'controller_name' => 'ChambreConrtroller'
        ]);
    }

    /**
     * @Route("/chambre/listechambre", name="chambre_listechambre")
     */
    public function listechambre(ChambreRepository $chambreRepository)
    {
        $chambres = $chambreRepository->findAll();
        return $this->render('chambre/listechambre.html.twig', compact('chambres'));
    }

    /**
     * @Route("/chambre/{id<[0-9]+>}/update", name="chambre_update", methods={"POST", "GET"})
     */
    public function update(Request $request, EntityManagerInterface $em, Chambre $chambre):Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em -> flush();
                return $this->redirectToRoute('chambre_update');
            }
        return $this->render('chambre/listechambre.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("chambre/{id<[0-9]+>}/delete", name="chambre_delete")
     */
    public function delete(EntityManagerInterface $em, Chambre $chambre)
    {
        $em->remove($chambre);
        $em->flush();
        return $this->redirectToRoute('chambre_delete');
    }
} 
