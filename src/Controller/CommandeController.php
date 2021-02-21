<?php


namespace App\Controller;


use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/command')]
class CommandeController extends AbstractController
{

    #[Route('/list', name: 'listOfCommands')]
    public function listOfCommands(CommandeRepository $commandeRepository)
    {
        $commandes = $commandeRepository->findAll();

        return $this->render('commande/list.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}