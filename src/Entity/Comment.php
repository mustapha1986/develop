<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext= {"groups" = {"comment:read"}},
 *     denormalizationContext= {"groups" = {"comment:write"}}
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"project:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read" , "comment:read" , "comment:write" })
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment:write"})
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }



    /**
     * Get the value of project
     */ 
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * Set the value of project
     *
     * @return  self
     */ 
    public function setProject($project): self
    {
        $this->project = $project;

        return $this;
    }
}
