<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\CompanyRepository;
use App\Generic\Api\Trait\EntityApiGeneric;
use Doctrine\Common\Collections\Collection;
use App\Generic\Api\Interfaces\ApiInterface;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company implements ApiInterface
{
    use EntityApiGeneric;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Cars::class)]
    private Collection $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Cars>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Cars $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setCompany($this);
        }

        return $this;
    }

    public function removeCar(Cars $car): self
    {
        if ($this->cars->removeElement($car)) {
            if ($car->getCompany() === $this) {
                $car->setCompany(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
