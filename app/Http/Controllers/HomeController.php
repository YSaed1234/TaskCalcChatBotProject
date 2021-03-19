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
            })
            ->orderby('id','asc')->get();
        return view('feedback')->with(['UserFeedBacks'=>$UserFeedBacks]);
    }


    public function send(Request  $request)
    {
        $matches = [] ;
        $feedbackError=false;
        $finishError=false;
        $lastOne =UserLog::orderBy('id','DESC')->first();
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
        UserLog::create($data);
        $messageArray = explode(' ' , $data['message']);
        unset($data['tag']);
        if ($data['message'] == '1'){
            if (!$lastOne){
                $data['message'] = 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            } elseif($lastOne &&  $lastOne->action=='finish'){
                $data['message'] = 'Send Your Next Mathematical Statment.';
                $data['action'] = 'Recive';
                UserLog::create($data);
            }elseif($lastOne &&  $lastOne->action=='feedback'){
                $data['message'] = 'OH, Great.';
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
        elseif ($data['message'] == '2'){


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
        elseif ($data['message'] == '3'){
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
else {
    if (!$feedbackError && !$finishError) {
        $messageAppend = ''; // appended message
        $baseWordsArray = ['hi', 'hello', 'mornning']; // as more common words to be replied correctly .
        $FunctionWithOneNumberArray = ['square']; // as more common words to be replied correctly .
        $passOneNumber = false;
        foreach ($messageArray as $word) {
            if (is_numeric($word)) {
                $matches[] = $word;
            } else {
                if (in_array($word, $FunctionWithOneNumberArray)) {
                    $passOneNumber = true;
                }
                if (in_array($word, $baseWordsArray))
                    $messageAppend .= $word . ' ' . auth()->user()->name . '  , ';
            }
        }


        if (count($matches) == 0) {
            $data['message'] = $messageAppend . 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
            $data['action'] = 'Recive';
            UserLog::create($data);
        } else if (count($matches) == 1 and !$passOneNumber) {

            $data['message'] = $messageAppend . 'please type another  numbers to be calculated ..! ';
            $data['action'] = 'Recive';
            UserLog::create($data);
        } else {


            $operators = Operators::all();
            $actionVal = '';
            $functionVal = '';
            foreach ($operators as $oneOperator) {

                if (in_array($oneOperator->key, $messageArray)) {
                    $actionVal = $oneOperator->value;
                    $functionVal = $oneOperator->function;
                }
            }
            if ($actionVal == '' and $functionVal == '') {
                $data['message'] = $messageAppend . 'Your Data Not Accurat please type at least two numbers to be calculated ..! ';
                $data['action'] = 'Recive';
                UserLog::create($data);
            } else {
                $data['message'] = $messageAppend . 'You Mean :' . implode($actionVal, $matches);
                $data['action'] = 'Recive';
                UserLog::create($data);
                if ($functionVal != '' and !$passOneNumber) {
                    $data['message'] = 'ABRACADABRA! it’s ' . "{$functionVal($matches)}";
                } elseif ($functionVal != '' and $passOneNumber) {
                    $data['message'] = 'ABRACADABRA! it’s ' . "{$functionVal($matches[0])}";
                } else {
                    $result = $matches[0];
                    for ($i = 1; $i < count($matches); $i++) {
                        eval('$result = ' . $result . $actionVal . $matches[$i] . ';');
                    }
                    $data['message'] = 'ABRACADABRA! it’s ' . "$result";
                }
                $data['action'] = 'Recive';
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
