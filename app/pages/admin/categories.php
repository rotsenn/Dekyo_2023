<!-- 2. Ahora vamos a agregar las categorias -->
<?php 

	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//validacion de datos *****categorias*****
			if(empty($_POST['category']))
			{
				$errors['category'] = "se requiere un nombre de categoria";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['category'])){
				$errors['category'] = "una categoría puede tener letras y espacios";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['category'] = trim($_POST['category']);
				$values['disabled'] 	= trim($_POST['disabled']);

				$query = "insert into categories (category,disabled) values (:category,:disabled)";
				db_query($query,$values);

				message("Categoria creada con Éxito ");
				redirect('admin/categories');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from categories where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['category']))
			{
				$errors['category'] = "a category is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['category'])){
				$errors['category'] = "una categoría puede tener letras y espacios";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['category'] = trim($_POST['category']);
				$values['disabled'] 	= trim($_POST['disabled']);
				$values['id'] 		= $id;

				$query = "update categories set category = :category, disabled = :disabled where id = :id limit 1";
				db_query($query,$values);

				message("Categoria editada con Éxito");
				redirect('admin/categories');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from categories where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{

				$values = [];
				$values['id'] 		= $id;

				$query = "delete from categories where id = :id limit 1";
				db_query($query,$values);

				message("Categoria eliminada con Éxito");
				redirect('admin/categories');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Agregar Nueva categoria</h3>

	  				<input class="form-control my-1" value="<?=set_value('category')?>" type="text" name="category" placeholder="Nombre de Categoria">
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>
 
	  				<select name="disabled" class="form-control my-1">
	  					<option value="">--Seleccionar desabilitado--</option>
	  					<option <?=set_select('disabled','0')?> value="0">Si</option>
	  					<option <?=set_select('disabled','1')?> value="1">No</option>
	  				</select>
	  				<?php if(!empty($errors['disabled'])):?>
	  					<small class="error"><?=$errors['disabled']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-green">Guardar</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Editar Categoria</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('category',$row['category'])?>" type="text" name="category" placeholder="Categoryname">
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>

	  				<select name="disabled" class="form-control my-1">
	  					<option value="">--Seleccionar desabilitado--</option>
	  					<option <?=set_select('disabled','0',$row['disabled'])?> value="0">Si</option>
	  					<option <?=set_select('disabled','1',$row['disabled'])?> value="1">No</option>
	  				</select>

	  				<button class="btn bg-orange">Guardar</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Ese registro no fue encontrado</div>
	  					<a href="<?=ROOT?>/admin/categories">
		  					<button type="button" class="float-end btn">Atras</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Borrar Categoria</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('category',$row['category'])?></div>
	  				<?php if(!empty($errors['category'])):?>
	  					<small class="error"><?=$errors['category']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Borrar</button>
	  				<a href="<?=ROOT?>/admin/categories">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Ese registro no fue encontrado</div>
	  					<a href="<?=ROOT?>/admin/categories">
		  					<button type="button" class="float-end btn">Atras</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from categories order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Categorias 
  				<a href="<?=ROOT?>/admin/categories/add">
  					<button class="float-end btn bg-purple">Agregar</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Categoria</th>
  					<th>Activo</th>
  					<th>Accion</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['category']?></td>
		  					<td><?=$row['disabled'] ? 'No':'Si'?></td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/categories/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/categories/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>