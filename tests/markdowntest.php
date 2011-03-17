<?php

require_once '../markdown.php';

class ElephantMarkdownTest extends PHPUnit_Framework_TestCase
{

    public function testMixedHTML()
    {
        $this->assertEquals(<<<HTML
<p>This is a regular paragraph.</p>

<table>
    <tr>
        <td>Foo</td>
    </tr>
</table>

<p>This is another regular paragraph.</p>

HTML
            ,
            Markdown(
                <<<MD
This is a regular paragraph.

<table>
    <tr>
        <td>Foo</td>
    </tr>
</table>

This is another regular paragraph.
MD
        ));
    }

    public function testEscaping()
    {
        $this->assertEquals("<p>http://images.google.com/images?num=30&amp;q=larry+bird</p>\n", Markdown("http://images.google.com/images?num=30&q=larry+bird"));
        $this->assertEquals("<p>&copy;</p>\n", Markdown("&copy;"));
        $this->assertEquals("<p>AT&amp;T</p>\n", Markdown("AT&T"));
        $this->assertEquals("<p>4 &lt; 5</p>\n", Markdown("4 < 5"));
    }

    public function testParagraphs()
    {
        $this->assertEquals(<<<HTML
<p>This is a paragraph</p>

<p>This is another paragraph</p>

HTML
            ,
            Markdown(
                <<<MD
This is a paragraph

This is another paragraph
MD
        ));
    }

    public function testLineBreaks()
    {
        $this->assertEquals(<<<HTML
<p>This is a paragraph<br />
with a line break</p>

HTML
            ,
            Markdown(
                <<<MD
This is a paragraph  
with a line break
MD
        ));
    }

    public function testH1Setext()
    {
        $this->assertEquals("<h1>This is an H1</h1>\n",
            Markdown(
                <<<MD
This is an H1
=============
MD
        ));
    }

    public function testH2Setext()
    {
        $this->assertEquals("<h2>This is an H2</h2>\n",
            Markdown(
                <<<MD
This is an H2
-------------
MD
        ));
    }

    public function testH1Atx()
    {
        $this->assertEquals(
            "<h1>This is an H1</h1>\n", Markdown("# This is an H1")
        );
        $this->assertEquals(
            "<h1>This is an H1</h1>\n", Markdown("# This is an H1#")
        );
    }

    public function testH2Atx()
    {
        $this->assertEquals(
            "<h2>This is an H2</h2>\n", Markdown("## This is an H2")
        );
        $this->assertEquals(
            "<h2>This is an H2</h2>\n", Markdown("## This is an H2#")
        );
    }

    public function testH3Atx()
    {
        $this->assertEquals(
            "<h3>This is an H3</h3>\n", Markdown("### This is an H3")
        );
        $this->assertEquals(
            "<h3>This is an H3</h3>\n", Markdown("### This is an H3#")
        );
    }

    public function testH4Atx()
    {
        $this->assertEquals(
            "<h4>This is an H4</h4>\n", Markdown("#### This is an H4")
        );
        $this->assertEquals(
            "<h4>This is an H4</h4>\n", Markdown("#### This is an H4#")
        );
    }

    public function testH5Atx()
    {
        $this->assertEquals(
            "<h5>This is an H5</h5>\n", Markdown("##### This is an H5")
        );
        $this->assertEquals(
            "<h5>This is an H5</h5>\n", Markdown("##### This is an H5#")
        );
    }

    public function testH6Atx()
    {
        $this->assertEquals(
            "<h6>This is an H6</h6>\n", Markdown("###### This is an H6")
        );
        $this->assertEquals(
            "<h6>This is an H6</h6>\n", Markdown("###### This is an H6#")
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
  <p>This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
  consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
  Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.</p>
  
  <p>Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
  id sem consectetuer libero luctus adipiscing.</p>
</blockquote>

HTML
            ,
            Markdown(
                <<<MD
> This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
> consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
> Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.
> 
> Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
> id sem consectetuer libero luctus adipiscing.
MD
        ));
    }

    public function testLazyBlockquotes()
    {
        $this->assertEquals(<<<HTML
<blockquote>
  <p>This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
  consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
  Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.</p>
  
  <p>Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
  id sem consectetuer libero luctus adipiscing.</p>
</blockquote>

HTML
            ,
            Markdown(
                <<<MD
> This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.

> Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
id sem consectetuer libero luctus adipiscing.
MD
        ));
    }

    public function testNestedBlockquotes()
    {
        $this->assertEquals(<<<HTML
<blockquote>
  <p>This is the first level of quoting.</p>
  
  <blockquote>
    <p>This is nested blockquote.</p>
  </blockquote>
  
  <p>Back to the first level.</p>
</blockquote>

HTML
            ,
            Markdown(
                <<<MD
> This is the first level of quoting.
>
> > This is nested blockquote.
>
> Back to the first level.
MD
        ));
    }

    public function testNestedRickBlockquotes()
    {
        $this->assertEquals(<<<HTML
<blockquote>
  <h2>This is a header.</h2>
  
  <ol>
  <li>This is the first list item.</li>
  <li>This is the second list item.</li>
  </ol>
  
  <p>Here's some example code:</p>

<pre><code>return shell_exec("echo \$input | \$markdown_script");
</code></pre>
</blockquote>

HTML
            ,
            Markdown(
                <<<MD
> ## This is a header.
> 
> 1.   This is the first list item.
> 2.   This is the second list item.
> 
> Here's some example code:
> 
>     return shell_exec("echo \$input | \$markdown_script");
MD
        ));
    }

    public function testSimpleLists()
    {
        $this->assertEquals(<<<HTML
<ul>
<li>Red</li>
<li>Blue</li>
<li>Green</li>
</ul>

HTML
            , Markdown(
                <<<MD
- Red
- Blue
- Green
MD
        ));
    }

    public function testSimpleListsPlusSign()
    {
        $this->assertEquals(<<<HTML
<ul>
<li>Foo</li>
<li>Bar</li>
<li>Baz</li>
</ul>

HTML
            , Markdown(
                <<<MD
+ Foo
+ Bar
+ Baz
MD
        ));
    }

    public function testSimpleListsAsterisk()
    {
        $this->assertEquals(<<<HTML
<ul>
<li>Foo</li>
<li>Bar</li>
<li>Baz</li>
</ul>

HTML
            , Markdown(
                <<<MD
* Foo
* Bar
* Baz
MD
        ));
    }

    public function testSimpleListsIndented()
    {
        $this->assertEquals(<<<HTML
<ul>
<li>Foo something, bar something
lorem ipsum etc</li>
<li>Bar everything, bar something
lorem ipsum etc</li>
<li>Bat Man, bar something
lorem ipsum etc</li>
</ul>

HTML
            ,
            Markdown(
                <<<MD
*  Foo something, bar something
   lorem ipsum etc
*  Bar everything, bar something
   lorem ipsum etc
*  Bat Man, bar something
   lorem ipsum etc
MD
        ));
    }

    public function testSimpleListsParagraph()
    {
        $this->assertEquals(<<<HTML
<ul>
<li><p>Foo</p></li>
<li><p>Bar</p></li>
<li><p>Baz</p></li>
</ul>

HTML
            ,
            Markdown(
                <<<MD
* Foo
    
* Bar

* Baz
MD
        ));
    }

    public function testBlocksInsideLists()
    {
        $this->assertEquals(<<<HTML
<ul>
<li><p>Foo</p>

<pre><code>sudo make me a sandwich
</code></pre></li>
<li><p>Bar</p>

<blockquote>
  <p>Cool.</p>
</blockquote></li>
</ul>

HTML
            ,
            Markdown(
                <<<MD
*   Foo
    
        sudo make me a sandwich
        
*   Bar

    >Cool.
MD
        ));
    }

    public function testListsMultipleParagraph()
    {
        $this->assertEquals(<<<HTML
<ul>
<li><p>Foo</p>

<p>Second Foo</p></li>
<li><p>Bar</p>

<p>Second Bar</p></li>
<li><p>Baz</p>

<p>Second Baz</p></li>
</ul>

HTML
            ,
            Markdown(
                <<<MD
*   Foo
    
    Second Foo
    
*   Bar

    Second Bar

*   Baz
    
    Second Baz
MD
        ));
    }

    public function testOrderedLists()
    {
        $this->assertEquals(<<<HTML
<ol>
<li>Foo</li>
<li>Bar</li>
<li>Baz</li>
</ol>

HTML
            ,
            Markdown(
                <<<MD
1. Foo
2. Bar
3. Baz
MD
        ));
    }

    public function testListEscapedDot()
    {
        $this->assertEquals(<<<HTML
<p>1990&#46; Nice Year
1991&#46; Terrible Year.</p>

HTML
            ,
            Markdown(
                <<<MD
1990\. Nice Year
1991\. Terrible Year.
MD
        ));
    }

    public function testOrderedListsCustom()
    {
        $this->assertEquals(<<<HTML
<ol>
<li>Foo</li>
<li>Bar</li>
<li>Baz</li>
</ol>

HTML
            ,
            Markdown(
                <<<MD
1. Foo
8. Bar
5. Baz
MD
        ));
    }

    public function testNestedLists()
    {
        $this->assertEquals(<<<HTML
<ol>
<li>Foo

<ul>
<li><em>Foo bat</em></li>
<li>Foo foo</li>
</ul></li>
<li>Bar</li>
<li>Baz</li>
</ol>

HTML
            ,
            Markdown(
                <<<MD
1. Foo
- *Foo bat*
- Foo foo
2. Bar
3. Baz
MD
        ));
    }

    public function testCodeBlock()
    {
        $this->assertEquals(<<<HTML
<pre><code>Some
Geeky &lt;strong&gt;HTML-escaped&lt;/strong&gt;
Code
</code></pre>

HTML
            ,
            Markdown(
                <<<MD
    Some
    Geeky <strong>HTML-escaped</strong>
    Code
MD
        ));
    }

    public function testHorizontal()
    {
        $this->assertEquals(<<<HTML
<hr />

HTML
            , Markdown(
                <<<MD
***********
MD
        ));
    }

    public function testHorizontal2()
    {
        $this->assertEquals(<<<HTML
<hr />

HTML
            , Markdown(
                <<<MD
- - - -
MD
        ));
    }

    public function testHorizontal3()
    {
        $this->assertEquals(<<<HTML
<hr />

HTML
            , Markdown(
                <<<MD
* * * * 
MD
        ));
    }

    public function testSimpleLinks()
    {
        $this->assertEquals(<<<HTML
<p>This is <a href="http://example.com/" title="Title" target="_blank">an example</a> inline link.</p>

<p><a href="http://example.net/" target="_blank">This link</a> has no title attribute.</p>

HTML
            , Markdown(
                <<<MD
This is [an example](http://example.com/ "Title") inline link.

[This link](http://example.net/) has no title attribute.
MD
        ));
    }

    public function testLinksRelative()
    {
        $this->assertEquals(<<<HTML
<p>See my <a href="/about/">About</a> page for details.</p>

HTML
            , Markdown(
                <<<MD
See my [About](/about/) page for details.
MD
        ));
    }



    public function testReferences()
    {
        $this->assertEquals(<<<HTML
<p>This is <a href="http://example.com/" title="Optional Title Here" target="_blank">an example</a> reference-style link.</p>

HTML
            , Markdown(
                <<<MD
This is [an example][id] reference-style link.

[id]: http://example.com/  "Optional Title Here"
MD
        ));
    }

    public function testReferencesSpaced()
    {
        $this->assertEquals(<<<HTML
<p>This is <a href="http://example.com/" title="Optional Title Here" target="_blank">an example</a> reference-style link.</p>

HTML
            , Markdown(
                <<<MD
This is [an example] [id] reference-style link.

[id]: http://example.com/  "Optional Title Here"
MD
        ));
    }

}