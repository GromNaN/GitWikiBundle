<?php

namespace Git\WikiBundle\Bridge;

if(!class_exists('RST_Parser')) {
    require_once realpath(__DIR__.'/..').'/vendor/rst.php';
}

class ReStructuredText extends \RST_Parser
{
    
}