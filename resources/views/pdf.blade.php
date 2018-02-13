<!DOCTYPE html>
<html>
<head>
	<title>User list - PDF</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<a href="{{ route('pdf',['download'=>'pdf']) }}">Download PDF</a>
	<table class="table table-bordered">
		<thead>
			<th>Name</th>
			<th>Email</th>
      <tr>
				<td> Celda 1 </td>
				<td> Celda 2 </td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td> Celda 1 </td>
				<td> Celda 2 </td>
			</tr>
		</tbody>
	</table>
</div>
</body>
</html>
