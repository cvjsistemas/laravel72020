@extends('layouts.app')



@section('title')
	Empleados
@endsection



@section('content')


<!--{{ route('empleados.store')}}-->

<div class="container-fluid">


 
        <div class="row">
        	<div class="col-md-12">

        		<button type="button" class="btn btn-primary btn-agregar"><i class="fa fa-plus"> </i>Agregar</button>

        		<br>
        		<br>
        		
        		<div class="table-responsive-md">

        			<table class="table" id="consulta">
        				
        				<thead>
        					<tr>
        						<th>Name</th>
        						<th>Position</th>
        						<th>Office</th>
        						<th>Age</th>
        						<th>Start Date</th>
        						<th>Salary</th>
        						<th>Acciones</th>
        					</tr>
        				</thead>	

        			</table>
        			
        		</div>


        	</div>
        </div>
   
</div>


<!--Modal Agregar--->

<form id="agregar" autocomplete="off">


<!-- Modal -->
<div class="modal fade" id="modal-agregar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      	@csrf


      	<input type="hidden" name="id" class="id">
        
      		<div class="form-group">
      			<label>Name</label>
      			<input class="form-control name" type="text" name="name" required="" ></input>
      		</div>


      		<div class="form-group">
      			<label>Position</label>
      			<input class="form-control position" type="text" name="position" required="" ></input>
      		</div>

      		<div class="form-group">
      			<label>Office</label>
      			<input class="form-control office" type="text" name="office" required="" ></input>
      		</div>

      		<div class="form-group">
      			<label>Age</label>
      			<input class="form-control age" type="number" name="age" required="" min="18" max="80" ></input>
      		</div>


      		<div class="form-group">
      			<label>Start Date</label>
      			<input class="form-control start_date" type="date" name="start_date" required="" ></input>
      		</div>


      		<div class="form-group">
      			<label>Salary</label>
      			<input class="form-control salary" type="number" name="salary" required="" step="any" min="0" ></input>
      		</div>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary btn-submit" id="btn-agregar">Agregar</button>
      </div>
    </div>
  </div>
</div>
</form>



<script>
	

function loadData(){

	$(document).ready(function(){


		$('#consulta').DataTable({



			language :{

				url : '{{ asset('js/spanish.json')}}'  // asset se usa para llamar elementos de la carpeta "public"

			},
			order:[[0,'ASC']],
			iDisplayLength: 25, // Mostrar numero de entradas por defecto seleccionada
			deferRender:true,// aumenta la velocidad de renderizado del datatable
			bProcessing:true, // aparece la palabra "processing"
			bAutoWidth:false, // Evista que se autoajuste el datatable
			destroy:true,//recarga el datatable

			ajax:{

				url:'{{ route('empleados.index')}}',
				type:'GET'

			},
			columns: [
				{data :"name"},
				{data :"position"},
				{data :"office"},
				{data :"age"},
				{data :"start_date"},
				{data :"salary"},
				{data : null, render:function(data){

					return `<button
						data-id="${data.id}"
					 type="button" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-pencil"></i></button>

					<button

						data-id="${data.id}"
					 type="button" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button>`
					;



				}}


			]

		});


	});

}

loadData();


// Mostrar Model Jquery
$(document).on('click','.btn-agregar',function(){


	$('#agregar')[0].reset();
	$('.id').val('');
	$('.modal-title').html('Agregar');
	$('.btn-submit').html('Agregar');
	$('#modal-agregar').modal('show');

});





$(document).on('submit','#agregar',function(e){

parametros = $(this).serialize();

//alert(parametros);

$.ajax({

	url:'{{ route('empleados.store') }}',
	type:'POST',
	data:parametros,
	//dataType:'JSON',
	beforeSend:function(){

		Swal.fire({

			title:'Cargando',
			text: 'Espere un momento....',
			showConfirmButton:false

		});

	},
	success:function(data){


		loadData();
		$('#modal-agregar').modal('hide');



		Swal.fire({

			title : data.title,
			text : data.text,
			icon : data.icon,
			timer : 2000,
			showConfirmButton: false


			});

		}

	});


		e.preventDefault(); //restringe la recarga de la pagina.


	});




//cargar Model Edit
$(document).on('click','.btn-edit',function(){



	$('#agregar')[0].reset();
	$('.id').val('');
	id = $(this).data('id');

	url = '{{ route('empleados.edit',':id')   }} ';
	url = url.replace(':id',id);

	//alert(id);
	$.ajax({

		url:url,
		type:'GET',
		data:{},
		dataType:'JSON',
		success:function(data){


			$('.id').val(data.id);
			$('.name').val(data.name);
			$('.position').val(data.position);
			$('.office').val(data.office);
			$('.age').val(data.age);
			$('.start_date').val(data.start_date);
			$('.salary').val(data.salary);



		}


	});

		$('.modal-title').html('Actualizar');
		$('.btn-submit').html('Actualizar');

	$('#modal-agregar').modal('show');




});

//carga modal de eliminar

$(document).on('click','.btn-delete',function(){

	id = $(this).data('id');

	url = '{{ route('empleados.destroy',':id')   }} ';
	url = url.replace(':id',id);


	Swal.fire({
		  title: 'Estas Seguro?',
		  text: "El registro se eliminara!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, estoy seguro!',
		  cancelButtonText: "Cancelar"
		}).then((result) => {
		  if (result.value) {
		    /*Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )*/
		    $.ajax({
		    	url:url,
		    	type:'DELETE',
		    	data:{
		    		'_token':'{{ csrf_token() }}'

		    	},
		    	dataType:'JSON',
		    	beforeSend:function(){

		    	},
		    	success(data){



				loadData();
			

		    			Swal.fire({

						title : data.title,
						text : data.text,
						icon : data.icon,
						timer : 2000,
						showConfirmButton: false


						});

		    	}


		    });

		  }
		})

});




</script>


@endsection
