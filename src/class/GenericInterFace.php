<?php
namespace App\class;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
interface GenericInterFace{
    public function onQuerySet(ServiceEntityRepository $entityManager);
}