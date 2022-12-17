<?php

namespace App\Controller;

use App\Entity\RechercheVoiture;
use App\Entity\Voiture;
use App\Form\RechercheVoitureType;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/afficherVoitures", name="afficherVoitures")
     */
    public function afficherVoitures(VoitureRepository $voitureRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $rechercheVoiture = new RechercheVoiture();

        $form = $this->createForm(RechercheVoitureType::class, $rechercheVoiture);
        $form->handleRequest($request);

        $voitures = $paginatorInterface->paginate(
            $voitureRepository->findAllWithPagination($rechercheVoiture),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('voiture/voitures.html.twig',[
            "voitures" => $voitures,
            "form" => $form->createView(),
            "admin" => true
        ]);
    }

    /**
     * @Route("/ajouterVoiture", name="ajouterVoiture")
     */
    public function AjouterVoiture(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($voiture);
            $entityManager->flush();
            $this->addFlash("success", "L'ajout a été effectuée");
            return $this->redirectToRoute('admin_afficherVoitures');
        }

        return $this->render('admin/ajout.html.twig',[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifierVoiture/{id}", name="modifierVoiture")
     */
    public function ModifierVoiture(Voiture $voiture, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($voiture);
            $entityManager->flush();
            $this->addFlash("success", "La modification a été effectuée");
            return $this->redirectToRoute('admin_afficherVoitures');
        }

        return $this->render('admin/modification.html.twig',[
            "voiture" => $voiture,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimerVoiture/{id}", name="supprimerVoiture")
     */
    public function SupprimerVoiture(Voiture $voiture, Request $request, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($voiture);
            $entityManager->flush();
            $this->addFlash("success", "La suppression a été effectuée");
            return $this->redirectToRoute('admin_afficherVoitures');
    }
}
