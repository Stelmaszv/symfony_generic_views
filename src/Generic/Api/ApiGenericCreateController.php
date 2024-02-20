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
        $this->initialize($serializer,$validator,$doctrine);
        $data = $request->getContent();

        if (empty($data)) {
            return new JsonResponse(['errors' => ['message' => 'No data provided']], JsonResponse::HTTP_BAD_REQUEST);
        }

        $dto = $this->serializer->deserialize($data, $this->dto, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->validation($dto);
        }

        $this->setEntity($dto);

        return new JsonResponse(['message' => 'Car added successfully'], JsonResponse::HTTP_CREATED);
    }

    protected function initialize(SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): void
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
    }

    private function validation($dto) : JsonResponse
    {
        $errors = $this->validator->validate($dto);
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
    }

    private function setEntity($dto) : void
    {
        $entity = new $this->entity();
        $reflectionClass = new ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();

            if($propertyName !== 'id'){
                $propertyTypeName = $propertyType->__toString(); 

                $object = $this->getObject($propertyTypeName);
                $method = 'set'.ucfirst($propertyName);

                if($object !== null && $dto->company !== null ){
                    $ObjectRepository = $this->doctrine->getRepository($object::class);
                    $entity->setCompany($ObjectRepository->find($dto->company));
                }else{
                    $entity->$method($dto->$propertyName);
                }
            }

        }

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    private function getObject(string $type) : ?object
    {
        $type = ltrim($type, '?');


        if (strpos($type, '\\') === false) {
            return null;
        }
        
        $nameSpace = '\\'.$type;

        return new $nameSpace;
    }
}
