<?php

namespace Entity;

class User
{
    /** @var null|int */
    private $id;
    /** @var null|string */
    private $name;
    /** @var null|string */
    private $gender;
    /** @var null|\DateTimeImmutable */
    private $birthDate;
    /** @var Article[] */
    private $articles;

    public function __construct($userAttributes) {}

    /** @return null|int */
    public function getId(): ?int {}

    /** @return null|string */
    public function getName(): ?string {}

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self {}

    /** @return null|string */
    public function getGender(): ?string {}

    /**
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender): self {}

    /** @return null|\DateTimeImmutable */
    public function getBirthDate(): ?\DateTimeImmutable {}

    /**
     * @param \DateTimeImmutable $birthDate
     * @return $this
     */
    public function setBirthDate(\DateTimeImmutable $birthDate): self {}

    /**
     * @param $articleAttributes
     * @return Article
     */
    public function createArticle($articleAttributes): Article
    {
        $article = new Article($articleAttributes);
        $article->setAuthor($this);
    }

    /** @return Article[] */
    public function getArticles(): array {}
}