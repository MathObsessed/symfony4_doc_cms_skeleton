<?php

namespace App\Service;

use App\Entity\Document;
use App\Repository\DocumentRepository;

class DocumentService
{
    private $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string[]
     */
    public function findAll(): array
    {
        return array_map(function (Document $document) {
            return $document->getName();
        }, $this->repository->findAll());
    }
}
