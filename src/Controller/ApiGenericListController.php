<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericListController extends AbstractController
{
    /**
     * @Route("/api/cars", name="api_cars", methods={"GET"})
     */
    public function list(CarsRepository $carsRepository, SerializerInterface $serializer): JsonResponse
    {
        $entities = $carsRepository->findAll();

        $data = $serializer->normalize($entities, null, [
            'groups' => 'api',
            'circular_reference_handler' => function ($object) {
                return null;
            },
        ]);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}

dqwed