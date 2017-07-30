<?php
/**
 * User: diogo
 * Date: 30/07/17
 * Time: 10:23
 */

namespace ZendHunter;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}