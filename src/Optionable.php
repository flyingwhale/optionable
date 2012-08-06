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

    public static function getOptionable($options, $class='Optionable')
    {
        if ($options InstanceOf Optionable) {
            return $options;
        }

        if (is_array($options)) {
        return new $class($options);
        }

        throwException(new InvalidArgumentException('The $options parameter must be an array or an Optionable class'));

    }

    public function setDefaultOption($id, $value)
    {
        if (!$this->offsetExists($id)) {
            $this[$id] = $value;
        }
    }

    public function setDefaultOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->setDefaultOption($key, $value);
        }
    }

    public function getArrayStructure($name, $class = '\Optionable')
    {
        if ($name == '')
        {
            return $this;
        }
        
        $keys = $this->keys();
        $variables = array();
        $pattern = sprintf('/(^%1$s[.])/', preg_quote($name, "/"));

        foreach($this->keys() as $key)
        {
            if (preg_match($pattern, $key))
            {
                $newKey = preg_replace($pattern, '', $key);
                $variables[$newKey] = $this->raw($key);
            }
            
        }
        
        $optionable = new $class($variables);

        return $optionable;
    }
}
