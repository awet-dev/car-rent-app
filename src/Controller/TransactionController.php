<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Transaction;
use App\Repository\CarRepository;
use App\Repository\TransactionRepository;

class TransactionController extends AbstractController
{
    #[Route('/rent/car/{carId}', name: 'rent_car')]
    public function index(int $carId, CarRepository $carRepository): Response
    {
        $car = $carRepository->find($carId);

        $transaction = new Transaction();
        
        $transaction->setCar($car);
        $transaction->setMode("km");
        $transaction->setvalue(2);
        $transaction->setTime(new \DateTime());

        $transaction->setUser($this->getUser());



        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transaction);
        $entityManager->flush();
        return $this->render('transaction/index.html.twig', [
            'controller_name' => 'TransactionController',
        ]);
    }

    #[Route('/check/transaction', name: 'check_transaction')]
    public function getTransactions(TransactionRepository $transactionRepository) 
    {
        return $this->json([
            'controller_name' => 'TransactionController',
            'transaction' => $transactionRepository->find(1),
        ]);
    }
}
