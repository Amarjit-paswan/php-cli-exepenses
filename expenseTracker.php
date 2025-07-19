<?php 

//----------------------------------
// Intailize a Expense Class
//----------------------------------

class Expense{

    // Create Properties to store expenses
    public $description;
    public $amount;
    public $id;
    public $date;

    // Intailiaze a Constructor to store the details
    public function __construct($id,$description,$amount,$date)
    {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->date = $date;
    }

}

//----------------------------------
// Intialize a Expense Tracker Class
//----------------------------------

class ExpenseTracker{

    //Intilize the files
    private $file = 'expenses.json';

    // Intialize arrary to store expense value
    private $expenses = [];

    // Constructor : Load expenses json into memory
    public function __construct()
    {
        //Check file exists
        if(file_exists($this->file)){
            // fetch content from file
            $json = file_get_contents($this->file);
            $this->expenses = json_decode($json,true);
            $this->expenses = array_map(function($expense){
                return new Expense(...$expense);
            },$this->expenses);


        }
    }

    //Add a Expenses
    public function AddExpenses($description,$amount){
        $id = count($this->expenses) + 1;
        $date = date('Y-m-d H:i:s');
        $expense = new Expense($id,$description,$amount,$date);
        $this->expenses[] = $expense;
        $this->saveExpense();

        echo "Expense Added Successfully";
    }

    //Update an Expense by id
    public function UpdateExpense($id,$description = null,$amount = null){
        foreach($this->expenses as $key => $expense){
            if($expense->id == $id){
                if(!empty($description)){
                    $this->expenses[$key]->description = $description;
                }

                if(!empty($amount)){
                    $this->expenses[$key]->amount = $amount;
                }
                $this->saveExpense();
                echo "Expenses Updated Successfully";
            }
        }
    }

    // Delete Expense by id
    public function DeleteExpense($id){
        foreach($this->expenses as $key => $expense){
            if($expense->id = $id){
                unset($this->expenses[$key]);
                $this->saveExpense();
                echo "Expense Deleted Successfully";
                return true;
            }
        }
    }

    // Show All Expenses
    public function ExpenseList(){
        echo "-----------------------------------------\n";
        echo " id | description | amount | date \n";
        echo "-----------------------------------------\n";
        foreach($this->expenses as $key => $expense){
            echo  $expense->id . " | ". $expense->description . " | ". $expense->amount . " | ". $expense->date . "\n";
        }
        echo "-----------------------------------------";

    }

    //Sumaary of all Expense
    public function SummaryExpnese(){
        $totalSum = 0;
        foreach($this->expenses as $key => $expense){
            $totalSum += number_format($expense->amount);
        }
        echo "Total Expenses : ". $totalSum;
    }

    //Summary according to month
    public function SummaryByMonth($month){
        $total = 0;

        foreach($this->expenses as $key => $expense){
            $expenseDate = date('m',strtotime($expense->date));
            if($expenseDate == $month){
                $total += number_format($expense->amount);
            }
        }
        $dateObj = DateTime::createFromFormat('!m',$month);
        $monthName = $dateObj->format('F');
                echo "Total Expense of $monthName : $total";

    }

    // Save all expense into json file
    public function saveExpense(){
        //Store each expense data into array
        $expenseData = array_map(function($expense){
            return [
                'id' => $expense->id,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'date' => $expense->date
            ];
        },$this->expenses);

        //Convert array into json file
        $json = json_encode($expenseData,JSON_PRETTY_PRINT);

        //Upload all file into json
        file_put_contents($this->file,$json);
        
        
    }
}





?>