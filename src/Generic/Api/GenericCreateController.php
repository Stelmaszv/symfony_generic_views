<?php

namespace App\Generic\Api;

use App\Generic\Api\GenericTrait;
use App\Generic\ApiInterFace;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericCreateController extends AbstractController implements GenricInterface
{
    use GenericTrait;

    public function __invoke(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        $this->initialize($request, $serializer, $validator, $doctrine);
        return $this->createAction($request, $serializer, $validator, $doctrine);
    }

    protected function initialize(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): void
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
        $this->request = $request;
    }

    public function createAction(): JsonResponse
    {
        $data = $this->request->getContent();

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