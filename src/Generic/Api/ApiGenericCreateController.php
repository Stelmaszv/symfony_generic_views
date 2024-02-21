<?php

namespace App\Generic\Api;

use App\Generic\Api\Genric;
use App\Generic\ApiInterFace;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericCreateController extends AbstractController implements Genric
{
    use Generic;

    public function __invoke(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        return $this->create($request, $serializer, $validator, $doctrine);
    }

    protected function initialize(SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): void
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
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

    public function getEntity() : ApiInterFace {
        return new $this->entity();
    }

}