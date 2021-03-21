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
        <div class="col-md-6" >
            <div  class=" card"  style="height: 550px ; width: 400px">
                <div class="card-header">{{ __('Dashboard') }} :
                    @if (auth()->user())
                    {{ __(auth()->user()->name.'You are logged in!') }}
                        @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                        <div class="body"   >


                                <div style="display: flex ; flex-direction: column-reverse;position: relative; overflow: auto ; height: 400px" >
                                    <hr>
                                    <table class="table" style="table-layout: fixed" >
                                        <thead>

                                        </thead>
                                        <tbody id="FilterTableBody"  >
                                        @if (auth()->user())
                                        @if (count(auth()->user()->load('logs')['logs']) > 0)

                                        @foreach(auth()->user()->load('logs')['logs'] as $one)
                                            <tr>
                                                @if($one->action == 'send')
                                                    <td style="max-width: 100%;    overflow-x: hidden;margin-bottom: 3px ;text-align: left ; float:left ;border-radius: 12px;  background:  #d0d0d0;">{{auth()->user()->name}} : {{$one->message}}</td>

                                                @else
                                                    <td style=" max-width: 100%;
    overflow-x: hidden;margin-bottom: 3px ; text-align: right ; float:right ; border-radius: 12px;  background: oldlace;">BOT : {{$one->message}}</td>
                                                @endif

{{--                                                <td><small>{{$one->created_at}}</small></td>--}}
                                            </tr>

                                        @endforeach

                                            @else
                                            <tr>

                                                <td style="border-radius: 12px;  background: oldlace;">
                                                    BOT :   Hey {{auth()->user()->name}} , I am the smart calculator bot and I am here to help to convert your words to math.
                                                    <br/>
                                                    Please give me the process you need me to calculate it.
                                                </td>

                                            </tr>
                                            @endif

                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            <hr>
                            <form   id="form_send" method="post">

                                    <div class="row">
                                        <div class="col-8">
<textarea  style="width: 350px ; height: 50px" type="text" id="Message" class="form-control" name="message" placeholder="Message" required></textarea>
                                        </div>
                                        <div id="divv">
                                        <div class="col-2">
                                                    <button type="button" id="SendBtn" class="buttonx btn" style="  margin-top: 8px ; color: #fff; background-color: #9fcdff; border-bottom-color: #9fcdff">Send</button>
                                        </div>
                                        </div>
                                    </div>
                                    <br/>




                                </form>
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
                            text +=   '                <td style=" overflow-x: hidden;max-width: 100%;margin-bottom: 3px ; text-align: right ; float:right ; border-radius: 12px;  background: oldlace;">BOT        :    '+data[i].message+'     </td>';

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
        // $(document).keyup('#Message',function() {
        //     /* I EVEN TRIED TO TRIM IT TO NO AVAIL */
        //     var content = $.trim($('#Message').val());
        //     if(content.length === 0) {
        //         $('#SendBtn').hide();
        //     } else {
        //         $('#SendBtn').show();
        //     }
        // });
    </script>
