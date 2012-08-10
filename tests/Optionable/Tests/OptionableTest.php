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
    * @dataProvider providerpullArray
    */
    public function testPullArray($key, $srcOptionable, $expectedArray)
    {
       $pulledArray = $srcOptionable->pullArray($key);
       $this->assertEquals($expectedArray, $pulledArray);
    }
    
    
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

    public function testSetDefaultOptions()
    {
        $options['first'] =  'first';
        $options['second'] = 'second';

        $optionable = new Optionable();
        $optionable->setDefaultOptions($options);

        $this->assertEquals('first', $optionable['first']);
        $this->assertEquals('second', $optionable['second']);
    }

    public function testGetOptionable()
    {
        $options = array('first' => 'firstv', 'second' => 'secondv');
        $optionableAsParam = new Optionable($options);

        $optionable  = Optionable::getOptionable($options);

        $this->assertEquals('Optionable',get_class($optionable));
        $this->assertEquals('firstv', $optionable['first']);
        $this->assertEquals('secondv', $optionable['second']);

        $optionable  = Optionable::getOptionable($optionableAsParam);

        $this->assertEquals('Optionable',get_class($optionable));
        $this->assertEquals('firstv', $optionable['first']);
        $this->assertEquals('secondv', $optionable['second']);
    }

    public function providerPullArray()
    {
        $data = array();
       
        $key = '';

        $srcOptionable =  new Optionable();
        $srcOptionable['1'] = 'v1';
        $srcOptionable['11'] = 'v11';
        $srcOptionable['1.1'] = 'v1.1';
        $srcOptionable['1.2'] = 'v1.2';
        $srcOptionable['1.2.1'] = 'v1.2.1';
        $srcOptionable['1.2.2'] = 'v1.2.2';
        $srcOptionable['1.2.3.4.5'] = 'v1.2.3.4.5';
        $srcOptionable['1.2.1.1'] = 'v1.2.1.1';
        $srcOptionable['1.2.c'] = function(){return 'v1.2.c';};
        $srcOptionable['1.22'] = 'v1.22';
        $srcOptionable['2'] = 'v2';
       
        $expectedArray = array(
            '1' => 'v1',
            '11' => 'v11',
            '1.1' => 'v1.1',
            '1.2' => 'v1.2',
            '1.2.1' => 'v1.2.1',
            '1.2.2' => 'v1.2.2',
            '1.2.3.4.5' => 'v1.2.3.4.5',
            '1.2.1.1' => 'v1.2.1.1',
            '1.2.c' => 'v1.2.c',
            '1.22' => 'v1.22',
            '2' => 'v2'
        );

        $data[] = array($key, $srcOptionable, $expectedArray);

        $key = '1';
        $expectedArray = array(
            '1' => 'v1.1',
            '2' => 'v1.2',
            '2.1' => 'v1.2.1',
            '2.2' => 'v1.2.2',
            '2.3.4.5' => 'v1.2.3.4.5',
            '2.1.1' => 'v1.2.1.1',
            '2.c' => 'v1.2.c',
            '22' => 'v1.22',
        );
        
        $data[] = array($key, $srcOptionable, $expectedArray);

        $key = '1.2';
        $expectedArray = array(
            '1' => 'v1.2.1',
            '2' => 'v1.2.2',
            '3.4.5' => 'v1.2.3.4.5',
            '1.1' => 'v1.2.1.1',
            'c' => 'v1.2.c'
        );
        
        $data[] = array($key, $srcOptionable, $expectedArray);
       
        return $data;
    }
}
