<?php

namespace App\Generic\Api;

use App\Generic\ApiInterFace;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericUpdateController extends AbstractController implements GenricInterface
{
    use GenericTrait;
    protected int $id;

    public function __invoke(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $this->initialize($request, $serializer, $validator, $doctrine, $id);
        return $this->update();
    }

    protected function initialize(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine, int $id): void
    {
        $this->request = $request;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
        $this->id = $id;
    }

    public function update(): JsonResponse
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

        return $this->respondWithSuccess('Car updated successfully', JsonResponse::HTTP_CREATED);
    }

    public function getEntity() : ApiInterFace {
        return $this->doctrine->getRepository($this->entity)->find($this->id);
    }
}
