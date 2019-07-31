<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ChatMessageRepository")
 */
class ChatMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiFilter(SearchFilter::class, strategy="exact")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @ApiFilter(SearchFilter::class, strategy="partial")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $msgTo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $messageText;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUSerTo;

    /**
     * @var object
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chatMessage")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $messageDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMsgTo(): ?string
    {
        return $this->msgTo;
    }

    public function setMsgTo(?string $msgTo): self
    {
        $this->msgTo = $msgTo;

        return $this;
    }

    public function getMessageText(): ?string
    {
        return $this->messageText;
    }

    public function setMessageText(?string $messageText): self
    {
        $this->messageText = $messageText;

        return $this;
    }

    public function getIdUSerTo(): ?int
    {
        return $this->idUSerTo;
    }

    public function setIdUSerTo(int $idUSerTo): self
    {
        $this->idUSerTo = $idUSerTo;

        return $this;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->messageDate;
    }

    public function setMessageDate(?\DateTimeInterface $messageDate): self
    {
        $this->messageDate = $messageDate;

        return $this;
    }

    /**
     * @return object
     */
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * @param object $user
     * @return ChatMessage
     */
    public function setUser(object $user): ChatMessage
    {
        $this->user = $user;
        return $this;
    }

}
