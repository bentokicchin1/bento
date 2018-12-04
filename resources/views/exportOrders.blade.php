<!DOCTYPE html>

<html>
	<head>
		<title>Hi</title>
	</head>
	<body>
		<h1>Todays Orders</h1>
				@if(!empty($orderList))
					<div class="box-body">
						<table id="userTable" border="2" cellspacing="5" cellpadding="5">
							<thead>
								<tr>
										<th>No</th>
										<th>Name</th>
										<th>Mobile</th>
										<th>Tiffin</th>
										<th>Office/Building</th>
										<th>Sector</th>
										<th>City</th>
								</tr>
							</thead>
							<tbody>
								@php
										$i = 1;
								@endphp
								@foreach($orderList as $list)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ ucfirst($list['name']) }}</td>
									<td>{{ $list['mobile_number'] }}</td>
									<td>
	                  <ul>
	                    @foreach($list['menu'] as $val)
	                      <li>{{ $val['quantity'].' '.$val['dish'] }}</li>
	                    @endforeach
	                 </ul>
								  </td> 
									<td>{{ ucfirst($list['address']) }}</td>
									<td>{{ ucfirst($list['area']) }}</td>
									<td>{{ ucfirst($list['city']) }}</td>
									@php
											$i++;
									@endphp
								</tr>
								@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</body>
	</html>
