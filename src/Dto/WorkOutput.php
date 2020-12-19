<?php
// src/Dto/WorkOutput.php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\TermFilter;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\MatchFilter;
# use ApiPlatform\Core\Bridge\Elasticsearch\ataProvider\Filter\MatchFilter;


/**
 * @ApiResource
 */

final class WorkOutput {
    /**
     * @ApiProperty(identifier=true)
     * @ ApiFilter(TermFilter::class)
     *
     * @var string
     */
    public $id;

    /**
     * @var string
     * @ ApiFilter(MatchFilter::class)
     */
    public $title;

    /**
     * @var string
     * @ ApiFilter(MatchFilter::class)
     */
    public $longTitle;

    /**
     * @var integer
     * @ ApiFilter(RangeFilter::class)
     */
    public $year;

    /**
     * @var integer
     * @ ApiFilter(TermFilter::class)
     */
    public $totalWords;

    /**
     * @var string
     * @ ApiFilter(TermFilter::class)
     */
    public $source;

    /**
     * @var string
     * @  ApiFilter(MatchFilter::class)
     */
    public $full_text;
}
