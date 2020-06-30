<?php

namespace App\Entity;

use App\Repository\TblCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TblCommentRepository::class)
 */
class TblComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $comment_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $parent_comment_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $comment_sender_name;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentId(): ?int
    {
        return $this->comment_id;
    }

    public function setCommentId(int $comment_id): self
    {
        $this->comment_id = $comment_id;

        return $this;
    }

    public function getParentCommentId(): ?int
    {
        return $this->parent_comment_id;
    }

    public function setParentCommentId(int $parent_comment_id): self
    {
        $this->parent_comment_id = $parent_comment_id;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommentSenderName(): ?string
    {
        return $this->comment_sender_name;
    }

    public function setCommentSenderName(string $comment_sender_name): self
    {
        $this->comment_sender_name = $comment_sender_name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
