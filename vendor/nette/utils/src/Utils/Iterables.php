<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\Utils;

use Nette;


/**
 * Utilities for iterables.
 */
final class Iterables
{
	use Nette\StaticClass;

	/**
	 * Tests for the presence of value.
	 */
	public static function contains(iterable $iterable, mixed $value): bool
	{
		foreach ($iterable as $v) {
			if ($v === $value) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Tests for the presence of key.
	 */
	public static function containsKey(iterable $iterable, mixed $key): bool
	{
		foreach ($iterable as $k => $v) {
			if ($k === $key) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Returns the first item (matching the specified predicate if given) or null if there is no such item.
	 * The callback has the signature `function ($value, $key, $iterable): bool`.
	 * @template T
	 * @param  iterable<T>  $iterable
	 * @return ?T
	 */
	public static function first(iterable $iterable, ?callable $predicate = null): mixed
	{
		foreach ($iterable as $k => $v) {
			if (!$predicate || $predicate($v, $k, $iterable)) {
				return $v;
			}
		}
		return null;
	}


	/**
	 * Returns the key of first item (matching the specified predicate if given) or null if there is no such item.
	 * The callback has the signature `function ($value, $key, $iterable): bool`.
	 * @template T
	 * @param  iterable<T, mixed>  $iterable
	 * @return ?T
	 */
	public static function firstKey(iterable $iterable, ?callable $predicate = null): mixed
	{
		foreach ($iterable as $k => $v) {
			if (!$predicate || $predicate($v, $k, $iterable)) {
				return $k;
			}
		}
		return null;
	}


	/**
	 * Tests whether at least one element in the array passes the test implemented by the
	 * provided callback with signature `function ($value, $key, $iterable): bool`.
	 * @template K
	 * @template V
	 * @param  iterable<K, V> $iterable
	 * @param  callable(V, K, iterable<K, V>): bool  $predicate
	 */
	public static function some(iterable $iterable, callable $predicate): bool
	{
		foreach ($iterable as $k => $v) {
			if ($predicate($v, $k, $iterable)) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Tests whether all elements in the array pass the test implemented by the provided function,
	 * which has the signature `function ($value, $key, $iterable): bool`.
	 * @template K
	 * @template V
	 * @param  iterable<K, V> $iterable
	 * @param  callable(V, K, iterable<K, V>): bool  $predicate
	 */
	public static function every(iterable $iterable, callable $predicate): bool
	{
		foreach ($iterable as $k => $v) {
			if (!$predicate($v, $k, $iterable)) {
				return false;
			}
		}
		return true;
	}


	/**
	 * Returns a new array containing all key-value pairs matching the given $predicate.
	 * The callback has the signature `function ($value, $key, $iterable): bool`.
	 * @template K
	 * @template V
	 * @param  iterable<K, V> $iterable
	 * @param  callable(V, K, iterable<K, V>): bool $predicate
	 * @return \Generator<K, V>
	 */
	public static function filter(iterable $iterable, callable $predicate): \Generator
	{
		foreach ($iterable as $k => $v) {
			if ($predicate($v, $k, $iterable)) {
				yield $k => $v;
			}
		}
	}


	/**
	 * Calls $transform on all elements in the array and returns the array of return values.
	 * The callback has the signature `function ($value, $key, $iterable): bool`.
	 * @template K
	 * @template V
	 * @template R
	 * @param  iterable<K, V> $iterable
	 * @param  callable(V, K, iterable<K, V>): R $transform
	 * @return \Generator<K, R>
	 */
	public static function map(iterable $iterable, callable $transform): \Generator
	{
		foreach ($iterable as $k => $v) {
			yield $k => $transform($v, $k, $iterable);
		}
	}
}
