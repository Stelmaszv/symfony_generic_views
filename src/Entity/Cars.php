<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    /**
     * @Groups("api")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Groups("api")
     */
    private ?string $name = null;

    /**
     * @Groups("api")
     */
    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Company $company = null;

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

    /**
     * @Groups("api")
     */
    public function getCompany(): ?array
    {
        if ($this->company === null) {
            return null;
        }
        
        return [
            'id' => $this->company->getId(),
            'name' => $this->company->getName()
        ];

    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
