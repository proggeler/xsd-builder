<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Type
{
    public const STRING = 'xs:string';
    public const DECIMAL = 'xs:decimal';
    public const INTEGER = 'xs:integer';
    public const BOOLEAN = 'xs:boolean';
    public const DATE = 'xs:date';
    public const TIME = 'xs:time';

    public const ID = 'xs:ID';
    public const IDREF = 'xs:IDREF';
    public const IDREFS = 'xs:IDREFS';
}
