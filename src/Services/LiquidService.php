<?php

namespace App\Services;

use App\Entity\Template;
use Liquid\Document;
use Liquid\Liquid;
use Liquid\Tag\TagBlock;
use Liquid\Tag\TagComment;
use Liquid\Tag\TagExtends;
use Liquid\Tag\TagIf;
use Liquid\Tag\TagInclude;
use Liquid\Template as LiquidTemplate;
use Liquid\Variable;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Yaml\Yaml;

class LiquidService
{
    private string $ext = 'tpl';
    public function __construct(private LoggerInterface $logger)
    {
        Liquid::set('INCLUDE_SUFFIX', 'tpl');
        Liquid::set('INCLUDE_PREFIX', '');
        Liquid::set('INCLUDE_ALLOW_EXT', true);


// Uncomment the following lines to enable cache
//$cache = array('cache' => 'file', 'cache_dir' => $protectedPath . 'cache' . DIRECTORY_SEPARATOR);
// or if you have APC installed
//$cache = array('cache' => 'apc');
//$liquid->setCache($cache);
    }

    public function getTemplateExtension($ext) {
        $this->ext = $ext;
    }

    public function map($templateName) {
        return str_replace('.'  . $this->ext, '.html.twig', $templateName );
    }




    private function convert(Document $document)
    {

        $this->logger->info("document ", [$document]);
        $twigs = [];
        $nodeList = $document->getNodelist();

        foreach ($nodeList as $node) {

            if (is_object($node)) {
                $nodeClass = $node::class;
                $this->logger->info("converting node ", [$node]);
                switch ($nodeClass) {
                    case TagExtends::class:
                        // we don't need to recurse this.
                        /** @var $node TagExtends */
                        ($reflectionProperty = new \ReflectionProperty($nodeClass, 'templateName'))->setAccessible(true);
                        $templateName = $reflectionProperty->getValue($node);
                        $twigs[] = ('{% extends " ' . $this->map($templateName) . '" %}');
                        break;
                    case Variable::class:
                    case TagIf::class:
                    case TagInclude::class:
                        dump($node);
                        break;
                    case TagBlock::class:
                        /** @var $node TagBlock */
                        dump($node);
                        ($reflectionProperty = new \ReflectionProperty($nodeClass, 'block'))->setAccessible(true);
                        $blockName  = $reflectionProperty->getValue($node);


                        $twigs[] = 'BLOCK ' . $blockName;
                        break;
                    case TagComment::class:
                        $twigs[] = sprintf("{# %s #}", join("\n", $node->getNodeList()));
//                            array_push($twigs, [
//                                'class' => $nodeClass,
//                                'value' => join("\n", $node->getNodeList())
//                            ]);
//                        dump($node);
                        break;
                    default:
                        assert(false, "Missing " . $nodeClass);
                }
            } else {
                $twigs[]  = $node; // plain string
            }
        }
        return $twigs;

    }

    // convert all .tpl files in a directory to .html.twig
    public function toTwig($dir): array
    {
        $templates = [];

        assert(is_dir($dir), "$dir is not a directory");
        $liquid = new LiquidTemplate($dir);

        $finder = new Finder();
        $finder->files()->in($dir)->name('*child*' . $this->ext);
        foreach ($finder as $file) {
            $liquidSource = file_get_contents($file->getRealPath());
            $template = (new Template())
                ->setLiquidSource($liquidSource)
                ->setLiquidFilename($file->getRelativePathname())
                ;
            try {
                $liquidTemplate = $liquid->parse($liquidSource);
            } catch (\Exception $exception) {
                throw new \Exception($file->getRealPath() . " " .  $exception->getMessage());
            }

            $twigs = $this->convert($liquidTemplate->getRoot());
            dd($twigs, $liquidTemplate, $liquidTemplate->getRoot()->getNodelist());
            $template->setTwigSource(join("\n", $twigs));

            dump(Yaml::dump($twigs));
            array_push($templates, $template);
        }
        return $templates;
        dd('stopped');


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
