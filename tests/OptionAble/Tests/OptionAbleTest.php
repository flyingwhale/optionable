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

namespace OptionAble\Tests;

use OptionAble;

class OptionAbleTest extends \PHPUnit_Framework_TestCase
{
    
   /**
    * @expectedException InvalidArgumentException
    * @expectedExceptionMessage Identifier "foo" is not defined.
    */    
    public function testWithoutDefault()
    {
       $optionAble =  new OptionAble();
       $optionAble->getOption('foo');
    }

    public function testSetterWithString()
    {
        $optionAble =  new OptionAble();
        $id = 'param';
        $value = 'value';
        $optionAble->setDefaultOption($id, $value);
        $this->assertEquals($value, $optionAble->getDefaultOption($id));
        $this->assertEquals($value, $optionAble->getOption($id));
    }

    public function testSetterWithClosure()
    {
        $optionAble =  new OptionAble();
        $id = 'func';
        $value = function () {
            return 'value';
        };
        $expectedValue = 'value';
        
        $optionAble->setDefaultOption($id, $value);
        $this->assertEquals($expectedValue, $optionAble->getDefaultOption($id));
        $this->assertEquals($expectedValue, $optionAble->getOption($id));
    }
    
    public function testSetterOverride()
    {
        $optionAble =  new OptionAble();
        $id = 'param';
        $defaultOptionValue = 'This is a String.';
        $optionValue = 'This is an overrided String.';
        
        $optionAble->setDefaultOption($id, $defaultOptionValue);
        $optionAble->setOption($id, $optionValue);
        
        $this->assertEquals($defaultOptionValue, $optionAble->getDefaultOption($id));
        $this->assertEquals($optionValue, $optionAble->getOption($id));
        
    }
    
    public function testConstructorWithString()
    {
        $optionAble =  new ExtOptionAble();
        $id = 'param';
        $expectedValue = 'This is a String.';
        
        $this->assertEquals($expectedValue, $optionAble->getDefaultOption($id));
        $this->assertEquals($expectedValue, $optionAble->getOption($id));
        
    }

    public function testConstructorWithClosure()
    {
        $optionAble =  new ExtOptionAble();
        $id = 'closure';
        $expectedValue = 'This is a closure.';
        
        $this->assertEquals($expectedValue, $optionAble->getDefaultOption($id));
        $this->assertEquals($expectedValue, $optionAble->getOption($id));
        
    }
   
    public function testConstructorOverride()
    {
        $optionAble =  new ExtOptionAble();
        $id = 'param';
        $expectedValue = 'This is an overrided String.';
        
        
        $optionAble->setOption($id, $expectedValue);
        
        $this->assertEquals('This is a String.', $optionAble->getDefaultOption($id));
        $this->assertEquals($expectedValue, $optionAble->getOption($id));
        
    }
    
}
