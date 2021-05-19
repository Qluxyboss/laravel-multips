<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">

            {{-- @if (session()->has('message'))

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-check-circle mr-1"></i>{{ session('message') }}!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                
            @endif --}}

            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card card-primary card-outline">

                                    <div class="card-header">
                                        <h3 class="card-title">Users List Table</h3>

                                        <div class="card-tools">
                                            <button wire:click.prevent="addNew" class="btn btn-primary"><i
                                                    class="fa fa-plus-circle mr-1"></i> Add New User</button>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                           
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Options</th>
                                            </tr>
     
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>1{{ $user->email }}</td>
                                                    <td>
                                                        <a href="" wire:click.prevent="edit({{ $user->id }})">
                                                            <i class="fa fa-edit mr-2"></i>
                                                        </a>
                                                        <a class="text-danger" wire:click.prevent="confirmUserRemoval({{ $user->id }})" href="">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer d-flex justify-content-end">
                                    {{ $users->links() }}
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
          <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                @if($showEditModal)
                  <span>Edit User</span>
                @else
                  <span>Add New User</span>
                @endif
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" wire:model.defer="state.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter full name">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
                </div>
      
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="text" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email">
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
                </div>
      
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" wire:model.defer="state.password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
                </div>
      
                <div class="form-group">
                  <label for="passwordConfirmation">Confirm Password</label>
                  <input type="password" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirm Password">
                </div>
      
            {{-- <div class="form-group">
              <label for="customFile">Profile Photo</label>
              <div class="custom-file">
                <div x-data="{ isUploading: false, progress: 5 }"
                     x-on:livewire-upload-start="isUploading = true"
                     x-on:livewire-upload-finish="isUploading = false; progress = 5"
                     x-on:livewire-upload-error="isUploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                  <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
                    <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                      <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>
                </div>
                <label class="custom-file-label" for="customFile">
                  @if ($photo)
                    {{ $photo->getClientOriginalName() }}
                  @else
                    Choose Image
                  @endif
                </label>
              </div>
      
              @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}" class="img d-block mt-2 w-100 rounded">
              @else
                <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mb-2 w-100 rounded" >
              @endif
            </div> --}}
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>
                @if($showEditModal)
                  <span>Save Changes</span>
                @else
                  <span>Save</span>
                @endif
              </button>
            </div>
          </div>
          </form>
        </div>
    </div>

      <!--Delete User Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Delete User</h5>
        </div>
  
        <div class="modal-body">
          <h4>Are you sure you want to delete this user?</h4>
        </div>
  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
          <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i class="fa fa-trash mr-1"></i>Delete User</button>
        </div>
      </div>
    </div>
  </div>
  
</div>