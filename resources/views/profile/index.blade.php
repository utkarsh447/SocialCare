@extends('templates.default')

@section('content')
	<div>
		<div class="col-lg-5">

			@include('user.partials.userblock')
			<hr>
			@if (!$statuses->count())
        <p>{{ $user->getFirstNameOrUsername() }} hasn't posted anything yet.</p>
        @else
            @foreach ($statuses as $status)
            <div class="media">
                <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}"> <!--  -->
                <!-- <img class="media-object" alt="" src=""> -->
                    <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">

                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
                    <p style="color: green">Field of Problem: {{ $status->stat }}</p>
                    <p style="color: green">Location of Problem: {{ $status->location }}</p>
                    <p>{{ $status->body }}</p>
                    <ul class="list-inline">
                        <li>{{ $status->created_at->diffForHumans() }}</li>  <!-- Need to add according to modified form -->
                    </ul>
                    <?php 
                    	$authority = 'null'; 
                    	if( $status->stat === "Traffic Problem" && $status->source === "traffic")
                    	{
                    		$authority = 'Sh. R. K. Kasana, Traffic Deptt.: jdadmntpt@hub.nic.in';
                    	}
                    	elseif ( $status->stat === "Finance Advising" && $status->source === "traffic") 
                    	{
                    		$authority = 'Sh. Vivek Kumar Tripathi, Finance Advisor: cgm_f_dtc@yahoo.in';
                    	}
                    	elseif ( $status->stat === "Bus depos" && $status->source === "traffic") 
                    	{
                    		$authority = 'Sh. A. K. Goyal, Operation of the Depots: dtc_trdeptt@yahoo.in';
                    	}
                    	elseif ( $status->stat === "Highways" && $status->source === "traffic") 
                    	{
                    		$authority = 'Shri B.S.Yadav, National Highways Authority: bsyadav@nhai.org';
                    	}

                    	elseif ( ($status->stat === "aged" || $status->stat === "Aged") && $status->source === "welfare") 
                    	{
                    		$authority = 'Old Age foundation: care@oldagefoundation.org';
                    	}
                    	elseif ( ($status->stat === "Children" || $status->stat === "children") && $status->source === "welfare") 
                    	{
                    		$authority = 'Children cruelty stop help: help@nspcc.org.uk';
                    	}
                    	elseif ( ($status->stat === "Disabled" || $status->stat === "disabled")&& $status->source === "welfare") 
                    	{
                    		$authority = 'Helping Disabled Ones: info@smilefoundationindia.org';
                    	}                    	
                    	
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "Rohini")
                    	{
                    		$authority = 'Rohini Delhi Office at dc-central@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "Narela")
                    	{
                    		$authority = 'Narela Office at dc-central@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "Najafgarh")
                    	{
                    		$authority = 'Najafgarh Office at dc-najafgarh@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "Civil Lines")
                    	{
                    		$authority = 'Civil Lines Office at dc-civilline@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "Central Delhi")
                    	{
                    		$authority = 'Central Delhi Office at dc-central@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "East Delhi")
                    	{
                    		$authority = 'East Delhi Office at dc-east@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "West Delhi")
                    	{
                    		$authority = 'West Delhi Office at dc-west@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "North Delhi")
                    	{
                    		$authority = 'North Delhi Office at dc-shahd-north@mcd.org.in';
                    	}
                    	elseif($status->stat === "hygiene" && $status->source === "medical" && $status->location === "South Delhi")
                    	{
                    		$authority = 'South Delhi Office at dc-south@mcd.org.in';
                    	}
                    ?>
                    <p style="color: green">Forward to Requested Authority:<br></p>
                    <button type="submit" class="btn btn-default"> {{ $authority }}</button>

                    

                    @foreach($status->replies as $reply)
                        <div class="media">
                            <a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                                <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->getAvatarUrl() }}">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                                <p>{{ $reply->body }}</p>
                                <ul class="list-inline">
                                    <li>{{ $reply->created_at->diffForHumans() }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    @if($authUserIsFriend || Auth::user()->id === $status->user->id)
	                    <form role="form" action="{{ route('status.reply',[ 'statusId' => $status->id]) }}" method="post">
	                        <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
	                            <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
	                            @if ($errors->has("reply-{$status->id}"))
	                                <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
	                            @endif
	                        </div>
	                        <input type="submit" value="Reply" class="btn btn-default btn-sm">
	                        <input type="hidden" name="_token" value="{{ Session::token() }}"></input>
	                    </form>
                    @endif
                </div>
            </div>
            @endforeach

        @endif

		</div>
		<div class="col-lg-4 col-lg-offset-3">

		@if (Auth::user()->hasFriendRequestPending($user))
			<p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
		@elseif (Auth::user()->hasFriendRequestReceived($user))
			<a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request</a>
		@elseif (Auth::user()->isFriendsWith($user))
			<p>You and {{ $user->getNameOrUsername() }} are friends.</p>
		@elseif (Auth::user()->id !== $user->id)
			<a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Add as friend</a>
		@endif

			<h4>
				{{ $user->getFirstNameOrUsername() }}'s friends.
			</h4>

			@if (!$user->friends()->count())
				<p>{{ $user->getFirstNameOrUsername() }} has no friends.</p>

			@else
				@foreach ($user->friends() as $user)
					@include('user/partials/userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop