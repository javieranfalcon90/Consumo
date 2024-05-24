<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {
        if($this->getUser() == 'Superadministrador'){
            return $this->redirectToRoute('administrador');
        }else{

            $usuario = $this->getUser()->getEntry()->getAttributes()['cn'][0];

            return $this->render('main/usuario.html.twig',[
                'usuario' => $usuario
            ]);
        }

    }

    /**
     * @Route("/administrador", name="administrador")
     */

    public function administrador(Request $request){

        if($request->get('date')){
            $date = new \DateTime($request->get('date'));
            $file1 = 'data'.$date->format('Ymd').'.txt';
        }else{
            $date = date("Ymd");
            $file1 = 'data'.$date.'.txt';
        }

$array = [];

        /*$filedir1 = "\\\proxy\\Log\\".$file1;*/
       /* $filedir1 = "/var/www/html/consumo.cecmed.local/public/log/".$file1;

        $file1 = fopen($filedir1, "r") or exit("Unable to open file!");

        $patrón = "/([^\s]+)/"; // IMPORTANTE!!!! EXPRESION REGULAR PARA OBTENER LAS COSAS DEL FICHERO

        while (!feof($file1)) {

            $linelog = fgets($file1);
            preg_match_all($patrón, $linelog, $coincidencias);

            if(!empty($coincidencias[0])){

                $consumo = ((integer)$coincidencias[0][1] + (integer)$coincidencias[0][2])/1048576;
                $consumo = round($consumo, 3);

                $array[] = array(
                    'usuario' => $coincidencias[0][0],
                    'consumo' => $consumo
                );

            }

        }

        fclose($file1);*/


        return $this->render('main/administrador.html.twig',[
            'usuario' => $this->getUser(),
            'resultados' => $array
        ]);
    }

    /**
     * @Route("/search", name="search", options={"expose"=true})
     */
    public function search(Request $request){

        if($request->get('date')){
            $date = new \DateTime($request->get('date'));
            $file1 = 'data'.$date->format('Ymd').'.txt';
        }else{
            $date = date("Ymd");
            $file1 = 'data'.$date.'.txt';
        }

        /*$filedir1 = "\\\proxy\\Log\\".$file1;*/
	$filedir1 = "/var/www/html/consumo.cecmed.local/public/log/".$file1;

        $file1 = fopen($filedir1, "r") or exit("Unable to open file!");

        $patrón = "/([^\s]+)/"; /* IMPORTANTE!!!! EXPRESION REGULAR PARA OBTENER LAS COSAS DEL FICHERO */

        while (!feof($file1)) {

            $linelog = fgets($file1);
            preg_match_all($patrón, $linelog, $coincidencias);

            if(!empty($coincidencias[0])){

                if($this->getUser()->getUsername() == $coincidencias[0][0]){
                    $consumo = ((integer)$coincidencias[0][1] + (integer)$coincidencias[0][2])/1048576;
                    $consumo = round($consumo, 3);
                }
            }

        }

        fclose($file1);

        $data = array(
            "consumo" => $consumo
        );

        $data1 = json_encode($data);
        return new Response($data1, 200, array('Content-Type' => 'application/json'));


    }

    /**
     * @Route("/searchdatatable", name="searchdatatable", options={"expose"=true})
     */
    public function searchdatatable(Request $request){

        if($request->get('date')){
            $date = new \DateTime($request->get('date'));
            $file1 = 'data'.$date->format('Ymd').'.txt';
        }else{
            $date = date("Ymd");
            $file1 = 'data'.$date.'.txt';
        }

        /*$filedir1 = "\\\proxy\\Log\\".$file1;*/
	    $filedir1 = "/var/www/html/consumo.cecmed.local/public/log/".$file1;
        $file1 = fopen($filedir1, "r") or exit("Unable to open file!");

        $patrón = "/([^\s]+)/"; /* IMPORTANTE!!!! EXPRESION REGULAR PARA OBTENER LAS COSAS DEL FICHERO */

        while (!feof($file1)) {

            $linelog = fgets($file1);
            preg_match_all($patrón, $linelog, $coincidencias);

            if(!empty($coincidencias[0])){

                $consumo = ((integer)$coincidencias[0][1] + (integer)$coincidencias[0][2])/1048576;
                $consumo = round($consumo, 3);

                $array[] = array(
                    utf8_encode($coincidencias[0][0]),
                    $consumo
                );
            }

        }

        fclose($file1);

        $data = array(
            "data" => $array
        );

        $data1 = json_encode($data);
        return new Response($data1, 200, array('Content-Type' => 'application/json'));


    }

}
