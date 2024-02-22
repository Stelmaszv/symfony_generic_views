<?php

namespace App\Generic\Web;

use App\Generic\Web\Flash;

use App\Generic\Web\Redirect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class GenericDeleteController extends AbstractController
{
    protected ?string $entity = null;
    protected ?string $redirectTo = null;
    protected EntityManagerInterface $entityManager;
    protected ServiceEntityRepository $repository;
    protected Redirect $redirect;
    protected Flash $flash;
    protected object $item;
    protected int $id;

    public function __invoke(EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        $this->initialize($entityManager, $id);
        return $this->deleteAction();
    }

    protected function initialize(EntityManagerInterface $entityManager, int $id): void
    {
        $this->entityManager = $entityManager;
        $this->id = $id;
        $this->repository = $this->entityManager->getRepository($this->entity);
        $this->redirect = new Redirect();
        $this->flash = new Flash($this);
        $this->checkData();
    }

    protected function beforeDelete(): void {}
    protected function afterDelete(): void {}
    protected function setRedirect(): void {}
    protected function setFlashMessage(): void {}

    private function executeRedirect(): RedirectResponse
    {
        $this->setRedirect();

        if (!($this->redirect->isRedirect() || $this->redirectTo)) {
            throw new \Exception("Set redirectTo!");
        }

        return $this->redirect->isRedirect() ? $this->redirectToRoute($this->redirect->getName(), $this->redirect->getAttributes()) : $this->redirectToRoute($this->redirectTo);
    }

    private function deleteAction(): RedirectResponse
    {
        $this->delete();
        $this->checkFlash();
        return $this->executeRedirect();
    }

    private function checkFlash(): void
    {
        $this->setFlashMessage();
        if ($this->flash->isFlash()) {
            $this->addFlash(
                $this->flash->getType(),
                $this->flash->getMessage()
            );
        }
    }

    private function delete(): void
    {
        $this->beforeDelete();
        $this->entityManager->remove($this->item);
        $this->entityManager->flush();
        $this->afterDelete();
    }

    private function checkData(): void
    {
        $item = $this->entityManager->getRepository($this->entity)->find($this->id);

        if (!$item) {
            throw $this->createNotFoundException('Not found with id: ' . $this->id);
        }

        $this->item = $item;

        if (!$this->entity) {
            throw new \Exception("Entity is not defined in controller " . get_class($this) . "!");
        }
    }
}
