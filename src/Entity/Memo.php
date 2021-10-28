<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "memo")]
#[ORM\Entity]
class Memo
{
    public static function create(string $title, int $day, ?string $description, bool $done = false)
    {
        return (new Memo())
            ->setTitle($title)
            ->setDescription($description)
            ->setDay($day)
            ->setDone($done)
            ;
    }

    #[ORM\Column(name: "id", type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Id]
    private ?int $id;

    #[ORM\Column(name: "title", type: "string", nullable: false)]
    private string $title;

    #[ORM\Column(name: "description", type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: "day", type: "integer")]
    private int $day = 0;

    #[ORM\Column(name: "is_done", type: "boolean")]
    private bool $done = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description = null): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setDay(int $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function isDone(?bool $done = null): static|bool
    {
        if (null === $done) {
            return $this->done;
        }

        return $this->setDone($done);
    }

    public function getDone(): bool
    {
        return $this->done;
    }

    public function setDone(bool $done): static
    {
        $this->done = $done;

        return $this;
    }
}