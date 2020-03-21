<?php

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\MatchFilter;

/**
 * @ApiResource
 * @ApiFilter(MatchFilter::class, properties={"title"})
 */

class Play
{

    /**
     * @ApiProperty(identifier=true)
     *
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $play_id;

    /**
     * @var \DateTimeInterface
     */
    public $date;

    /**
     * @var string
     */
    public $message;
}