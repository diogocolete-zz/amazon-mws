<?php
/**
 * User: diogo
 * Date: 30/07/17
 * Time: 10:13
 */

namespace ZendHunter\AmazonMwsFeed;

use Interop\Container\ContainerInterface;

class AmazonMwsFeedFactory
{
    public function __construct()
    {
        set_include_path(get_include_path() .
            PATH_SEPARATOR . __DIR__ . '/../../../library/AmazonMwsSdk/src');

        spl_autoload_register(function ($className) {
            $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
            $includePaths = explode(PATH_SEPARATOR, get_include_path());
            foreach($includePaths as $includePath){
                if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)){
                    require_once $filePath;
                    return;
                }
            }
        });
    }

    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        if (!defined('DATE_FORMAT')) {
            define ('DATE_FORMAT', $config['mws-config']['DATE_FORMAT']);
        }

        return new AmazonMwsFeed($config);
    }
}