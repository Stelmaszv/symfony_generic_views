<?php

namespace App\Generic\Api;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericDetailController extends AbstractController
{
    protected ?string $entity = null;
    protected int $perPage = 0;
    protected ManagerRegistry $managerRegistry;
    private SerializerInterface $serializer;
    private int $id = 0;

    public function get(ManagerRegistry $doctrine, SerializerInterface $serializer, int $id): JsonResponse
    {
        $this->managerRegistry = $doctrine;
        $this->serializer = $serializer;
        $this->id = $id;

        return new JsonResponse($this->getResponse(), JsonResponse::HTTP_OK);
    }

    protected function onQuerySet(ObjectRepository $repository): ?object
    {
        return $repository->find($this->id);
    }

    private function normalize(object $object): array
    {
        return $this->serializer->normalize($object, null, [
            'groups' => 'api',
            'circular_reference_handler' => function () {
                return null;
            },
        ]);
    }

    private function getResponse(): array
    {
        $car = $this->getObject();

        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        
        return $this->normalize($car);
    }

    private function getObject(): object
    {
        return $this->onQuerySet($this->managerRegistry->getRepository($this->entity));
    }
}