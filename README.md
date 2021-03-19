develop a chatbot that does the basic calculation, this chatbot aimed to helps users do basic mathematical operations by taking a string as input and then decodes the basic mathematical operations mainly (+ , -, square root, *, ...etc), the solution converts a user input (string) to mathematical operations and digits. 

you should create a unique id for the session and store the following in the database:  

1- the string request from the user (for example: please add 5 to 9). 

2- the mathematical form of the user request (for example 5 + 9 ). 

3- the final result (for example 14). 

 

you should ask the user if he/she needs to make another calculation. 

all processes will be related to the session ID in the database. 



First You initialize database name   (mworldtask)   in mysql then imort  mworldtask.sql file on it ,
 Now you can  Regist or login if there is a sign account 
then You can Ask Chat bot some of basic mathematical operations 
must operation separated with space as  (1 + 2 )  or ( add 1 to 2 )  not like  (1+2) or (add1to2)

task can solve 
addition [ (+ or add or and)  $number1 , $number2]
subtraction [ (- or minus)  $number1 , $number2]
dividing [ (/ or dividing)  $number1 , $number2]
multipling [ (* or multiplying)  $number1 , $number2]
square root [ square  $number]


You can any other operators by add its Data in DB as
key value and its built function if found . 
Note : in Data base Table operators id Colom oneNum== 0 then cant pass message that have only one number as [add 1]  ,
must has at least two numbers as [add 1 to 2]
else can allow to pass only one number as square function Ex : [square 9 ]


Note : 
if Chat bot ask You abaut Your feedBack then your should answer from allowed Choices else  will ask you for correct answer again .
that Also with  ask to complete or Finish  .
