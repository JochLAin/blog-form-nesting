<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\Type\AppType;
use App\Handler\AppHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: "app_")]
class AppController extends AbstractController
{
    #[Route("/", name: "index", methods: ["GET", "POST"])]
    public function index(AppHandler $handler, EntityManagerInterface $em, Request $request): Response
    {
        $memos = $em->getRepository(Memo::class)->findAll();
        $form = $this->createForm(AppType::class, $memos);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($form, $memos);
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
