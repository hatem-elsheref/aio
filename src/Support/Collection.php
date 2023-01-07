<?php
namespace Hatem\Aio\Support;

class Collection implements \Countable
{

    public $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function all()
    {
        return $this->items;
    }

    public function get($key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    public function count()
    {
        return count($this->items);
    }

    public function only(array|string|int $keys)
    {
      return array_intersect_key($this->items, array_flip(is_array($keys) ? $keys : [$keys]));
    }

    public function except(array|string|int $keys)
    {
        return array_diff($this->items, $this->only($keys));
    }

    public function flat()
    {
        return Arr::flat($this->items, INF);
    }

    public function filter(callable $callback)
    {
        return array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);
    }

    public function map(callable $callback)
    {
        return array_map($callback, $this->items, array_keys($this->items));
    }

    public function merge(array $newItems)
    {
       return $this->items = array_merge($this->items, $newItems);
    }

    public function mergeRecursive(array $newItems)
    {
        return $this->items = array_merge($this->items, $newItems);
    }

    public function contains(int|string $key)
    {
        return in_array($key, array_keys($this->items));
    }

    public function union(array $newItems)
    {
        $this->items = $this->items + $newItems;
    }

    public function combine(array $values)
    {
        return $this->items = array_combine(array_keys($this->items), $values);
    }
    public function flip()
    {
        return array_flip($this->items);
    }

    public function first()
    {
        //return reset($this->items);
        foreach ($this->items as $key => $value){
            return [$key => $value];
        }
    }

    public function last()
    {
        //return end($this->items);
        $keys = array_keys($this->items);
        $lastKey = end($keys);
        return [$lastKey => $this->items[$lastKey]];
    }

    private function put(int|string$key, $value)
    {
        $this->items[$key] = $value;
        return $this->items;
    }

    public function add($value, $key = null)
    {
        if (is_null($key)){
          array_push($this->items, $value);
          return $this->items;
        }else{
            return $this->put($key, $value);
        }
    }

     public function addMore(array $values)
    {
        foreach ($values as $key => $value){
            $this->add($key, $value);
        }
        return $this->items;
    }


    public function forget(int|string $key)
    {
        unset($this->items[$key]);
        return $this->items;
    }
}