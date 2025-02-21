<?php

namespace App\Controller;


use App\Services\CarTransformer;
use App\Services\PrismicApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CarAction extends AbstractController
{

    public function __construct(
        private readonly Environment            $environment,
        private readonly PrismicApiService $prismicApiService,
        private readonly CarTransformer $carTransformer


    )
    {
    }

    #[Route('/voiture/{slug}', name: 'app_voiture')]
    public function __invoke(Request $request, string $slug)
    {

        $currentCar = $this->prismicApiService->getByUid('car', $slug);
        if (!$currentCar) {
            return new RedirectResponse('/');
        }

        $car = $this->carTransformer->transform($currentCar);

        return new Response(
            $this->environment->render('product-page.html.twig', [
                'car' => $car[0]
               ])
        );
    }
}

