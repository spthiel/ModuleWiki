<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Element::class, orphanRemoval: true)]
    private Collection $elements;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Version::class)]
    private Collection $versions;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Type::class, orphanRemoval: true)]
    private Collection $types;

    // TODO: Add author

    public function __construct()
    {
        $this->elements = new ArrayCollection();
        $this->versions = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Element>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    /**
     * @return Element[]
     */
    public function getElementsByType(Type $type): array
    {
        $out = [];
        foreach ($this->getElements() as $element) {
            if ($element->getType() === $type) {
                $out[] = $element;
            }
        }
        return $out;
    }

    /**
     * @param Type $type
     * @return Element[][]
     */
    public function getElementsByTypeAndCategories(Type $type): array
    {
        $out = [];
        foreach ($this->getElements() as $element) {
            if ($element->getType() === $type) {
                $out[$element->getCategory()][] = $element;
            }
        }

        return $out;
    }

    public function addElement(Element $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements->add($element);
            $element->setModule($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getModule() === $this) {
                $element->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Version>
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(Version $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions->add($version);
            $version->setModule($this);
        }

        return $this;
    }

    public function removeVersion(Version $version): self
    {
        if ($this->versions->removeElement($version)) {
            // set the owning side to null (unless already changed)
            if ($version->getModule() === $this) {
                $version->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setModule($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getModule() === $this) {
                $type->setModule(null);
            }
        }

        return $this;
    }
}
