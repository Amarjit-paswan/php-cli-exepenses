<?php 

// Include Expense Class file
require_once('expenseTracker.php');

// Intialize the class
$exepenseTracker = new ExpenseTracker();

// Run when command more than 1
if(count($argv) > 1){

    // Store the arguments
    $command = $argv[1];

    // Check for each command
    switch($command){

        // Case for add expesnes
        case 'add':
            $exepenseTracker->AddExpenses($argv[2],$argv[3]);
        break;

        // Case for update Expenses
       
        case 'update':
            $amount = $argv[4] ?? null;
            $description = $argv[3] ?? null;
            $exepenseTracker->UpdateExpense($argv[2],$description,$amount);
        break;

        case 'delete':
            $exepenseTracker->DeleteExpense($argv[2]);
        break;

        case 'list':
            $exepenseTracker->ExpenseList();
        break;

        case 'summary':
            $month = $argv[2] ?? null;
            if($month){
                $exepenseTracker->SummaryByMonth($month);
            }else{

                $exepenseTracker->SummaryExpnese($month);
            }
        break;

        default:
            echo "No command";
    }
}else{
    echo "No found";

}




?>