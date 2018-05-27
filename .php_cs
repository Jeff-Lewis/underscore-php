<?php
use PhpCsFixer\Config;
//use PhpCsFixer\Finder;
//use PhpCsFixer\Fixer\Contrib\HeaderCommentFixer;
use PhpCsFixer\FixerInterface;

$finder = PhpCsFixer\Finder::create()->in(['config', 'src', 'tests']);
$header = <<< EOF
This file is part of Underscore.php

(c) Maxime Fabre <ehtnam6@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

HeaderCommentFixer::setHeader($header);

return Config::create()
             ->level(FixerInterface::SYMFONY_LEVEL)
             ->fixers([
                 'ereg_to_preg',
                 'header_comment',
                 'multiline_spaces_before_semicolon',
                 'ordered_use',
                 'php4_constructor',
                 'phpdoc_order',
                 'short_array_syntax',
                 'short_echo_tag',
                 'strict',
                 'strict_param',
             ])
             ->setUsingCache(true)
             ->finder($finder);
