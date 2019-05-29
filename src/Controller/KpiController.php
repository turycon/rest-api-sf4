<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KpiController extends AbstractController
{
    /**
     * @Route("/", name="kpi.index")
     */
    public function index()
    {
        return $this->render('kpi/index.html.twig', [
            'controller_name' => 'KpiController',
        ]);
    }
}
