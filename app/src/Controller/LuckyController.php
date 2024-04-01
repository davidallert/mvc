<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to you!</body></html>'
        );
    }

    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {
        $number = random_int(0, 4);
        // $number = 0;
        $timestamp = time();
        $date = date('d-m-Y');
        // En blandad kompott av citat.
        $quotes = [
            "Gratis är gott.",
            "Opinion is the medium between knowledge and ignorance.",
            "Det stod en varmkorvsgubbe ner' på Fyristorg. Han måla' korvarna svarta för han hade sorg. Han hade låda på magen, det gillas inte av lagen",
            "He who is not contented with what he has, would not be contented with what he would like to have.",
            "Fate leads him who follows it, and drags him who resist."
        ];
        $quote_of_the_day = $quotes[$number];

        $data = [
            'timestamp' => $timestamp,
            'date' => $date,
            'quote_of_the_day' => $quote_of_the_day
        ];

        return new JsonResponse($data);
    }
}

