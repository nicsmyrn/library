@extends('admin.dashboard')

@section('header')
    Προβολή Χρηστών
@endsection

@section('content')
<div class="row">
    <div id="users">
        <input v-model="search" class="form-control">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th v-repeat="columns">
                        <a href="#" v-on="click: sortBy(header)" v-class="active: sortKey == header">@{{ value }} <i class="fa fa-sort-amount-asc"></i></a>
                    </th>
                    <th><a href="#">E-mail</a> </th>
                    <th><a href="#">Type</a> </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody data-link="row" class="rowlink">
                <tr v-repeat="users |filterBy search | orderBy sortKey reverse">
                    <td>@{{ last_name }}</td>
                    <td>@{{ first_name }}</td>
                    <td>@{{ username }}</td>
                    <td>@{{ email }}</td>
                    <td>@{{ role.name }}</td>
                    <td>Edit | Delete </td>
                </tr>
            </tbody>
        </table>
        <pre>@{{ $data | json }}</pre>

     </div>
</div>

@endsection

@section('scripts.footer')
     <script src="/js/vue_users.js"></script>
@endsection