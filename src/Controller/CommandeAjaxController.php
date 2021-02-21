<?php


namespace App\Controller;


use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ajax')]
class CommandeAjaxController extends CommandeController
{
    #[Route('/get-commande', name: 'ajax-get-commande')]
    public function ajaxGetCommande(Request $request, CommandeRepository $commandeRepository, LoggerInterface $logger)
    {
        if ($request->isXmlHttpRequest() and $request->query->has('commande')) {
            $commande = $commandeRepository->find($request->query->get('commande'));
            if (is_null($commande)) {
                throw new BadRequestException("Internal error", 500);
            } else {
                return new JsonResponse(json_encode($commande->toArray()), 200, [], true);
            }
        } else {
            if ($request->query->has('commande')) {
                throw new BadRequestException("Mauvaise requête, elle doit être de type XmlHttp.", 403);
            } else {
                throw new BadRequestException("La requête doit contenir le paramètre 'commande'.", 400);
            }

        }
    }

    #[Route('/toggle-commande-validation', name: 'ajax-toggle-commande-validation')]
    public function toggleValidation(Request $request, CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest() and $request->query->has('commande')) {
            $commande = $commandeRepository->find($request->query->get('commande'));
            if (is_null($commande)) {
                throw new BadRequestException("Internal error", 500);
            } else {
                $commande->setValid(!$commande->getValid());
                $em->flush();
                return new JsonResponse(json_encode($commande->toArray()), 200, [], true);
            }
        } else {
            if ($request->query->has('commande')) {
                throw new BadRequestException("Mauvaise requête, elle doit être de type XmlHttp.", 403);
            } else {
                throw new BadRequestException("La requête doit contenir le paramètre 'commande'.", 400);
            }

        }
    }

    #[Route('/toggle-commande-delivered', name: 'ajax-toggle-commande-delivered')]
    public function toggleDelivered(Request $request, CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest() and $request->query->has('commande')) {
            $commande = $commandeRepository->find($request->query->get('commande'));
            if (is_null($commande)) {
                throw new BadRequestException("Internal error", 500);
            } else {
                $commande->setDelivered(!$commande->getDelivered());
                $em->flush();
                return new JsonResponse(json_encode($commande->toArray()), 200, [], true);
            }
        } else {
            if ($request->query->has('commande')) {
                throw new BadRequestException("Mauvaise requête, elle doit être de type XmlHttp.", 403);
            } else {
                throw new BadRequestException("La requête doit contenir le paramètre 'commande'.", 400);
            }

        }
    }
}