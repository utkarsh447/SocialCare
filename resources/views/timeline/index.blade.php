@extends('templates.default')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <form role="form" action="{{ route('status.post') }}" method="post">
            <!-- <div class="form-group{{ $errors->has('status') ? ' has-error': '' }}">
                <textarea placeholder="Anything you want to share about, {{ Auth::user()->getFirstNameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                @if ($errors->has('status'))
                    <span class="help-block">{{ $errors->first('status') }}</span>
                @endif
               
            </div> -->


            <script language="javascript" type="text/javascript">
                function dynamicdropdown(listindex)
                {
                    switch (listindex)
                    {
                        case "medical" :
                        document.getElementById("stat").options[0]=new Option("Select scope","");
                        document.getElementById("stat").options[1]=new Option("HYGIENE","hygiene");
                        //document.getElementById("status").options[1].remove();
                        if(!document.getElementById("stat").value){
                            document.getElementById("stat").options[2].remove();
                            document.getElementById("stat").options[3].remove();
                            document.getElementById("stat").options[4].remove();}
                            break;

                            case "traffic" :
                            document.getElementById("stat").options[0]=new Option("Select scope","");
                            document.getElementById("stat").options[1]=new Option("Traffic Problem","Traffic Problem");
                            document.getElementById("stat").options[2]=new Option("Finance Advising","Finance Advising");
                            document.getElementById("stat").options[3]=new Option("Bus depos","Bus depos");
                            document.getElementById("stat").options[4]=new Option("Highways","Highways");
                            break;

                            case "welfare" :
                        /*document.getElementById("status").options[1].remove();
                        document.getElementById("status").options[2].remove();
                        document.getElementById("status").options[3].remove();
                        document.getElementById("status").options[4].remove();*/                       
                        document.getElementById("stat").options[0]=new Option("Select scope","");
                        document.getElementById("stat").options[1]=new Option("Aged","aged");
                        document.getElementById("stat").options[2]=new Option("Children","children");
                        document.getElementById("stat").options[3]=new Option("Disabled","disabled");
                        document.getElementById("stat").options[4].remove();
                        
                    }
                    return true;
                }
            </script>

            <div class="category_div" id="category_div">Field which needs attention:
                <select id="source" name="source" autocomplete="off" required onchange="javascript: dynamicdropdown(this.options[this.selectedIndex].value);">
                    <option value="">Select field</option>
                    <option value="medical">Medical</option>
                    <option value="traffic">Traffic</option>
                    <option value="welfare">Welfare</option>
                </select>
                <!-- <textarea></textarea> -->
            </div>
            <br>
            <div class="sub_category_div" id="sub_category_div">Field of Problem:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <script type="text/javascript" language="JavaScript">
                    document.write('<select name="stat" id="stat"><option value="">Select Problem</option></select>')
                </script>

            </div>
            <br>
            <div>
                Location:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="location" name="location" autocomplete="off" required>>
                    <option>Select your location</option>
                    <option>Rohini</option>
                    <option>Narela</option>
                    <option>Najafgarh</option>
                    <option>Civil Lines</option>
                    <option>Central Delhi</option>
                    <option>East Delhi</option>
                    <option>West Delhi</option>
                    <option>North Delhi</option>
                    <option>South Delhi</option>
                </select>
            </div>
            <br>
            <div>
                LandMark: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" placeholder="Any Landmark?" class="form-control" autocomplete="off" required></input>
            </div>
            <br>
            Problem:
            <div class="form-group{{ $errors->has('status') ? ' has-error': '' }}">
                <textarea placeholder="Anything you want to share about, {{ Auth::user()->getFirstNameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                @if ($errors->has('status'))
                <span class="help-block">{{ $errors->first('status') }}</span>
                @endif             
            </div> 

            <button type="submit" class="btn btn-default">Update Post</button>
            
            <input type="hidden" name="_token" value="{{ Session::token() }}"></input>
        </form>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <!-- Timeline statuses and replies -->
        @if (!$statuses->count())
        <p>There's nothing in your timeline, yet.</p>
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
                </div>
            </div>
            @endforeach

            {!! $statuses->render() !!}
        @endif
    </div>
</div>
@stop