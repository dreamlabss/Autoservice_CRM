<?php

namespace App\Entity;

use App\Repository\AutoServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutoServiceRepository::class)]
class AutoService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Consignment::class)]
    private Collection $consignments;

    public function __construct()
    {
        $this->consignments = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Consignment>
     */
    public function getConsignments(): Collection
    {
        return $this->consignments;
    }

    public function addConsignment(Consignment $consignment): self
    {
        if (!$this->consignments->contains($consignment)) {
            $this->consignments->add($consignment);
            $consignment->setService($this);
        }

        return $this;
    }

    public function removeConsignment(Consignment $consignment): self
    {
        if ($this->consignments->removeElement($consignment)) {
            // set the owning side to null (unless already changed)
            if ($consignment->getService() === $this) {
                $consignment->setService(null);
            }
        }

        return $this;
    }
}
