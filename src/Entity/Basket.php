<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consignment $consignment = null;

    #[ORM\Column]
    private ?float $cost = null;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: PartInstall::class)]
    private Collection $partInstalls;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: Service::class)]
    private Collection $services;

    public function __construct()
    {
        $this->partInstalls = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsignment(): ?Consignment
    {
        return $this->consignment;
    }

    public function setConsignment(?Consignment $consignment): self
    {
        $this->consignment = $consignment;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return Collection<int, PartInstall>
     */
    public function getPartInstalls(): Collection
    {
        return $this->partInstalls;
    }

    public function addPartInstall(PartInstall $partInstall): self
    {
        if (!$this->partInstalls->contains($partInstall)) {
            $this->partInstalls->add($partInstall);
            $partInstall->setBasket($this);
        }

        return $this;
    }

    public function removePartInstall(PartInstall $partInstall): self
    {
        if ($this->partInstalls->removeElement($partInstall)) {
            // set the owning side to null (unless already changed)
            if ($partInstall->getBasket() === $this) {
                $partInstall->setBasket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setBasket($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getBasket() === $this) {
                $service->setBasket(null);
            }
        }

        return $this;
    }
}
