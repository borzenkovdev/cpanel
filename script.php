<?php

/**
 * Класс вычисляет количство слов в строке
 * Class ParseString
 */
class ParseString
{
    protected $stringParse;

    protected $notWords = [
        "\t", '=', '+', '-', '*', '/', '\\', ',', '.', ';', ':', '[', ']', '{', '}', '(', ')', '<', '>', '&', '%', '$', '@', '#', '^', '!', '?', '~'
    ];

    /**
     * @param $arguments
     * @return bool
     */
    protected function isValidScriptArgs ($arguments)
    {
        return (count($arguments) == 2);
    }

    /**
     * Вернёт количество строк - метод str_word_count
     * @param $arguments
     * @return bool
     */
    public function parseString_v1 ()
    {
        $str = $this->stringParse;
        //уберём лишние символы из строки
        $str = str_replace($this->notWords, '', $str);

        $strWordsCount = str_word_count($str, 0, "АаБбВвГгҐґДдЕеЁёЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЪъЫыЮюЬьЭэЯя");

        //var_dump($strWordsCount);

        echo 'Result_v1: Quantity words in string is ' . $strWordsCount . PHP_EOL;
    }

    /**
     * Вернёт количество строк
     * @param $arguments
     * @return bool
     */
    public function parseString_v2 ()
    {
        $str = $this->stringParse;

        //уберём лишние символы из строки
        $str = str_replace($this->notWords,'',$str);

        //уберём пробелы с начала и конца строки
        $str= trim($str);

        //уберём повторяющиеся пробелмы
        $str = preg_replace("/(\s){2,}/",' ',$str);



        $strExpl = explode(' ', $str);

        //var_dump($strExpl);

        echo 'Result_v2: Quantity words in string is ' . count($strExpl) . PHP_EOL;
    }

    public function __construct($arguments) {
        if ($this->isValidScriptArgs($arguments)) {
            $this->stringParse = $arguments[1];
        } else {
            echo 'Error: Incorrect quantity of arguments' . PHP_EOL;
            $this->help();
            return false;
        }
    }

    /**
     * help
     */
    public function help ()
    {
        echo PHP_EOL . 'This script calulcate quantity words in sentence' . PHP_EOL;
        echo 'example of usage  "php script.php "Example of sentence" ' . PHP_EOL;
    }
}

$obj = new ParseString($argv);

$obj->parseString_v1();

$obj->parseString_v2();
?>
