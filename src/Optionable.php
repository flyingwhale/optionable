<?php

/*
 * Copyright 2012 Zsolt Javorszky <zsolt.javorszky@gmail.com>
 *                Imre Toth <tothimre@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Optionable extends Pimple
{
    protected $defaultValues;
    
    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->defaultValues = array();
        $this->setupDefaultOptions();
    }

    public function getDefaultOption($id)
    {
        if (!array_key_exists($id, $this->defaultValues)) {
            throw new InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }

        return $this->defaultValues[$id] instanceof Closure ? $this->defaultValues[$id]($this) : $this->defaultValues[$id];
    
    }
    
    public function getOption($id)
    {
        $option = false;
        try
        {
            $option = $this->offsetGet($id);
        }
        catch (InvalidArgumentException $e)
        {
            $option = $this->getDefaultOption($id);
        }

        return $option;
    }

    public function setDefaultOption($id, $value)
    {
        $this->defaultValues[$id] = $value;
    }
    
    public function setOption($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    protected function setupDefaultOptions()
    {
    }
    
}