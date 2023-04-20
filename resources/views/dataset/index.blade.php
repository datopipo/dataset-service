@extends('layouts.app')

@section('title', 'Dataset')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if(Session::has('error'))
        <div class="alert alert-danger">
            <h1> {{ Session::get('error') }}</h1>
            <form method="GET" action="{{ route('dataset.import') }}">
                <button type="submit" class="btn btn-secondary">import data</button>
            </form>
        </div>
    @endif

    <div class="container mb-4">
        <form method="GET" action="{{ route('dataset.index') }}">
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control form-control-sm" id="category" name="category">
                    <option value="">All</option>
                    <option value="toys">toys</option>
                    <option value="electronics">electronics</option>
                    <option value="handmade">handmade</option>
                    <option value="health">health</option>
                    <option value="films">films</option>
                    <option value="books">books</option>
                    <option value="clothes">clothes</option>
                    <option value="food">food</option>
                    <option value="sports">sports</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control form-control-sm" id="gender" name="gender">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control form-control-sm" id="age" name="age">
            </div>
            <div class="form-group">
                <label for="age_from">Age From</label>
                <input type="number" class="form-control form-control-sm" id="age_from" name="age_from">
            </div>
            <div class="form-group">
                <label for="age_to">Age To</label>
                <input type="number" class="form-control form-control-sm" id="age_to" name="age_to">
            </div><br>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button href="{{ route('dataset.index') }}" class="btn btn-primary">Reset</button>
        </form>
    </div>
    <!-- Display data table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Category</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Date of Birth</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data ?? $data as $row)
            <tr>
                <td>{{ $row->category }}</td>
                <td>{{ $row->firstname }}</td>
                <td>{{ $row->lastname }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->gender }}</td>
                <td>{{ $row->birthDate }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Display pagination links -->
    <div class="d-flex justify-content-center">
        @if ($data->lastPage() > 1)
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="{{ ($data->currentPage() == 1) ? 'disabled' : '' }}">
                        <a href="{{ $data->url(1) }}">First</a>
                    </li>
                    @if ($data->currentPage() > 3)
                        <li><span>...</span></li>
                    @endif
                    @for ($i = max(1, $data->currentPage() - 2); $i <= min($data->lastPage(), $data->currentPage() + 2); $i++)
                        <li class="{{ ($data->currentPage() == $i) ? ' active' : '' }}">
                            <a href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if ($data->currentPage() < $data->lastPage() - 2)
                        <li><span>...</span></li>
                    @endif
                    <li class="{{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                        <a href="{{ $data->url($data->lastPage()) }}">Last</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
   @endsection
