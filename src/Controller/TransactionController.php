<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\CarRateRepository;
use App\Repository\CarRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{

    #[Route('/transaction', name: 'transaction')]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }


    #[Route('/rent/{id}', name: 'rent', methods: ['GET', 'POST'])]
    public function rent(int $id, Request $request, CarRepository $carRepository): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $transaction->setUser($this->getUser());
            $transaction->setTime(new \DateTime());

            $car = $carRepository->find($id);
            $transaction->setCar($car);

            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('car_quantity', ['rateId' => $transaction->getId()]);
        }

        return $this->render('home/rent.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
            'car' => $carRepository->find($id),
        ]);
    }

    #[Route('/car/{rateId}', name: 'car_quantity')]
    public function carQuantity(int $rateId, TransactionRepository $transactionRepository, ): Response
    {
        $transaction = $transactionRepository->find($rateId);

        $car = $transaction->getCar();

        $manager = $this->getDoctrine()->getManager();
        if($car->getStock() > $transaction->getValue()) {
            $car->setStock($car->getStock() - $transaction->getValue());
        } else {
            $car->setIsSold(true);
        }
        $manager->persist($car);
        $manager->flush();

        return $this->redirectToRoute('home');
    }
    
}
