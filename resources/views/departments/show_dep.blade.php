<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

<div class="container" style="width:900px; margin-top:20px;">

    <table class="table" id="table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($users as $user)
            <tr class="user{{$user->id}}">
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <form action="/departments/show/update/{{$user->id}}" method="post">
                        <input class="btn btn-danger" type="submit" value="Remove" style="display:inline-block" />
                        @method('patch')
                        @csrf
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>


</div>