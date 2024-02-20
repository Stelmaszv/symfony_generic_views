<?php

namespace App\Generic\Api;

use ReflectionClass;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericCreateController extends AbstractController
{
    protected ?string $entity = null;
    protected ?string $dto = null;

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private ManagerRegistry $doctrine;

    public function __invoke(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        return $this->create($request, $serializer, $validator, $doctrine);
    }

    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        $this->initialize($serializer, $validator, $doctrine);
        $data = $request->getContent();

        if (empty($data)) {
            return $this->respondWithError('No data provided', JsonResponse::HTTP_BAD_REQUEST);
        }

        $dto = $this->deserializeDto($data);

        $errors = $this->validateDto($dto);
        if (!empty($errors)) {
            return $this->validationErrorResponse($errors);
        }

        $this->processEntity($dto);

        return $this->respondWithSuccess('Car added successfully', JsonResponse::HTTP_CREATED);
    }

    protected function initialize(SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): void
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
    }

    private function deserializeDto(string $data)
    {
        return $this->serializer->deserialize($data, $this->dto, 'json');
    }

    private function validateDto($dto): array
    {
        return iterator_to_array($this->validator->validate($dto));
    }

    private function processEntity($dto): void
    {
        $entity = new $this->entity();
        $reflectionClass = new ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();

            if ($propertyName !== 'id') {
                $propertyTypeName = $propertyType->__toString();
                $object = $this->getObject($propertyTypeName);
                $method = 'set' . ucfirst($propertyName);

                if ($object !== null && property_exists($dto, 'company') && $dto->company !== null) {
                    $objectRepository = $this->doctrine->getRepository($object::class);
                    $entity->setCompany($objectRepository->find($dto->company));
                } else {
                    $entity->$method($dto->$propertyName);
                }
            }
        }

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    private function getObject(string $type): ?object
    {
        $type = ltrim($type, '?');

        if (strpos($type, '\\') === false) {
            return null;
        }

        $nameSpace = '\\' . $type;

        return new $nameSpace;
    }

    private function respondWithError(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse(['errors' => ['message' => $message]], $statusCode);
    }

    private function validationErrorResponse(array $errors): JsonResponse
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }
        return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
    }

    private function respondWithSuccess(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse(['message' => $message], $statusCode);
    }
}