<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{

    #[Route('/review/new', name: 'review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReviewRepository $reviewRepository): Response
    {
        $review = new Review();
        if ($request->isMethod('POST') && $request->get('message')) {
            $review->setUser($this->getUser());
            $review->setMessage($request->get('message'));
            $review->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();
            return $this->redirectToRoute('home', [
                'reviews' => $reviewRepository->findAll()
            ]);
        }
        return $this->render('review/new.html.twig');
    }
}
