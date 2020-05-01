<?php
// src/DataTransformer/WorkOutputDataTransformer.php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\WorkOutput;
use App\Entity\Work;

final class WorkOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = new WorkOutput();

        /** @var Work $data */
        $output->title = $data->getTitle();
        $output->year = $data->getYear();
        $output->id = $data->getId();
        $output->longTitle = $data->getLongTitle();
        $output->totalWords = $data->getTotalWords();
        $output->full_text = substr($data->getFullText(), 0, 500);
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return WorkOutput::class === $to && $data instanceof Work;
    }
}