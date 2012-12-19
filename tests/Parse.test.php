<?php
use Underscore\Parse;

class ParseTest extends UnderscoreWrapper
{
  ////////////////////////////////////////////////////////////////////
  ////////////////////////// DATA PROVIDERS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  public function provideSwitchers()
  {
    return array(
      array('toArray', NULL, array()),
      array('toArray', 15, array(15)),
      array('toArray', 'foobar', array('foobar')),
      array('toArray', (object) $this->array, $this->array),

      array('toString', 15, '15'),

      array('toBoolean', '', false),
      array('toBoolean', 'foo', true),
      array('toBoolean', 15, true),
      array('toBoolean', 0, false),
      array('toBoolean', array(), false),
    );
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// TESTS ///////////////////////////////
  ////////////////////////////////////////////////////////////////////

  public function testCanCreateCsvFiles()
  {
    $csv = Parse::toCSV($this->arrayMulti);
    $matcher = '"bar";"ter"' . PHP_EOL . '"bar";"ter"' .PHP_EOL. '"foo";"ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanUseCustomCsvDelimiter()
  {
    $csv = Parse::toCSV($this->arrayMulti, ',');
    $matcher = '"bar","ter"' . PHP_EOL . '"bar","ter"' .PHP_EOL. '"foo","ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanOutputCsvHeaders()
  {
    $csv = Parse::toCSV($this->arrayMulti, ',', true);
    $matcher = 'foo,bis' . PHP_EOL . '"bar","ter"' . PHP_EOL . '"bar","ter"' .PHP_EOL. '"foo","ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanConvertToJson()
  {
    $json = Parse::toJSON($this->arrayMulti);
    $matcher = '[{"foo":"bar","bis":"ter"},{"foo":"bar","bis":"ter"},{"bar":"foo","bis":"ter"}]';

    $this->assertEquals($matcher, $json);
  }

  public function testCanParseJson()
  {
    $json = Parse::toJSON($this->arrayMulti);
    $array = Parse::fromJSON($json);

    $this->assertEquals($this->arrayMulti, $array);
  }

  public function testCanParseXML()
  {
    $array = Parse::fromXML('<article><name>foo</name><content>bar</content></article>');
    $matcher = array('name' => 'foo', 'content' => 'bar');

    $this->assertEquals($matcher, $array);
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////// TYPES SWITCHERS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * @dataProvider provideSwitchers
   */
  public function testCanSwitchTypes($method, $from, $to)
  {
    $from = Parse::$method($from);

    $this->assertEquals($to, $from);
  }
}
