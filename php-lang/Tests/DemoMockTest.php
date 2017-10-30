<?php

// ./vendor/bin/phpunit -c phpunit.xml DemoMockTest Tests/DemoMockTest.php
class DemoMockTest extends \PHPUnit\Framework\TestCase
{
    public function testSimple()
    {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')
            ->willReturn('foo');

        $this->assertEquals('foo', $stub->doSomething());
    }

    public function testMockClassHaveMethodMethod()
    {
        $stub = $this->createMock(SomeClassHaveMethod::class);

        $stub->expects($this->any())->method('doSomething')->willReturn('foo');

        $this->assertSame('foo', $stub->doSomething());
    }

    public function testWithMockBuilder() {
        $stub = $this->getMockBuilder(SomeClass::class)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

        $stub->method('doSomething')->willReturn('foo');

        $this->assertSame('foo', $stub->doSomething());
    }

    public function testWithReturnArgument() {
        $stub = $this->createMock(SomeClass::class);

        $stub->method("doSomething")
            ->willReturnArgument(0);

        $this->assertEquals('foo', $stub->doSomething('foo'));

        $this->assertEquals('bar', $stub->doSomething('bar'));
    }

    public function testWithReturnSelf() {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')
            ->willReturnSelf();

        $this->assertSame($stub, $stub->doSomething());
    }

    public function testReturnValueMap() {
        $stub = $this->createMock(SomeClass::class);

        $map = [
            ['a', 'b', 'c', 'd'],
            ['e', 'f', 'g', 'h'],
        ];

        $stub->method('doSomething')
            ->willReturnValueMap($map);

        $this->assertEquals('d', $stub->doSomething('a', 'b', 'c'));
        $this->assertEquals('h', $stub->doSomething('e', 'f', 'g'));
    }

    public function testMockWithReturnCallback() {
        $stub = $this->createMock(SomeClass::class);

        // Configure the stub
        $stub->method('doSomething')
            ->willReturnCallback(function($str) {
                return strtoupper($str);
            });

        $this->assertEquals('SOMETHING', $stub->doSomething('something'));
    }

    public function testMockWithConsecutiveResult() {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')
            ->willReturnConsecutiveResult(2, 3, 5, 7);

        $this->assertEquals(2, $stub->doSomething());
        $this->assertEquals(3, $stub->doSomething());
        $this->assertEquals(5, $stub->doSomething());
        $this->assertEquals(7, $stub->doSomething());
    }

    /**
     * @expectedException Exception
     */
    public function testMockWithThrownException() {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')
            ->willThrowException(new \Exception());

        $stub->doSomething();
    }

    public function testObserversAreUpdated() {
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        $observer->expectCalledOne()
            ->method('update')
            ->withParameter($this->equalTo('something'));

        $subject = new Subject("My Subject");
        $subject->attach($observer);

        $subject->doSomething();
    }

    public function testExpectNeverCall() {
        $stub = $this->createMock(SomeClass::class);

        $stub->expectNeverCalled()
            ->method('doSomething');
    }

}

class SomeClass
{
    public function doSomething()
    {
        // Do something.
    }
}

class SomeClassHaveMethod
{
    public function doSomething()
    {

    }

    public function method()
    {

    }
}


class Subject
{
    protected $observers = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething()
    {
        // Do something.
        // ...

        // Notify observers that we did something.
        $this->notify('something');
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }

    // Other methods.
}

class Observer
{
    public function update($argument)
    {
        // Do something.
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // Do something
    }

    // Other methods.
}
