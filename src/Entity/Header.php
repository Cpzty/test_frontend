<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity()]
#[ORM\Table(name: 'process_header')]
class Header
{
     #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $executionDate = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $summaryFile = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $detailFile = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'header', targetEntity: Summary::class)]
    private Collection $summaries;

    public function __construct()
    {
        $this->summaries = new ArrayCollection();
        $this->createdAt = new \DateTime(); // default to now
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExecutionDate(): ?\DateTimeInterface
    {
        return $this->executionDate;
    }

    public function setExecutionDate(\DateTimeInterface $executionDate): self
    {
        $this->executionDate = $executionDate;
        return $this;
    }

    public function getSummaryFile(): ?string
    {
        return $this->summaryFile;
    }

    public function setSummaryFile(string $summaryFile): self
    {
        $this->summaryFile = $summaryFile;
        return $this;
    }

    public function getDetailFile(): ?string
    {
        return $this->detailFile;
    }

    public function setDetailFile(string $detailFile): self
    {
        $this->detailFile = $detailFile;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection|Summary[]
     */
    public function getSummaries(): Collection
    {
        return $this->summaries;
    }
}
