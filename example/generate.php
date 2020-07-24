<?php

use DavidBadura\XsdBuilder\Attribute;
use DavidBadura\XsdBuilder\Builder;
use DavidBadura\XsdBuilder\ComplexType;
use DavidBadura\XsdBuilder\Element;
use DavidBadura\XsdBuilder\Key;
use DavidBadura\XsdBuilder\KeyRef;

require_once __DIR__ . '/../vendor/autoload.php';

/* Library */

$builder = new Builder();
$library = new ComplexType();
$builder->addElement(Element::complexType('library', $library));

/* Books */

$books = new ComplexType();
$booksEl = Element::complexType('books', $books);
$booksEl->setKey(Key::create('book-id', 'book', ['@identifier']));
$booksEl->addKeyRef(KeyRef::create('author-ref', 'book-id', 'book', 'author'));
$library->addElement($booksEl);

/* Book */

$book = new ComplexType();
$book->addElement(Element::string('isbn'));
$book->addElement(Element::string('title'));
$book->addElement(Element::string('author'));

$id = Attribute::string('identifier');
$id->setUse('required');
$book->addAttribute($id);

$bookEl = Element::complexType('book', $book);
$bookEl->setMinOccurs(0);
$bookEl->setUnbounded(true);

$books->addElement($bookEl);

/* Authors */

$authors = new ComplexType();
$authorsEl = Element::complexType('authors', $authors);
$authorsEl->setKey(Key::create('author-id', 'author', ['@identifier']));
$library->addElement($authorsEl);

/* Author */

$author = new ComplexType();
$author->addElement(Element::string('name'));
$author->addAttribute(Attribute::string('identifier'));

$authorEl = Element::complexType('author', $author);
$authorEl->setMinOccurs(0);
$authorEl->setUnbounded(true);

$authors->addElement($authorEl);




file_put_contents(__DIR__ . '/library.xsd', $builder->toString());
