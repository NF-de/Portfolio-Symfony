<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Projets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $technologies = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien_demo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien_github = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    // Modification : nullable: true pour éviter l'erreur au moment de l'envoi du formulaire
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rapportPdf = null;

    #[ORM\Column]
    private ?bool $en_vedette = false; // Par défaut à false pour éviter les erreurs de null
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getTechnologies(): ?string
    {
        return $this->technologies;
    }

    public function setTechnologies(?string $technologies): static
    {
        $this->technologies = $technologies;
        return $this;
    }

    public function getLienDemo(): ?string
    {
        return $this->lien_demo;
    }

    public function setLienDemo(?string $lien_demo): static
    {
        $this->lien_demo = $lien_demo;
        return $this;
    }

    public function getLienGithub(): ?string
    {
        return $this->lien_github;
    }

    public function setLienGithub(?string $lien_github): static
    {
        $this->lien_github = $lien_github;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }

    // Modification : le paramètre accepte ?\DateTime (null)
    public function setDateCreation(?\DateTime $date_creation): static
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function isEnVedette(): ?bool
    {
        return $this->en_vedette;
    }

    public function setEnVedette(bool $en_vedette): static
    {
        $this->en_vedette = $en_vedette;
        return $this;
    }

    public function getRapportPdf(): ?string
    {
        return $this->rapportPdf;
    }

    public function setRapportPdf(?string $rapportPdf): static
    {
        $this->rapportPdf = $rapportPdf;
        return $this;
    }

    /**
     * Automatisation de la date de création
     */
    #[ORM\PrePersist]
    public function setInitialDate(): void
    {
        if ($this->date_creation === null) {
            $this->date_creation = new \DateTime();
        }
    }
}