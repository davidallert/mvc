<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Request and session interfaces.
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MetricsController extends AbstractController
{
    // Card overview ..............................................................................
    #[Route("/metrics", name: "metrics")]
    public function metrics(
    ): Response {
        return $this->render("metrics/metrics.html.twig");
    }

}