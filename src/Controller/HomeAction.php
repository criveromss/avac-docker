<?php

namespace App\Controller;


use App\Services\CarTransformer;
use App\Services\PrismicApiService;
use App\Transformer\CibleTransformer;
use App\Transformer\CtaContactTransformer;
use App\Transformer\GalleryTransformer;
use App\Transformer\HeaderTransformer;
use App\Transformer\HistoryTransformer;
use App\Transformer\NumbersTransformer;
use App\Transformer\ProTransformer;
use App\Transformer\TestimonialTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeAction extends AbstractController
{

    public function __construct(
        private readonly Environment  $environment,
        private readonly PrismicApiService $prismicApiService,
        private readonly CarTransformer $carTransformer


    )
    {
    }

    #[Route('/', name: 'app_index')]
    public function __invoke(Request $request)
    {


        $cars =  $this->carTransformer->transform(
            $this->prismicApiService->getAllByType('car')->results
        );


        return new Response(
            $this->environment->render('index.html.twig', [
                'cars' => $cars
               ])
        );
    }
}

