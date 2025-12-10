<?php
namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Charger le JSON des races
        $racesJson = file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/races.json');
        $racesData = json_decode($racesJson, true);

        // Durée des prestations selon type de poils
        $durations = [
            "poils_courts" => 30,
            "poils_moderes" => 60,
            "poils_longs" => 90,
            "poils_speciaux" => 120
        ];

        $reservation = new Reservations();

        // Passer les choix de race pour que le select soit généré
        $form = $this->createForm(ReservationType::class, $reservation, [
            'race_choices' => $this->getRaceChoices($racesData)
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();
            $this->addFlash('success', 'Réservation enregistrée avec succès !');
            return $this->redirectToRoute('app_services');
        }

        return $this->render('services/index.html.twig', [
            'form' => $form->createView(),
            'racesData' => $racesData,
            'durations' => $durations
        ]);
    }

    private function getRaceChoices(array $racesData): array
    {
        $choices = [];
        foreach ($racesData as $animal => $races) {
            foreach ($races as $race => $typePoils) {
                $choices[$race] = $race; // clé => valeur
            }
        }
        return $choices;
    }
}
