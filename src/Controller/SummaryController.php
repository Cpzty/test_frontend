<?php

namespace App\Controller;

use App\Entity\Header;
use App\Entity\Summary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SummaryController extends AbstractController
{
    #[Route('/summary', name: 'summary_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
{
    // Get selected process_id from query parameters
    $selectedHeaderId = $request->query->get('header_id');

    // Fetch all process headers
    $headers = $em->getRepository(Header::class)->findBy([], ['executionDate' => 'DESC']);

    // Fetch summaries filtered by selected header, or all if none selected
    $summaries = $selectedHeaderId
        ? $em->getRepository(Summary::class)->findBy(['header' => $selectedHeaderId], ['createdAt' => 'DESC'])
        : $em->getRepository(Summary::class)->findBy([], ['createdAt' => 'DESC']);

    // Prepare chart data
    $metrics = [];       // Sum of value per metric
    $processCounts = []; // Count of summaries per process
   

    foreach ($summaries as $summary) {
    if (isset($genderIds[$summary->getId()])) {
        $genderCounts[$genderIds[$summary->getId()]]++;
    }
}

    foreach ($summaries as $summary) {
        // Sum values per metric
        $metricName = $summary->getMetric();
        if (!isset($metrics[$metricName])) {
            $metrics[$metricName] = 0;
        }
        $metrics[$metricName] += $summary->getValue();

       
    }

    $genderCounts = [
    'male' => $metrics['Gender: male'] ?? 0,
    'female' => $metrics['Gender: female'] ?? 0,
    ];


    return $this->render('summary/index.html.twig', [
        'headers' => $headers,
        'summaries' => $summaries,
        'selectedHeaderId' => $selectedHeaderId,
        'metrics' => $metrics,
         'genderCounts' => $genderCounts,
    ]);
}

}
