<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericListController extends AbstractController
{
    /**
     * @Route("/api/cars", name="api_cars", methods={"GET"})
     */
    public function getCars(CarsRepository $carsRepository, SerializerInterface $serializer): JsonResponse
    {
        $entities = $carsRepository->findAll();

        $data = $serializer->normalize($entities, null, [
            'groups' => 'api',
            'circular_reference_handler' => function () {
                return null;
            },
        ]);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/car/{id}", name="api_car", methods={"GET"})
     */
    public function getCarById(CarsRepository $carsRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $car = $carsRepository->find($id);

        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $serializer->normalize($car, null, [
            'groups' => 'api',
            'circular_reference_handler' => function () {
                return null;
            },
        ]);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}