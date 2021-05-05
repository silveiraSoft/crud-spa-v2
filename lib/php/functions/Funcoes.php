<?php

namespace Functions;

class Funcoes
{



    //function Funcoes(){
    public function __constructor()
    {
    }

    public static function removeAcentos($string)
    {

        return

            strtr(strtr($string, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿº° ', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyyoo_'), array(

                    'Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',

                    'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u', 'º' => 'o', '°' => 'o'

                ));
    }



    public static function retiraAcentos($string)
    {


        $acentos = array(

                    'Š','Ž','š','ž','Ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï',

                    'Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è',

                    'é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ',

                    'º','°',' ','ª'

                    );
        $sem_acentos = array(

                    'S','Z','s','z','Y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I',

                    'N','O','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e',

                    'e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y',

                    'o','o','_','a'

                    );
        return str_replace($acentos, $sem_acentos, utf8_encode($string));
    }

    public static function soNumeros($string)
    {


        return trim(preg_replace('#[^0-9]#', '', $string));
    }

    public static function utf8EncodeDeep(&$input)
    {

        if (is_string($input)) {
            $input = utf8_encode($input);
        } elseif (is_array($input)) {
            foreach ($input as &$value) {
                Functions\utf8EncodeDeep($value);
            }

            unset($value);
        } elseif (is_object($input)) {
            $vars = array_keys(get_object_vars($input));



            foreach ($vars as $var) {
                Functions\utf8EncodeDeep($input->$var);
            }
        }
    }

    public static function utf8DecodeDeep(&$input)
    {

        if (is_string($input)) {
            $input = utf8_decode($input);
        } elseif (is_array($input)) {
            foreach ($input as &$value) {
                utf8DecodeDeep($value);
            }

            unset($value);
        } elseif (is_object($input)) {
            $vars = array_keys(get_object_vars($input));



            foreach ($vars as $var) {
                utf8DecodeDeep($input->$var);
            }
        }
    }
    /*
    function mssql_real_escape_string($data) {

       $data = stripslashes(trim($data));

       $data = strip_tags($data);

       if ( !isset($data) or empty($data) ) return '';

      if ( is_numeric($data) ) return $data;



        $non_displayables = array(

               '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15

             '/%1[0-9a-f]/',             // url encoded 16-31

             '/[\x00-\x08]/',            // 00-08

             '/\x0b/',                   // 11

                '/\x0c/',                   // 12

                '/[\x0e-\x1f]/'             // 14-31

     );

       foreach ( $non_displayables as $regex )

          $data = preg_replace( $regex, '', $data );

       $data = str_replace("'", "''", $data );

      return $data;

    }
    */
    public static function mssqlRealEscapeString($data, $usarStrip_tags = true)
    {

        $data = trim($data);
        if ($usarStrip_tags) {
            $data = strip_tags($data);
        }



        if (!isset($data) or (!is_numeric($data) && empty($data))) {
            return '';
        }

        if (is_numeric($data)) {
            return $data;
        }



        $non_displayables = array(

                '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15

                '/%1[0-9a-f]/',             // url encoded 16-31

                '/[\x00-\x08]/',            // 00-08

                '/\x0b/',                   // 11

                '/\x0c/',                   // 12

                '/[\x0e-\x1f]/'             // 14-31

        );
        foreach ($non_displayables as $regex) {
            $data = preg_replace($regex, '', $data);
        }

        $data = str_replace("'", "''", $data);
        return $data;
    }
    //Retorna true quando for um número

    public static function somenteNumero($numero)
    {


        // numeros aceitos 0,1,2,3,4,5,6,7,8,9,37,38,39,40,46

        return preg_match("([0-9]{1})", $numero);
    }

    //Função para coverter data do brasil p/ banco

    public static function dataBr2bd($data)
    {


        $registros = explode('/', $data);
// ereg ("([0-9]{2})/([0-9]{1,2})/([0-9]{1,4})", $data, $registros);



        return $registros[2] . "-" . $registros[1] . "-" . $registros[0];
    }



    //Função para coverter data do banco p/ brasil

    public static function dataBd2br($data)
    {


        $registros = explode('-', $data);
        return $registros[2] . "/" . $registros[1] . "/" . $registros[0];

        // ereg ("([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})", $data, $registros);



        // return $registros[3]."/".$registros[2]."/".$registros[1];
    }



    public static function dataBd2tela($data)
    {


        // ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $data, $registros);

        $registros = explode('-', $data);
        return $registros[2] . "/" . $registros[1] . "/" . $registros[0];
    }



    /**

     * [hora_bd2tela Formata tipo time para HH:mm

     * @param  [type] $hora Ex.: 10:00:00

     * @return [type]       Ex.: 10:00

     */

    public static function horaBd2tela($hora)
    {


        return substr($hora, 0, 5);
    }

    //Função para tirar /n e chr13 do texto

    public static function tiraNtxt($str)
    {


        $str = str_replace(chr(13), "", $str);
        $str = str_replace("\n", "\\n", $str);
        return $str;
    }
}
