<?php

namespace App\Controller;
use DateTime;
use App\Service\CallApiService;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CallApiService $callApiService, ChartBuilderInterface $chartBuilderInterface): Response
    {
        for ($i = 1; $i < 8; $i++){
            $date = New DateTime('- '. $i .' day');
            $datas = $callApiService->getAllDataByDate($date->format('d-m-Y'));

            $label[] = $datas[0]['date'];
            $hospitalisation[] = $datas[0]['incid_hosp'];
            $rea[] = $datas[0]['incid_rea'];
            
        };
      
        $chart = $chartBuilderInterface->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Nouvelles Hospitalisations',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_reverse($hospitalisation)
                ], 
                [
                    'label' => 'Nouvelles entrées en Réa',
                    'borderColor' => 'rgb(46,41,78)',
                    'data' => array_reverse($rea)
                ]
            ]
                ]);

        return $this->render('home/index.html.twig', [
            'data' => $callApiService->getFranceData(),
            'departements' => $callApiService->getAllData(),
            'chart' => $chart
        ]);
    }
}
