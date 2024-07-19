<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingPageController extends AbstractController
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_landing_page')]
    public function index(): Response
    {
        $products = $this->productRepository->findBy([], ['rating' => 'DESC']);

        return $this->render('landing_page/index.html.twig', [
            'products' => $products,
        ]);
    }
}
