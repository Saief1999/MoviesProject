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
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $comment_sender_name;

    /**
     * @ORM\ManyToOne(targetEntity=Cinema::class, inversedBy="tblComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    /**
     * @ORM\Column(type="datetime")
     */
    private $replyTime;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }

    public function getReplyTime(): ?\DateTimeInterface
    {
        return $this->replyTime;
    }

    public function setReplyTime(\DateTimeInterface $replyTime): self
    {
        $this->replyTime = $replyTime;

        return $this;
    }
}
