<?php

namespace app\domain\model;

abstract class ModelAbstract
{

    protected $metadata = [];

    public function __construct(array $properties = [])
    {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public abstract static function create();

    public function addMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    public function removeMetadata($key)
    {
        if (isset($this->metadata[$key])) {
            unset($this->metadata[$key]);
        }
    }

    public function listMetadataKeys()
    {
        return array_keys($this->metadata);
    }

    public function listMetadata()
    {
        return $this->metadata;
    }

    public function getMetadata($key)
    {
        return isset($this->metadata[$key]) ? $this->metadata[$key] : null;
    }

    public function toArray()
    {
        $data = $this->toArrayData();
        return array_merge($this->metadata, $data);
    }

    protected abstract function toArrayData();
}