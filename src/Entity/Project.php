<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;
use DateTimeInterface;

/**
 * @ApiResource(
 *     normalizationContext = {"groups"={"project:read"}},
 *     denormalizationContext = {"groups" = {"project:write"}},
 *     collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('edit', object)"},
 *         "delete"={"security"="is_granted('delete', object)"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("project:read", "user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read", "project:write"})
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"project:read", "project:write"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("project:read")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("project:read")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("project:read")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="project", orphanRemoval=true)
     * @ApiSubresource
     * @Groups("project:read")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="projects" , cascade={"persist"} )
     * @Groups({"project:read", "project:write"})
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"project:read"})
     */
    private $author;


    public function __construct()
    {
        $this->isPublished = false;
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    /**
     * Get the value of isPublished
     */
    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    /**
     * Set the value of isPublished
     *
     * @return  self
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get the value of publishedAt
     */
    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Set the value of publishedAt
     *
     * @return  self
     */
    public function setPublishedAt(DateTimeInterface $publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of picture
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getAuthor(): ?Utilisateur
    {
        return $this->author;
    }

    public function setAuthor(?Utilisateur $author): self
    {
        $this->author = $author;

        return $this;
    }

}
