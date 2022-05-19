<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociationRepository::class)
 */
class Association
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Don::class, mappedBy="association")
     */
    private $Don;

    public function __construct()
    {
        $this->Don = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Don[]
     */
    public function getDon(): Collection
    {
        return $this->Don;
    }

    public function addDon(Don $don): self
    {
        if (!$this->Don->contains($don)) {
            $this->Don[] = $don;
            $don->setAssociation($this);
        }

        return $this;
    }

    public function removeDon(Don $don): self
    {
        if ($this->Don->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getAssociation() === $this) {
                $don->setAssociation(null);
            }
        }

        return $this;
    }
}
