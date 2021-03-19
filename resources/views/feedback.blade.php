@extends('layouts.app')

@section('content')
    @if (auth()->user())
<div class="container" >

    <div class="row justify-content-center">
        <div  >
            <div  class=" card" >

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                        <div class="body"   >


                                <div  >
                                    <hr>
                                    <table class="table" style="table-layout: fixed" >
                                        <thead>

                                        </thead>
                                        <tbody id="FilterTableBody"  >
                                        @if (auth()->user())
                                        @if (count($UserFeedBacks) > 0)

                                        @foreach($UserFeedBacks as $one)
                                            <tr>

                                                @if($one->message == '1')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 5px ;  border-radius: 12px;  background: #a5dc86;"> answer is correct.</td>
                                                    @elseif($one->message == '2')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 5px ;  border-radius: 12px;  background: #d9534f;"> it’s wrong.</td>


                                                @elseif($one->message == '3')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 5px ;  border-radius: 12px;  background: #9fcdff;">  don’t know.</td>

                                                @elseif($one->action == 'send')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 5px ;  border-radius: 12px;  background: oldlace;">  {{$one->message}}</td>
@elseif($one->action == 'Recive')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 5px ;  border-radius: 12px;  background: #7DA0B1;">  {{$one->message}}</td>

                                                @endif

                                            </tr>

                                        @endforeach

                                            @else
                                            <tr>

                                                <td style="border-radius: 12px;  background: oldlace;">
                                                    BOT :   Hey {{auth()->user()->name}} , there is no any Feed back yet .
                                                </td>

                                            </tr>
                                            @endif

                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            <hr>
                                <br/>


                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    @endif
@endsection

