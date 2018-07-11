# CodeHightlightJs
Helper for Yii2 that format source code for highlightjs integration

## Requirements
To highlight code you still need integrate highlightjs via external integration. 

For example via [https://github.com/nezhelskoy/yii2-highlight](https://github.com/nezhelskoy/yii2-highlight)

## Instalation
Put file Code.php to /app/comp/ folder or put any where you need and change namespace in file

## Description
This class allows:
- write not escaped html code between start() and end() methods
- not think about /t and /s characters
- not think about offset before code block

## Usage examples

### Basic example
```
<?php $code = Code::start('js')?>
console.log('Hello world');
<?=$code->end()?>
```
will produce
```
<pre><code class="js">
console.log('Hello world');
</code></pre>
```

### PHP example
```
<?php $code = Code::start('php', "\t", '<?php')?>
echo 'Hello world';
<?=$code->end()?>
```
will produce
```
<pre><code class="php">
<?php
    echo 'Hello world';
</code></pre>
```

### HTML example
```
<body>
  <main>
    <h1>Page head</h1>
    <article>  
      <header><h1>Article head</h1></header>
      <p>As you see we have offset of the code from the begin of the code, that helper auto strip before output</p>
      <div class="example">
        <?php $code = Code::start()?>
|||||||||| <= offset that should not be appear in code output HTML
          <script>
            for(var i=0; i<10; i++) {
              console.log('Hello world');
            }
          </script>
|||||||||| <= offset that should not be appear in code output HTML          
        <?=$code->end()?>
      </div>
    </article>
  </main>
</body>
```
will produce
```
<body>
  <main>
    <h1>Page head</h1>
    <article>  
      <header><h1>Article head</h1></header>
      <p>As you see we have offset of the code from the begin of the code, that helper auto strip before output</p>
      <div class="example">
<pre><code>
&lt;script&gt;
  for(var i=0; i<10; i++) {
    console.log('Hello world');
  }
&lt;/script&gt;
</code></pre>
      </div>
    </article>
  </main>
</body>
```
Pay attention that class has stripped offset for the code based on first line offset, but keeps code formating
