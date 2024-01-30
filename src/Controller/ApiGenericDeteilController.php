<?php

namespace App\Controller;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiGenericDeteilController extends AbstractController
{
    /**
     * @Route("/api/car/{id}", name="api_car", methods={"GET"})
     */
    public function showCar(Cars $car, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->normalize($car, null, ['groups' => 'api']);
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}

