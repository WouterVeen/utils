<?php
declare(strict_types=1);

namespace DR\Utils\Tests\Unit;

use DR\Utils\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;

#[CoversClass(Assert::class)]
class AssertTest extends TestCase
{
    public function testNullFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be null');
        Assert::null('foobar');
    }

    public function testNullSuccess(): void
    {
        static::assertNull(Assert::null(null));
    }

    public function testNotNullFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be not null');
        Assert::notNull(null);
    }

    public function testNotNullSuccess(): void
    {
        $object = new stdClass();
        static::assertSame($object, Assert::notNull($object));
    }

    public function testIsArrayFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be an array');
        Assert::isArray('foobar'); // @phpstan-ignore-line
    }

    public function testIsArray(): void
    {
        $objects = [new stdClass()];
        static::assertSame($objects, Assert::isArray($objects));
    }

    public function testIsCallable(): void
    {
        $callable = [$this, 'testIsCallable'];
        static::assertSame($callable, Assert::isCallable($callable));
    }

    public function testIsCallableFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be `callable`');
        Assert::isCallable('string');
    }

    public function testScalarSuccess(): void
    {
        static::assertSame(123, Assert::scalar(123));
    }

    public function testScalarFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a `scalar`');
        Assert::scalar(new stdClass()); // @phpstan-ignore-line
    }

    public function testResourceSuccess(): void
    {
        static::assertSame(STDIN, Assert::resource(STDIN));
    }

    public function testResourceFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a `resource`');
        Assert::resource('string'); // @phpstan-ignore-line
    }

    public function testObjectSuccess(): void
    {
        $obj = new stdClass();
        static::assertSame($obj, Assert::object($obj));
    }

    public function testObjectFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a `object`');
        Assert::object('string'); // @phpstan-ignore-line
    }

    public function testInteger(): void
    {
        static::assertSame(5, Assert::integer(5));
    }

    public function testIntegerFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be an int');
        Assert::integer('string'); // @phpstan-ignore-line
    }

    public function testFloat(): void
    {
        static::assertSame(5.5, Assert::float(5.5));
    }

    public function testFloatFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a float');
        Assert::float('string'); // @phpstan-ignore-line
    }

    public function testStringFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a string');
        Assert::string(123); // @phpstan-ignore-line
    }

    public function testString(): void
    {
        static::assertSame('string', Assert::string('string'));
    }

    public function testNonEmptyStringNoStringFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a string');
        Assert::nonEmptyString(123); // @phpstan-ignore-line
    }

    public function testNonEmptyStringFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a non empty string');
        Assert::nonEmptyString('');
    }

    public function testNonEmptyString(): void
    {
        static::assertSame('string', Assert::nonEmptyString('string'));
    }

    public function testBoolean(): void
    {
        static::assertTrue(Assert::boolean(true));
        static::assertFalse(Assert::boolean(false));
    }

    public function testBooleanFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be a boolean');
        Assert::boolean('string'); // @phpstan-ignore-line
    }

    public function testTrueFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be true');
        Assert::true(false);
    }

    public function testTrueSuccess(): void
    {
        static::assertTrue(Assert::true(true));
    }

    public function testFalseFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be false');
        Assert::false(true);
    }

    public function testFalseSuccess(): void
    {
        static::assertFalse(Assert::false(false));
    }

    public function testNotFalseFailure(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be not false');
        Assert::notFalse(false);
    }

    public function testNotFalseSuccess(): void
    {
        $object = new stdClass();
        static::assertSame($object, Assert::notFalse($object));
    }

    public function testIsInstanceOfFailure(): void
    {
        $object = new stdClass();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Expecting value to be instance of RuntimeException');
        Assert::isInstanceOf($object, RuntimeException::class); // @phpstan-ignore-line
    }

    public function testIsInstanceOfSuccess(): void
    {
        static::assertSame($this, Assert::isInstanceOf($this, self::class));
        static::assertSame($this, Assert::isInstanceOf($this, TestCase::class));
    }
}
