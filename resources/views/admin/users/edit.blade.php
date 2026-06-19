@extends('layouts.app')

@section('title', 'Editar usuario '.$user->name.' | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-10 text-center">
                <div class="mb-5 px-5 text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Editando el usuario:</span> {{$user->name}} </h1>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                            <div class="text-center px-lg-3 mb-5">
                                <h2 class="h3 my-4">Datos personales</h2>
                            </div>
                            <div>
                                <form class="needs-validation" novalidate action="{{route('admin.users.update', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 row">
                                        <label for="dni" class="col-sm-3 col-form-label">DNI:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" value="{{old('dni', $user->dni)}}" placeholder="12345678" name="dni" required>
                                            @error('dni')
                                                <div class="invalid-feedback d-block">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="name" class="col-sm-3 col-form-label">Nombre:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name', $user->name)}}" placeholder="Nombre" name="name" required>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="lastname" class="col-sm-3 col-form-label">Apellido:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" value="{{old('lastname', $user->lastname)}}" placeholder="Apellido" name="lastname" required>
                                            @error('lastname')
                                                <div class="invalid-feedback d-block">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="email" class="col-sm-3 col-form-label">Email:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{old('email', $user->email)}}" placeholder="Email" name="email" required>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="role" class="col-sm-3 col-form-label">Rol:</label>
                                        <div class="col-sm-9">
                                            @foreach($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role_id" id="role{{ ucfirst($role->type) }}" value="{{ $role->id }}"
                                                    {{ old('role_id', $user->role_id) == $role->id ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role{{ ucfirst($role->type) }}">{{ ucfirst($role->name) }}</label>
                                            </div>
                                            @endforeach
                                            @error('role_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#eliminarUsModal">Eliminar Usuario</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if ($user->role->type === 'user')
                    <div class="col-lg-6">
                        <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                            <div class="text-center px-lg-3 mb-5">
                                <h2 class="h3 my-4">Membresía</h2>
                            </div>
                            <div>
                                @if($user->plans->isEmpty())
                                <p class="mb-0">No tiene ninguna membresía</p>
                                @else
                                <table class="table mb-3">
                                    <thead>
                                        <tr>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Membresía</th>
                                        <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->plans as $plan)
                                        <tr>
                                            <th scope="row">{{$plan->title}}</th>
                                            <td>$ {{number_format($plan->price, 0, ',', '.')}} / <span class="text-capitalize">{{$plan->duration}}</span></td>
                                            <td>
                                                <button
                                                    class="btn btn-outline-danger btn-sm"
                                                    type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#cancelarMembresiaModal"
                                                    data-plan-id="{{ $plan->id }}"
                                                    data-plan-name="{{ $plan->title }}"
                                                >Cancelar</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>Total: </th>
                                            <td colspan="2"><span class="text-capitalize fw-bold">$ {{number_format($totalPrice, 0, ',', '.')}}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endif
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="eliminarUsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="eliminarCatLabel">Eliminar Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Quiere eliminar definitivamente al usuario {{$user->name}} {{$user->lastname}} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Sí, eliminar al usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelarMembresiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="eliminarCatLabel">Membresía del Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Quiere cancelar el plan <span id="modal-plan-name" class="fw-bold"></span> para el usuario <span class="fw-bold">{{$user->name}} {{$user->lastname}}</span> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form id="form-cancelar-membresia" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Sí, cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let cancelarModal = document.getElementById('cancelarMembresiaModal');

cancelarModal.addEventListener('show.bs.modal', function (event) {

    let button = event.relatedTarget; // Botón que abrió el modal

    // Obtener valores del botón
    let planId = button.getAttribute('data-plan-id');
    let planName = button.getAttribute('data-plan-name');

    // Insertar texto en el modal
    cancelarModal.querySelector('#modal-plan-name').textContent = planName;

    // Configurar acción del formulario
    let form = cancelarModal.querySelector('#form-cancelar-membresia');

    form.action = `{{ url('admin/usuarios/' . $user->id . '/membresia') }}/${planId}`;
});
</script>
@endsection
