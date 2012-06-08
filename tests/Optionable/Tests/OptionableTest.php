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

namespace Optionable\Tests;

use Optionable;

class OptionableTest extends \PHPUnit_Framework_TestCase
{
    
   /**
    * @expectedException InvalidArgumentException
    * @expectedExceptionMessage Identifier "foo" is not defined.
    */    
    public function testWithoutDefault()
    {
       $optionAble =  new Optionable();
       $optionAble['foo'];
    }

    public function testSetterWithString()
    {
        $optionAble =  new Optionable();
        $id = 'param';
        $value = 'value';
        $optionAble->setDefaultOption($id, $value);
        $this->assertEquals($value, $optionAble[$id]);
    }

    public function testSetterWithClosure()
    {
        $optionAble =  new Optionable();
        $id = 'func';
        $value = function () {
            return 'value';
        };
        $expectedValue = 'value';
        
        $optionAble->setDefaultOption($id, $value);
        $this->assertEquals($expectedValue, $optionAble[$id]);
    }
    
    public function testSetterOverwrite()
    {
        $optionAble =  new Optionable();
        $id = 'param';
        $defaultOptionValue = 'This is a String.';
        $optionValue = 'This is a string to overwrite.';
        
        $optionAble->setDefaultOption($id, $defaultOptionValue);
        $optionAble[$id] = $optionValue;
        
        $this->assertEquals($optionValue, $optionAble[$id]);
        
    }
    
    public function testConstructorWithString()
    {
        $optionAble =  new ExtOptionable();
        $id = 'param';
        $expectedValue = 'This is a String.';
        
        $this->assertEquals($expectedValue, $optionAble[$id]);
        
    }

    public function testConstructorWithClosure()
    {
        $optionAble =  new ExtOptionable();
        $id = 'closure';
        $expectedValue = 'This is a closure.';
        
        $this->assertEquals($expectedValue, $optionAble[$id]);
        
    }
   
    public function testConstructorOverride()
    {
        $optionAble =  new ExtOptionable();
        $id = 'param';
        $expectedValue = 'This is an overrided String.';
        
        
        $optionAble[$id] = $expectedValue;
        
        $this->assertEquals($expectedValue, $optionAble[$id]);
        
    }
    
}
