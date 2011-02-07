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

}