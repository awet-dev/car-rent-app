<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/', name: 'car_index')]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'cars' => $this->carsArrayGrouping($carRepository->findAll()),
        ]);
    }

    #[Route('/cars/{id}', name: 'car_detail')]
    public function detail(int $id, CarRepository $carRepository): Response
    {
        return $this->render('home/detail.html.twig', [
            'car' => $carRepository->find($id),
        ]);
    }

    public function carsArrayGrouping($cars): array
    {
        $i = 0;
        $array_cars = [];
        while ($i < count($cars)) {
            array_push($array_cars, array_slice($cars, $i, 3));
            $i += 3;
        }
        return $array_cars;
    }
}
