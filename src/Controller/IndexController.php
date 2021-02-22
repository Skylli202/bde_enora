<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Eleve;
use App\Form\CommandeRoseType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CommandeRoseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            /** @var Eleve $from */
            /** @var Eleve $to   */

            $data = $form->getData();

            $from = $data['from'];
            $to = $data['to'];
            $msg = $data['msg'];

            $commande = new Commande();
            $commande
                ->setPar($from)
                ->setPour($to)
                ->setOrderDate(new DateTime())
                ->setMessage($msg)
            ;

            $this->getDoctrine()->getManager()->persist($commande);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('index/commande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
