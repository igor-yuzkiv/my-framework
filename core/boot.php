<?php

/**
 * @return \core\ServiceManager
 */
function services () {
    return \core\ServiceManager::init();
}

/**
 * Load defined services
 */
services()->boot();