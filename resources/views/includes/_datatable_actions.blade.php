@if(@$getDate)
	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row p-0 m-0">
						<div class="col-md-2 p-0">
							<label>{{$getDate}} Date</label>
						</div>
						<div class="col-md-2  p-0">
							<input type = "date" id="dateto" name="dateto" value = "{{ $today }}" class="form-control "/>
						</div>
						<div class="col-md-2  p-0">
							<button id="btn-reload" class="btn btn-info btn-sm float-right">Reload</button>
						</div>
					</div>
				</div>
			</div>
	</div>
@endif
@if(@$getMonth)
	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row p-0 m-0">
								<input hidden type = "text" id="datefrom" name="datefrom" value = "{{ $today }}" class="form-control "/>
							  <input  hidden  type = "text" id="dateto" name="dateto" value = "{{ $today }}" class="form-control "/>
								<div class="col-md-10">

									<a href="#" onclick="ajaxReload('01')" class="btn btn-info btn-sm">January</a>
									<a href="#" onclick="ajaxReload('02')"  class="btn btn-primary btn-sm">February</a>
									<a href="#" onclick="ajaxReload('03')"  class="btn btn-secondary btn-sm">March</a>
									<a href="#" onclick="ajaxReload('04')"  class="btn btn-warning btn-sm">April</a>
									<a href="#" onclick="ajaxReload('05')"  class="btn btn-info  btn-sm" btn-sm>May</a>
									<a href="#" onclick="ajaxReload('06')"  class="btn btn-success btn-sm">June</a>
									<a href="#" onclick="ajaxReload('07')"  class="btn btn-danger btn-sm">July</a>
									<a href="#" onclick="ajaxReload('08')"  class="btn btn-primary btn-sm">August</a>
									<a href="#" onclick="ajaxReload('09')"  class="btn btn-info btn-sm">September</a>
									<a href="#" onclick="ajaxReload('10')"  class="btn btn-secondary btn-sm">October</a>
									<a href="#" onclick="ajaxReload('11')"  class="btn btn-warning btn-sm">November</a>
									<a href="#" onclick="ajaxReload('12')"  class="btn btn-danger btn-sm">December</a>

								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-md-4">
												<label>
													Year:
												</label>
										</div>
										<div class="col-sm-8">
											<select id="yearto" class='form-control' >
											 	 <?php
											 		 $yirto = date('Y');
											 		 $yirfrom = $yirto - 2000;


											 		 for ( $i = 0; $i < $yirfrom; $i++) {
											 				echo "<option  value ='". ($yirto-$i) ."'> ".($yirto-$i)."</option>";
											 		 }
											 	 ?>
									 	 </select>
									 </div>
								 </div>
							  </div>
					</div>
				</div>
			</div>
	</div>
@endif
@if(@$getYir)
	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row p-0 m-0">
								<input hidden type = "text" id="datefrom" name="datefrom" value = "{{ $today }}" class="form-control "/>
							  <input hidden   type = "text" id="dateto" name="dateto" value = "{{ $today }}" class="form-control "/>

									<div class="row col-md-12">

												<h5 class="p-1">
													{{$getYir}} Year:
												</h5>

											<select id="yearto" class='form-control col-sm-2' >
											 	 <?php
											 		 $yirselected = date('Y',strtotime($today));

													 $yirto = date('Y');
											 		 $yirfrom = $yirto - 2000;


											 		 for ( $i = 0; $i < $yirfrom; $i++) {

											 				echo "<option ".($yirselected ==  ($yirto-$i) ? " selected":"")." value ='". ($yirto-$i) ."' > ".($yirto-$i)."</option>";
											 		 }
											 	 ?>

									 	 </select>

										 	<a href="#" onclick="ajaxReload('01')" class="btn btn-info btn-sm p-1 offset-1"> Reload</a>

							  </div>

					</div>
				</div>
			</div>
	</div>
@endif

@if(@$getDateRange)
	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row p-0 m-0">

						<div class="col-md-2  p-0">
							<div class="form-group">
								<label>From</label> <input type = "date" id="datefrom" name="datefrom" value = "{{ $datefrom }}" class="form-control "/>
							</div>
						</div>
						<div class="col-md-2  p-0">
							<label>To</label><input type = "date" id="dateto" name="dateto" value = "{{ $dateto }}" class="form-control "/>
						</div>
						<div class="col-md-2  p-4">
							<button id="btn-reload" class="btn btn-info btn-sm float-right">Reload</button>
						</div>
					</div>
				</div>
			</div>
	</div>
@endif

@if(@$colUrl)
	<a href="{{ $colUrl }}" >{{ $colVal }}</a>
@endif
@if(@$colImg)

	<a href="{{ $colImgUrl }}" class=" ">
		<img class="img-rounded" style="height:{{ $colHeight }}; width: {{ $colWidth }};" src="{{$colImg}}" alt="{{ $colVal }}">
	</a>
@endif
@if(@$addBtn)
	<a href="{{$addBtn}}" class="btn btn-sm btn-success float-right offset-sm-1"><i class="nav-icon fa fa-plus"></i> {{$BtnCaption}} </a>

@endif
@if(@$showUrl)
	<a href="{{$showUrl}}" class="btn btn-sm btn-info btn-xs " title ="View Record"><i class="nav-icon fa fa-eye"></i></a>
@endif
@if(@$addUrl)
<a href="{{$addUrl}}" class="btn btn-sm btn-success btn-xs addBtn" title ="Add Record"><i class="nav-icon fa fa-plus"></i></a>
@endif
@if(@$editUrl)
<a href="{{$editUrl}}" class="btn btn-sm btn-secondary btn-xs deleteBtn" title ="Edit Record"><i class="nav-icon fa fa-edit"></i></a>
@endif
@if(@$editPurchaseItem)
<a href="#" onclick="showEditForm({{$editPurchaseItem}})" id = "btn_{{$editPurchaseItem}}" class="btn btn-sm btn-secondary btn-xs deleteBtn" title ="Edit Record"><i class="nav-icon fa fa-edit"></i></a>
@endif
@if(@$editTable2)
<a href="#" onclick="showEditForm2({{$editTable2}})" id = "btn_{{$editTable2}}" class="btn btn-sm btn-secondary btn-xs deleteBtn" title ="Edit Record"><i class="nav-icon fa fa-edit"></i></a>
@endif
@if(@$deleteUrl)
<a href="#" onclick="confirmDelete(this)" data-href="{{$deleteUrl}}" data-method="DELETE" title ="Delete Record" class="btn btn-sm btn-danger btn-action-to-confirm btn-xs deleteBtn" data-toggle="modal" data-target="#confirm-modal"><i class="nav-icon fa fa-trash"></i></a>
@endif
@if(@$downloadUrl)
<form  action="{{$downloadUrl}}" method="POST">
	{{ Form::token() }}
	<button type="submit" class="btn btn-sm btn-primary">{{trans('app.download')}}</button>
</form>
@endif
@if(@$approveUrl)
<form  action="{{$approveUrl}}" method="POST">
	{{ Form::token() }}
	<button type="submit" class="btn btn-sm btn-default">{{trans('app.approve')}}</button>
</form>
@endif
@if(@$featureUrl && isset($isFeatured))
<a data-href="{{$featureUrl}}" title="{{trans('app.pim.candidates.mark_featured_title')}}" class="btn btn-default feature-candidate"><i style="{{$isFeatured ? 'color: orange' : ''}}" class="glyphicon glyphicon-star" aria-hidden="true"></i></a>
@endif
