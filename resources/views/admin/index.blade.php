@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">

        <div class="row justify-content-center py-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="title mb-0 fs-2">Bienvenido {{Auth::user()->name}}</h1>
                </div>
            </div>
        </div>

        <div class="admin-dashboard row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fw-medium fs-5">Últimos Planes</h2>
                        <a href="{{route('admin.plans.index')}}" class="btn btn-light btn-sm">Ir a Planes</a>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestPlans as $plan)
                                    <tr>
                                        <td>{{ $plan->title }}</td>
                                        <td><span class="fw-bold text-nowrap">$ {{ number_format($plan->price, 0, ',', '.') }}</span></td>
                                        <td><span class="badge {{$plan->status ? 'text-bg-success' : 'text-bg-warning' }}">{{$plan->status ? 'Activo' : 'Inactivo' }}</span></td>
                                        <td class="text-center">
                                            <a href="{{route('admin.plans.show', $plan)}}" class="btn btn-sm btn-primary">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="ms-auto text-end col-12">
                                <a href="{{route('admin.plans.create')}}" class="btn btn-primary btn-sm">AGREGAR NUEVO PLAN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fw-medium fs-5">Últimas Categorías</h2>
                        <a href="{{route('admin.categories.index')}}" class="btn btn-light btn-sm">Ir a Categorías</a>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Código</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($latestCategories->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No hay categorías cargadas.</td>
                                    </tr>
                                    @endif
                                    @foreach($latestCategories as $category)
                                    <tr>
                                        <td>{{ $category->code }}</td>
                                        <td><span class="text-capitalize">{{ $category->name }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm mx-2 btn-primary">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="ms-auto text-end col-12">
                                    <a href="{{route('admin.categories.create')}}" class="btn btn-primary btn-sm">AGREGAR NUEVA CATEGORÍA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-dark d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-medium fs-5">Últimos Usuarios</h2>
                <a href="{{route('admin.users.index')}}" class="btn btn-light btn-sm">Ir a Usuarios</a>
            </div>
            <div class="card-body">
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">DNI</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo de usuario</th>
                                <th scope="col">Membresía</th>
                                <th scope="col" class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($latestUsers->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                            @endif
                            @foreach($latestUsers as $user)
                            <tr>
                                <td>{{ $user->dni }}</td>
                                <td>{{ $user->name }} {{ $user->lastname }}</td>
                                <td>{{$user->role->name}}</td>
                                <td>
                                    @if($user->plans->isEmpty())
                                    <p class="text-muted fst-italic small">No tiene ninguna membresía</p>
                                    @else
                                    <ul class="list-unstyled mb-0">
                                        @foreach($user->plans as $plan)
                                        <li @class(['plan-item', 'text-danger' => !$plan->pivot->is_active,])>
                                            {{$plan->title}}
                                            @if(!$plan->pivot->is_active)
                                            <span class="badge text-bg-warning">Inactivo</span>
                                            @endif
                                            @if(!$plan->pivot->is_valid_now)
                                            <span class="badge text-bg-danger">Vencido</span>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm mx-2 btn-primary">Ver</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5">Suspender la membresía</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Queres cancelar tu plan actual en nuestro gym?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="btn-unsuscribe" onclick="unsuscribe()">Sí</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
         /*Funciones del formulario*/
        function toggleInputs() {
            const inputs = document.querySelectorAll('#f-user-data input');
            inputs.forEach(input => {
                input.readOnly = !input.readOnly;
            });
            document.getElementById("btn-edit").style.display = "none";
            document.getElementById("btns-actions").style.display = "";
            document.getElementById("alert-success").style.display = "none";
        }
        function readOnlyInputs(event) {
            event.preventDefault();
            const btnTarget = event.target.id;
            const inputs = document.querySelectorAll('#f-user-data input');
            inputs.forEach(input => input.readOnly = true);
            document.getElementById("btns-actions").style.display = "none";
            document.getElementById("btn-edit").style.display = "";
            document.getElementById("alert-success").style.display = "none";
            if (btnTarget === 'btn-save') {
                document.getElementById("alert-success").style.display = "";
                setTimeout(() => {
                    document.getElementById("alert-success").style.display = "none";
                }, 2000);
            }
        }
        /*Funciones para cambiar de plan*/
        function togglePlan() {
            const modifyPlan = document.getElementById("modify-plan").classList.toggle('d-none');
            const currentPlan = document.getElementById("current-plan").classList.toggle('d-none');
        }
        function changePlan(){
            togglePlan();
            document.getElementById("alert-plan").style.display = "";
            setTimeout(() => {
                document.getElementById("alert-plan").style.display = "none";
            }, 2000);
        }
        function activePlan() {
            changePlan();
            document.getElementById("no-plan").style.display = "none";
            document.getElementById("modify-plan").classList.add("d-none");
        }
        /*Funciones eliminar plan*/
        function unsuscribe(){
            const modalElement = document.getElementById('confirmDelete');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            document.getElementById("no-plan").style.display = "";
            document.getElementById("modify-plan").classList.add("d-none");
            document.getElementById("current-plan").classList.toggle('d-none');
        }
    </script>
@endsection
