<?php
// src/DataTransformer/WorkInputDataTransformer.php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\Work;

final class WorkInputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $existingWork = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        $existingWork->title = $data->title;
        return $existingWork;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Work) {
            return false;
        }

        return Work::class === $to && null !== ($context['input']['class'] ?? null);
    }
}