<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, article>
     */
    #[ORM\OneToMany(targetEntity: article::class, mappedBy: 'commentaire')]
    private Collection $article_id;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: user::class, mappedBy: 'commentaire')]
    private Collection $auteur_id;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $created_at = null;

    public function __construct()
    {
        $this->article_id = new ArrayCollection();
        $this->auteur_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, article>
     */
    public function getArticleId(): Collection
    {
        return $this->article_id;
    }

    public function addArticleId(article $articleId): static
    {
        if (!$this->article_id->contains($articleId)) {
            $this->article_id->add($articleId);
            $articleId->setCommentaire($this);
        }

        return $this;
    }

    public function removeArticleId(article $articleId): static
    {
        if ($this->article_id->removeElement($articleId)) {
            // set the owning side to null (unless already changed)
            if ($articleId->getCommentaire() === $this) {
                $articleId->setCommentaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getAuteurId(): Collection
    {
        return $this->auteur_id;
    }

    public function addAuteurId(user $auteurId): static
    {
        if (!$this->auteur_id->contains($auteurId)) {
            $this->auteur_id->add($auteurId);
            $auteurId->setCommentaire($this);
        }

        return $this;
    }

    public function removeAuteurId(user $auteurId): static
    {
        if ($this->auteur_id->removeElement($auteurId)) {
            // set the owning side to null (unless already changed)
            if ($auteurId->getCommentaire() === $this) {
                $auteurId->setCommentaire(null);
            }
        }

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
