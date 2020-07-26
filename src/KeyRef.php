<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class KeyRef
{
    private string $name;
    private string $refer;
    private string $selector;
    private string $field;

    private function __construct()
    {
    }

    public static function create(string $name, string $refer, string $selector, string $field): self
    {
        $self = new self();
        $self->name = $name;
        $self->refer = $refer;
        $self->selector = $selector;
        $self->field = $field;

        return $self;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:keyref');
        $el->setAttribute('name', $this->name);
        $el->setAttribute('refer', $this->refer);

        $selector = $dom->createElement('xs:selector');
        $selector->setAttribute('xpath', $this->selector);
        $el->appendChild($selector);

        $fieldElement = $dom->createElement('xs:field');
        $fieldElement->setAttribute('xpath', $this->field);
        $el->appendChild($fieldElement);

        return $el;
    }
}
