<?php

namespace Handlebars\Cache;
use Handlebars\Cache;

class Memcached implements Cache {
  protected $cache;
  
  public function __construct($server = NULL, $port = 11211) {
    if($server instanceof \Memcached) {
      $this->cache = $server;
      // no need to continue. Assume fully configured.
      return;
    }
    else {
      $this->cache = new \Memcached();
    }
    
    if(is_array($server)) {
      $this->cache->addServers($servers);
    }
    else {
      call_user_func_array(array($this->cache, 'addServer'), func_get_args());
    }
  }
  /**
   * Get cache for $name if exist.
   *
   * @param string $name Cache id
   *
   * @return mixed data on hit, boolean false on cache not found
   */
  public function get($name){
    return $this->cache->get($name);
  }

  /**
   * Set a cache
   *
   * @param string $name  cache id
   * @param mixed  $value data to store
   * @param int $expiration optional Duration to store. Default is 5min.
   * 
   * @return void
   */
  public function set($name, $value, $expiration = 300){
    $this->cache->set($name, $value, $expiration);
  }

  /**
   * Remove cache
   *
   * @param string $name Cache id
   *
   * @return void
   */
  public function remove($name) {
    $this->cache->delete($name);
  }
}

class Cache extends _Cache{}
