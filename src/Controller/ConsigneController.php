<?php

namespace App\Controller;

use App\Entity\Consigne;
use App\Entity\GroupeConsignes;
use App\Form\ConsigneType;
use App\Repository\ConsigneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsigneController extends AbstractController
{
    #[Route('/consigne', name: 'app_consigne')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $consignes = $doctrine->getRepository( Consigne::class)->findBy([], ["libelle" => "ASC"]);

        return $this->render('consigne/index.html.twig', [
            'consignes' => $consignes,
        ]);
    }
    #[Route('/consigne/add', name: 'app_consigne_add', methods: ['GET', 'POST'])]
    #[Route('/consigne/{id}/update', name: 'update_consigne')]
    public function add(ManagerRegistry $doctrine, Consigne $consigne = null, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        // Si vous avez un paramètre {id} dans la route, vous pouvez le récupérer
        $groupeConsignes = null;
        if ($request->attributes->has('id')) {
            $groupeConsignes = $entityManager->getRepository(GroupeConsignes::class)->find($request->attributes->get('id'));
        }

        if (!$consigne) {
            $consigne = new Consigne();
        }

        $form = $this->createForm(ConsigneType::class, $consigne);

        // Ajoutez le groupeConsignes au formulaire
        $form->get('groupeConsignes')->setData($groupeConsignes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de récupérer les données du formulaire à nouveau
            $entityManager->persist($consigne);
            $entityManager->flush();

            return $this->redirectToRoute('app_consigne');
        }

        return $this->render('consigne/add.html.twig', [
            'formAddConsigne' => $form->createView(),
            'update' => [$consigne->getId(), $groupeConsignes ? $groupeConsignes->getId() : null]
        ]);
    }

    #[Route('/consigne/{id}/delete', name: 'delete_consigne')]
    public function delete( ManagerRegistry $doctrine, Consigne $consigne):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($consigne);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_consigne');
    }

//*details
    #[Route('/consigne/{id}', name: 'show_consigne')]
    public function show( ConsigneRepository $consigneRepository, Consigne $consigne): Response
    {
        $consigne_id = $consigne->getId();

        return $this->render('consigne/show.html.twig', [
            'consigne' => $consigne
        ]);
    }

}
