@extends('layouts.app')
<style>
    .buttonx {
        display: none;
    }
    #divv:hover + .buttonx {
        display: inline-block;
    }
</style>
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
    overflow-x: hidden;margin-bottom: 3px ;  border-radius: 12px;  background: #a5dc86;"> answer is correct.</td>
                                                    @elseif($one->message == '2')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 3px ;  border-radius: 12px;  background: #d9534f;"> it’s wrong.</td>


                                                @elseif($one->message == '3')
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 3px ;  border-radius: 12px;  background: #9fcdff;">  don’t know.</td>

                                                @else
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 3px ;  border-radius: 12px;  background: oldlace;">  {{$one->message}}</td>

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
<link rel="stylesheet" href="{{asset('assets/css/sweetalert2.css')}}" />
<script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>



<script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script type="text/javascript">


        $(document).on("click", "#SendBtn" , function(e) {
            e.preventDefault();
            if ($('#Message').val()==''){
                alert("Type Message Firstly ...! ");

            }else{
                $.ajax({
                    url: '{{url("message/send")}}',
                    data: $("#form_send").serialize(),
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $('#Message').val('');
                        var i;
                        $('#FilterTableBody').text('');

                        for (i = 0; i < data.length; i++)


                        {
                            text = '  <tr>' ;
                            if(data[i].action=='send') {
                            text +=   '                <td style="max-width: 100%;    overflow-x: hidden;margin-bottom: 3px ;text-align: left ; float:left ;border-radius: 12px;  background:  #d0d0d0;"><?php if (auth()->user()) echo auth()->user()->name ?>    :     '+data[i].message+'        </td>' ;
                        }else{
                            text +=   '                <td style=" overflow-x: hidden;max-width: 100%;margin-bottom: 3px ;  border-radius: 12px;  background: oldlace;">BOT        :    '+data[i].message+'     </td>';

                        }
                                +
                                '            </tr>';
                            $('#FilterTableBody').append(text);
                        }
                    },
                    error: function(){
                        // alert("failure From php side!!! ");
                    }

                });

            }


    });
    </script>
