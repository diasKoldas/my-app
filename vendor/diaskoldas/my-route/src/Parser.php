<?php
namespace MyRoute;


class Parser
{
    const STRING = "@STRING@";
    const INTEGER = "@INTEGER@";
    const STRING_PATTERN = "/@STRING@/";
    const INTEGER_PATTERN = "/@INTEGER@/";
    const STRING_ROUTE = "[a-z-]+";
    const INTEGER_ROUTE = "\d+";
    const STRING_ROUTE_PATTERN = "/[\{]\w+[\}]/";
    const INTEGER_ROUTE_PATTERN = "/[\{]\w+\:\\\d\+[\}]/";

    public static function getRegex($route)
    {
        // Заменим все строчные переменные
        $result = preg_replace(self::STRING_ROUTE_PATTERN,self::STRING, $route);

        // Заменим все числовые переменные
        $result = preg_replace(self::INTEGER_ROUTE_PATTERN,self::INTEGER, $result);

        // Заменяем строковые переменные на регулярное выражение
        $result = preg_replace(self::STRING_PATTERN,self::STRING_ROUTE, $result);

        // Заменяем числовые переменные на регулярное выражение
        $result = preg_replace(self::INTEGER_PATTERN,self::INTEGER_ROUTE, $result);

        // Устанавливаю правила для дополнительных параметров
        $pattern = "/\[[\/]/";
        $result = preg_replace($pattern,"($|/", $result);
        $pattern = "/[\]]$/";
        $result = preg_replace($pattern,")", $result);

        // Обрабатываем все слэши
        $pattern = "/[\/]/";
        $result = preg_replace($pattern,"\/", $result);

        $result = "/^{$result}$/";

        return $result;
    }

    public static function getVars($route, $query)
    {
        /**
         * Подготавливаем массив из роута
         */
        $result = preg_replace("/^[\/]/","", $route); // Удалим первый слэш
        $result = preg_replace("/\[|\]/","", $result); // Удалим квадратные скобки
        $result = preg_replace("/\:\\\d\+/","", $result); // Удалим префиксы у переменных
        $result = preg_replace("/\{|\}/","@", $result); // Заменим фигурные скобки на @
        $result_route = preg_split("/\//",$result); //  Разобьем на массив

        /**
         * Подготавливаем массив из запроса
         */
        $result = preg_replace("/^[\/]/","", $query); // Удалим первый слэш
        $result_query = preg_split("/\//",$result); //  Разобьем на массив

        /**
         * Создаем массив с переменными и знаениями
         */
        $arrVars = [];
        foreach ($result_route as $key => $value)
        {
            if (!empty($result_query[$key]))
            {
                $arrVars[$value] = $result_query[$key];
            }
        }

        /**
         * Удаляем все не переменные с массива
         */
        foreach ($arrVars as $key => $value)
        {
            if (preg_match("/^\w+$/", $key, $matches))
            {
                unset($arrVars[$key]);
            }
        }

        return self::getSimpleKey($arrVars);
    }

    public static function getSimpleKey($vars)
    {
        foreach ($vars as $key => $var)
        {
            $simple_key = preg_replace("/@/", "", $key);
            $vars[$simple_key] = $var;
            unset($vars[$key]);
        }
        return $vars;
    }
}