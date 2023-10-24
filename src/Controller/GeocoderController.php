<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Exceptions\PositionNotFoundException;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Services\AddressPositionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeocoderController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/')]
    public function geocoder(
        Request $request,
        AddressPositionService $service,
    ): Response {
        $success = false;
        $message = '';
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address, [
            'attr' => [
                'class' => 'col-md-6 mx-auto text-center',
            ],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $service->run($address);
                $success = true;
            } catch (PositionNotFoundException $exception) {
                $message = $exception->getMessage();
            }
        }

        return $this->render('geocoder/index.html.twig', [
            'form' => $form,
            'success' => $success,
            'message' => $message,
        ]);
    }
}
