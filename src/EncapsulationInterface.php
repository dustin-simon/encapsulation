<?php

namespace Dustin\Encapsulation;

interface EncapsulationInterface extends \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    /**
     * Sets the value of a field.
     *
     * @param mixed $value
     */
    public function set(string $field, $value): void;

    /**
     * Sets multiple values.
     */
    public function setList(array $data): void;

    /**
     * Clears the value or removes the whole field.
     */
    public function unset(string $field): void;

    /**
     * Returns the value of a field or null.
     *
     * @return mixed
     */
    public function get(string $field);

    /**
     * Returns a list of field values where the array key is the name of the field.
     */
    public function getList(array $fields): array;

    /**
     * Adds a value to a list.
     *
     * @param mixed $value
     */
    public function add(string $field, $value): void;

    /**
     * Add multiple values to a list.
     */
    public function addList(string $field, array $values): void;

    /**
     * Returns wether a field does exist.
     */
    public function has(string $field): bool;

    /**
     * Converts object to array.
     */
    public function toArray(): array;

    /**
     * Returns a list with all existing fields.
     */
    public function getFields(): array;
}
