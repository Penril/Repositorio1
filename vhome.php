    <div class="botones">
        <a class="btn btn-default <?php echo $vista == 'index' ? 'active' : '' ?>" href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-list-alt"></span> Itinerarios</a>
        <a class="btn btn-default <?php echo $vista == 'eventos' ? 'active' : '' ?>" href="<?php echo base_url(); ?>home/eventos"><span class="glyphicon glyphicon-tasks"></span> Tracking</a>
        <a class="btn btn-default <?php echo $vista == 'garantia' ? 'active' : '' ?>" href="<?php echo base_url(); ?>home/garantia"><span class="glyphicon glyphicon-star"></span> Garantizar</a>
        <a class="btn btn-default <?php echo $vista == 'cerrada' ? 'active' : '' ?>" href="<?php echo base_url(); ?>home/cerrada"><span class="glyphicon glyphicon-pushpin"></span> Cerradas</a>
    </div>
    <form class="form-inline formulario" role="form" method="post" action="">
        <label>Filtrar por:</label>
        <div class="form-group">
            <select id="pais" name="pais" class="form-control" onchange="cambiar()">
	           <option value="all">Todos los Paises</option>
             <?php 
             $opciones = array('ARGENTINA','BRAZIL','CHILE','COLOMBIA','ECUADOR','PERU');
             foreach ($opciones as $opcion) { ?>
               <option value="<?php echo $opcion;?>" <?php echo $opcion == 'CHILE' ? 'selected="selected"' : '' ?>><?php echo $opcion;?></option>
             <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <select id="puerto" name="puerto" class="form-control puerto">
	           <option value="all">Todos los Puertos</option>
             <?php 
             $opciones = array('ANTOFAGASTA','ARICA','IQUIQUE','PATILLOS','PUERTO ANGAMOS','SAN ANTONIO','SAN VICENTE','VALPARAISO');
             foreach ($opciones as $opcion) { ?>
               <option value="<?php echo $opcion;?>" <?php echo $opcion == 'CHILE' ? 'selected="selected"' : '' ?>><?php echo $opcion;?></option>
             <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <select name="servicio" class="form-control">
               <option value="all">Todos los Servicios</option>
            <?php 
             $opciones = array('ABAC','ACSA','ACW','AGAS','ASPA','ASW','CABOTAGE','CWL','CONOSUR','EUROSAL','FEEDER','INCA','NASA','NP2','PWS','WSA');
             foreach ($opciones as $opcion) { ?>
               <option value="<?php echo $opcion;?>"><?php echo $opcion;?></option>
             <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <select name="armador" class="form-control">
               <option value="all" selected="selected">Todos los Armadores</option>
               <option value="CAROTRANS CHILE">Carotrans Chile</option>
        	   <option value="CMA CGM">Cma-Cgm</option>
               <option value="EVERGREEN MARITIME CORP.">Evergreen</option>
               <option value="HAMBURG SUD SHIPPING GROUP (PSNC+LASER)">Hamburg Süd</option>
               <option value="HAPAG LLOYD CHILE AG. MARITIMA LTDA.">Hapag Lloyd</option>
               <option value="allasda">Hoegh Autoliners</option>
               <option value="HYUNDAI MERCHANT MARINE CO.">Hyundai</option>
               <option value="MITSUI OSK LINES">MOL</option>
               <option value="allsa">Transmares</option>
               <option value="Wan Hai">Wan Hai</option>
            </select>
        </div>
        <input type="submit" name="filtro" class="btn btn-primary" value="Aplicar Filtro"/>
    </form>
    
    <?php if (isset($parametros['pais']) && isset($parametros['servicio'])) { ?>
    <div class="busqueda">
            <label><p>Estas Filtrando por:</p></label>
            <label><p>País:</p> <span class="label label-primary"><?php echo $parametros['pais'] == 'all' ? 'Todos' : $parametros['pais']; ?></span></label>
            <?php if(isset($parametros['puerto']) && $parametros['puerto'] != '') { ?>
            <label><p>Puerto:</p> <span class="label label-primary"><?php echo $parametros['puerto'] == 'all' ? 'Todos' : $parametros['puerto']; ?></span></label>
            <?php } ?>
            <label><p>Servicio:</p> <span class="label label-primary"><?php echo $parametros['servicio'] == 'all' ? 'Todos' : $parametros['servicio']; ?></span></label>
            <label><p>Armador:</p> <span class="label label-primary"><?php echo $parametros['armador'] == 'all' ? 'Todos' : $parametros['armador']; ?></span></label>
    </div>
    <?php } ?>
    <!-- Inicio Vista 'Lista' -->
    <table id="tabla">
    <thead>
     <tr>
        <?php if ($vista == 'index' or $vista == 'garantia') { ?>
        <th width="20%">Armador</th>
        <th>Servicio</th>
    	<th width="15%">Nave</th>
        <th>Viaje</th>
        <th>Puerto Nacional</th>
        <th>Puerto Extranjero</th>
        <th>País</th>
        <?php if ($vista != 'garantia') { ?>
        <th>Código Contable</th>
        <?php } ?>
       	<th>ETA</th>
        <th>ETD</th>
        <?php if ($vista != 'garantia') { ?>
        <th>IMO</th>
        <?php } ?>
        <th class="default_sort">Proximidad</th>
        <th width="17%">Acciones</th>
        <?php } ?>
        
        <?php if ($vista == 'eventos' or $vista == 'cerrada') { ?>
        <th>Itinerario</th>
        <th>Baplie</th>
    	<th>EDI</th>
        <th>BL</th>
        <th>CTR</th>
        <th>Flete</th>
        <th>Garantía</th>
        <th>Manifestación</th>
       	<th>ETA</th>
        <th>ETD</th>
        <th class="default_sort">Proximidad</th>
        <th width="17%">Acciones</th>
        <?php } ?>
     </tr>
    </thead>
    <tbody>
    <?php 
    if(isset($registros)) {
    foreach ($registros as $registro) {   
        $dif_fecha = dateDiff(date("Y-m-d H:i:s"),$registro->ETA);
        $fechaETA = date_create_from_format('Y-m-d H:i:s', $registro->ETA);
        $fecha_nueva_ETA = date_format($fechaETA, 'd-m-Y');
        $fechaETD = date_create_from_format('Y-m-d H:i:s', $registro->ETD);
        $fecha_nueva_ETD = date_format($fechaETD, 'd-m-Y');
        ?>
    <tr>
        <?php if ($vista == 'index' or $vista == 'garantia') { ?>
        <td><?php echo $registro->armador; ?></td>
        <td><?php echo $registro->servicio; ?></td>
    	<td><?php echo $registro->nave; ?></td>
        <td><?php echo $registro->viaje; ?></td>
        <td><?php echo $registro->puerto; ?></td>
       	<td><?php echo $registro->puerto_anterior; ?></td>
        <td><?php echo $registro->pais; ?></td>
        <?php if ($vista != 'garantia') { ?>
        <td><?php echo $registro->cc; ?></td>
        <?php } ?>
       	<td><?php echo $fecha_nueva_ETA; ?></td>
        <td><?php echo $fecha_nueva_ETD; ?></td>
        <?php if ($vista != 'garantia') { ?>
        <td><?php echo $registro->IMO; ?></td>
        <?php } ?>
        <td <?php echo $dif_fecha <= 0 ? 'class="danger"' : '' ?>><?php echo $dif_fecha; ?></td>
        <?php } ?>
        
        <?php if ($vista == 'eventos' or $vista == 'cerrada') { ?>
        <td><?php echo $registro->nave; ?> <?php echo $registro->viaje; ?> <?php echo $registro->puerto; ?></td>
        <td <?php echo $registro->plano == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->plano != 0 ? 'Si' : 'No'; ?></td>
    	<td <?php echo $registro->bl == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->bl != 0 ? 'Si' : 'No'; ?></td>
        <td <?php echo $registro->diferencia == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->diferencia != 0 ? 'Si' : 'No'; ?></td>
        <td <?php echo $registro->depurado == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->depurado != 0 ? 'Si' : 'No'; ?></td>
       	<td <?php echo $registro->flete == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->flete != 0 ? 'Si' : 'No'; ?></td>
        <td <?php echo $registro->garantia == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->garantia != 0 ? 'Si' : 'No'; ?></td>
        <td <?php echo $registro->manifiesto == 1 ? 'class="success"' : 'class="danger"' ?>><?php echo $registro->manifiesto != 0 ? 'Si' : 'No'; ?></td>
       	<td><?php echo $fecha_nueva_ETA; ?></td>
        <td><?php echo $fecha_nueva_ETD; ?></td>
        <td <?php echo $dif_fecha <= 0 ? 'class="danger"' : '' ?>><?php echo $dif_fecha; ?></td>
        <?php } ?>
     <td>
     <a href="<?php echo base_url(); ?>itinerario/detalle/<?php echo $registro->id; ?>"  data-toggle="tooltip" title="Trackear" class="btn btn-xs btn-primary tol-top"><span class="glyphicon glyphicon-share-alt"></span></a>
     <?php if ($this->ion_auth->in_group('colaborador') or $this->ion_auth->in_group('admin')) { ?>
     <a href="<?php echo base_url(); ?>itinerario/editar/<?php echo $registro->id; ?>"  data-toggle="tooltip" title="Editar" class="btn btn-xs btn-primary tol-top"><span class="glyphicon glyphicon-pencil"></span></a>
     <a href="<?php echo base_url(); ?>itinerario/delete/<?php echo $registro->id; ?>"  data-toggle="tooltip" title="Eliminar" onclick="return confirmar();" class="btn btn-xs btn-danger tol-top"><span class="glyphicon glyphicon-trash"></span></a>
     <?php } ?>
     </td>
    </tr>
    <?php }} ?>
    </tbody>
    </table>
    <!-- Fin Vista 'Lista' -->