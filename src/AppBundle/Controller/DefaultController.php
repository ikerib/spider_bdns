<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/subentzioak", name="subentzioak")
     * @param Request $request
     *
     * @return Response
     */
    public function subentzioakAction(Request $request)
    {

        $headers = [
            'headers' => [
                'Accept-Encoding'           => 'gzip, deflate',
                'Host'                      => 'www.pap.minhafp.gob.es',
                'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
                'Upgrade-Insecure-Requests' => '1',
                'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
                'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Cache-Control'             => 'no-cache',
                'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias',
                'DNT'                       => 1,
            ],
            'cookies'   => true,
            'debug'     => false
        ];
        $client = new Client($headers);
        $r = $client->request('GET', 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias');

        $cookieJar = $client->getConfig('cookies');
        $gaileta = $cookieJar->toArray();


        $nireCookie = $this->parse_cookie( $gaileta );
//
//
//        $post_data = array(
//            'type'      => 'convs',
//            '_search'   =>'false',
//            'nd'        =>'1521104104306',
//            'rows'      =>'50',
//            'page'      =>'1',
//            'sidx'      =>'4',
//            'sord'      =>'desc'
//        );



//        $response = $client->request(
//            'GET',
//            'http://www.pap.minhafp.gob.es/bdnstrans/busqueda?type=convs&_search=false&nd=1521188750178&rows=50&page=1&sidx=4&sord=desc',
//            array(
//                'headers' => [
//                    'Accept-Encoding'           => 'gzip, deflate',
//                    'Host'                      => 'www.pap.minhafp.gob.es',
//                    'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
//                    'Upgrade-Insecure-Requests' => '1',
//                    'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
//                    'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
//                    'Cache-Control'             => 'no-cache',
//                    'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias',
//                    'DNT'                       => 1,
//                    'Cookie'    => $nireCookie
//                ],
//                'query' => $post_data
//            )
//        );



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
//        curl_setopt( $ch, CURLOPT_URL, 'http://www.pap.minhafp.gob.es/bdnstrans/busqueda?type=convs&_search=false&nd=1521183725759&rows=50&page=1&sidx=4&sord=desc' );
//
//        $kabezerak = [
//            'Accept-Encoding'           => 'gzip, deflate',
//            'Host'                      => 'www.pap.minhafp.gob.es',
//            'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
//            'Upgrade-Insecure-Requests' => '1',
//            'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
//            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
//            'Cache-Control'             => 'no-cache',
//            'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias',
//            'DNT'                       => 1
//        ];
//
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//        $erantzuna = curl_exec( $ch );
//
//        $data = json_decode( $erantzuna );
//
//        $body = $response->getBody();


//        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt( $ch, CURLOPT_URL, 'http://www.pap.minhafp.gob.es/bdnstrans/busqueda?type=convs&_search=false&nd=1521189224961&rows=50&page=1&sidx=4&sord=desc' );

        $kabezerak = [
            'Pragma'                    => 'no-cache',
            'Accept-Encoding'           => 'gzip, deflate',
            'Host'                      => 'www.pap.minhafp.gob.es',
            'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
            'Accept'                    => 'application/json, text/javascript, */*; q=0.01',
            'Cache-Control'             => 'no-cache',
            'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias',
            'X-Requested-With'          => 'XMLHttpRequest',
            'DNT'                       => 1,
            'Connection'                => 'keep-alive'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $kabezerak);

        $strCookie="JSESSIONID=YQctkNo4ddSF9qa9lJO1hJicctZhNExoPI1H25e5Ikn5WwKShJOg!1207007942!-1943145791; TS01358f12=01b3ae6da862b76d28476e522f1ad3ac36ea6b98b1db27d40e95c0c32faca457bdb71d77370859fa64e4e3663852ab01d32537e6f77d63a6a93038f958991ba7b3e2cfd2ce; TS0181fda2=01b3ae6da8fc94c02d99a67af5ddd5bd1722f28f51823a1bae55a0e2e27f4021af37b70763aecdc1eb87ab6f2a0d0b4a80b4078a31";
//        curl_setopt( $ch, CURLOPT_COOKIE, $nireCookie );
        curl_setopt( $ch, CURLOPT_COOKIE, $strCookie );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);

        $erantzuna = curl_exec( $ch );

        curl_close( $ch );



        $data = json_decode( $erantzuna, true );

        $miJson = json_encode( $data[ "rows" ] );

        $arr = array();



        if ( array_key_exists("rows", $data)) {
            foreach ($data["rows"] as $a) {
                $temp = array(
                    'id'                => $a[ 0 ],
                    'administracion'    => $a[ 1 ],
                    'departamento'      => $a[ 2 ],
                    'Organo'            => $a[ 3 ],
                    'FechaRegistro'     => $a[ 4 ],
                    'TituloConvocatoria'=> $a[ 5 ],
                    'BBReguladoras'     => $a[ 6 ],
                    'IDBDNS'            => $a[ 7 ],

                );
                array_push( $arr, $temp );
            }
            return new JsonResponse( $arr );
        }

//        return $this->render( 'default/index.html.twig', array(
//            'res' => "2",
//
//        ) );
//
//
        return new JsonResponse( array( 'data' => 'No data',) );
    }

    /**
     * @Route("/konzesioak", name="konzesioak")
     * @param Request $request
     *
     * @return Response
     */
    public function konzesioakAction(Request $request)
    {

        $headers = [
            'headers' => [
                'Accept-Encoding'           => 'gzip, deflate',
                'Host'                      => 'www.pap.minhafp.gob.es',
                'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
                'Upgrade-Insecure-Requests' => '1',
                'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
                'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Cache-Control'             => 'no-cache',
                'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/concesiones',
                'DNT'                       => 1,
            ],
            'cookies'   => true,
            'debug'     => false
        ];
        $client = new Client($headers);
        $r = $client->request('GET', 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/concesiones');

        $cookieJar = $client->getConfig('cookies');
        $gaileta = $cookieJar->toArray();


        $nireCookie = $this->parse_cookie( $gaileta );




        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);


//        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt( $ch, CURLOPT_URL, 'http://www.pap.minhafp.gob.es/bdnstrans/busqueda?type=concs&_search=false&nd=1521199462977&rows=50&page=1&sidx=8&sord=asc' );

        $kabezerak = [
            'Pragma'                    => 'no-cache',
            'Accept-Encoding'           => 'gzip, deflate',
            'Host'                      => 'www.pap.minhafp.gob.es',
            'Accept-Language'           => 'es,eu;q=0.9,en-GB;q=0.8,en;q=0.7',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36',
            'Accept'                    => 'application/json, text/javascript, */*; q=0.01',
            'Cache-Control'             => 'no-cache',
            'Referer'                   => 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/concesiones',
            'X-Requested-With'          => 'XMLHttpRequest',
            'DNT'                       => 1,
            'Connection'                => 'keep-alive'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $kabezerak);

        $strCookie="JSESSIONID=YQctkNo4ddSF9qa9lJO1hJicctZhNExoPI1H25e5Ikn5WwKShJOg!1207007942!-1943145791; TS01358f12=01b3ae6da862b76d28476e522f1ad3ac36ea6b98b1db27d40e95c0c32faca457bdb71d77370859fa64e4e3663852ab01d32537e6f77d63a6a93038f958991ba7b3e2cfd2ce; TS0181fda2=01b3ae6da8fc94c02d99a67af5ddd5bd1722f28f51823a1bae55a0e2e27f4021af37b70763aecdc1eb87ab6f2a0d0b4a80b4078a31";
//        curl_setopt( $ch, CURLOPT_COOKIE, $nireCookie );
        curl_setopt( $ch, CURLOPT_COOKIE, $strCookie );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);

        $erantzuna = curl_exec( $ch );

        curl_close( $ch );



        $data = json_decode( $erantzuna, true );

        $miJson = json_encode( $data[ "rows" ] );

        $arr = array();



        if ( array_key_exists("rows", $data)) {
            foreach ($data["rows"] as $a) {
                $temp = array(
                    'administracion'            => $a[ 2 ],
                    'departamento'              => $a[ 3 ],
                    'Organo'                    => $a[ 4 ],
                    'TituloConvocatoria'        => $a[ 5 ],
                    'BBReguladoras'             => $a[ 6 ],
                    'AplicacionPresupuestaria'  => $a[ 7 ],
                    'FechaConcesion'            => $a[ 8 ],
                    'Beneficiario'              => $a[ 9 ],
                    'Importe'                   => $a[ 10 ],
                    'Instrumento'               => $a[ 11 ],
                    'AyudaEquivalente'          => $a[ 12 ],
                    'Detalles'                  => $a[ 13 ],
                );
                array_push( $arr, $temp );
            }
            return new JsonResponse( $arr );
        }

        
        return new JsonResponse( array( 'data' => 'No data',) );
    }

    function parse_cookie($gaileta) {

        $nireCookie ="";

        foreach ($gaileta as $key => $val) {

            $nireCookie .= $val["Name"]."=".$val["Value"]."; ";

        }

        return $nireCookie;
    }
}
