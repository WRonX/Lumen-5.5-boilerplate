<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Simplified version of Laravel's ThrottlesLogins trait.
 *
 * @package App\Http\Controllers\Traits
 */
trait ThrottlesLogins
{
    private $cache_key;
    private $max_login_attempts;
    private $block_time_minutes;
    
    protected function createThrottlingConfig(Request $request, $attempts, $block_time)
    {
        $this->cache_key = $this->cacheKey($request);
        $this->max_login_attempts = $attempts;
        $this->block_time_minutes = $block_time;
    }
    
    protected function tooManyAttempts() : bool
    {
        $key = $this->cache_key;
        
        $currentAttempts = Cache::get($key, 0);
        if($currentAttempts >= $this->max_login_attempts) {
            if(Cache::has($key . ':timer')) {
                return true;
            }
            
            $this->resetThrottleCounter();
        }
        
        return false;
    }
    
    protected function hitThrottleCounter() : int
    {
        $key = $this->cache_key;
        $decayMinutes = $this->block_time_minutes;
        Cache::add($key . ':timer', $this->availableAt($decayMinutes * 60), $decayMinutes);
        
        $added = Cache::add($key, 0, $decayMinutes);
        
        $hits = (int)Cache::increment($key);
        
        if(!$added && $hits == 1) {
            Cache::put($key, 1, $decayMinutes);
        }
        
        return $hits;
    }
    
    protected function resetThrottleCounter()
    {
        Cache::forget($this->cache_key);
    }
    
    protected function availableIn()
    {
        return Cache::get($this->cache_key . ':timer') - Carbon::now()->getTimestamp();
    }
    
    private function availableAt($delay = 0)
    {
        return Carbon::now()->addSeconds($delay)->getTimestamp();
    }
    
    private function cacheKey(Request $request)
    {
        return strtolower($request['username']) . '|' . $request->ip();
    }
}