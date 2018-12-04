<!DOCTYPE html>

<html>
	<head>
		<title>Todays Orders</title>
	</head>
	<body>
		<h2>Orders On {{ date('jS M Y') }}</h2>
				@if(!empty($orderList))
					<div class="box-body">
						<table id="userTable" border="1" cellspacing="2" cellpadding="2">
							<thead>
								<tr>
										<th class="text-center">No</th>
										<th class="text-center">Name</th>
										<th class="text-center">Mobile</th>
	                  <th class="text-center" style="width:20%;">Tiffin</th>
	                  <th class="text-center">Price</th>
	                  <th class="text-center" style="width:15%;">Office/Building</th>
										<th class="text-center">Sector</th>
										<th class="text-center">City</th>
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
									<td>{{ ucfirst($list['price']) }}</td>
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
