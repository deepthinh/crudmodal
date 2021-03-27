<div class="row">
    <div class="col-12 py-3">
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal" wire:click="create()">
    Open Form
    </button>
    </div> <!-- ./col12 -->
    <div class="col-6 form-inline py-3">
        <select wire:model="perPage" class="form-control">
            <option> 5 </option>
            <option> 10 </option>
            <option> 50 </option>
            <option> 100 </option>
        </select> 
    </div> 
    <div class="col-6 py-3"> 
        <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search here..">
    </div>


<!-- Create Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter Name" wire:model="name">
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput2" wire:model="email" placeholder="Enter Email">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Password</label>
                        <input type="password" class="form-control" id="exampleFormControlInput2" wire:model="password" placeholder="Enter Password">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
            </div>
        </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- ./modal -->


<!-- edit modal -->
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Usertype</label>
                        <select class="form-control" name="usertype_id" wire:model="usertype_id">

                        <option value="" selected>--Select--</option>

                        @foreach($usertypes as $utypes)

                            <option value="{{ $utypes->id }}">{{ $utypes->name }}</option>

                        @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" wire:model="user_id">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" class="form-control" wire:model="name" id="exampleFormControlInput1" placeholder="Enter Name">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Email address</label>
                        <input type="email" class="form-control" wire:model="email" id="exampleFormControlInput2" placeholder="Enter Email">
                        @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Password</label>
                        <input type="password" class="form-control" id="exampleFormControlInput2" wire:model="password" placeholder="Enter Password">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
       </div> <!-- ./modal-content -->
    </div> <!-- ./modal-dialog -->
</div> <!-- ./modal -->
<!-- edit modal -->
   
    
    <div class="col-12 py-2" >
    @if (session()->has('message'))
        <div class="alert alert-success" style="margin-top:30px;">x
          {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped mt-5">
        <thead>
            <tr>
                <th wire:click="sortBy('id')">No.</th>
                <th wire:click="sortBy('name')">Name</th>
                <th wire:click="sortBy('email')"> Email</th>
                <th wire:click="sortBy('usertype')"> Usertype</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach($usersdet as $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->usertype }}</td>
                <td>
                <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                <button wire:click="delete({{ $value->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p> Showing {{ $usersdet->firstItem() }} to  {{ $usersdet->lastItem() }} out of  {{ $usersdet->total() }} singers. </p>
    <p> {{ $usersdet->onEachSide(4)->links() }}  </p>
  </div> <!-- ./col12 -->
</div> <!-- ./row -->
