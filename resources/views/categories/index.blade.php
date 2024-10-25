@extends('layouts.admin')
@section('content')
<!-- Begin Page Content -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold text-primary"> Categories</h3>
            <a href="{{route('categories.create')}}" class="btn btn-primary">Crear</a>

        </div>
        <div class="card-body">

            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>

                        <th scope="col">Title</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>         
                            <th scope="row">{{$category->id}}</th>
                            <td>
                                <img src="{{asset($category->image)}}" width="50">

                            </td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->icon}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{route('categories.edit',$category->id)}}">
                                    <span class="fas fa-edit"></span>
                                </a>
                            </td>
                            <td>

                                <form action="{{route('categories.destroy', $category->id)}}" method="POST" class="confirm-form mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"   class="btn btn-danger btn-sm">
                                        <span class="fas fa-trash"></span>
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @empty
                    <tr>
                        <td colspan="10">
                            No se encontararon registros
                        </td>
                    </tr>
                    @endforelse
           


                </tbody>
            </table>
        </div>
        <div class="card-footer">

            {{$categories->links()}}

        </div>
    </div>


</div>
@endsection