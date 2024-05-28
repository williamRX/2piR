<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductWishlist;
use App\Repository\ProductWishlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductWishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'app_product_wishlist')]
    public function index(ProductWishlistRepository $productWishlistRepository): Response
    {
        $wishlist = $productWishlistRepository->findAll();

        return $this->render('product_wishlist/index.html.twig', [
            'wishlist' => $wishlist,
        ]);
    }

    #[Route('/wishlist/{id}', name: 'app_product_wishlist_show')]
    public function show(ProductWishlist $wishlistItem): Response
    {
        return $this->render('product_wishlist/show.html.twig', [
            'wishlistItem' => $wishlistItem,
        ]);
    }

    #[Route('/wishlist/add/{id}', name: 'app_product_wishlist_add', methods: ['POST'])]
    public function add(Product $product): Response
    {
        $wishlistItem = new ProductWishlist();
        $wishlistItem->setProduct($product);
        $wishlistItem->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($wishlistItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_wishlist');
    }

    #[Route('/wishlist/remove/{id}', name: 'app_product_wishlist_remove', methods: ['DELETE'])]
    public function remove(ProductWishlist $wishlistItem): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($wishlistItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_wishlist');
    }
}