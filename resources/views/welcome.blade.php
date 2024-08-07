<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Rotas</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container text-center">
    <div class="row justify-content-md-center">
        <div class="col col-lg-12">
            <h1 class="mb-4">Listagem de Rotas</h1>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>HTTP Method</th>
                    <th>URI</th>
                    <th>Action</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>POST</td>
                    <td>/api/transactions</td>
                    <td>TransactionController@store</td>
                    <td>Creates a new transaction</td>
                </tr>
                <tr>
                    <td>GET</td>
                    <td>/api/statistics</td>
                    <td>TransactionController@index</td>
                    <td>Fetches statistics for the last 60 seconds of transactions</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>/api/transactions</td>
                    <td>TransactionController@destroy</td>
                    <td>Deletes all transactions</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
