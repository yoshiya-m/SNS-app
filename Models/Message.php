<?php

namespace Models;
use Database\DataAccess\ORM;
class Message extends ORM
{
    protected static ?array $columnTypes = null;
    // public function __construct(
    //     private int $messageId,
    //     private string $encryptedContent,
    //     private int $senderId,
    //     private int $receiverId,
    //     private string $createdAt,
    // ) {}
    
    // public function getMessageId(): int {
    //     return $this->messageId;
    // }
    // public function setMessageId(int $messageId): void {
    //     $this->messageId = $messageId;
    // }
    // public function getEncryptedContent(): string {
    //     return $this->encryptedContent;
    // }

    // public function setEncryptedContent(string $encryptedContent): void {
    //     $this->encryptedContent = $encryptedContent;
    // }
    // public function getSenderId(): int {
    //     return $this->senderId;
    // }
    // public function setSenderId(int $senderId): void {
    //     $this->senderId = $senderId;
    // }
    // public function getReceiverId(): int {
    //     return $this->receiverId;
    // }
    // public function setReceiverId(int $receiverId): void {
    //     $this->receiverId = $receiverId;
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