<?php
/**
 * Created by PhpStorm.
 * User: mmahdy
 * Date: 12/23/18
 * Time: 3:42 PM
 */

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Prophecy\ProphecyPlugin;
use Peridot\Plugin\Watcher\WatcherPlugin;

return function (EventEmitterInterface $emitter) {
    $watcher = new WatcherPlugin($emitter);
    $watcher->track(__DIR__ . '/src');

    new ProphecyPlugin($emitter);
};
