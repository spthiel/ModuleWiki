<?php

namespace App\Entity;

use App\Repository\VersionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersionRepository::class)]
class Version
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $major = null;

    #[ORM\Column]
    private ?int $minor = null;

    #[ORM\Column]
    private ?int $patch = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $addition = null;

    //TODO: Add download

    #[ORM\ManyToOne(inversedBy: 'versions')]
    private ?Module $module = null;

    #[ORM\OneToMany(mappedBy: 'version', targetEntity: Changelog::class)]
    private Collection $changelogs;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releasedate = null;

    public function __construct()
    {
        $this->changelogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return sprintf("v%d.%d.%d%s", $this->getMajor(), $this->getMinor(), $this->getPatch(), $this->getAddition() ? "-" . $this->getAddition() : "");
    }

    public function getMajor(): ?int
    {
        return $this->major;
    }

    public function setMajor(int $major): self
    {
        $this->major = $major;

        return $this;
    }

    public function getMinor(): ?int
    {
        return $this->minor;
    }

    public function setMinor(int $minor): self
    {
        $this->minor = $minor;

        return $this;
    }

    public function getPatch(): ?int
    {
        return $this->patch;
    }

    public function setPatch(int $patch): self
    {
        $this->patch = $patch;

        return $this;
    }

    public function getAddition(): ?string
    {
        return $this->addition;
    }

    public function setAddition(string $addition): self
    {
        $this->addition = $addition;

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
            $changelog->setVersion($this);
        }

        return $this;
    }

    public function removeChangelog(Changelog $changelog): self
    {
        if ($this->changelogs->removeElement($changelog)) {
            // set the owning side to null (unless already changed)
            if ($changelog->getVersion() === $this) {
                $changelog->setVersion(null);
            }
        }

        return $this;
    }

    public function getReleasedate(): ?\DateTimeInterface
    {
        return $this->releasedate;
    }

    public function setReleasedate(\DateTimeInterface $releasedate): self
    {
        $this->releasedate = $releasedate;

        return $this;
    }
}
