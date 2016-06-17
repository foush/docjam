<?php
namespace DocJam;

class Route implements \ArrayAccess {

    /**
     * @var array
     */
    protected $tags;

    /**
     * Route constructor.
     * @param array $tags
     * @param string $routeString
     */
    public function __construct(array $tags, $routeString)
    {
        /* @var $tag \phpDocumentor\Reflection\DocBlock\Tags\Generic */
        foreach ($tags as $tag) {
            $this->tags[$tag->getName()] = $tag->getDescription();
        }
        var_dump($routeString);
        if (!preg_match('#^\$router->(\w+)\(([\'|"])(.*?)\\2,\s*(.+)\);\s*$#', trim($routeString), $matches)) {
            throw new \InvalidArgumentException("The route does not conform to the expected pattern.");
        }
        $method = $matches[1];
        $route = $matches[3];
        $paramString = $matches[4];
        if (!preg_match_all('#([\'|"])(\w+)\\1\s*=>\s*([\'|"])(\w+)\\3#', $paramString, $matches)) {
            throw new \InvalidArgumentException("The route params do not conform to the expected pattern.");
        }
        $params = [];
        foreach ($matches[2] as $index => $paramName) {
            $params[$paramName] = $matches[4][$index];
        }
        var_dump($params);
    }

    public function offsetExists($offset)
    {
        return isset($this->tags[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->tags[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->tags[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->tags[$offset]);
    }
}
