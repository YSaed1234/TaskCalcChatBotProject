<?php

namespace App\Http\Controllers;

use App\Models\Operators;
use App\Models\UserLog;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function feedBake()
    {

        $UserFeedBacks = UserLog::
        where('user_id',auth()->user()->id)

            ->where(function($query){
                return $query
            ->where('tag','feedback')->whereIn('message',['1','2','3']);

            })->orwhere(function($query){
                return $query
                    ->WhereNull('tag')->where('action','send');
            })->orwhere(function($query){
                return $query
                    ->WhereNull('tag')->where('action','Recive')->where('message','like','ABRACADABRA! it’s%');
            })
            ->orderby('id','asc')->get();
        return view('feedback')->with(['UserFeedBacks'=>$UserFeedBacks]);
    }


    public function send(Request  $request)
    {
        $matches = [] ; // numbers array
        $feedbackError=false; // if reply from user not allowed on feedback case
        $finishError=false; // if reply from user not allowed on finish case
        $lastOne =UserLog::orderBy('id','DESC')->first(); // get last row in db to know its Type  ( finish , feedback ,send , recive)
        $data=$request->all();
        $data['user_id']=auth()->user()->id;

        $data['action']='send';
        if($lastOne &&  $lastOne->action=='feedback'){
        $data['tag'] = 'feedback';
        if (!in_array($data['message'],['1','2','3'])){
            $feedbackError = true ;
        }
        }
        elseif($lastOne &&  $lastOne->action=='finish'){
        $data['tag'] = 'finish';
            if (!in_array($data['message'],['1','2'])){
                $finishError = true ;
            } }

        // add user reply in DB as Send Action
        UserLog::create($data);
        $messageArray = explode(' ' , $data['message']);
        unset($data['tag']);



        if ($data['message'] == '1'){ // if user reply 1
            if (!$lastOne){ // if it first message
                $data['message'] = 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            } elseif($lastOne &&  $lastOne->action=='finish'){ // if it reply message for finish
                $data['message'] = 'Send Your Next Mathematical Statment.';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }elseif($lastOne &&  $lastOne->action=='feedback'){  // if it reply message for feedback
                $data['message'] = 'OH, Great.';
                $data['action'] = 'Recive';
                UserLog::create($data);

                // finish ask
                $data['message'] = ' If you need a new process send 1 or 2 to end this session.';
                $data['action'] = 'finish';
                UserLog::create($data);


            }else{  // if it reply message  not first and not finish answer and there are old messages then need to add another number to complete the process as ambigous statement
                $data['message'] = 'please type another  numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }
}
        elseif ($data['message'] == '2'){ // if user reply 2


            if (!$lastOne){
                $data['message'] = 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }
            elseif($lastOne &&  $lastOne->action=='finish'){
                $data['message'] = 'Good-Bye! Have a nice day.';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }elseif($lastOne &&  $lastOne->action=='feedback'){
                $data['message'] = 'Please Enter it With another Syntax to Try Again . ..... (Test ) ';
                $data['action'] = 'Recive';
                UserLog::create($data);
                $data['message'] = ' If you need a new process send 1 or 2 to end this session.';
                $data['action'] = 'finish';
                UserLog::create($data);


            }else{
                $data['message'] = 'please type another  numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }

        }
        elseif ($data['message'] == '3'){ // if user reply 3
            if (!$lastOne){
                $data['message'] = 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            } elseif($lastOne &&  $lastOne->action=='feedback'){
                $data['message'] = 'Then We Can Try Again..!';
                $data['action'] = 'Recive';
                UserLog::create($data);

                $data['message'] = ' If you need a new process send 1 or 2 to end this session.';
                $data['action'] = 'finish';
                UserLog::create($data);




            }else{
                $data['message'] = 'please type another  numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }
}
else { // if user reply text message
    if (!$feedbackError && !$finishError) { // if message not reply for finish or feedback Q
        $messageAppend = ''; // appended message
        $baseWordsArray = ['hi', 'hello', 'mornning']; // as more common words to be replied correctly .
        for ($i=0 ; $i < count($messageArray); $i++) {
            if (is_numeric($messageArray[$i])) {
                $matches[] = $messageArray[$i];
            } else {
                $messageArray[$i]=strtolower ($messageArray[$i]); // make searched words as lower case to comapre it easy
                if (in_array($messageArray[$i], $baseWordsArray))
                    $messageAppend .= $messageArray[$i] . ' ' . auth()->user()->name . '  , ';
            }
        }

        $operators = Operators::all();
        $oneNumVal = 0;
        $actionVal = '';
        $functionVal = '';
        foreach ($operators as $oneOperator) { // compare DB operators with message words

            if (in_array($oneOperator->key, $messageArray)) {
                $actionVal = $oneOperator->value;
                $functionVal = $oneOperator->function;
                $oneNumVal = $oneOperator->oneNum;
            }
        }
        if (count($matches) == 0) { // there is no any numbers
            $data['message'] = $messageAppend . 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
            $data['action'] = 'Recive';
            UserLog::create($data);
        } else if (count($matches) == 1 and $oneNumVal==0) { // only have one num and operator not allow less than two numbers

            $data['message'] = $messageAppend . 'please type another  numbers to be calculated ..! ';
            $data['action'] = 'Recive';
            UserLog::create($data);
        } else {


            if ($actionVal == '' and $functionVal == '') {// operators not match with any message word
                $data['message'] = $messageAppend . 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            } else { // calc operation
                $data['message'] = $messageAppend . 'You Mean :' . implode($actionVal, $matches);
                $data['action'] = 'Recive';
                UserLog::create($data);
                if ($functionVal != '' and $oneNumVal==0) {
                    $data['message'] = 'ABRACADABRA! it’s ' . "{$functionVal($matches)}";
                } elseif ($functionVal != '' and $oneNumVal==1) {
                    $data['message'] = 'ABRACADABRA! it’s ' . "{$functionVal($matches[0])}";
                } else {
                    $result = $matches[0];
                    for ($i = 1; $i < count($matches); $i++) {
                        eval('$result = ' . $result . $actionVal . $matches[$i] . ';');
                    }
                    $data['message'] = 'ABRACADABRA! it’s ' . "$result";
                }
                $data['action'] = 'Recive'; // feedback ask
                UserLog::create($data);
                $data['message'] = ' please send 1 if you think my answer is correct, 2 if it’s wrong, or 3 if you don’t know. ';
                $data['action'] = 'feedback';
                UserLog::create($data);
            }

        }
    }
}
if ($feedbackError){
    $data['message'] = ' please send 1 if you think my answer is correct, 2 if it’s wrong, or 3 if you don’t know. ' ;
    $data['action'] = 'feedback';
    UserLog::create($data);
}
if ($finishError){
    $data['message'] = ' If you need a new process send 1 or 2 to end this session.';
    $data['action'] = 'finish';
    UserLog::create($data);
}
        return $this->search(new Request() );
    }
    public function search(Request  $request)
    {
        $settings = $request->all();
        $settings['user_id']=auth()->user()->id;
        $values = ['user_id','id','action'] ;
        $orderDir = 'asc';
        $orderBy = 'id';
        $model = new UserLog();
        foreach (array_keys($settings) as  $key){
            if (!empty($settings[$key]) and  ($settings[$key] != null)  and  ($settings[$key] != '') ){
                if (in_array($key, $values)) {
                    $model = $model->where($key, $settings[$key]);
                } else {
                    $model = $model ->where($key, 'like', '%' . $settings[$key] . '%');
                }
            }else{
                if ($key=='parent_id' and $settings[$key]==0){
                    $model = $model->where($key, $settings[$key]);
                }
            }
        }
        $alldata = $model->orderBy($orderBy,$orderDir)->get();
        return $alldata ;
    }
}
