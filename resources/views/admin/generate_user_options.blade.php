<label for="exampleInputEmail1">Select User <em>*</em></label>
<select id="select_user" name="select_user" class="form-control">
    <option value="all" selected="selected">All</option>
    @foreach($users as $user)
    <option value="{{$user->user_id}}">{{$user->user->name}}</option>
    @endforeach
</select>