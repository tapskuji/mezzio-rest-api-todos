<?php

declare(strict_types=1);

namespace Todos\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="todos")
 **/
class Todo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", unique=true)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="integer", name="is_complete", nullable=false)
     */
    protected $isComplete;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $modified;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getIsComplete(): int
    {
        return $this->isComplete;
    }

    /**
     * @param int $isComplete
     */
    public function setIsComplete(int $isComplete): void
    {
        $this->isComplete = $isComplete;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime|null $created
     */
    public function setCreated(\DateTime $created = null): void
    {
        $this->created = (!$created) ? new \DateTime("now") : $created;
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime|null $modified
     */
    public function setModified(\DateTime $modified = null): void
    {
        $this->modified = (!$modified) ? new \DateTime("now") : $modified;
    }

    /**
     * Get todo data as an array
     * @return array|mixed
     */
    public function getTodo(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'isComplete' => ($this->getIsComplete() ? true : false),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Set todos fields for creating a new entry
     * @param array $requestParams
     * @throws \Exception
     */
    public function setTodo(array $requestParams): void
    {
        // do not set id
        $this->setTitle($requestParams['title']);
        $this->setIsComplete($requestParams['isComplete'] ? 1 : 0);
        $this->setCreated(new \DateTime("now"));
        $this->setModified(new \DateTime("now"));
    }

    /**
     * Update todo
     * @param array $requestParams
     * @throws \Exception
     */
    public function updateTodo(array $requestParams): void
    {
        if (isset($requestParams['title'])) {
            $this->setTitle($requestParams['title']);
        }
        if (isset($requestParams['isComplete'])) {
            $this->setIsComplete($requestParams['isComplete'] ? 1 : 0);
        }
        //$this->setModified(new \DateTime("now"));
    }
}
