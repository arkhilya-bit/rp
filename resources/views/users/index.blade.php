<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .table-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 30px; }
        th a { color: inherit; text-decoration: none; display: block; width: 100%; }
        th a:hover { color: #60bfdb; }
        .sort-icon { font-size: 0.8em; margin-left: 5px; }
        .cursor-pointer { cursor: pointer; }
    </style>
</head>
<body>
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
                                Score
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
</body>
</html>
