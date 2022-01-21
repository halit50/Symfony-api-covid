<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getFranceData(): array
    {
        return $this->getApi('france');
    }

    public function getAllData(): array
    {
        return $this->getApi('departements');
    }

    public function getDepartementData($departement): array
    {
        return $this->getApi('departement/'.$departement);
    }

    public function getAllDataByDate($date): array
    {
        $response2 = $this->client->request(
            'GET',
            'https://coronavirusapifr.herokuapp.com/data/france-by-date/'.$date
        );
        return $response2->toArray();
    }

    private function getApi($var): array
    {
        $response = $this->client->request(
            'GET',
            'https://coronavirusapifr.herokuapp.com/data/live/'.$var
        );
        return $response->toArray();
    }


}