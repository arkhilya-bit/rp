@extends('layouts.main')
@section('body')
<div class="container">
    <div class="table-container">
        <h2 class="mb-4 text-center">Список топ-5 пользователей</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="cursor-pointer">ID</th>
                        <th class="cursor-pointer">Имя</th>
                        <th class="cursor-pointer">Город</th>
                        <th class="cursor-pointer">Возраст</th>
                        <th class="cursor-pointer">Ранг</th>
                        <th class="cursor-pointer">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->city }}</td>
                            <td>{{ $user->age }}</td>
                            <td><span class="badge bg-info text-dark">{{ $user->score }}</span></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Пользователи не найдены</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection