<?php

namespace App\Twig;

use Gajus\Dindent\Indenter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class IndentExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('html_indent', [$this, 'indent']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function indent($content)
    {
        try {
            $indenter = new Indenter();
            $cleanHtml = $indenter->indent($content);
            return $cleanHtml;
        } catch (\Exception $exception) {
            // probably not installed
        }

        $config = [
            'clean'       => false,
            // 'doctype'     => 'omit',
            'indent'      => 2, // auto
            'output-html' => true,
            'tidy-mark'   => false,
            'wrap'        => 120];

        try {
            $tidy = new \tidy();
            $content = $tidy->repairString($content, $config);
            return $content;

        } catch (\Exception $e) {
            //
            $content = $e->getMessage() . "\n" . $content;
        }


        // ...
    }
}
