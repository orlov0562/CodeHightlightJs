<?php
namespace app\comp\widgets;

use yii\helpers\Html;

class Code {
    public $codeClass;
    public $offset;
    public $before;
    public $end;

    /**
     * string $codeClass see http://highlightjs.readthedocs.io/en/latest/css-classes-reference.html
     */

    public static function start($codeClass='', $offset='', $before='', $after='', $template=null){
        $code = new self;
        $code->codeClass = $codeClass;
        $code->offset = str_replace("\t", "    ", $offset);
        $code->before = $before;
        $code->after = $after;
        $code->template = is_null($template)
                          ? self::getDefaultTemplate()
                          : $template
        ;
        ob_start();
        return $code;
    }

    public function end($after=''){
        $code = ob_get_clean();

        $code = self::cleanupCode($code);

        if ($this->offset) {
            $code = self::addOffset($code, $this->offset);
        }

        $code = ($this->before ? Html::encode($this->before).PHP_EOL : '')
                .Html::encode(rtrim($code)).PHP_EOL
                .($this->after ? Html::encode(trim($this->after)).PHP_EOL : '')
        ;

        $codeClass = $this->codeClass
                     ? ' class="'.Html::encode($this->codeClass).'"'
                     : ''
        ;

        return str_replace(
            ['{%CODE_CLASS%}','{%CODE%}'],
            [$codeClass,$code],
            $this->template
        );
    }

    protected static function getDefaultTemplate(){
        return '<pre><code{%CODE_CLASS%}>{%CODE%}</code></pre>';
    }

    protected static function cleanupCode($code) {
        $code = str_replace("\t", "    ", $code);
        $code = self::cutLeadOffset($code);
        return $code;
    }

    protected static function addOffset($code, $offset) {
        return preg_replace('~^~um', $offset, $code);
    }

    protected static function cutLeadOffset($code){
        $cutFirstLen = self::getCutFirstLen($code);
        if ($cutFirstLen) {
            $code = preg_replace('~^\s{'.$cutFirstLen.'}~um', '', $code);
        }
        return $code;
    }

    protected static function getCutFirstLen($code){
        $ret = 0;
        $lines = explode(PHP_EOL, $code);
        if ($lines) {
            foreach($lines as $line) {
                if (!trim($line)) continue;
                if (preg_match('~^(\s+)\S~', $line, $regs)) {
                    $ret = strlen($regs[1]);
                }
                break;
            }
        }
        return $ret;
    }

}
