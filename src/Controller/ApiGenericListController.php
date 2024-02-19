<?php

namespace App\Controller;

use App\Controller\DTO\CarDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Cars;
use App\Repository\CarsRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function getCarById(CarsRepository $carsRepository, SerializerInterface $serializer, int $id): JsonResponse
    {
        $car = $carsRepository->find($id);

        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $serializer->normalize($car, null, [
            'groups' => 'api',
            'circular_reference_handler' => function () {
                return null;
            },
        ]);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/car", name="api_car_add", methods={"POST"})
     */
    public function addCar(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        $data = $request->getContent();
        $carDto = $serializer->deserialize($data, CarDto::class, 'json');

        $car = new Cars();
        $car->setName($carDto->name);

        $errors = $validator->validate($carDto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($car);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Car added successfully'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/api/car/{id}", name="api_car_update", methods={"PUT"})
     */
    public function updateCar(Request $request, CarsRepository $carsRepository, SerializerInterface $serializer, ValidatorInterface $validator, int $id, ManagerRegistry $doctrine): JsonResponse
    {
        $car = $carsRepository->find($id);
    
        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        $data = $request->getContent();
        $carDto = $serializer->deserialize($data, CarDto::class, 'json');
    
        $car->setName($carDto->name);

        $errors = $validator->validate($carDto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        $entityManager = $doctrine->getManager();
        $entityManager->persist($car);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Car updated successfully'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/car/{id}", name="api_car_delete", methods={"DELETE"})
     */
    public function deleteCar(CarsRepository $carsRepository, int $id, ManagerRegistry $doctrine): JsonResponse
    {
        $car = $carsRepository->find($id);
    
        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        $entityManager = $doctrine->getManager();
        $entityManager->remove($car);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Car deleted successfully'], JsonResponse::HTTP_OK);
    }
}