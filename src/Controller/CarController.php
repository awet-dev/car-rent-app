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
            'cars' => $carRepository->findAll(),
        ]);
    }

    #[Route('/cars/{id}', name: 'car_detail')]
    public function detail(int $id, CarRepository $carRepository): Response
    {
        return $this->render('home/detail.html.twig', [
            'car' => $carRepository->find($id),
        ]);
    }

    #[Route('/car/rent/{id}', name: 'car_rent')]
    public function rent(int $id, CarRepository $carRepository): Response
    {
        return $this->render('home/rent.html.twig', [
            'car' => $carRepository->find($id),
        ]);
    }

}
