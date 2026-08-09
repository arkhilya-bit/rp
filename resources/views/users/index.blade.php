@extends('layouts.main')
@section('body')
<div class="container">
    <div class="table-container">
        <h2 class="mb-4 text-center">Список пользователей</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sortBy === 'id' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                ID
                                @if($sortBy === 'id') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => $sortBy === 'name' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Имя
                                @if($sortBy === 'name') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'city', 'direction' => $sortBy === 'city' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Город
                                @if($sortBy === 'city') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'age', 'direction' => $sortBy === 'age' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Возраст
                                @if($sortBy === 'age') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'score', 'direction' => $sortBy === 'score' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Ранг
                                @if($sortBy === 'score') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        
                        <th class="cursor-pointer">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => $sortBy === 'email' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Email
                                @if($sortBy === 'email') <span class="sort-icon">{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
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

        <div class="d-flex justify-content-center mt-4">
            {{ $users->appends(['sort' => $sortBy, 'direction' => $direction])->links() }}
        </div>
    </div>
</div>
@endsection