<?php

include '../markdown.php';

class ElephantMarkdownTest extends PHPUnit_Framework_TestCase
{

    public function testH1Setext()
    {
        $this->assertEquals("<h1>Testando!</h1>\n",
            Markdown(
                <<<MD
Testando!
======
MD
            ));
    }

    public function testH2Setext()
    {
        $this->assertEquals("<h2>Outro Teste</h2>\n",
            Markdown(
                <<<MD
Outro Teste
----------------
MD
            ));
    }

    public function testH1Atx()
    {
        $this->assertEquals(
            "<h1>Teste Atx</h1>\n", Markdown("# Teste Atx")
        );
        $this->assertEquals(
            "<h1>Teste Atx</h1>\n", Markdown("# Teste Atx #")
        );
    }

    public function testH2Atx()
    {
        $this->assertEquals(
            "<h2>Outro Teste</h2>\n", Markdown("## Outro Teste")
        );
        $this->assertEquals(
            "<h2>Outro Teste</h2>\n", Markdown("## Outro Teste ##")
        );
    }

    public function testH3Atx()
    {
        $this->assertEquals(
            "<h3>Outro Teste</h3>\n", Markdown("### Outro Teste")
        );
        $this->assertEquals(
            "<h3>Outro Teste</h3>\n", Markdown("### Outro Teste ###")
        );
    }

    public function testH4Atx()
    {
        $this->assertEquals(
            "<h4>Outro Teste</h4>\n", Markdown("#### Outro Teste")
        );
        $this->assertEquals(
            "<h4>Outro Teste</h4>\n", Markdown("#### Outro Teste ####")
        );
    }

    public function testH5Atx()
    {
        $this->assertEquals(
            "<h5>Outro Teste</h5>\n", Markdown("##### Outro Teste")
        );
        $this->assertEquals(
            "<h5>Outro Teste</h5>\n", Markdown("##### Outro Teste #####")
        );
    }

    public function testH6Atx()
    {
        $this->assertEquals(
            "<h6>Outro Teste</h6>\n", Markdown("###### Outro Teste")
        );
        $this->assertEquals(
            "<h6>Outro Teste</h6>\n", Markdown("###### Outro Teste ######")
        );
    }

    public function testHAtxCloseMismatch()
    {
        $this->assertEquals(
            "<h6>Outro Teste</h6>\n", Markdown("###### Outro Teste ##")
        );
    }

    public function testSimpleBlockquotes()
    {
        $this->assertEquals(<<<HTML
<blockquote>
  <p>This
  is
  awesome</p>
</blockquote>

HTML
            ,
            Markdown(
                    <<<MD
>This
>is
>awesome
MD
                ));
    }

    public function testLazyBlockquotes()
    {
        $this->assertEquals(<<<HTML
<blockquote>
  <p>This is very awesome
  lazy paragraphs</p>
  
  <p>These too</p>
</blockquote>

HTML
            ,
            Markdown(
                    <<<MD
>This is very awesome
lazy paragraphs

>These too
MD
                ));
    }

}