<?php

namespace AppBundle\Command;

use AppBundle\Entity\Subentzioa;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Konzesioa;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSubentzioakCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('get-subentzioak')
            ->setDescription('Subentzioak eskuratzeko aplikazioa')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
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
        try {
            $r = $client->request( 'GET', 'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias' );
        } catch ( GuzzleException $e ) {
            echo $e->getMessage();
        }

        $post_data = array(
            "_ministerios"       => "1",
            "_organos"           => "1",
            "_cAutonomas"        => "1",
            "_departamentos"     => "1",
            "administracion"     => "locales",
            "entLocSearch"       => "pasaia",
            "locales"            => "3532",
            "_locales"           => "1",
            "localesOculto"      => "3532",
            "_localesOculto"     => "1",
            "beneficiarioFilter" => "DNI",
            "beneficiarioDNI"    => "",
            "beneficiarioNombre" => "",
            "beneficiario"       => "",
            "fecDesde"           => "",
            "fecHasta"           => "",
            "titulo"             => "",
            "_regiones"          => "1",
            "_actividadesNACE"   => "1",
            "_instrumentos"      => "1",
        );

        $r = $client->post(
            'http://www.pap.minhafp.gob.es/bdnstrans/GE/es/convocatorias', array (
            'form_params' => $post_data
        ));

        $cookieJar = $client->getConfig('cookies');
        $gaileta = $cookieJar->toArray();
        $nireCookie = $this->parse_cookie( $gaileta );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
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
        curl_setopt( $ch, CURLOPT_COOKIE, $nireCookie );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        $erantzuna = curl_exec( $ch );
        curl_close( $ch );

        $data = json_decode( $erantzuna, true );
        $miJson = json_encode( $data[ "rows" ] );
        $arr = array();
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $output->writeln( 'Subentzioen datuak esportatzen...' );

        if ( array_key_exists("rows", $data)) {
            foreach ($data["rows"] as $a) {

                $output->writeln( $a[ 5 ] );
                $s = new Subentzioa();
                $s->setAdministracion( $a[ 1 ] );
                $s->setDepartamento( $a[ 2 ] );
                $s->setOrgano( $a[ 3 ] );
                $s->setFechaRegistro( $a[ 4 ] );
                $s->setTituloConvocatoria( $a[ 5 ] );
                $s->setBbReguladoras( $a[ 6 ] );
                $s->setIdbdns( $a[ 7 ] );
                $s->setEguneratua( new \DateTime() );
                $em->persist( $s );
            }
            $em->flush();
        }

        $output->writeln('Amaitu da.');
    }

    function parse_cookie($gaileta) {

        $nireCookie ="";
        $lehena = 1;
        $resp="";

        foreach ($gaileta as $key => $val) {

            if ($lehena == 1) {
                $nireCookie .= $val["Name"]."=".$val["Value"];
                $lehena = 0;
            } else {
                $nireCookie .= "; ".$val["Name"]."=".$val["Value"];
            }
        }
        $var1 = "JSESSIONID=".$gaileta[0]["Value"].";";
        $resp = $var1;
        if (count($gaileta)>1) {
            $var2 = " TS01358f12=".$gaileta[1]["Value"].";";
            $var3 = " TS0181fda2=".$gaileta[2]["Value"];
            $resp = $resp . $var2 . $var3;
        }


        return $resp;
    }

}
