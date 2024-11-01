<?php

namespace Models;

use Database\DataAccess\ORM;

class User extends ORM {
    protected static ?array $columnTypes = null;
    // public function __construct(
    //     private ?int $id = null,
    //     private string $userName,
    //     private string $encryptedEmail,
    //     private string $hashedPassword,
    //     private ?string $createdAt
    // ) {}

    // public function getId(): ?int {
    //     return $this->id;
    // }

    // public function setId(int $id): void {
    //     $this->id = $id;
    // }

    // public function getUserName(): string {
    //     return $this->userName;
    // }

    // public function setUserName(string $userName): void {
    //     $this->userName = $userName;
    // }

    // public function getEncryptedEmail(): string {
    //     return $this->encryptedEmail;
    // }

    // public function setEncryptedEmail(string $encryptedEmail): void {
    //     $this->encryptedEmail = $encryptedEmail;
    // }
    // public function getHashedPassword(): string {
    //     return $this->hashedPassword;
    // }
    // public function setHashedPassword(string $hashedPassword): void {
    //     $this->hashedPassword = $hashedPassword;
    // }
    // public function getCreatedAt(): string
    // {
    //     return $this->createdAt;
    // }
    // public function setCreatedAt(string $createdAt): void
    // {
    //     $this->createdAt = $createdAt;
    // }

}