@extends('layouts.app')

@section('title', 'Usuarios | Admin Dashboard')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-10 text-center">

                <div class="mb-5 rounded-3 px-3 py-4 border bg-white text-start">
                    <div class="mb-3">
                        <div class="text-center px-lg-3">
                            <h1 class="title mb-4 mt-3">Usuarios</h1>
                            <p>Listado de usuarios</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                    @endif

                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Nombre y apellido</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tipo de usuario</th>
                                    <th scope="col" class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                                    </tr>
                                @endif
                                @foreach($users as $user)
                                    <tr class="{{($user->plans->isEmpty() && $user->role->type == 'user') ? 'table-warning' : ''}}">
                                        <td>{{$user->dni}}</td>
                                        <td>{{$user->name}} {{$user->lastname}} </td>
                                        <td><a href="mailto:{{$user->email}}" target="_blank">{{$user->email}}</a></td>
                                        <td><span class="text-capitalize">{{$user->role->name}}</span></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm mx-2 btn-secondary">Editar</a>
                                                <a href="{{route('admin.users.show', $user)}}" class="btn btn-sm mx-2 btn-primary">Ver</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
