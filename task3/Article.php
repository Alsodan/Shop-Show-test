<?php

namespace Entity;


class Article
{
    /** @var null|int */
    private $id;
    /** @var null|string */
    private $title;
    /** @var null|string */
    private $content;
    /** @var null|User */
    private $author;

    public function __construct($articleAttributes) {}

    /** @return null|int */
    public function getId(): ?int {}

    /** @return null|string */
    public function getTitle(): ?string {}

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self {}

    /** @return null|string */
    public function getContent(): ?string {}

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self {}

    /** @return null|User */
    public function getAuthor(): ?User {}

    /**
     * @param User $user
     * @return $this
     */
    public function setAuthor(User $user): self {}
}