<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado; //importa modelo Empleado
use DB;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        try {

             if ($request->ajax()) {
            
            //$result = Empleado::all();
                   // $result = array('data'=>Empleado::all());
                  //return $result;
               // $sql='';

              //  $result = DB::select($sql); // CONSULTA PERSONALIZADA

              //  dd($result);

                      $result = Empleado::select(DB::raw("

                            id,
                            name,
                            position,
                            office,
                            age,
                            DATE_FORMAT(start_date,'%d/%m/%Y') start_date,
                            salary



                    "))->get(); // DB::Raw se usa para consulta SQL

                      return array('data'=> $result);


                 }

       




             return view('empleados.index');



            
        } catch (\Illuminate\Database\QueryException $e) {
            
           // return $e->getMessage();
           // return $e->getCode();


                        return array(

                            'title'=>'Error',
                            'text'=>$e->getMessage(),
                            'icon'=>'error'

                        );



        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());
       /* Empleado::create([
                  "name" => $request->name,
                  "position" => $request->position,
                  "office" => $request->office,
                  "age" => $request->age,
                  "start_date" => $request->start_date,
                  "salary" => $request->salary

        ]);*/  try {


                     Empleado::updateOrCreate(


                        ['id'=>$request->id], // SI EXISTE ID, ACTUALIZA sino INSERTA


                        //VALORES DE REGISTRO O ACTUALIZACION
                        //"COLUMNA BD => PARAMETRO ENVIADO POR FORMULARIO"
                        [
                          "name" => $request->name,
                          "position" => $request->position,
                          "office" => $request->office,
                          "age" => $request->age,
                          "start_date" => $request->start_date,
                          "salary" => $request->salary
                        ]



                        );


                    $texto = (isset($request->id)) ? 'Registro Actualizado': 'Registro Agregado';



                        return array(

                            'title'=>'Buen trabajo',
                            'text'=>$texto,
                            'icon'=>'success'

                        );




            
        } catch (\Illuminate\Database\QueryException $e) {

               return array(

                            'title'=>'Error',
                            'text'=>$e->getMessage(),
                            'icon'=>'error'

                        );

            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        //dd($id);

        //$result = Empleado::all();
        $result = Empleado::find($id); //1ERA FORMA (FUNCIONA SOLO CON LLAVES PRIMARIAS)


        //$result = Empleado::where('id',$id)->first(); //2DA FORMA

        //$result = Empleado::firstWhere('id',$id); // 3ERA FORMA

        return $result;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Reque)st  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        Empleado::where('id',$id)->delete();

        return array(

            'title'=>'Buen trabajo',
            'text'=>'Registro Eliminado',
            'icon'=>'success'

        );
    }
}
