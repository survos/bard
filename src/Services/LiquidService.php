<?php

namespace App\Services;

use Liquid\Liquid;
use Liquid\Tag\TagComment;
use Liquid\Tag\TagIf;
use Liquid\Tag\TagInclude;
use Liquid\Template;
use Liquid\Variable;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class LiquidService
{
    public function __construct(private ParameterBagInterface $bag)
    {
        Liquid::set('INCLUDE_SUFFIX', 'tpl');
        Liquid::set('INCLUDE_PREFIX', '');


// Uncomment the following lines to enable cache
//$cache = array('cache' => 'file', 'cache_dir' => $protectedPath . 'cache' . DIRECTORY_SEPARATOR);
// or if you have APC installed
//$cache = array('cache' => 'apc');
//$liquid->setCache($cache);

    }

    // convert all .tpl files in a directory to .html.twig
    public function toTwig($dir) {


        $protectedPath = sprintf("%s/liquid/protected/", $this->bag->get('kernel.project_dir'));
        assert(file_exists($protectedPath), "missing dir $protectedPath");

        $liquid = new Template($protectedPath . 'templates' . DIRECTORY_SEPARATOR);
        $liquidTemplate = $liquid->parse(file_get_contents($protectedPath . 'templates' . DIRECTORY_SEPARATOR . 'index.tpl'));


        foreach ($liquidTemplate->getRoot()->getNodelist() as $node) {
            if (is_object($node)) {
                switch ($nodeClass = $node::class) {
                    case Variable::class:
                    case TagIf::class:
                    case TagInclude::class:
                    case TagComment::class:
                        dump($node);
                        break;
                    default:
                        assert(false, "Missing " . $nodeClass);
                }
            } else {

                dump($node);
            }
        }

        $assigns = array(
            'document' => array(
                'title' => 'This is php-liquid',
                'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
                'copyright' => 'Guz Alexander - All rights reserved.',
            ),
            'blog' => array(
                array(
                    'title' => 'Blog Title 1',
                    'content' => 'Nunc putamus parum claram',
                    'tags' => array('claram', 'parum'),
                    'comments' => array(
                        array(
                            'title' => 'First Comment',
                            'message' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr',
                        ),
                    ),
                ),
                array(
                    'title' => 'Blog Title 2',
                    'content' => 'Nunc putamus parum claram',
                    'tags' => array('claram', 'parum', 'freestyle'),
                    'comments' => array(
                        array(
                            'title' => 'First Comment',
                            'message' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr',
                        ),
                        array(
                            'title' => 'Second Comment',
                            'message' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr',
                        ),
                    ),
                ),

            ),
            'array' => array('one', 'two', 'three', 'four'),
        );

    }


}
