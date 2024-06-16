<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Role</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Role: {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-danger float-right">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for=""><h4>Permissions</h4></label>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-2">
                                        <label>
                                            <input 
                                            type="checkbox" 
                                            name="permission[]" 
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                            />
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
