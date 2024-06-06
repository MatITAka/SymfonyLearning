<?php

namespace App\Tax;

class Calculator
{

    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function calculTTC(float $prixHT, float $tauxTVA ): float
    {
        $this->logger->info('Calcul TTC');
        return $prixHT * (1 + $tauxTVA / 100);
    }

}