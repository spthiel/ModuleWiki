<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Michelf\MarkdownExtra;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class Element
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $extendedName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $example = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $permission = null;

    #[ORM\ManyToOne(inversedBy: 'elements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Version $since = null;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: Link::class, orphanRemoval: true)]
    private Collection $links;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $related;

    #[ORM\OneToMany(mappedBy: 'version', targetEntity: Changelog::class)]
    private Collection $changelogs;

    #[ORM\ManyToOne(inversedBy: 'elements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'elements')]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $shortDescription = null;

    public function __construct()
    {
        $this->links = new ArrayCollection();
        $this->related = new ArrayCollection();
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

    public function getExtendedName(): ?string
    {
        return $this->extendedName;
    }

    public function setExtendedName(string $extendedName): self
    {
        $this->extendedName = $extendedName;

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

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(?string $example): self
    {
        $this->example = $example;

        return $this;
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }

    public function setPermission(?string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getSince(): ?Version
    {
        return $this->since;
    }

    public function setSince(?Version $since): self
    {
        $this->since = $since;

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setElement($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getElement() === $this) {
                $link->setElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRelated(): Collection
    {
        return $this->related;
    }

    public function addRelated(self $related): self
    {
        if (!$this->related->contains($related)) {
            $this->related->add($related);
        }

        return $this;
    }

    public function removeRelated(self $related): self
    {
        $this->related->removeElement($related);

        return $this;
    }

    /**
     * @return Collection<int, Changelog>
     */
    public function getChangelogs(): Collection
    {
        return $this->changelogs;
    }

    public function addChangelog(Changelog $changelog): self
    {
        if (!$this->changelogs->contains($changelog)) {
            $this->changelogs->add($changelog);
            $changelog->setElement($this);
        }

        return $this;
    }

    public function removeChangelog(Changelog $changelog): self
    {
        if ($this->changelogs->removeElement($changelog)) {
            // set the owning side to null (unless already changed)
            if ($changelog->getElement() === $this) {
                $changelog->setElement(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function formatDescription(): string
    {
        $parser = new MarkdownExtra();
        $parser->hard_wrap = true;
        $parser->code_class_prefix = "language-";
        $parser->code_block_content_func = $parser->code_span_content_func = fn($input) =>$input;
        return str_replace("<code", "<code data-highlight-target=\"code\"", $parser->transform(htmlspecialchars($this->getDescription())));
    }
}
