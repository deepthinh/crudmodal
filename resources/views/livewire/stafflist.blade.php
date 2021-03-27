<div>
	<div class="row ">

		<div class="col-12">
			<button class="btn btn-sm btn-info" wire:click="openModal">Create Staff</button>
		</div> <!-- ./col12 -->
	 <div class="col-6 form-inline">
		<select wire:model="perPage" class="form-control">
			<option> 5 </option>
			<option> 10 </option>
			<option> 50 </option>
			<option> 100 </option>
		</select> 
	</div> 
	<div class="col-6"> 
		<input wire:model.debounce.300ms="search" type="text" class="form-control">
	</div>
    </div>

	<table class="table table-stripped table-bordered"><thead>
	<th wire:click="sortBy('id')"> Id	</th>
	<th wire:click="sortBy('name')"> Name	</th>
	<th wire:click="sortBy('email')"> Email	</th>
	<th wire:click="sortBy('created_at')"> Created	</th>
	<th> Action </th>
</thead> <tbody>
	@foreach($item as $list)
	<tr>
		<td> {{$list->id}}</td>
		<td> {{$list->name}}</td>
		<td> {{$list->email}}</td>
		<td> {{$list->created_at}}</td>
		<td> 
			<div class="btn-group" role="group">
				<button data-toggle="modal" data-target="#editmodal"  type="button" class="btn btn-sm btn-primary" wire:click="editStaff({{ $list }})"> Edit </button>
				<button type="button" class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $list['id']}})"> Delete </button>
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

                


 <p> Showing {{ $item->firstItem() }} to  {{ $item->lastItem() }} out of  {{ $item->total() }} staffs. </p>
 <p> {{ $item->onEachSide(4)->links() }}  </p>
</div>


@if(!empty($editModal))

<div wire:ignore.self class="modal fade {{ $editModal ? 'is-active' :''}} " id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
 <div class="modal-content">
		<form class="" wire:submit.prevent="saveStaff">
			<div class="row">
				<div class="col-12"> <label> Name </label>
					<input wire:modal.lazy="editingStaff.name" class="input" type="text">
					@error('editingStaff.name')
					<p class="help is-danger"> {{ $message }} </p>
					@enderror
				</div> <!-- .col12 -->
				<div class="col-12"> <label> Email </label>
					<input wire:modal.lazy="editingStaff.email" class="input" type="email">
					@error('editingStaff.email')
					<p class="help is-danger"> {{ $message }} </p>
					@enderror
				</div> <!-- .col12 -->
			</div> <!-- ./row -->
		</form> 
		<div class="field is-grouped">
			<button wire:click="saveStaff" class="btn btn-sm btn-success">Save</button>
			<button wire:click="closeModal" class="btn btn-sm btn-success">Cancel</button>
		</div> <!-- ./field -->
	 <button wire:click="toggleModal" class="modal-close is-large" aria-label="close"></button>
	</div> <!-- ./modal-content-->
</div> <!-- ./dialog -->
</div> <!-- ./modal-->
@endif

<div wire:ignore.self class="modal fade {{ $deleteModal?'is-active':''}} " id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<button class="btn btn-sm btn-success" wire:click="deleteStaff">Yes</button>
		<button class="btn btn-sm btn-danger" wire:click="closeModal">Cancel</button>
	</div> <!-- ./modal-content -->
	</div> <!-- ./modal-dialog -->
</div> <!--./modal -->

